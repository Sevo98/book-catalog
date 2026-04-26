<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Регистрация';
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Заполните поля для создания аккаунта:</p>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
