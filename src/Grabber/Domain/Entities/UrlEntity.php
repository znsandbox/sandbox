<?php

namespace ZnSandbox\Sandbox\Grabber\Domain\Entities;

use ZnSandbox\Sandbox\Grabber\Domain\Helpers\UrlHelper;

class UrlEntity
{

    protected $scheme = null;

    protected $host = null;

    protected $path = null;

    protected $queryParams = null;

    public function __construct(string $url = null)
    {
        if($url) {
            $urlArr = UrlHelper::parse($url);
            $this->setScheme($urlArr['scheme']);
            $this->setHost($urlArr['host']);
            $this->setPath($urlArr['path']);
            $this->setQueryParams($urlArr['queryParams']);
        }
    }

    public function getScheme()
    {
        return $this->scheme;
    }

    public function setScheme($scheme): void
    {
        $this->scheme = $scheme;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setHost($host): void
    {
        $this->host = $host;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path): void
    {
        $this->path = $path;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }

    public function setQueryParams($queryParams): void
    {
        $this->queryParams = $queryParams;
    }

    public function setQueryParam(string $name, string $value): void
    {
        $this->queryParams[$name] = $value;
    }

    /*public function getString() {
        $url = $this->getScheme() . '://' . $this->getHost();
        if($this->getPath()) {
            $url .= '/' . $this->getPath();
        }
        if($this->getQueryParams()) {
            $url .= '?' . http_build_query($this->getQueryParams());
        }
        return $url;
    }*/

    public function __toString() {
        $url = $this->getScheme() . '://' . $this->getHost();
        if($this->getPath()) {
            $url .= '/' . $this->getPath();
        }
        if($this->getQueryParams()) {
            $url .= '?' . http_build_query($this->getQueryParams());
        }
        return $url;
    }
}
