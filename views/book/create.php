<?php
$this->title = 'Добавить книгу';
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['site/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?= $this->title ?></h1>
<?= $this->render('_form', ['model' => $model]) ?>