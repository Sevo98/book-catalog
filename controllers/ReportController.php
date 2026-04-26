<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

class ReportController extends Controller
{
    public function actionIndex()
    {
        $year = Yii::$app->request->get('year');
        $models = [];

        if ($year !== null && filter_var($year, FILTER_VALIDATE_INT) !== false) {
            $models = (new \yii\db\Query())
                ->select([
                    'a.id',
                    'a.name',
                    'a.img',
                    'COUNT(b.id) as book_count'
                ])
                ->from(['a' => 'author'])
                ->innerJoin(['ba' => 'book_authors'], 'a.id = ba.author_id')
                ->innerJoin(['b' => 'book'], 'ba.book_id = b.id')
                ->where(['b.year' => $year])
                ->groupBy(['a.id', 'a.name', 'a.img'])
                ->orderBy(['book_count' => SORT_DESC])
                ->limit(10)
                ->all();
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $models,
            'pagination' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'year' => $year,
        ]);
    }
}