<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\VarDumper;

/** @var yii\web\View $this */
/** @var app\models\Group $model */

$this->title = $model->title;
\yii\web\YiiAsset::register($this);
?>
<div class="group-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(Yii::$app->user->can('per_head_teacher')) { ?>
        <p>
            <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-info',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить группу?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php } ?>

    <?php if(Yii::$app->user->can('per_manager')) { ?>
        <p>
            <?= Html::a('Управление студентами', ['./stud-of-group/create', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
        </p>
    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table tablesorter'],
        'attributes' => [
            'title',
            [
                'attribute' => 'manager_id',
                'visible' => !Yii::$app->user->can('per_student'),
                'value' => function ($model) {
                    return $model->manager->surname . ' ' . $model->manager->name . ' ' . $model->manager->patronymic;
                },
            ],
            [
                'attribute' => 'id',
                'format' => 'html',
                'value' => function ($model) {
                    $student = '';
                    foreach($model->studOfGroups as $value)
                    {
                        $student .= 
                        '<div>
                            <table class="table">
                                <tbody>
                                    <tr class="row">
                                        <td class="col-5">' . $value->student->surname . '</td>
                                        <td class="col">' . $value->student->name . '</td>
                                        <td class="col">' . $value->student->patronymic . '</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>';
                    }
                    return $student;
                },
                'label' => 'Студенты',
                'filter' => false,
            ],
        ],
    ]) ?>

</div>
