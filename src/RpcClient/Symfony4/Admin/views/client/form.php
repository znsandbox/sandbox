<?php

/**
 * @var $formView FormView|AbstractType[]
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnLib\Web\Symfony4\MicroApp\Libs\FormRender;

/** @var CsrfTokenManagerInterface $tokenManager */
$tokenManager = ContainerHelper::getContainer()->get(CsrfTokenManagerInterface::class);
$formRender = new FormRender($formView, $tokenManager);
//$formRender->addFormOption('autocomplete', 'off');

?>

<?= $formRender->errors() ?>

<?= $formRender->beginFrom() ?>

<div class="form-group required has-error">
    <?= $formRender->label('method') ?>
    <?= $formRender->input('method') ?>
    <?= $formRender->hint('method') ?>
</div>
<div class="form-group required has-error">
    <?= $formRender->label('authBy') ?>
    <?= $formRender->input('authBy') ?>
    <?= $formRender->hint('authBy') ?>
</div>
<div class="form-group required has-error">
    <?= $formRender->label('body') ?>
    <?= $formRender->input('body') ?>
    <?= $formRender->hint('body') ?>
</div>
<div class="form-group required has-error">
    <?= $formRender->label('meta') ?>
    <?= $formRender->input('meta') ?>
    <?= $formRender->hint('meta') ?>
</div>
<div class="form-group required has-error">
    <?= $formRender->label('description') ?>
    <?= $formRender->input('description') ?>
    <?= $formRender->hint('description') ?>
</div>

<div class="form-group">
    <?= $formRender->input('save', 'submit') ?>
</div>

<?= $formRender->endFrom() ?>
