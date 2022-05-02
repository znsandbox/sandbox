<?php

namespace ZnSandbox\Sandbox\Organization\Widgets\CurrentOrganization;

use App\Organization\Domain\Enums\Rbac\OrganizationOrganizationPermissionEnum;
use ZnCore\Contract\User\Exceptions\ForbiddenException;
use ZnCore\Domain\Libs\Query;
use ZnLib\Web\Widgets\Base\BaseWidget2;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Services\OrganizationServiceInterface;
use ZnUser\Rbac\Domain\Interfaces\Services\ManagerServiceInterface;

class CurrentOrganizationWidget extends BaseWidget2
{

    private $organizationService;
    private $managerService;

    public function __construct(
        OrganizationServiceInterface $organizationService,
        ManagerServiceInterface $managerService
    )
    {
        $this->organizationService = $organizationService;
        $this->managerService = $managerService;
    }

    public function run(): string
    {
        if(!$this->managerService->iCan([OrganizationOrganizationPermissionEnum::SWITCH])) {
            return '';
        }

        $query = new Query();
        $query->with('locality');
        return $this->render('index', [
            'organizationCollection' => $this->organizationService->all($query),
            'currentOrganizationId' => $this->organizationService->getCurrentOrganizationId(),
        ]);
    }
}
