<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\AuthItem;

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\User $model */

?>
<div class="user-form">

<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'fieldConfig' => [
        'template' => "{label}\n{input}\n{error}",
        'labelOptions' => ['class' => 'col col-form-label'],
    ],
    ]); ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                <h4 class="title">Личный кабинет</h4>
                </div>
                <?php if ($success) { ?>
                    <div class="alert alert-success mx-2">
                        <button type="button" aria-hidden="true" class="close btn btn-link" data-dismiss="alert" aria-label="Close">
                        <i class="tim-icons icon-simple-remove"></i>
                        </button>
                        <span>Профиль<b> успешно </b>отредактирован!</span>
                    </div>
                <?php } ?>
                <div class="card-body">
                <form>
                    
                        
                    <div class="row mx-1">
                        <div class="col-md pr-md-1">
                            <div class="form-group me-3">
                                <?= $form->field($model, 'surname')->textInput() ?>
                            </div>
                        </div>
                        <div class="col-md px-md-1 me-3">
                            <div class="form-group">
                                <?= $form->field($model, 'name')->textInput() ?>
                            </div>
                        </div>
                        <div class="col-md pl-md-1">
                            <div class="form-group">
                                <?= $form->field($model, 'patronymic')->textInput() ?>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-1">
                        <div class="col-md pr-md-1 me-2">
                            <div class="form-group">
                                <?= $form->field($model, 'email') ?>
                            </div>
                        </div>
                        <div class="col-md pl-md-1">
                            <div class="form-group">
                                <?= $form->field($model, 'login') ?>
                            </div>
                        </div>
                    </div>
                    <div class="row ms-1">
                        <div class="col-md pr-md-1 ps-0">
                            <?= Html::a('Изменить пароль', ['change-password'], ['class' => 'btn btn-secondary']) ?>
                        </div>
                    </div>
                </form>
                </div>
                <div class="card-footer">
                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-info']) ?>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-user">
                <div class="card-body ">
                    <p class="card-text">
                        <div class="author">
                        <div class="block block-one" style="background: linear-gradient(90deg,rgb(30 138 248 / 60%) 0,rgba(225,78,202,0));"></div>
                        <div class="block block-two" style="background: linear-gradient(90deg,rgb(30 138 248 / 60%) 0,rgba(225,78,202,0));"></div>
                        <div class="block block-three" style="background: linear-gradient(90deg,rgb(30 138 248 / 60%) 0,rgba(225,78,202,0));"></div>
                        <div class="block block-four" style="background: linear-gradient(90deg,rgb(30 138 248 / 60%) 0,rgba(225,78,202,0));"></div>
                        <i class="tim-icons icon-single-02 mb-2" style="font-size: 50px;"></i>
                        <h3 class="title"><?= $model->surname ?> <?= $model->name ?></h3>
                        </div>
                    </p>
                    <p class="card-description text-center">
                        <?= AuthItem::findOne($model->authAssignments->item_name)->title; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>


