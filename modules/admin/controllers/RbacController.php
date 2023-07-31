<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;

class RbacController extends Controller
{
    public function actionRbacInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // Создание ролей
        $user = $auth->createRole('user');
        $student = $auth->createRole('student');
        $head_teacher = $auth->createRole('head_teacher');
        $manager = $auth->createRole('manager');
        $admin = $auth->createRole('admin');

        // Запись ролей в бд
        $auth->add($user);
        $auth->add($student);
        $auth->add($head_teacher);
        $auth->add($manager);
        $auth->add($admin);

        // Добавление разрешений для общего пользователя (user)
        $per_user = $auth->createPermission('per_user');
        $per_user->description = 'Доступ в личный аккаунт. Добавить задачу. Просмотреть задачи. Редактировать задачу. Удалить задачу. Добавить предмет к задаче.';
        $auth->add($per_user);
        $auth->addChild($user, $per_user);

        // Добавление разрешений для студента (student)
        $per_student = $auth->createPermission('per_student');
        $per_student->description = 'Отправить ответ на задачу. Изменить ответ. Отменить ответ.';
        $auth->add($per_student);
        $auth->addChild($student, $per_student);
        $auth->addChild($student, $user);

        // Добавление разрешений для заместителя директора (head_teacher)
        $per_head_teacher = $auth->createPermission('per_head_teacher');
        $per_head_teacher->description = 'Добавить куратора. Добавить группу. Добавить куратора в группу. Изменить куратора в группе. Создать предмет. Удалить предмет. Добавить задачу для студентов. Изменить задачу. Удалить задачу. Просмотреть ответы студентов на задачу.';
        $auth->add($per_head_teacher);
        $auth->addChild($head_teacher, $per_head_teacher);
        $auth->addChild($head_teacher, $user);

        // Добавление разрешений для куратора (manager)
        $per_manager = $auth->createPermission('per_manager');
        $per_manager->description = 'Создать группу. Изменить группу. Удалить группу. Добавить студента в группу. Удалить студента из группы. Создать предмет. Удалить предмет. Добавить задачу для студентов. Изменить задачу. Удалить задачу. Просмотреть ответы студентов на задачу.';
        $auth->add($per_manager);
        $auth->addChild($manager, $per_manager);
        $auth->addChild($manager, $user);

        // Добавление разрешений для администратора (admin)
        $can_admin = $auth->createPermission('can_admin');
        $can_admin->description = 'Все разрешения + создавать пользователей, изменять их удалять.';
        $auth->add($can_admin);
        $auth->addChild($admin, $can_admin);

        $auth->assign($admin, 1);
        echo 'ok';
        die;
    }
}