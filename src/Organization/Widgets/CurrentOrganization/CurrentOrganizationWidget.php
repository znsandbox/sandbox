<?php

namespace ZnSandbox\Sandbox\Organization\Widgets\CurrentOrganization;

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
        return $this->render('index', [
            'organizationCollection' => $this->organizationService->all(),
            'currentOrganizationId' => $this->organizationService->getCurrentOrganizationId(),
        ]);
    }
}
