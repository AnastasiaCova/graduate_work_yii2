<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "response_files".
 *
 * @property int $id
 * @property int $response_id
 * @property int $file_id
 *
 * @property File $file
 * @property Response $response
 */
class ResponseFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'response_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['response_id', 'file_id'], 'required'],
            [['response_id', 'file_id'], 'integer'],
            [['response_id'], 'exist', 'skipOnError' => true, 'targetClass' => Response::class, 'targetAttribute' => ['response_id' => 'id']],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['file_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'response_id' => 'Ответ',
            'file_id' => 'Файл',
        ];
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::class, ['id' => 'file_id']);
    }

    /**
     * Gets query for [[Response]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponse()
    {
        return $this->hasOne(Response::class, ['id' => 'response_id']);
    }
}
