<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UserCreateForm $model */
/** @var ActiveForm $form */
$this->title = 'Создание пользователя';
?>
<div class="site-usercreate">
<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin([
    'id' => 'usercreate-form',
    'layout' => 'horizontal',
    'fieldConfig' => [
        'template' => "{label}\n{input}\n{error}",
        'labelOptions' => ['class' => 'col col-form-label'],
        'inputOptions' => ['class' => 'col-lg-3 form-control'],
        'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
    ],
    ]); ?>
        <?= $form->field($model, 'role')->dropdownList($role, ['prompt'=>'Выберете роль']) ?>

        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'surname')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'patronymic')->textInput(['autofocus' => true]) ?>
        
        <?= $form->field($model, 'email', ['enableAjaxValidation' => true]) ?>
        
        <?= $form->field($model, 'login', ['enableAjaxValidation' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput()?>

        <?= $form->field($model, 'password_repeat')->passwordInput()?>
    
        <div class="form-group">
            <?= Html::submitButton('Зарегистрировать', ['class' => 'btn btn-info', 'name' => 'usercreate-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-usercreate -->
