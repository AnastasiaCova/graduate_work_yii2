<?php

use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */
$this->title = 'Личный кабинет';
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model,
        'success' => $success,
    ]) ?>

</div>
