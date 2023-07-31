<?php

use app\models\User;
use app\models\AuthItem;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\bootstrap5\Modal;
use yii\bootstrap5\ActiveForm;
use app\models\Response;
use yii\bootstrap5\LinkPager;
use yii\helpers\VarDumper;

/** @var yii\web\View $this */
/** @var app\models\AdminSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Управление пользователями';
?>

<div class="user-index">

    <h2><?= Html::encode($this->title) ?></h2> 

    <?php Pjax::begin(['id'=>"pjax-user", "enablePushState"=>FALSE, "timeout"=>5000]); ?>

    <div class="row mb-3">
        <button type="button" rel="tooltip" title="" class="btn btn-link col-auto">
            <?= Html::a('<i class="tim-icons icon-simple-add text-info" style="font-size: 25px;" ></i>', ['/site/user-create']) ?>
        </button>
    
        <?php echo $this->render('_search', ['model' => $searchModel, 'dataProvider' => $dataProvider]); ?>
    </div>

    <div class="card card-tasks" style="height: auto;">
        <!-- card body -->
        <div class="card-body">
                <table class="table tablesorter">
                    <thead>
                        <th class="text-dark">Фамилия</th>
                        <th class="text-dark">Имя</th>
                        <th class="text-dark">Отчество</th>
                        <th class="text-dark">Логин</th>
                        <th class="text-dark">Почта</th>
                        <th class="text-dark">Роль в системе</th>
                    </thead>
                    <tbody>
                        <?=  ListView::widget([
                            'dataProvider' => $dataProvider,
                            'itemOptions' => ['class' => 'item'],
                            'layout' => '{items}<div class="mt-3">{pager}</div>',
                            'pager' => ['class' => \yii\bootstrap5\LinkPager::class],
                            'itemView' => 'user', 
                        ]) ?>
                    </tbody>
                </table>
        </div>
    </div>
    <?php Pjax::end(); ?>

</div>

