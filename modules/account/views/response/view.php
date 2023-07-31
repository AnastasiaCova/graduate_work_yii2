<?php

use yii\bootstrap5\Html;
use yii\widgets\DetailView;
use app\models\File;
use app\models\Status;
use app\models\ResponseFiles;

/** @var yii\web\View $this */
/** @var app\models\Response $model */
$this->title = $model->text;
\yii\web\YiiAsset::register($this);
?>
<div class="response-view">

    <?php if(Yii::$app->user->can('per_student')) {?>
        <?php if ($model->status_id != Status::findOne(['title' => 'Проверено'])->id){ ?>
            <p>
                <?= Html::a('<i class="tim-icons icon-pencil me-2"></i> Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
                <?= Html::a('<i class="tim-icons icon-simple-remove me-2"></i> Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-info',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить ответ?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        <?php } ?>
    <?php } ?>


    <?php if(Yii::$app->user->can('per_manager') || Yii::$app->user->can('per_head_teacher')) {?>
        <?php if($model->status_id == Status::findOne(['title' => 'Проверено'])->id) {?>
            <?= Html::a('Перепроверить', ['', 'id' => $model->id, 'no_confirm_response_id' => true], ['class' => "btn btn-secondary"]) ?>
        <?php }else{ ?>
            <?= Html::a('Проверить!', ['', 'id' => $model->id, 'confirm_response_id' => $model->id], ['class' => "btn btn-info"]) ?>
        <?php } ?>
    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        
        'options' => ['class' => 'table tablesorter'],
        'attributes' => [
            'text:ntext',
            [
                'attribute' => 'date',
                'value' => function($model){
                    $date = new DateTime($model->date);
                    return $date->format('d.m Y H:i');
                }
            ],
            [
                'attribute' => 'student_id',
                'visible' => !Yii::$app->user->can('per_student'),
                'value' => function ($model) {
                    return $model->student->name . ' ' . $model->student->surname . ' ' . $model->student->patronymic;
                },
            ],
            [
                'attribute' => 'status_id',
                'value' => function ($model) {
                    return $model->status->title;
                },
                'label' => 'Статус',
            ],
        ],
    ]) ?>

    <?php if($model->status_id == Status::findOne(['title' => 'Проверено'])->id){ ?>
            <div class="well border border-danger rounded p-1" style="width:100px">
                <p class='text-danger m-1 text-center'>Проверено</p>
            </div>
    <?php } ?>

    <?php foreach( ResponseFiles::find()->where(['response_id' => $model->id])->all() as $file){ ?>
        <a class="btn btn-info" href="<?= File::findOne(['id' => $file->file_id])->name ?>" download="<?= explode("_", File::findOne(['id' => $file->file_id])->name)[2] ?>">
        <i class="tim-icons icon-tap-02 text-white me-2"></i> Скачать файл <?= explode("_", File::findOne(['id' => $file->file_id])->name)[2] ?>
        </a>
    <?php } ?>

</div>
