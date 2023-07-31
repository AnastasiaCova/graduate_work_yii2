<?php

use app\models\Subject;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\SubjectSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Предметы';
?>
<div class="subject-index">

    <h2>Академические предметы</h2>

    <?php Pjax::begin(['id'=>"pjax-subject", "enablePushState"=>FALSE, "timeout"=>5000]); ?>

    <div class="row mb-3">
        <button type="button" rel="tooltip" title="" class="btn btn-link col-auto">
            <?= Html::a('<i class="tim-icons icon-simple-add text-info" style="font-size: 25px;" ></i>', ['create']) ?>
        </button>
    
        <?php echo $this->render('_search', ['model' => $searchModel, 'dataProvider' => $dataProvider]); ?>
    </div>

        <?=  ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item col-auto'],
            'layout' => '<div class="row">{items}</div><div class="mt-3">{pager}</div>',
            'pager' => ['class' => \yii\bootstrap5\LinkPager::class],
            'itemView' => 'subject', 
        ]) ?>

    <?php Pjax::end(); ?>

</div>
