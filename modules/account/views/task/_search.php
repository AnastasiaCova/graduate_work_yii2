<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use kartik\date\DatePicker;

/** @var yii\web\View $this */
/** @var app\models\TaskSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>


<div class="task-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="well border border-secondary rounded p-1">
        <div class="m-0 search-bar input-group w-auto mb-2 row justify-content-center">
            <?= $form->field($model, 'title', ['options' => ['class' => 'm-0 row align-items-center col']])->textInput(['placeholder'=>'Поиск...', 'class' => 'form-control'])->label(false) ?>
            <div class="input-group-addon col-auto">
                    <?= Html::submitButton('<i class="tim-icons icon-zoom-split"></i>', ['class' => "btn btn-link"]) ?>
            </div>
        </div>
    </div>

    <div class="mt-3 well border border-secondary rounded p-1" style="width:285px">

        <?= DatePicker::widget([
                'bsVersion' => 5,
                'model' => $model, 
                'attribute' => 'deadline_date',
                'type' => DatePicker::TYPE_INLINE,
                'pluginOptions' => [
                    'format' => 'yyyy.mm.dd',
                    'todayHighlight' => true,
                    'startDate' => date('Y') . '-01-01',
                    // 'multidate' => true,
                ]
            ]);
        ?>
    </div>
    <?= $form->field($model, 'priority_id')->dropdownList($priority, ['prompt' => 'Все приоритеты'])->label('Выберете степень важности') ?>

    <?= $form->field($model, 'status_id')->dropdownList($status, ['prompt' => 'Все статусы'])->label('Выберете статус') ?>

    <?= $form->field($model, 'subject_id')->dropdownList($subject, ['prompt' => 'Все предметы'])->label('Выберете предмет') ?>

    <div class='text-center'>
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-info']) ?>
        <?= Html::a('Сбросить', ['/account/task'], ['class' => 'btn btn-outline-secondary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>




