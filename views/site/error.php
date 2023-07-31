<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception$exception */

use yii\bootstrap5\Html;

$this->title = $name;
?>
<div class="card card-chart">
    <div class="card-header ">
        <div class="row">
            <div class="col text-left">
                <h5 class="card-category"><?= Html::encode($this->title) ?></h5>
                <div class="card-title alert alert-danger">
                    <?= nl2br(Html::encode($message)) ?>
                </div>
            </div>
        </div>
    </div>
</div>