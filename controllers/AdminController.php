<?php

namespace greeschenko\useractivitylog\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use greeschenko\useractivitylog\models\UseractivitylogSearch;
use greeschenko\useractivitylog\models\UsererrorlogSearch;

class AdminController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return !Yii::$app->user->isGuest
                                and Yii::$app->user->identity->role == 'admin';
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new UseractivitylogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionErrors()
    {
        $searchModel = new UsererrorlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('errors', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
