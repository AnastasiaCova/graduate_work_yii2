<?php

namespace app\models;

use yii\helpers\VarDumper;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class UserCreateForm extends Model
{
    public $name;
    public $surname;
    public $patronymic;
    public $login;
    public $email;
    public $password;
    public $password_repeat;
    public $role;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'login', 'email', 'password', 'password_repeat', 'role'], 'required', 'message'=>'Данное поле не может быть пустым.'],
            [['name', 'surname', 'patronymic', 'login', 'email', 'password', 'password_repeat'], 'string', 'max' => 255],
            ['patronymic', 'default', 'value' => null],
            [['password', 'password_repeat'], 'string', 'min' => 6, 'message'=>'Пароль должен содержать минимум 6 символов.'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message'=>'Неправильный пароль.'],
            ['email', 'email', 'message'=>'Неверный формат почты.'],
            ['login', 'unique', 'targetClass'=>User::class, 'message'=>'Такой логин уже существует.'],
            ['email', 'unique', 'targetClass'=>User::class, 'message'=>'Такая почта уже существует.'],
            [['name','patronymic','surname'], 'match', 'pattern' => '/^[а-яА-ЯёЁ\-\s]+$/u', 'message'=>'Пожалуйста, введите ФИО на русском языке.'],
            ['login', 'match', 'pattern' => '/^[a-zA-Z0-9-]+$/', 'message'=>'В логине используется только латиница.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество (не обязательно)',
            'login' => 'Логин',
            'email' => 'Почта',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
            'role' => 'Роль в сиситеме',
        ];
    }


    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function createUser()
    {
        if ($this->validate()) {
            $user = new User();
            $auth = \Yii::$app->authManager;
            if($user->load($this->attributes, '')) {
                $user->save(false);
                Yii::$app->session->setFlash('success', 
                'Пользователь создан успешно!');
                $auth->assign($auth->getRole($this->role), $user->getId()); 
            }   
        }   
        return $user ?? false;
    }
}
