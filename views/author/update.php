<?php $this->title = 'Редактировать: ' . $model->name; ?>
    <h1><?= $this->title ?></h1>
<?= $this->render('_form', ['model' => $model]) ?>