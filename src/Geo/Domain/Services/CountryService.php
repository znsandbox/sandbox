<?php

namespace ZnSandbox\Sandbox\Geo\Domain\Services;

use ZnSandbox\Sandbox\Geo\Domain\Entities\CountryEntity;
use ZnSandbox\Sandbox\Geo\Domain\Interfaces\Services\CountryServiceInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Libs\Query;

/**
 * @method
 * CountryRepositoryInterface getRepository()
 */
class CountryService extends BaseCrudService implements CountryServiceInterface
{
    private $currentCountry;

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

    public function getEntityClass() : string
    {
        return CountryEntity::class;
    }

    public function getCurrentCountry(): CountryEntity
    {
        if(!isset($this->currentCountry)) {
            $this->currentCountry = $this->oneCountry($_ENV['COUNTRY_ID']);
        }
        return $this->currentCountry;
    }

    public function oneCountry(int $id): CountryEntity
    {
        /** @var CountryEntity $companyEntity */
        $query = new Query();
        $query->with(['regions', 'localities']);
        $companyEntity = $this->oneById($id, $query);
        return $companyEntity;
    }

}

