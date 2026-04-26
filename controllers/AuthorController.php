<?php
namespace app\controllers;

use app\models\Subscription;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\Author;
use yii\data\ActiveDataProvider;

class AuthorController extends Controller
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
            'query' => Author::find()->with('books'),
            'pagination' => ['pageSize' => 10],
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $subscription = new Subscription();

        if (Yii::$app->request->isPost && $subscription->load(Yii::$app->request->post())) {
            $subscription->author_id = $model->id;

            $existing = Subscription::findOne([
                'author_id' => $model->id,
                'number' => trim($subscription->number)
            ]);

            if ($existing) {
                Yii::$app->session->setFlash('warning', 'Подписка на этого автора уже оформлена.');
            } elseif ($subscription->save()) {
                Yii::$app->session->setFlash('success', 'Вы успешно подписались на уведомления о новых книгах!');
            }

            return $this->refresh();
        }

        return $this->render('view', [
            'model' => $model,
            'subscription' => $subscription,
        ]);
    }

    public function actionCreate()
    {
        $model = new Author();
        if ($model->load(Yii::$app->request->post())) {
            $this->handleImageUpload($model);
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldImg = $model->img;

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

    private function handleImageUpload(Author $model, $isUpdate = false)
    {
        $image = UploadedFile::getInstance($model, 'img');
        if ($image) {
            $uploadPath = Yii::getAlias('@webroot/uploads/authors');
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            if ($isUpdate && $model->img && file_exists($uploadPath . '/' . $model->img)) {
                unlink($uploadPath . '/' . $model->img);
            }

            $fileName = uniqid('auth_') . '.' . $image->extension;
            $image->saveAs($uploadPath . '/' . $fileName);
            $model->img = $fileName;
        }
    }

    protected function findModel($id)
    {
        $model = Author::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('Автор не найден.');
        }
        return $model;
    }
}