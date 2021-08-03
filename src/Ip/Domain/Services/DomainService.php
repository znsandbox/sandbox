<?php

namespace ZnSandbox\Sandbox\Ip\Domain\Services;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Domain\Helpers\FilterHelper;
use ZnCore\Domain\Libs\Query;
use ZnSandbox\Sandbox\Ip\Domain\Helpers\IpHelper;
use ZnSandbox\Sandbox\Ip\Domain\Repositories\Api\HostInfoRepository;

class DomainService
{

    private $hostInfoRepository;

    public function __construct(HostInfoRepository $hostInfoRepository)
    {
        $this->hostInfoRepository = $hostInfoRepository;
    }

    private function clearDomainList(array $rr): array
    {
        foreach ($rr as &$item) {
            $item = IpHelper::cleanUrl($item);
            $item = IpHelper::to2DomainLevel($item);
        }
        sort($rr);
        $rr = array_unique($rr);
        $rr = array_values($rr);
        return $rr;
    }

    public function all(array $rr)
    {
        $domains = $this->clearDomainList($rr['domains']);
        $dd = $this->hostInfoRepository->getIpByDomainList($domains);

        $res = [];
        $allIps = [];
        $ipList = [];
        foreach ($dd as $domainInfo) {
            $ip = $domainInfo['ip'];
            $domain = $domainInfo['domain'];
            $dd[$domain]['isOur'] = false;
            $dd[$domain]['netname'] = [];
            //dd($domainInfo);
            if (empty($ip)) {
                $res['unknown'][] = $domain;
            } elseif (!empty(array_intersect($rr['ourIpList'], $ip))) {
                $res['our'][] = $domain;
                //dd($domainInfo);
                $dd[$domain]['isOur'] = true;
            } else {
                $res['their'][] = $domain;
            }
            if (!empty($ip)) {

                foreach ($ip as $ipItem) {
                    $ipList[] = $ipItem;
                    $allIps[$ipItem]['domains'][] = $domain;
                    $info = $this->hostInfoRepository->getHostInfo($ipItem);
                    $allIps[$ipItem]['info'] = [
                        'netname' => $info['netname'],
                    ];

                    $dd[$domain]['netname'] = $info['netname'];
                }
//                $allIps = ArrayHelper::merge($allIps, $ip);
            }
        }

        $ipList = array_unique($ipList);

        usort($dd, function ($value, $value2) {
            return $value2['isOur'] ? 1 : -1;
            /*if(empty($value2['ip'])) {
                return 1;
            }
            return $value2['ip'] > $value['ip'] ? -1 : 1;*/
        });

        return [
            'domains' => $domains,
            'ipByDomainList' => $dd,
            'ipList' => $ipList,
            'allIps' => $allIps,
            'res' => $res,
        ];

        /*$allIps = array_unique($allIps);
        foreach ($allIps as &$value) {
            $value = implode(', ', $value);
        }
        dd($allIps);*/
    }
}
