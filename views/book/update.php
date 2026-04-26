<?php
$this->title = 'Редактировать: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
    <h1><?= $this->title ?></h1>
<?= $this->render('_form', ['model' => $model]) ?>