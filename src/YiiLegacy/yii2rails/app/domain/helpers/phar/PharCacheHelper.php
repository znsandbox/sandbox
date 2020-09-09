<?php

namespace yii2rails\app\domain\helpers\phar;

use Phar;
use yii\base\ErrorException;
use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;
use yii2bundle\db\domain\helpers\TableHelper;
use yii2rails\app\domain\helpers\EnvService;
use yii2rails\domain\helpers\DomainHelper;
use yii2rails\extension\console\handlers\RenderHahdler;
use yii2rails\extension\console\helpers\Output;
use yii2rails\extension\yii\helpers\FileHelper;

class PharCacheHelper {

    private static $phar = null;
    private static $render = null;
    private static $renderClass = null;

    public static function allCommon() {
        $maxCount = self::max();
        $all = self::totalItem($maxCount);
        $all = ArrayHelper::getColumn($all, 'class');
        $all = self::totalItem111($all);
        $all = ArrayHelper::getColumn($all, 'class');
        $all = array_unique($all);
        return $all;
    }

    private static function totalItem111($classList) {
        $tableName = TableHelper::getGlobalName('runtime_include');
        $classes = "'" . implode("','", $classList) . "'";
        $command = "
SELECT id, class, timestamp
FROM $tableName
WHERE class IN($classes)
ORDER BY id ASC
";
        //d($command);
        $all = \Yii::$app->db->createCommand($command)->queryAll();
        //d($all);
        return $all;
    }

    private static function totalItem($maxCount) {
        $tableName = TableHelper::getGlobalName('runtime_include');
        $command = "
SELECT class, COUNT(*) as count
FROM $tableName
GROUP BY class
HAVING COUNT(*) = $maxCount

";
        $all = \Yii::$app->db->createCommand($command)->queryAll();
        //d($all);
        return $all;
    }

    private static function max() {
        $tableName = TableHelper::getGlobalName('runtime_include');
        $command = "
SELECT class, COUNT(*) as count
FROM $tableName
GROUP BY class

LIMIT 1
";
        $all = \Yii::$app->db->createCommand($command)->queryAll();
        return intval($all[0]['count']);
    }

    public static function forgeClassCache() {
        $all = \App::$domain->tool->runtimeInclude->allUnique();
        //d([count($all), $all]);
        self::addClassListWithParents($all);
        return array_values($all);
    }

    /*public static function fileNameByClass($class) {
        $fileName = 'phar://../../' . PHAR_FILE . SL . $class . '.php';
        return $fileName;
    }*/

    public static function registerSaveDeclaredClasses() {
        $registerSaveDeclaredClasses = EnvService::get('dev.registerSaveDeclaredClasses', false);
        if(!$registerSaveDeclaredClasses) {
            return;
        }
        register_shutdown_function(function() {
            DomainHelper::defineDomains([
                'tool' => 'yii2tool\tool\domain\Domain',
            ]);
            if(strpos($_SERVER['REQUEST_URI'], '/debug/') !== 0) {
                $classes = \yii2rails\extension\code\helpers\ClassDeclaredHelper::allUserClasses();
                foreach ($classes as $class) {
                    \App::$domain->tool->runtimeInclude->create([
                        'request_data' => [
                            '_SERVER' => $_SERVER,
                            '_GET' => $_GET,
                        ],
                        'class' => $class,
                        'timestamp' => TIMESTAMP,
                    ]);
                }
            }
        });
    }

    public static function prepareParentClass(array $all) {
        $new = [];
        foreach($all as $cl) {
            $new = self::getParents($cl, $new);
        }
        return $new;
    }

    public static function getStubTemplate() {
        $stubCode = file_get_contents(__DIR__ . DS . 'stub_template.php');
        return $stubCode;
    }

    public static function createInstance(string $outputFileName) : Phar {
        FileHelper::createDirectory(FileHelper::up($outputFileName));
        $basePharName = basename($outputFileName);
        $phar = new Phar(
            $outputFileName,
            null,
            $basePharName
        );
        return $phar;
    }

