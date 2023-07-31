<?php

use app\models\Task;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\VarDumper;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\bootstrap5\Modal;
use yii\bootstrap5\ActiveForm;
use app\models\Response;
use yii\bootstrap5\LinkPager;

/** @var yii\web\View $this */
/** @var app\models\TaskSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Задачи';
?>
<div class="task-index">

    <?php if(Yii::$app->user->can('per_user')) {?>
        <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
            <?= Html::a('<i class="tim-icons icon-simple-add text-info" style="font-size: 25px;" ></i>', ['create']) ?>
        </button>
    <?php } ?>


    <div class="card card-tasks" style="height: auto;">
        <div class="card-header ">
            <h6 class="title d-inline">Задачи (<?= $count ?>)</h6>
        </div>

        <!-- card body -->
        <div class="card-body">
    
            <?php Pjax::begin(['id'=>"pjax-task", "enablePushState"=>FALSE, "timeout"=>5000]); ?>

                <div class="row">
                    <div class="col-auto" style="width:310px">
                        <?php echo $this->render('_search', ['model' => $searchModel, 'dataProvider' => $dataProvider, 'priority' => $priority, 'status' => $status, 'subject' => $subject]); ?>
                    </div>

                    <?php if ($count > 0) { ?>
                        <div class="col">
                            <?=  ListView::widget([
                                'dataProvider' => $dataProvider,
                                'itemOptions' => ['class' => 'item'],
                                'layout' => '{items}<div class="mt-3">{pager}</div>',
                                'pager' => ['class' => \yii\bootstrap5\LinkPager::class],
                                'itemView' => 'task', 
                                'viewParams' => [
                                    'reflection' => $reflection,
                                    'mood' => $mood,
                                ],
                            ]) ?>
                        </div>
                    <?php }else{ ?>

                        <div class="col card-header text-center">
                            <img src="/img/scared.png" class="my-3" style="max-height: 200px;">
                            <div class="row card-title mx-3">
                                <div class="col text-center align-self-center">
                                    <h2>Когда ты начнешь выполнять задачи, они появятся здесь!</h2>
                                </div>
                            </div>
                            
                        </div>

                    <?php } ?>
                </div>

                

            <?php Pjax::end(); ?>
            
        </div>

    </div>

</div>
