<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ChangePasswordForm extends Model
{
    public $password;
    public $new_password;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['password', 'new_password'], 'required', 'message'=>'Данное поле не может быть пустым.'],
            [['password', 'new_password'], 'string', 'max' => 255],
            [['password', 'new_password'], 'string', 'min' => 6, 'message'=>'Пароль должен содержать минимум 6 символов.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Старый пароль',
            'new_password' => 'Новый пароль',
        ];
    }

}
