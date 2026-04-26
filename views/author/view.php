<?php
use yii\widgets\DetailView;
use yii\helpers\Html;
$this->title = $model->name;
?>
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Список авторов', ['index'], ['class' => 'btn btn-success']) ?>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => ['confirm' => 'Удалить этого автора?', 'method' => 'post'],
            ]) ?>
        <?php endif; ?>
    </p>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'name',
        [
            'attribute' => 'img',
            'format' => 'html',
            'value' => $model->img ? Html::img("@web/uploads/authors/{$model->img}", ['style' => 'max-width: 200px; border-radius: 4px;']) : 'Нет фото',
        ],
        [
            'label' => 'Книги автора',
            'value' => implode(', ', array_map(fn($b) => Html::encode($b->name), $model->books)) ?: 'Книг нет',
            'format' => 'raw',
        ],
    ],
]) ?>
<?php if (Yii::$app->user->isGuest): ?>
    <div class="card mt-4">
        <div class="card-header bg-light">Подписка на новые книги автора</div>
        <div class="card-body">
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success"><?= Yii::$app->session->getFlash('success') ?></div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('warning')): ?>
                <div class="alert alert-warning"><?= Yii::$app->session->getFlash('warning') ?></div>
            <?php endif; ?>

            <?php $form = \yii\widgets\ActiveForm::begin(['id' => 'subscription-form']); ?>
            <?= $form->field($subscription, 'number')
                    ->textInput(['placeholder' => '+7 (999) 123-45-67', 'maxlength' => 20]) ?>

            <?= \yii\helpers\Html::submitButton('Подписаться', ['class' => 'btn btn-primary']) ?>
            <?php \yii\widgets\ActiveForm::end(); ?>

            <small class="text-muted">Уведомления будут приходить на указанный номер при публикации новых книг.</small>
        </div>
    </div>
<?php endif; ?>
