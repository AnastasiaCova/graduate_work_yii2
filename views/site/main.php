<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;
use app\models\AuthItem;
use app\models\AuthAssignment;
$this->title = 'Главная';
?>

<div class="card card-chart m-2">
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-lg-4 col-md-12 text-center">
                <img src="/img/mip.png" class="my-3" style="max-height: 400px;">
            </div>
            <div class="col-lg-8 col-md-12 ">
                <div class="text-center">
                    <h2>
                        Система управления
                        <br>
                        <small class="text-info">Учебным временем</small>
                    </h2>
                </div>
                <blockquote class="blockquote blockquote-info me-4 my-0">
                    <p>
                        <span class="fw-bold">Привет!</span> Добро пожаловать в нашу систему! Меня зовут <span class="fw-bold">Мип</span>, я прилетел с планеты Мум, чтобы поделиться с Землянами своими знаниями об управлении и менеджменте. Ведь наша планета является лидирующей в Галактике по креативности и производительности.  
                    </p>
                    <p>
                        Наши Мумы разработали космическую структуру, благодаря которой ты сможешь управлять своими задачами и грамотно распределить рабочее время, не упустив ни один световой миг!
                    </p>
                    <p>
                        Не переживай, я буду твоим личным помощником. <span class="fw-bold">Полетели вперед к знаниям!</span> 
                    </p>
                    <div><a href=<?= !Yii::$app->user->can('can_admin') ? "/account/task" : "/admin" ?> ><button class="btn btn-success mt-3" >Начать планирование</button></a></div>
                </blockquote>
            </div>
            
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
            <div class="places-buttons">
                <div class="row">
                    <div class="col ml-auto mr-auto text-center">
                        <h4 class="card-title">
                        Ухты, <?= AuthItem::findOne(AuthAssignment::findOne(['user_id' => Yii::$app->user->identity->id])->item_name)->title; ?> имеет дополнительные возможности!
                        <p class="category">Кликни по кнопке, чтобы узнать.</p>
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto mx-auto">
                        <div class="row">
                            <?php if(!Yii::$app->user->can('per_student')) { ?>
                                    <div class="col-auto">
                                        <a href="/account/group"><button class="btn btn-info btn-block">Управление группами</button></a>
                                    </div>
                                    <?php if(!Yii::$app->user->can('per_manager')) { ?>
                                        <div class="col-auto">
                                            <a href="/account/subject"><button class="btn btn-info btn-block">Управление предметами</button></a>
                                        </div>
                                    <?php } ?>
                                    <?php if(Yii::$app->user->can('can_admin')) { ?>
                                    <div class="col-auto">
                                        <a href="/admin"><button class="btn btn-info btn-block">Управление пользователями</button></a>
                                    </div>
                                    <?php } ?>
                                <?php } ?>
                                <?php if(!Yii::$app->user->can('can_admin')) { ?>
                                    <div class="col-auto">
                                        <a href="/account/reflection"><button class="btn btn-info btn-block">Статистика настроений</button></a>
                                    </div>
                                <?php } ?>
                        </div>
                    </div>
                </div>
                
            </div>
            </div>
        </div>
    </div>
</div>

