<?php

namespace ZnSandbox\Telegram\Services;

use ZnSandbox\Telegram\Entities\UserTelegramEntity;
use ZnSandbox\Telegram\Repositories\Eloquent\UserTelegramRepository;

class UserService
{

    private $user;
    private $repository;

    public function __construct(UserTelegramRepository $repository)
    {
        $this->repository = $repository;
    }

    public function authById(int $userId) {
        $user = new UserTelegramEntity;
        $user->setId($userId);
        $this->user = $user;
    }

    public function authByUpdate($update) {
        $user = new UserTelegramEntity;
        $user->setId($update['message']['user_id'] ?? $update['message']['from_id']);
        $user->setUpdate($update);
        $this->user = $user;
    }

    public function getCurrentUser(): UserTelegramEntity {
        if(empty($this->user)) {
            throw new \Exception('No auth!!!');
        }
        return $this->user;
    }

    public function logout() {
        $this->user = null;
    }
}
