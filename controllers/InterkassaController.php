<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\InterkassaRefillForm;

class InterkassaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionRefill()
    {
        $model = new InterkassaRefillForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($url = $model->refill()) {
                return $this->redirect($url);
            }
        }

        return $this->render('refill', [
            'model' => $model,
        ]);
    }

    public function actionSuccess()
    {
        return $this->render('success');
    }

    public function actionFailed()
    {
        return $this->render('failed');
    }

    public function actionPending()
    {
        return $this->render('pending');
    }

    public function actionInteraction()
    {
        if (false) {
            Yii::$app->response->setStatusCode(200, 'OK');
        }
    }
}
