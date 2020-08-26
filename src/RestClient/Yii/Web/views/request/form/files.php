<?php
/**
 * @var \yii\web\View $this
 * @var \yii\base\Model $model
 * @var \yii\widgets\ActiveForm $form
 * @var string $keyAttribute
 * @var string $valueAttribute
 * @var string $activeAttribute
 * @var string $valueInput
 */
$id = uniqid('params-');
$fieldOptions = [
    'options' => ['class' => 'form-group form-group-sm'],
];
$i = 1;
$valueInput = $valueInput ?? 'textInput';
?>
<div id="<?= $id ?>" class="params-list">
    <table class="table">
        <tbody>
        <?= $form->field($model, 'files[]')->fileInput([
            'multiple' => true,
            //'accept' => 'image/*',
        ]) ?>
        </tbody>
    </table>
</div>
