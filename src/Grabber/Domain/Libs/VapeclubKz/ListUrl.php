<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Libs\VapeclubKz;

class ListUrl
{

    public function generate(string $path, int $page = 1, int $limit = null): string
    {
        $url = "https://vapeclub.kz/{$path}/";
        $query = [];
        if($limit) {
            $query['limit'] = $limit;
        }
        if($page) {
            $query['page'] = $page;
        }
        if(!empty($query)) {
            $url .= '?' . http_build_query($query);
        }
        return $url;
    }
}
