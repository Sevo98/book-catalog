<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $name
 * @property int $year
 * @property string $description
 * @property string $isbn
 * @property string $img
 *
 * @property BookAuthors[] $bookAuthors
 */
class Book extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    public $authorIds = [];
    public function rules()
    {
        return [
            [['name', 'year', 'description'], 'required'],
            [['year'], 'integer'],
            [['name', 'isbn', 'img'], 'string', 'max' => 256],
            [['isbn'], 'string'],
            [['description'], 'string'],
            [['img'], 'file', 'extensions' => 'png, jpg, jpeg, gif', 'maxSize' => 2 * 1024 * 1024, 'skipOnEmpty' => true],
            [['authorIds'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'year' => 'Год публикации',
            'description' => 'Описание',
            'isbn' => 'ISBN',
            'img' => 'Обложка',
            'authorIds' => 'Авторы'
        ];
    }

    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthors::class, ['book_id' => 'id']);
    }

    /**
     * Связь с авторами через промежуточную таблицу
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->via('bookAuthors');
    }

    public function actionView($id)
    {
        $book = Book::findOne(['id' => $id]);
        if ($book === null) {
            throw new \yii\web\NotFoundHttpException('Книга не найдена.');
        }

        return $this->render('view', [
            'book' => $book,
        ]);
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $authorIds = is_array($this->authorIds) ? $this->authorIds : [];

        $this->unlinkAll('bookAuthors', true);
        foreach ($authorIds as $authorId) {
            if (!empty($authorId)) {
                $this->link('authors', Author::findOne($authorId));
            }
        }
    }
}
