<?php
use yii\helpers\Html;

$this->title = 'Каталог книг';
?>
<div class="site-index text-center py-5">
    <h1 class="display-4">Каталог книг</h1>
    <p class="lead text-muted">Каталог книг с системой подписок на авторов</p>

    <div class="mt-5">
        <?= Html::a('Каталог книг', ['book/index'], ['class' => 'btn btn-primary btn-lg mx-2']) ?>
        <?= Html::a('Авторы', ['author/index'], ['class' => 'btn btn-secondary btn-lg mx-2']) ?>
        <?= Html::a('Отчёт', ['report/index'], ['class' => 'btn btn-info btn-lg mx-2']) ?>
    </div>

    <div class="mt-4">
        <?php if (Yii::$app->user->isGuest): ?>
            <?= Html::a('Авторизация', ['site/login'], ['class' => 'btn btn-outline-success']) ?>
            <?= Html::a('Регистрация', ['site/signup'], ['class' => 'btn btn-outline-warning']) ?>
        <?php else: ?>
            <?php
            $logPath = Yii::getAlias('@webroot/logs');
            $logFiles = is_dir($logPath) ? glob($logPath . '/*.log') : [];
            $hasLogs = !empty($logFiles);
            ?>

            <?php if ($hasLogs): ?>
                <?= Html::a('Скачать логи смс', ['site/download-logs'], [
                        'class' => 'btn btn-outline-secondary',
                        'download' => true,
                ]) ?>
            <?php endif; ?>

            <?= Html::a('Выйти', ['site/logout'], [
                    'class' => 'btn btn-outline-danger',
                    'data-method' => 'post'
            ]) ?>
        <?php endif; ?>
    </div>
</div>