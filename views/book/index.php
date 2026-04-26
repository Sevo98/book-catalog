<?php
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Каталог книг';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (!Yii::$app->user->isGuest): ?>
        <?= Html::a('Добавить новую книгу', ['book/create'], ['class' => 'btn btn-warning']) ?>
    <?php endif; ?>
        <?= Html::a('Авторы', ['author/index'], ['class' => 'btn btn-success']) ?>
    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-striped table-bordered'],
            'columns' => [
                    'name',
                    'year',
                    'isbn',
                    [
                            'attribute' => 'description',
                            'format' => 'ntext',
                            'contentOptions' => ['style' => 'max-width: 300px;'],
                    ],
                    [
                            'attribute' => 'img',
                            'label' => 'Обложка',
                            'format' => 'html',
                            'value' => function ($model) {
                                if (!empty($model->img)) {
                                    return Html::img(Yii::getAlias("@web/uploads/{$model->img}"), [
                                            'style' => 'max-height: 60px; max-width: 50px; object-fit: contain;'
                                    ]);
                                }
                                return '<span class="text-muted">Нет</span>';
                            },
                    ],
                    [
                            'label' => 'Авторы',
                            'value' => function ($model) {
                                return !empty($model->authors)
                                        ? implode(', ', array_map(fn($a) => $a->name, $model->authors))
                                        : 'Не указаны';
                            },
                    ],
                    [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => Yii::$app->user->isGuest ? '{view}' : '{view} {update} {delete}',
                    ],
            ],
    ]); ?>
</div>