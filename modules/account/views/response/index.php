<?php

use app\models\Response;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\VarDumper;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\bootstrap5\Modal;
use yii\bootstrap5\ActiveForm;
use app\models\Task;

/** @var yii\web\View $this */
/** @var app\models\ResponseSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Ответы';
?>
<div class="response-index">

<div class="card card-tasks" style="height: auto;">
    <div class="card-header ">
        <h6 class="title d-inline">Ответы (<?= $count ?>)</h6>
        <p class="card-category d-inline"><?= Task::findOne($task_id)->title ?></p>
    </div>

    <!-- card body -->
    <div class="card-body">

        <?php Pjax::begin(['id'=>"pjax-resp", "enablePushState"=>FALSE, "timeout"=>5000]); ?>

            <div class="row">
                <div class="col-auto me-4">
                    <?php echo $this->render('_search', ['model' => $searchModel, 'dataProvider' => $dataProvider, 'status' => $status]); ?>
                    <?php if($no_reply != null) { ?>
                        <h5 class="mb-1 mt-3 text-center">Студенты, которые не отправили ответы:</h5>
                        <div class="well border border-secondary rounded p-1 w-auto text-center">
                            <?php foreach ($no_reply as $nr){ ?>
                                <div><?= $nr ?></div>
                            <?php }?>
                        </div>
                    <?php }?>
                </div>

                <div class="col">
                    <?=  ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemOptions' => ['class' => 'item'],
                        'layout' => '{items}<div class="mt-3">{pager}</div>',
                        'pager' => ['class' => \yii\bootstrap5\LinkPager::class],
                        'itemView' => 'response', 
                    ]) ?>
                </div>
            </div>

        <?php Pjax::end(); ?>
        
    </div>
</div>




</div>
