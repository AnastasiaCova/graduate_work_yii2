<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ChangePasswordForm $model */
/** @var ActiveForm $form */
$this->title = 'Смена пароля';
?>
<div class="change-password">

    <?php if ($alert) { ?>
        <div class="alert alert-danger">
            <button type="button" aria-hidden="true" class="close btn btn-link" data-dismiss="alert" aria-label="Close">
            <i class="tim-icons icon-simple-remove"></i>
            </button>
            <span>
            <b>Неправильный</b> пароль!</span>
        </div>
    <?php } ?>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'new_password')->passwordInput() ?>
    
        <div class="form-group">
            <?= Html::submitButton('Сменить пароль', ['class' => 'btn btn-secondary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- change-password -->
