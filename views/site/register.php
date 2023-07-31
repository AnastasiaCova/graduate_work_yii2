<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var app\models\RegisterForm $model */
/** @var ActiveForm $form */
$this->title = 'Регистрация';
?>

<div class="site-register mx-auto card px-2" style="width: 500px;">
    <div class="card-header ">
        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="card-body">

        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col col-form-label'],
                'inputOptions' => ['class' => 'col-lg-3 form-control'],
                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            ],
            ]); ?>
                <?= $form->field($model, 'role')->checkbox([
                    'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                ]) ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'surname')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'patronymic')->textInput(['autofocus' => true]) ?>
                
                <?= $form->field($model, 'email', ['enableAjaxValidation' => true]) ?>
                
                <?= $form->field($model, 'login', ['enableAjaxValidation' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput()?>

                <?= $form->field($model, 'password_repeat')->passwordInput()?>

                <?= $form->field($model, 'rules')->checkbox([
                    'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                ]) ?>
            
                <div class="form-group">
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-secondary', 'name' => 'register-button']) ?>
                </div>
        <?php ActiveForm::end(); ?>
    </div>
</div><!-- site-register -->
