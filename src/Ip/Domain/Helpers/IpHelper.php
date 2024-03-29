<?php

namespace ZnSandbox\Sandbox\Ip\Domain\Helpers;

class IpHelper
{

    public static function getIpBydomainList(array $domains)
    {
        $collection = [];
        foreach ($domains as $domain) {
            $collection[] = IpHelper::getIpBydomain($domain);
        }
        return $collection;
    }

    public static function getIpBydomain(string $domain)
    {
        $item = [
            'domain' => $domain,
            'ip' => [],
        ];
//        $domain = self::cleanUrl($domain);
        $url = parse_url($domain);
        if(empty($ipList)) {
            $url = parse_url('https://' . $domain);
        }
        $ipList = gethostbynamel($url['host']);

        if(is_array($ipList)) {
            foreach($ipList as $ip) {
                $item['ip'][] = $ip;
            }
        }

        return $item;
    }

    public static function to2DomainLevel($item) {
        $arr = explode('.', $item);
        $arr = array_slice($arr, -2, 2);
        $item = implode('.', $arr);
        return $item;
    }

    public static function cleanUrl($url) {
        $url = trim($url); // Удаляем пробелы по краям, если есть
        $url = strtolower($url); // приводим все символы к нижнему регистру, нужно если адрес попал такой HTTP://siTe.coM
        if(substr($url,0,7) == "http://") {
            // Убираем приставку http:// если она есть
            $url = substr($url,7,strlen($url));
        }
        if(substr($url,0,8) == "https://") {
            // Убираем приставку https:// если она есть
            $url = substr($url,8,strlen($url));
        }
        if(substr($url,0,4) == "www.") {
            $url = substr($url,4,strlen($url));
        }
        return $url;
    }
}
