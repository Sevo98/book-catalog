<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $book app\models\Book */

$this->title = $book->name;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['book/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Каталог книг', ['book/index'], ['class' => 'btn btn-success']) ?>

        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('Редактировать', ['book/update', 'id' => $book->id], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('Удалить', ['book/delete', 'id' => $book->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить эту книгу?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $book,
        'options' => ['class' => 'table table-striped table-bordered detail-view'],
        'attributes' => [
            'id',
            'name',
            'year',
            'isbn',
            'description:ntext',
            [
                'attribute' => 'img',
                'label' => 'Обложка',
                'format' => 'html',
                'value' => function ($model) {
                    if (!empty($model->img)) {
                        return Html::img(Yii::getAlias("@web/uploads/{$model->img}"), [
                            'style' => 'max-width: 200px; border-radius: 4px;',
                            'class' => 'img-thumbnail'
                        ]);
                    }
                    return '<span class="text-muted">Изображение не загружено</span>';
                },
            ],
            [
                'label' => 'Авторы',
                'value' => function ($model) {
                    $authors = $model->authors ?? [];
                    if (empty($authors)) {
                        return 'Не указаны';
                    }
                    return implode(', ', array_map(function ($author) {
                        return Html::encode($author->name);
                    }, $authors));
                },
                'format' => 'raw',
            ],
        ],
    ]) ?>
</div>
