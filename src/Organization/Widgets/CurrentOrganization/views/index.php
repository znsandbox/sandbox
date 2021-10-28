<?php

/**
 * @var View $this
 * @var Collection | OrganizationEntity[] $organizationCollection
 * @var int $currentOrganizationId
 */

use Illuminate\Support\Collection;
use ZnCore\Base\Legacy\Yii\Helpers\Html;
use ZnCore\Base\Legacy\Yii\Helpers\Url;
use ZnLib\Web\View\View;
use ZnSandbox\Sandbox\Organization\Domain\Entities\OrganizationEntity;

$items = [];
$items[-100] = '- Выбор организации -';
foreach ($organizationCollection as $organizationEntity) {
    $items[$organizationEntity->getId()] = $organizationEntity->getTitle() . " ({$organizationEntity->getLocality()->getName()})";
}

?>

<form id="CurrentOrganizationWidget" class="form-inline ml-3" method="get"
      action="<?= Url::to(['/organization/organization/switch']) ?>">
    <div class="input-group input-group-sm">
        <?= Html::dropDownList('organizationId', $currentOrganizationId, $items, [
            'class' => 'form-control form-control-navbar select2',
            'onchange' => '$("#CurrentOrganizationWidget").submit()',
        ]) ?>
    </div>
</form>
