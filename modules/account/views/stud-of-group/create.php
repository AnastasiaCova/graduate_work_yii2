<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\StudOfGroup $model */
$this->title = 'Управление студентами';
?>
<div class="stud-of-group-create">

    <?= $this->render('_form', [
        'model' => $model,
        'student' => $student,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
