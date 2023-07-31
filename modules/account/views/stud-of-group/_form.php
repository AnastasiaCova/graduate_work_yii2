<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\helpers\VarDumper;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use app\models\StudOfGroup;
use app\models\Group;

/** @var yii\web\View $this */
/** @var app\models\StudOfGroup $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="stud-of-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row align-items-bottom"> 
        <div class="col-4 h-auto">
            <?= $form->field($model, 'student_id')->dropdownList($student, ['prompt' => 'Выберите студента'])->label(false) ?>
        </div>
        <div class="col-auto">
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-info m-0']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="card card-tasks" style="height: auto;">
        <div class="card-header ">
            <h6 class="title d-inline">Студенты</h6>
            <p class="card-category d-inline">Группа №<?= Group::findOne(Yii::$app->request->get('id'))->title ?></p>
        </div>

        <!-- card body -->
        <div class="card-body">

            <?php Pjax::begin(['id'=>"pjax-group", "enablePushState"=>FALSE, "timeout"=>5000]); ?>

            <?=  ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'layout' => '{pager}{items}{pager}',
                'pager' => ['class' => \yii\bootstrap5\LinkPager::class],
                'itemView' => 'studofgroup', 
            ]) ?>

            <?php Pjax::end(); ?>
            
        </div>
    </div>

</div>
