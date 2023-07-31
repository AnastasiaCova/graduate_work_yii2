<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
use app\models\File;
use app\models\TaskFiles;

/** @var yii\web\View $this */
/** @var app\models\Task $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deadline_date')->widget(DatePicker::class, [
        'bsVersion' => 5,
        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy.mm.dd',
            'todayBtn' => true, 
            'todayHighlight' => true,
            'startDate' => date('Y') . '-01-01',
        ]
    ]);?>

    <?= $form->field($model, 'deadline_time')->widget(TimePicker::classname(), [
        'bsVersion' => 5,
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'hh:ii',
            'showSeconds' => false,
            'showMeridian' => false,
            'showInputs' => false,
            'defaultTime' => false,
        ]
    ]); ?>

    <?php if ($alert) { ?>
        <div class="alert alert-danger">
            <button type="button" aria-hidden="true" class="close btn btn-link" data-dismiss="alert" aria-label="Close">
            <i class="tim-icons icon-simple-remove"></i>
            </button>
            <span>
            <b>Вы не можете </b> прикрепить больше 5 файлов к задаче!</span>
        </div>
    <?php } ?>

    <?= $form->field($model, 'add_files[]')->fileInput(['multiple' => true, 'accept' => 'files/*']) ?>

    <div class="mb-3">
        <?php if(Yii::$app->request->get('id')){ ?>
            <?php foreach( TaskFiles::find()->where(['task_id' => $model->id])->all() as $file){ ?>
                <div class="row align-items-center">
                    <p class="col-auto m-0"><?= explode("_", File::findOne(['id' => $file->file_id])->name)[2] ?></p>
                    <button type="button" rel="tooltip" title="" class="col-auto btn btn-link p-1" id="delete-file">
                        <?= Html::a('<i class="tim-icons icon-trash-simple"></i>', ['update', 'id' => $model->id, 'file'=>File::findOne(['id' => $file->file_id])->id], 
                        ['data' => [
                            'confirm' => 'Вы уверены, что хотите удалить файл?',
                            'method' => 'post',
                        ],
                        'class' => 'trash-btn',
                        ]) ?>
                    </button>
                </div>
            <?php } ?>
        <?php } ?>
    </div>

    <?php if(!Yii::$app->user->can('per_student')) { ?>
        <?= $form->field($model, 'group_id')->dropdownList($group, ['prompt' => 'Выберите группу', 'options' => [$prompt =>['selected' => 'selected']]]) ?>
    <?php } ?>

    <?= $form->field($model, 'subject_id')->dropdownList($subject, ['prompt' => 'Выберите предмет', 'options' => [$prompt =>['selected' => 'selected']]]) ?>


    <?php if($model->group_id == null) { ?>
        <?php if($model->priority != null && $model->priority->title == 'Важная') { ?>
            <?= $form->field($model, 'important')->checkbox([
                'template' => "<div class=\"col custom-control custom-checkbox checked\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'checked ' => true,
            ]) ?>
        <?php }else{ ?>
            <?= $form->field($model, 'important')->checkbox([
                'template' => "<div class=\"col custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ]) ?>
        <?php } ?>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton('Ок', ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
