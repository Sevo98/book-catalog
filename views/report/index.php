<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Отчёт: Топ авторов за год';
?>
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card mb-4">
        <div class="card-body">
            <?php $form = ActiveForm::begin(['method' => 'get']); ?>
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Год издания</label>
                    <input type="number" name="year" value="<?= Html::encode($year) ?>"
                           class="form-control"
                           min="0000" max="<?= (int)date('Y') + 1 ?>">
                </div>
                <div class="col-md-2">
                    <?= Html::submitButton('Сформировать', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'layout' => "{items}\n{summary}",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'name',
            'label' => 'Автор'
        ],
        [
            'attribute' => 'book_count',
            'label' => 'Книг выпущено',
        ],
    ],
]); ?>