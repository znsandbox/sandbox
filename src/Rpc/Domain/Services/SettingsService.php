<?php

namespace ZnSandbox\Sandbox\Rpc\Domain\Services;

use ZnSandbox\Sandbox\Rpc\Domain\Entities\SettingsEntity;
use ZnSandbox\Sandbox\Rpc\Domain\Interfaces\Services\SettingsServiceInterface;
use App\Settings\Domain\Interfaces\Services\SystemServiceInterface;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Domain\Helpers\ValidationHelper;

class SettingsService implements SettingsServiceInterface
{

    private $systemService;

    public function __construct(SystemServiceInterface $systemService)
    {
        $this->systemService = $systemService;
    }

    public function getEntityClass(): string
    {
        return SettingsEntity::class;
    }

    public function update(SettingsEntity $settingsEntity)
    {
        ValidationHelper::validateEntity($settingsEntity);
        $settingsData = EntityHelper::toArray($settingsEntity);
        $this->systemService->update('rpc', $settingsData);
    }

    public function view(): SettingsEntity
    {
        $data = $this->systemService->view('rpc');
        $settingsEntity = new SettingsEntity();
        EntityHelper::setAttributes($settingsEntity, $data);
        return $settingsEntity;
    }
}
