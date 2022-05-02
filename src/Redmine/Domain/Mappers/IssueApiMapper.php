<?php

namespace ZnSandbox\Sandbox\Redmine\Domain\Mappers;

use ZnCore\Contract\Encoder\Interfaces\EncoderInterface;
use ZnSandbox\Sandbox\Redmine\Domain\Entities\PriorityEntity;
use ZnSandbox\Sandbox\Redmine\Domain\Entities\ProjectEntity;
use ZnSandbox\Sandbox\Redmine\Domain\Entities\StatusEntity;
use ZnSandbox\Sandbox\Redmine\Domain\Entities\TrackerEntity;
use ZnSandbox\Sandbox\Redmine\Domain\Entities\UserEntity;

class IssueApiMapper implements EncoderInterface
{

    public function encode($data)
    {
        return $data;
    }

    public function decode($row)
    {
        if(!empty($row['project'])) {
            $projectEntity = new ProjectEntity();
            $projectEntity->setId($row['project']['id']);
            $projectEntity->setName($row['project']['name']);
            $row['project'] = $projectEntity;
        }

        if(!empty($row['tracker'])) {
            $projectEntity = new TrackerEntity();
            $projectEntity->setId($row['tracker']['id']);
            $projectEntity->setName($row['tracker']['name']);
            $row['tracker'] = $projectEntity;
        }

        if(!empty($row['status'])) {
            $projectEntity = new StatusEntity();
            $projectEntity->setId($row['status']['id']);
            $projectEntity->setName($row['status']['name']);
            $row['status'] = $projectEntity;
        }

        if(!empty($row['priority'])) {
            $projectEntity = new PriorityEntity();
            $projectEntity->setId($row['priority']['id']);
            $projectEntity->setName($row['priority']['name']);
            $row['priority'] = $projectEntity;
        }

        if(!empty($row['author'])) {
            $projectEntity = new UserEntity();
            $projectEntity->setId($row['author']['id']);
            $projectEntity->setName($row['author']['name']);
            $row['author'] = $projectEntity;
        }

        if(!empty($row['assigned_to'])) {
            $projectEntity = new UserEntity();
            $projectEntity->setId($row['assigned_to']['id']);
            $projectEntity->setName($row['assigned_to']['name']);
            $row['assigned'] = $projectEntity;
        }

        return $row;
    }
}
