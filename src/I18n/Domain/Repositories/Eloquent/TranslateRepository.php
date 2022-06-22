<?php

namespace ZnSandbox\Sandbox\I18n\Domain\Repositories\Eloquent;

use ZnCore\Domain\Query\Entities\Query;
use ZnCore\Domain\Relation\Libs\Types\OneToOneRelation;
use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;
use ZnSandbox\Sandbox\I18n\Domain\Entities\TranslateEntity;
use ZnSandbox\Sandbox\I18n\Domain\Interfaces\Repositories\TranslateRepositoryInterface;

class TranslateRepository extends BaseEloquentCrudRepository implements TranslateRepositoryInterface
{

    public function tableName(): string
    {
        return 'i18n_translate';
    }

    public function getEntityClass(): string
    {
        return TranslateEntity::class;
    }

    public function relations2()
    {
        return [
            [
                'class' => OneToOneRelation::class,
                'relationAttribute' => 'language_id',
                'relationEntityAttribute' => 'language',
                'foreignRepositoryClass' => \ZnBundle\Language\Domain\Interfaces\Repositories\LanguageRepositoryInterface::class
            ],
        ];
    }

    public function oneByEntity(int $entityTypeId, int $entityId, int $languageId, Query $query = null): TranslateEntity
    {
        $query = $this->forgeQuery($query);
        $query->where('entity_type_id', $entityTypeId);
        $query->where('entity_id', $entityId);
        $query->where('language_id', $languageId);
        return $this->one($query);
    }
}
