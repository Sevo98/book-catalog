<?php
namespace app\models;

use yii\db\ActiveRecord;

class Subscription extends ActiveRecord
{
    public static function tableName()
    {
        return 'subscription';
    }

    public function rules()
    {
        return [
            [['number'], 'required'],
            [['author_id'], 'integer'],
            [['number'], 'string', 'max' => 20],
            [['number'], 'filter', 'filter' => 'trim'],
            [['author_id', 'number'], 'unique', 'targetAttribute' => ['author_id', 'number'],
                'message' => 'Вы уже подписаны на этого автора'],
            [['author_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Автор',
            'number' => 'Номер телефона',
        ];
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }
}