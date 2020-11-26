<?php

namespace ZnSandbox\Sandbox\Qr\Encoders;

use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCrypt\Base\Domain\Libs\Encoders\EncoderInterface;
use ZnLib\Egov\Helpers\XmlHelper;

class ZipEncoder implements EncoderInterface
{

    public function encode($data)
    {
        return XmlHelper::encode($data);
    }

    public function decode($encodedData)
    {
        $zipFile = tempnam(sys_get_temp_dir(), 'qrZip');
        FileHelper::save($zipFile, $encodedData);
        $zip = new \ZipArchive();
        $res = $zip->open($zipFile);
        if ($res === TRUE) {
            $xmlContent = $zip->getFromName('one');
            $zip->close();
        } else {
            throw new Exception('Zip not opened!');
        }
        unlink($zipFile);
        return $xmlContent;
    }
}