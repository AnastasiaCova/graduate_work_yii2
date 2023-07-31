<?php 
use yii\bootstrap5\Html;
use yii\helpers\Json;
use app\models\Response;
use app\models\Reflection;
use app\models\Task;
use app\models\Status;
use app\models\Mood;
use app\models\Group;
use app\models\AuthAssignment;
use yii\helpers\VarDumper;
use yii\bootstrap5\Modal;
use yii\bootstrap5\ActiveForm;
?>

<div class="">
    <table class="table">
        <tbody>
            <tr class="row">
                <td class="col-auto">
                    <div class="form-check">
                        <label class="form-check-label">

                            <?php if(!$model->group_id): ?>

                                <?= Html::a(Html::checkbox('checked', $model->checked, ['label' => '', 'class'=>"check-box opacity-100 visible position-relative", 'data-id' => $model->id, 'data-check' => $model->checked]), ['index', 'id' => $model->id, 'modal' => $model->checked], ['class' => 'text-decoration-none']) ?>

                            <?php endif; ?>
                            
                        </label>
                    </div>
                </td>
                <td class="col row">
                    <h4 class="col-auto mb-2"><?= Html::a($model->title,['view', 'id' => $model->id], ['class' => 'text-decoration-none text-dark'])?></h4>

                    <?php if($model->group_id && !Yii::$app->user->can('per_student')) : ?>
                        <p class="text-muted mb-0">
                            Для группы №<?= Group::findOne($model->group_id)->title ?> 
                        </p>
                    <?php endif; ?>

                    <?php if(!$model->group_id && ($model->priority->title == 'Важная')) : ?>
                        <p class="text-info mb-0">Важная</p>
                    <?php endif; ?>

                    <?php if(Yii::$app->user->can('can_admin') || (Yii::$app->user->can('per_student') && $model->group_id)) : ?>
                        <p class="text-muted mb-0">
                            <?= $model->user->surname . ' ' . $model->user->name . ' ' . $model->user->patronymic ?> 
                        </p>
                    <?php endif; ?>

                    <?php if ($model->deadline_date) : ?>
                        <p class="text-muted mt-1 mb-0">
                            <?php $deadline = new DateTime($model->deadline_date . ' ' . $model->deadline_time);?>

                            Дедлайн до <?= $deadline->format('d.m H:i'); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($model->subject_id) : ?>
                        <p class="text-muted mt-1 mb-0">
                            <?= $model->subject->title ?>
                        </p>
                    <?php endif; ?>
                    
                </td>
                <td class="td-actions col-auto row align-items-center px-0 m-0">
                    <div class="col-auto p-0">
                        <?php if($ref = Reflection::findOne(['task_id' => $model->id])) : ?>
                            <img src="<?= $ref->mood->image ?>" class="me-2" style="max-height: 70px;">
                        <?php endif; ?>
                    </div>

                    <div class="col-auto p-0">
                        <?php if(in_array(($s1 = $model->status->title), ['Выполнено', 'Просрочено'])) : ?>
                            <p class="<?= ($s1 == 'Выполнено') ? 'text-success' : 'text-danger' ?> me-2"><?= $s1 ?></p>
                        <?php elseif(Yii::$app->user->can('per_student') && $model->group_id && Response::findOne(['task_id' => $model->id])): ?>
                            <?php $s2 = Response::findOne(['task_id' => $model->id])->status->title ?>
                            <p class="<?= ($s2 == 'Просрочено') ? 'text-danger' : 'text-success' ?> me-2"><?= $s2 ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-auto text-muted ps-0">

                        <?php if($model->group_id != null) : ?>
                            <?php if(Yii::$app->user->can('per_student')) : ?>
                                <?php if(Response::findOne(['task_id' => $model->id]) != null) : ?>
                                    <?= Html::a('<i class="tim-icons icon-send text-white me-2"></i> Ответ на задачу', ['/account/response/view', 'id' => Response::findOne(['task_id' => $model->id])->id], ['class' => 'btn btn-secondary']) ?>
                                <?php else : ?>
                                    <?= Html::a('<i class="tim-icons icon-send text-white me-2"></i> Прикрепить ответ', ['/account/response/create', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
                                <?php endif; ?>
                            <?php else : ?>
                                <?= Html::a('Ответы на задачу', ['/account/response', 'task_id' => $model->id], ['class' => 'btn btn-secondary ms-2']) ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    
                        <?php if($model->user_id == Yii::$app->user->id) : ?>
                            <?php if(!Task::findOne(['id' => $model->id, 'status_id' => Status::findOne(['title' => 'Выполнено'])->id])) : ?>
                                <button type="button" rel="tooltip" title="" class="btn btn-link pe-0" data-original-title="Edit Task">
                                    <?= Html::a('<i class="tim-icons icon-pencil"></i>', ['update', 'id'=>$model->id]) ?>
                                </button>
                            <?php endif; ?>

                            <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                <?= Html::a('<i class="tim-icons icon-simple-remove"></i>', ['delete', 'id'=>$model->id], ['data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить задачу?',
                                    'method' => 'post',
                                ]]) ?>
                            </button>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php
    if (Yii::$app->request->get('id') && (Yii::$app->request->get('modal') == false)){
        Modal::begin([
            'headerOptions' => ['class' => 'bg-info'],
            'options' => [
                'id' => 'modal-reflection',
                'style' => 'max-width: 100%;',
            ],
            ]);
?>            
            <div class="reflection-form text-center">

            <h3>Какие у тебя ощущения после выполнеия этой задачи?</h3>

            <?php $form = ActiveForm::begin(); ?>
        
            <?= $form->field($reflection, 'mood_id')->radioList(
                    $mood,
                    [
                        'item' => function($index, $label, $name, $checked, $value) {
                            $img = Mood::findOne($value)->image;
                            $return = '<div class="radio-tile-group col-auto"><div class="input-container">';
                            $return .= Html::radio($name, $checked, ['value' => $value, 'class' => 'display-none']);
                            $return .= '<div class="radio-tile"><img src="'. $img . '"><label>' . $label . '</label></div></div></div>';
                            return $return;
                            },
                            'class' => 'row justify-content-center',
                    ]
                )->label(false);
            ?>
        
            <div class="form-group text-center">
                <?= Html::submitButton('Ок', ['class' => 'btn btn-success']) ?>
            </div>
        
            <?php ActiveForm::end(); ?>
        
        </div>
<?php
        Modal::end();
        $this->registerJs("$(document).ready(()=>$('#modal-reflection').modal('show'))");
    }
?>