    public static function packDirectory(string $baseDir, string $outputFileName, $stubCode = null) : Phar {
        FileHelper::createDirectory(FileHelper::up($outputFileName));
        $basePharName = basename($outputFileName);
        //d($basePharName);
        $phar = new Phar(
            $outputFileName,
            null,
            $basePharName
        );
        //$stubCode = file_get_contents(__DIR__ . DS . 'stub.php');
        if($stubCode) {
            $phar->setStub($stubCode);
        }

        //$phar->addFile('README.md', '1234');
        //'#vendor(.+)#i'
        $phar->buildFromDirectory($baseDir);

        return $phar;
        /*foreach (self::yiiRootClasses() as $yiiRootClass => $yiiRootPath) {
            $phar->addFile(ROOT_DIR . SL . 'vendor/' . $yiiRootPath . '.php', 'vendor/' . $yiiRootPath . '.php');
        }*/
    }

    public static function addClassListWithParents(array $classNameList) {
        $classNameList = array_unique($classNameList);
        $all = array_combine($classNameList, $classNameList);
        $all = self::prepareParentClass($all);
        self::addClassList($all);
    }

    public static function yiiRootClasses() {
        return [
            'yii/Yii' => 'yiisoft/yii2/Yii',
            'yii/classes' => 'yiisoft/yii2/classes',
            'yii2rails/app/App' => 'znsandbox/sandbox/src/YiiLegacy/yii2rails/app/App',
        ];
    }

    public static function addClassList(array $classNameList) {
        foreach (self::yiiRootClasses() as $yiiRootClass => $yiiRootPath) {
            //self::addClass($yiiRootClass);
            $content = file_get_contents(ROOT_DIR . SL . 'vendor/' . $yiiRootPath . '.php');
            //d($yiiRootClass . '.php');
            self::addClass($yiiRootClass, $content);
        }
        foreach ($classNameList as $className) {
            self::addClass($className);
        }
    }

    public static function addClass(string $className) {
        $classFile = $className . DOT . 'php';
        try {
            $fileName = FileHelper::getAlias('@' . $classFile);
        } catch(\Throwable $e) {
            return;
        }
        try {
            $content = file_get_contents($fileName);
            self::addFile($classFile, $content);
        } catch (ErrorException $e) {
            return;
        }
    }

    /*public static function addClassFile(string $className, string $content) {
        self::addFile($className . DOT . 'php', $content);
    }*/

	public static function addFile(string $filePath, string $content) {
	    if(self::getRenderInstance()) {
            self::getRenderInstance()->line($filePath);
        }
	    //prr($filePath);
        $phar = self::getInstance();
        //$phar->offsetExists($filePath);
        if(!isset($phar[$filePath])) {
            $phar->addFromString($filePath, $content);
            $phar[$filePath] = $content;
        }
	}

	public static function has() {
        $pharFileName = ROOT_DIR . DS . PHAR_FILE;
        $isExists = file_exists($pharFileName);
        return $isExists;
    }

    public static function setRendeClass($renderClass) {
        self::$renderClass = $renderClass;
    }

    private static function getParents(string $cl, array $new) {
        $parent = get_parent_class($cl);
        if($parent) {
            $new = self::getParents($parent, $new);
            $new[$parent] = $parent;
        }
        $new[$cl] = $cl;
        return $new;
    }

    private static function getRenderInstance() {
        if(self::$render === null && self::$renderClass) {
            self::$render = \Yii::createObject(self::$renderClass);
        }
        return self::$render;
    }

    private static function getInstance() : Phar {
        if(self::$phar === null) {
            $pharFileName = ROOT_DIR . DS . PHAR_FILE;
            FileHelper::createDirectory(FileHelper::up($pharFileName));
            $isExists = self::has();
            self::$phar = new \Phar($pharFileName);
            if(!$isExists) {
                $stubCode = file_get_contents(__DIR__ . DS . 'stub.php');
                self::$phar->setStub($stubCode);
                self::addFile('README.md', '1234');
            }
        }
        return self::$phar;
    }

}
