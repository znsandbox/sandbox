<?php

namespace ZnSandbox\Sandbox\Organization\Widgets\CurrentOrganization;

use ZnCore\Domain\Libs\Query;
use ZnLib\Web\Widgets\Base\BaseWidget2;
use ZnSandbox\Sandbox\Organization\Domain\Interfaces\Services\OrganizationServiceInterface;

class CurrentOrganizationWidget extends BaseWidget2
{

    private $organizationService;

    public function __construct(OrganizationServiceInterface $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    public function run(): string
    {
        $query = new Query();
        $query->with('locality');
        return $this->render('index', [
            'organizationCollection' => $this->organizationService->all($query),
            'currentOrganizationId' => $this->organizationService->getCurrentOrganizationId(),
        ]);
    }
}
