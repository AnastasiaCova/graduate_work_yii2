<?php 
use yii\bootstrap5\Html;
use yii\helpers\Json;
use app\models\Subject;
use app\models\AuthAssignment;
use yii\helpers\VarDumper;
?>

<div class="card card-chart">
    <div class="card-body">
        <h3 class="card-title mx-2">
            <button type="button" rel="tooltip" class="btn btn-link m-0 p-0 text-decoration-none">
                <?= Html::a('<i class="tim-icons icon-atom me-2" style="font-size: 25px;" ></i>' . $model->title, ['view', 'id' => $model->id], ['class' => 'text-decoration-none text-info']) ?>
            </button>
        </h3>
    </div>
</div>



