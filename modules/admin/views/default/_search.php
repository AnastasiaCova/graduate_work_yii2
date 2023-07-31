<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AdminSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-search col-auto">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="well border border-secondary rounded ms-3 col-auto">
            <div class="m-0 search-bar input-group w-auto mb-2 row justify-content-center">
                <?= $form->field($model, 'surname', ['options' => ['class' => 'm-0 row align-items-center col']])->textInput(['placeholder'=>'Введите фамилию...', 'class' => 'form-control'])->label(false) ?>
                <div class="input-group-addon col-auto">
                    <?= Html::submitButton('<i class="tim-icons icon-zoom-split text-dark mb-2"></i>', ['class' => "btn btn-link"]) ?>
                </div>
            </div>
        </div>

        <div class="col-auto">
            <?= Html::a('Сбросить', ['/admin'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
