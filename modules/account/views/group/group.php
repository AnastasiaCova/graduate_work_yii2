<?php 
use yii\bootstrap5\Html;
use yii\helpers\Json;
use app\models\Group;
use app\models\AuthAssignment;
use yii\helpers\VarDumper;
?>

<div class="card card-chart">
    <?php if(!Yii::$app->user->can('per_manager')) {?>
        <div class="card-header ">
            <h5 class="card-category"><?= $model->manager->surname . ' ' . $model->manager->name . ' ' . $model->manager->patronymic ?></h5>
        </div>
    <?php } ?>
    <div class="card-body">
        <h2 class="card-title mx-2">
            <button type="button" rel="tooltip" class="btn btn-link m-0 p-0 text-decoration-none">
                <p><?= Html::a('<i class="tim-icons icon-planet me-2" style="font-size: 25px;" ></i>' .  $model->title, ['view', 'id' => $model->id], ['class' => 'text-decoration-none text-info']) ?></p>
            </button>
        </h2>
    </div>
</div>



