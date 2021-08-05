<?php

/**
 * @var View $this
 * @var Request $request
 * @var RegionForm $model
 */

use ZnSandbox\Sandbox\Geo\Yii2\Admin\Forms\RegionForm;
use Packages\Layout\Web\Widgets\LanguageI18n\LanguageI18n;
use yii\helpers\Html;
use yii\web\Request;
use yii\web\View;
use yii\widgets\ActiveForm;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnYii\Web\Widgets\CancelButton\CancelButtonWidget;

//SummernoteAsset::register($this);

?>

<div class="row">
    <div class="col-lg-12">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <div class="form-row">
            <div class="form-group col-md-12">
                <?= LanguageI18n::widget([
                    'model' => $model,
                    'attribute' => 'name'
                ]) ?>
            </div>
        </div>

        <?= Html::submitButton(I18Next::t('core', 'action.save'), ['class' => 'btn btn-success']) ?>

        <?= CancelButtonWidget::widget() ?>

        <?php ActiveForm::end() ?>

    </div>
</div>
