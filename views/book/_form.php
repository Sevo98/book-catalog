<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Author;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'year')->textInput() ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'img')->fileInput() ?>
    <?php if ($model->isNewRecord === false && $model->img): ?>
        <div class="mb-3">
            <small>Текущая обложка:</small><br>
            <?= Html::img("@web/uploads/{$model->img}", ['style' => 'max-width: 100px; margin-top: 5px;']) ?>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'authorIds')->listBox(
        Author::find()->select(['name'])->indexBy('id')->column(),
        ['multiple' => true, 'size' => 5]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>