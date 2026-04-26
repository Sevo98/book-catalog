<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $model app\models\Author */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="author-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'img')->fileInput() ?>

    <?php if (!$model->isNewRecord && $model->img): ?>
        <div class="mb-2">
            <small>Текущее фото:</small><br>
            <?= Html::img("@web/uploads/authors/{$model->img}", ['style' => 'max-width: 100px; margin-top: 5px;']) ?>
        </div>
    <?php endif; ?>

    <div class="form-group mt-3">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>