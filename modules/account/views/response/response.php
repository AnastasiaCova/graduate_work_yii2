<?php 
use yii\bootstrap5\Html;
use yii\helpers\Json;
use app\models\Response;
use app\models\Task;
use app\models\Status;
use app\models\AuthAssignment;
use yii\helpers\VarDumper;
?>

<div class="">
    <table class="table">
        <tbody>
            <tr class="row">
                <td class="col row align-items-center">
                    <p class="title m-0 row">
                        <p class="col-auto"><?= Html::a($model->text,['view', 'id' => $model->id], ['class' => 'text-decoration-none text-dark'])?></p>
                        <?php $date = new DateTime($model->date); ?>
                        <p class="text-muted col-auto"><?= $date->format('d.m H:i') ?></p>
                    </p>
                    <p class="text-muted mb-0">
                        <?= $model->student->surname . ' ' . $model->student->name . ' ' . $model->student->patronymic ?> 
                    </p>
                </td>
                <td class="td-actions col-auto row align-items-center px-0 m-0">
                    <?php $s = $model->status->title ?>
                    <div class="<?= ($s == 'Просрочено') ? 'text-danger' : 'text-success' ?>"><?= $s ?></div>
                </td>
            </tr>
        </tbody>
    </table>
</div>



