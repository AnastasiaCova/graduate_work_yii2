<?php

use yii\bootstrap5\Html;
use yii\widgets\DetailView;
use app\models\AuthItem;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->name;
\yii\web\YiiAsset::register($this);
?>

<div class="user-view text-light">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-info',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table tablesorter'],
        'attributes' => [
            'surname',
            'name',
            'patronymic',
            'login',
            'email',
            [
                'attribute' => 'role',
                'value' => function ($model) {
                    return AuthItem::findOne($model->authAssignments->item_name)->title;
                },
                'label' => 'Роль в системе',
            ],
        ],
    ]) ?>

</div>

