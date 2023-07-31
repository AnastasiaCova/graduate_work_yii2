<?php

use app\models\Group;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\GroupSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Группы';
?>
<div class="group-index">

    <h2>Группы</h2>

    <?php if(!Yii::$app->user->can('per_manager')) { ?>
        <button type="button" rel="tooltip" title="" class="btn btn-link">
            <?= Html::a('<i class="tim-icons icon-simple-add text-info" style="font-size: 25px;" ></i>', ['create']) ?>
        </button>
    <?php } ?>

    <?php if (!Yii::$app->user->can('per_manager') || !empty(Group::findOne(['manager_id' => Yii::$app->user->id]))) { ?>
        <?php Pjax::begin(['id'=>"pjax-group", "enablePushState"=>FALSE, "timeout"=>5000]); ?>

            <?=  ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item col-auto'],
                'layout' => '<div class="row">{items}</div><div class="mt-3">{pager}</div>',
                'pager' => ['class' => \yii\bootstrap5\LinkPager::class],
                'itemView' => 'group', 
            ]) ?>

        <?php Pjax::end(); ?>
    
    <?php }else{ ?>
            
        <div class="card-header text-center">
            <img src="/img/scared.png" class="my-3" style="max-height: 200px;">
            <div class="row card-title mx-3">
                <div class="col text-center align-self-center">
                    <h3>У вас еще нет групп! Но скоро они обязательно появятся.</h3>
                </div>
            </div>
            
        </div>
        
    <?php } ?>


</div>
