<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\Book;
use app\models\Subscription;
use yii\data\ActiveDataProvider;

class BookController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    ['allow' => true, 'roles' => ['@']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => ['delete' => ['POST']],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Book::find()->with('authors'),
            'pagination' => ['pageSize' => 10],
            'sort' => ['defaultOrder' => ['year' => SORT_DESC]],
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'book' => $this->findModel($id),
        ]);
    }
    public function actionCreate()
    {
        $model = new Book();

        if ($model->load(Yii::$app->request->post())) {
            $this->handleImageUpload($model);

            if ($model->save()) {
                $this->notifySubscribers($model);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldImg = $model->img;
        $model->authorIds = array_map(fn($a) => $a->id, $model->authors);

        if ($model->load(Yii::$app->request->post())) {
            $this->handleImageUpload($model, true);

            if (empty($model->img)) {
                $model->img = $oldImg;
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    private function handleImageUpload(Book $model, bool $isUpdate = false): void
    {
        $image = UploadedFile::getInstance($model, 'img');
        if ($image) {
            $uploadPath = Yii::getAlias('@webroot/uploads');
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            if ($isUpdate && $model->img && file_exists($uploadPath . '/' . $model->img)) {
                unlink($uploadPath . '/' . $model->img);
            }

            $fileName = uniqid('book_') . '.' . $image->extension;
            $image->saveAs($uploadPath . '/' . $fileName);
            $model->img = $fileName;
        }
    }


    private function notifySubscribers(Book $model): void
    {
        foreach ($model->authors as $author) {
            $subscribers = Subscription::findAll(['author_id' => $author->id]);
            foreach ($subscribers as $sub) {
                Yii::$app->smsNotifier->sendNewBookNotification(
                    $sub->number,
                    $author->name,
                    $model->name
                );
            }
        }
    }

    protected function findModel($id): Book
    {
        $model = Book::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Книга не найдена.');
        }
        return $model;
    }
}