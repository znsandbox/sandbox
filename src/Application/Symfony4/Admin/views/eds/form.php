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
    <?= $formRender->label('applicationId') ?>
    <?= $formRender->input('applicationId', 'select') ?>
    <?= $formRender->hint('applicationId') ?>
</div>
<div class="form-group required has-error">
    <?= $formRender->label('certificateRequest') ?>
    <?= $formRender->input('certificateRequest', 'textarea') ?>
    <?= $formRender->hint('certificateRequest') ?>
</div>
<div class="form-group required has-error">
    <?= $formRender->label('expiredAt') ?>
    <?= $formRender->input('expiredAt', 'text') ?>
    <?= $formRender->hint('expiredAt') ?>
</div>

<div class="form-group">
    <?= $formRender->input('save', 'submit') ?>
</div>

<?= $formRender->endFrom() ?>
