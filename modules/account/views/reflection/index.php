<?php

use app\models\Reflection;
use app\models\Mood;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

/** @var yii\web\View $this */
/** @var app\models\ReflectionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Статистика';
?>
<div class="reflection-index">

    <p class="lead text-center">Статистика настроений</p>

    <div class="card card-chart">
        
        <?php if (Reflection::findAll(['user_id' => Yii::$app->user->id])) { ?>
            <div class="card-body">
                <?= Highcharts::widget([
                    'scripts' => [
                        'modules/exporting',
                        'themes/grid-light',
                    ],
                    'options' => [
                        'title' => [
                            'text' => '',
                        ],
                        'xAxis' => [
                            'categories' => $mood,
                        ],
                        'yAxis' => [
                            'title' => ['text' => ''],
                        ],
                        'series' => [
                            [
                                'type' => 'column',
                                'name' => 'Мои настроения',
                                'data' => $statistic,
                                'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
                            ],
                        ],
                    ]
                ]); ?>
            </div>
            <div class="row mx-3">
                <?php foreach(Mood::find()->all() as $m){ ?>
                    <div class="col text-center">
                        <img src="<?= $m->image ?>" style="max-height: 100px;">
                    </div>
                <?php } ?>
            </div>
        <?php }else{ ?>
            
            <div class="card-header text-center">
                <img src="/img/tired.png" class="my-3" style="max-height: 200px;">
                <div class="row card-title mx-3">
                    <div class="col text-center align-self-center">
                        <h3>Когда ты начнешь выполнять задачи и отмечать настроения, здесь появится статистика!</h3>
                    </div>
                </div>
                <div><a href="/account/task"><button class="btn btn-success mb-3" >Начать выполнять задачи!</button></a></div>
                
            </div>
        
        <?php } ?>

    </div>
</div>
