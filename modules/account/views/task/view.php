<?php
use yii\bootstrap5\Html;
use yii\widgets\DetailView;
use app\models\Response;
use app\models\Reflection;
use app\models\Task;
use app\models\Group;
use app\models\Status;
use app\models\File;
use app\models\TaskFiles;
use yii\helpers\VarDumper;

/** @var yii\web\View $this */
/** @var app\models\Task $model */
$this->title = $model->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

    <p>
        <?php if (Yii::$app->user->can('per_user') && ($model->user_id == Yii::$app->user->id)) { ?>
            <?php if(!Task::findOne(['id' => $model->id, 'status_id' => Status::findOne(['title' => 'Выполнено'])->id]) || Task::findOne(['id' => $model->id, 'status_id' => Status::findOne(['title' => 'Задача для группы'])->id])) { ?>           
                <?= Html::a('<i class="tim-icons icon-pencil me-2"></i> Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
                <?= Html::a('<i class="tim-icons icon-simple-remove me-2"></i> Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-info',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить задачу?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php } ?>
        <?php } ?>
        
        <?php if($model->group_id != null) { ?>
            <?php if(Yii::$app->user->can('per_student')) { ?>
                <?php if(Response::findOne(['task_id' => $model->id]) != null) { ?>
                    <?= Html::a('<i class="tim-icons icon-send text-white me-2"></i> Ответ на задачу', ['/account/response/view', 'id' => Response::findOne(['task_id' => $model->id])->id], ['class' => 'btn btn-secondary']) ?>
                <?php } else { ?>
                <?= Html::a('<i class="tim-icons icon-send text-white me-2"></i> Прикрепить ответ', ['/account/response/create', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
                <?php } ?>
            <?php } else { ?>
                <?= Html::a('<i class="tim-icons icon-send text-white me-2"></i> Ответы на задачу', ['/account/response', 'task_id' => $model->id], ['class' => 'btn btn-secondary ms-2']) ?>
            <?php } ?>
        <?php } ?>
    
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table tablesorter'],
        'attributes' => [
            'title',
            [
                'attribute' => 'date',
                'value' => function($model){
                    $date = new DateTime($model->date);
                    return $date->format('d.m Y');
                }
            ],
            [
                'attribute' => 'deadline_date',
                'label' => 'Дедлайн',
                'value' => function($model){
                    $deadline = new DateTime($model->deadline_date . ' ' . $model->deadline_time);
                    return $deadline->format('d.m Y H:i');
                },
                'visible' => $model->deadline_date ? true : false,
            ],
            [
                'attribute' => 'user_id',
                'visible' => Yii::$app->user->can('can_admin'),
                'value' => function ($model) {
                    return $model->user->name . ' ' . $model->user->surname . ' ' . $model->user->patronymic;
                },
                'label' => 'Кто создал',
            ],
            [
                'attribute' => 'group_id',
                'visible' => $model->group_id && !Yii::$app->user->can('per_student'),
                'value' => function ($model) {
                    return Group::findOne($model->group_id)->title;
                },
                'label' => 'Задача для группы',
            ],
            [
                'attribute' => 'priority_id',
                'visible' => !$model->group_id && ($model->priority->title == 'Важная'),
                'value' => function ($model) {
                    return $model->priority->title;
                },
            ],
            [
                'attribute' => 'status_id',
                'visible' => in_array(($model->status->title), ['Выполнено', 'Просрочено']),
                'value' => function ($model) {
                    return $model->status->title;
                },
            ],
            [
                'attribute' => 'subject_id',
                'visible' => $model->subject_id != null,
                'value' => function ($model) {
                    return $model->subject->title;
                },
            ],
            [
                'attribute' => 'reflection_id',
                'format' => ['image', ['width' => '100']],
                'visible' => Reflection::findOne(['task_id' => $model->id]) != null,
                'value' => function ($model) {
                    return Reflection::findOne(['task_id' => $model->id])->mood->image;
                },
                'label' => 'Настроение',
            ],
            
        ],
    ]) ?>

    <?php foreach( TaskFiles::find()->where(['task_id' => $model->id])->all() as $file){ ?>
        <a class="btn btn-success" href="<?= File::findOne(['id' => $file->file_id])->name ?>" download="<?= explode("_", File::findOne(['id' => $file->file_id])->name)[2] ?>">
        <i class="tim-icons icon-tap-02 text-white me-2"></i> Скачать файл <?= explode("_", File::findOne(['id' => $file->file_id])->name)[2] ?>
        </a>
    <?php } ?>


        

</div>
