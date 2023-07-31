<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Response $model */

$this->title = 'Редактирование ответа';
?>
<div class="response-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'alert' => $alert,
    ]) ?>

</div>
