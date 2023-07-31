<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string|null $patronymic
 * @property string $login
 * @property string $email
 * @property string $password
 * @property string $auth_key
 *
 * @property Group[] $groups
 * @property Response[] $responses
 * @property StudOfGroup[] $studOfGroups
 * @property Task[] $tasks
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $role;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'login', 'email', 'password', 'auth_key', 'role'], 'required', 'message'=>'Данное поле не может быть пустым.'],
            [['name', 'surname', 'patronymic', 'login', 'email', 'password', 'auth_key'], 'string', 'max' => 255],
            ['patronymic', 'default', 'value' => null],
            ['email', 'email', 'message'=>'Неверный формат почты.'],
            ['login', 'unique', 'targetClass'=>User::class, 'message'=>'Такой логин уже существует.'],
            ['email', 'unique', 'targetClass'=>User::class, 'message'=>'Такой почтовый адрес уже существует.'],
            [['name','patronymic','surname'], 'match', 'pattern' => '/^[а-яА-ЯёЁ\-\s]+$/u', 'message'=>'Пожалуйста, введите ФИО на русском языке.'],
            ['login', 'match', 'pattern' => '/^[a-zA-Z0-9-]+$/', 'message'=>'В логине используется только латиница.'],
        
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID пользователя',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'login' => 'Логин',
            'email' => 'Почта',
            'password' => 'Пароль',
            'auth_key' => 'Auth Key',
            'role' => 'Роль в сиситеме',
        ];
    }

    /**
     * Gets query for [[Groups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Group::class, ['manager_id' => 'id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::class, ['student_id' => 'id']);
    }

    /**
     * Gets query for [[StudOfGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudOfGroups()
    {
        return $this->hasMany(StudOfGroup::class, ['student_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['user_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        //return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) { 
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
                $this->password = Yii::$app->security->generatePasswordHash($this->password);
            }
            return true;
        }
        return false;
    }

    public static function findByUsername($login)
    {
        return static::findOne(['login' => $login]);
    }
    
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function getAuthAssignments()
    {
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id']);
    }

    public static function getManagerList()
    {
        $auth = \Yii::$app->authManager;
        $man = static::find()->select(['id', 'surname', 'name', 'patronymic'])->where(['id' => $auth->getUserIdsByRole('manager')])->all(); 
        $fio = [];
        foreach ($man as $m) {
            $fio[$m['id']] = $m['surname'] . ' ' . $m['name'] . ' ' . $m['patronymic'];
        }
        return $fio;
    }

    public static function getStudentList()
    {
        $auth = \Yii::$app->authManager;
        $stud = static::find()->select(['id', 'surname', 'name', 'patronymic'])->where(['id' => $auth->getUserIdsByRole('student')])->orderBy('surname ASC')->all(); 
        $fio = [];
        foreach ($stud as $s) {
            if (!StudOfGroup::findOne(['student_id' => $s['id']])){
                $fio[$s['id']] = $s['surname'] . ' ' . $s['name'] . ' ' . $s['patronymic'];
            }
        }
        return $fio;
    }

    public static function getNoReplyStudentList($task_id, $group_id)
    {
        $stud = static::find()
                        ->select(['id', 'surname', 'name', 'patronymic'])
                        ->where(['id' => StudOfGroup::find()->select(['student_id'])->where(['group_id' => $group_id])])
                        ->all(); 
        $fio = [];
        foreach ($stud as $s) {
            if (!Response::findOne(['task_id' => $task_id, 'student_id' => $s['id']])){
                $fio[$s['id']] = $s['surname'] . ' ' . $s['name'] . ' ' . $s['patronymic'];
            }
        }
        return $fio;
    }

}
