<?php

/**
 * @var $formView FormView|AbstractType[]
 * @var $entityCollection Collection | EntityEntity[]
 */

use Illuminate\Support\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use ZnBundle\Eav\Domain\Entities\EntityEntity;
use ZnBundle\Eav\Symfony4\Widgets\DynamicForm\DynamicFormWidget;
use ZnCore\Base\Legacy\Yii\Helpers\Url;
use ZnLib\Web\Widgets\Tab\TabWidget;

/** @var CsrfTokenManagerInterface $tokenManager */
//$tokenManager = ContainerHelper::getContainer()->get(CsrfTokenManagerInterface::class);
//$formRender = new FormRender($formView, $tokenManager);
//$formRender->addFormOption('autocomplete', 'off');

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
$uri = $request->getRequestUri();

$items = [];
foreach ($entityCollection as $entityEntity) {
    $itemUri = '/person-settings';
    $itemUri = Url::to([$itemUri, 'entity' => $entityEntity->getName()]);
    $items[] = [
        'title' => $entityEntity->getTitle(),
        'url' => $itemUri,
        'is_active' => $uri == $itemUri,
    ];
}

?>

<?= TabWidget::widget([
    //'class' => 'mb-3',
    'items' => $items,
]);

?>

<br/>

<?= DynamicFormWidget::widget([
    'formView' => $formView,
]) ?>

<?php
/*
?>
<?= $formRender->errors() ?>

<?= $formRender->beginFrom() ?>

<?= DynamicInputWidget::widget([
    'formRender' => $formRender,
]) ?>

<div class="form-group">
    <?= $formRender->input('save', 'submit') ?>
</div>

<?= $formRender->endFrom() ?>
*/
?>