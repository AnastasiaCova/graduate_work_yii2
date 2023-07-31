<?php 
use yii\bootstrap5\Html;
use yii\helpers\Json;
use app\models\Group;
use app\models\StudOfGroup;
use app\models\AuthAssignment;
use yii\helpers\VarDumper;
$this->title = 'Студенты';
?>

<div>
    <div class="row">
        <div class="col row align-items-center">
            <p class="title m-0 row">
                <p class="col-auto"><?= $model->student->surname . ' ' . $model->student->name . ' ' . $model->student->patronymic ?> </p>
            </p>
            <p class="text-muted mb-0">
                <?= $model->student->email ?>
            </p>
        </div>
        <div class="td-actions col-auto row align-items-center px-0 m-0">
            <button type="button" rel="tooltip" class="btn btn-link ps-0">
                <?= Html::a('<i class="tim-icons icon-simple-remove"></i>', ['delete', 'id'=>$model->id, 'group'=>Yii::$app->request->get('id')], ['data' => [
                    'method' => 'post',
                ]]) ?>
            </button>
        </div>
    </div>
    <hr/>
</div>



