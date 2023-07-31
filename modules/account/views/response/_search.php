<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ResponseSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="response-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'status_id')->dropdownList($status, ['prompt' => 'Все статусы'])->label('Выберете статус') ?>
    
    <?= Html::activeHiddenInput($model, 'task_id') ?>

    <div class='text-center'>
        <?= Html::submitButton('Поиск',['class' => 'btn btn-info']) ?>
        <?= Html::a('Сбросить', ['/account/response', 'task_id' => $model->task_id], ['class' => 'btn btn-outline-secondary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
