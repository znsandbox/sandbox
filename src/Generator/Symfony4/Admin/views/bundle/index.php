<?php

/**
 * @var $this \ZnLib\Web\View\Libs\View
 * @var $formView FormView|AbstractType[]
 * @var $formRender \ZnLib\Web\Form\Libs\FormRender
 * @var $dataProvider DataProvider
 * @var $baseUri string
 * @var $bundleCollection \ZnCore\Domain\Collection\Libs\Collection | \ZnSandbox\Sandbox\Bundle\Domain\Entities\BundleEntity[]
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use ZnLib\Web\Html\Helpers\Url;
use ZnCore\Domain\DataProvider\Libs\DataProvider;
use ZnSandbox\Sandbox\Generator\Domain\Entities\ApiKeyEntity;

//dd($this->translate('core', 'action.send'));
?>

<div class="row">
    <div class="col-lg-12">
        <div class="list-group">
            <?php foreach ($bundleCollection as $bundleEntity): ?>
            <a href="<?= $this->url('generator/bundle/view', ['id' => $bundleEntity->getId()]) ?>" class="list-group-item list-group-item-action ">
                <?= $bundleEntity->getNamespace() ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
