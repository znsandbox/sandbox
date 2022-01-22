<?php

namespace ZnSandbox\Sandbox\Grabber\Commands;

use App\Parser\Helpers\ParseHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnSandbox\Sandbox\Grabber\Domain\Entities\UrlEntity;
use ZnSandbox\Sandbox\Grabber\Domain\Interfaces\Services\QueueServiceInterface;

class QueueGrabSpaCommand extends Command
{

    protected static $defaultName = 'grabber:queue:grab-spa';
    private $queueService;

    public function __construct(?string $name = null, QueueServiceInterface $queueService)
    {
        parent::__construct($name);
        $this->queueService = $queueService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<fg=white># Grabber Queue grab SPA</>');

        $url = 'https://cryptii.com/';

        $urlEntity = new UrlEntity($url);
        $path = $urlEntity->getPath() ?: 'index';
        //dd($urlEntity);

        $dir = $_ENV['ROOT_DIRECTORY'] . '/var/grabber/spa';
        $file = $dir . '/' . $urlEntity->getHost() . '/' . $path . '.html';

        //dd($file);

        $html = file_get_contents($url);

        $crawler = new Crawler($html);

        $rr = $crawler->filter('*[src]')->each(function (Crawler $crawler, $i) use($urlEntity) {
            if($crawler->attr('src')) {

                $src = $crawler->attr('src');
                $urlEntity1 = new UrlEntity($src);
                if($urlEntity1->getHost() == null) {
                    $urlEntity1->setHost($urlEntity->getHost());
                    $urlEntity1->setScheme($urlEntity->getScheme());
                    $src = $urlEntity1->__toString();
                    //dd();
                }

                $mime = FileHelper::mimeTypeByExtension(FileHelper::fileExt($urlEntity1->getPath()));
               // dd();

                $content = file_get_contents($src);
                $contentB64 = base64_encode($content);

                $srcB64 = 'data:'.$mime.';base64,' . $contentB64;
                //dd($srcB64);

                return [
                    'from' => $crawler->attr('src'),
                    'to' => $srcB64,
                ];

                return $crawler->attr('src');

                $node = $crawler->getNode(0);

                /** @var DOMAttr $attribute */
                foreach ($node->attributes as $attribute) {
                    if($attribute->name == 'src') {
                        $attribute->nodeValue = 'sdfsdfsd';
                    }
                    //$attrs[$attribute->name] = $attribute->value;
                }


//                $node->attributes->item(1)->nodeValue = 'sdfsdfsd';
               // dd($node->attributes->item(1)->nodeValue);
               // $crawler->
               // dd($crawler->outerHtml());
            }

            /*$property = $crawler->attr('property');
            return [
                'property' => str_replace('og:', '', $property),
                'content' => $crawler->attr('content'),
            ];*/
        });



        foreach ($rr as $item) {
            $html = str_replace($item['from'], $item['to'], $html);
        }
//        dd($rr);

//        $ogProps = ParseHelper::parseMeta($crawler);
//        $title = ParseHelper::parseTitle($crawler);
//        dd($title);

//        dd($ogProps);

        FileHelper::save($file, $html);

        //dd($html);

        return 0;
    }
}
