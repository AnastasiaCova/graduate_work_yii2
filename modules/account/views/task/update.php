<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Task $model */

$this->title = 'Редактирование задачи: ' . $model->title;
?>
<div class="task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'group' => $group,
        'subject' => $subject,
        'prompt' => $prompt,
        'alert' => $alert,
    ]) ?>

</div>
