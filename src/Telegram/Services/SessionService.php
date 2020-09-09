<?php

namespace ZnSandbox\Telegram\Services;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\CacheItem;

class SessionService /*extends BaseCrudService implements SessionServiceInterface*/
{

    private $repository;

    public function __construct(FilesystemAdapter $repository)
    {
        $this->repository = $repository;
    }

    public function set($key, $value, $expiriesAt = null) {
        $item = $this->repository->getItem($key);
        $item->set($value);
        if($expiriesAt) {
            $item->expiresAt($expiriesAt);
        }
        $this->repository->save($item);
    }

    public function get($key, $default = null) {
        /** @var CacheItem $item */
        if($this->repository->hasItem($key)) {
            $item = $this->repository->getItem($key);
            return $item->get();
        }
        return $default;
    }

    public function remove($key) {
        $this->repository->deleteItem($key);
    }
}
