<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use app\models\File;
use app\models\ResponseFiles;

/** @var yii\web\View $this */
/** @var app\models\Response $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="response-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

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
            <?php foreach( ResponseFiles::find()->where(['response_id' => $model->id])->all() as $file){ ?>
                <div class="row align-items-center">
                    <h5 class="col-auto m-0"><?= explode("_", File::findOne(['id' => $file->file_id])->name)[2] ?></h5>
                    <button type="button" rel="tooltip" title="" class="col-auto btn btn-link p-1" id="delete-file">
                        <?= Html::a('<i class="tim-icons icon-trash-simple text-info"></i>', ['update', 'id' => $model->id, 'file'=>File::findOne(['id' => $file->file_id])->id], 
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
    
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
