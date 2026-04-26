<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Авторы';
?>
    <h1><?= Html::encode($this->title) ?></h1>
<?php if (!Yii::$app->user->isGuest): ?>

    <p><?=
        Html::a('Добавить автора', ['create'], ['class' => 'btn btn-success']) ?></p>
<?php endif; ?>
<?= Html::a('Топ авторов', ['report/index'], ['class' => 'btn btn-success']) ?>
<?= Html::a('Книги', ['book/index'], ['class' => 'btn btn-success']) ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
                'name',
                [
                        'attribute' => 'img',
                        'format' => 'html',
                        'value' => fn($m) => $m->img ? Html::img("@web/uploads/authors/{$m->img}", ['style' => 'max-height: 50px; object-fit: cover;']) : '—',
                ],
                [
                        'label' => 'Книг выпущено',
                        'value' => fn($m) => count($m->books),
                ],
                [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => Yii::$app->user->isGuest ? '{view}' : '{view} {update} {delete}',
                ],
        ],
]); ?>