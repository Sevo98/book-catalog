<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'О проекте';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Данный проект выполнен в качестве тестового задания для "АНО ДПО Национальная Академия Медицинского Образования Им. Н.А. Бородина".
    </p>
    <p>
        Проект выполнил Кирилл Севостьянов (@Sevo98, sevo98.sk@gmail.com).
    </p>

</div>
