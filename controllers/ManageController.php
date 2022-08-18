<?php

namespace app\controllers;

use Yii;
use app\models\cuti\TblManagement;
use app\models\system_core\TblUserAccess;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ManageController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['*'],
                'rules' => [
                    [
                        // 'actions' => ['*'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();

                            $check = TblUserAccess::find()->where(['icno'=> $logicno])->exists();
                            $boleh = false;
                            if ($check) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [],
            ],
        ];
    }

    public function actionList()
    {
        $model = TblManagement::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        return $this->render(
            'list',
            [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]
        );
    }
    public function actionDeletePh($id)
    {

        $exist = TblManagement::find()->where(['id' => $id])->one();
        $exist->delete();

        return $this->redirect(['list']);
    }
    public function actionEdit($id)
    {
        $icno = Yii::$app->user->getId();

        $model = TblManagement::findOne(['id' => $id]);
        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => ':)']);
                return $this->redirect(['index']);
            }
        }

        return $this->render(
            'index',
            [
                'model' => $model,
            ]
        );
    }
    public function actionAdd()
    {
        $icno = Yii::$app->user->getId();

        $model = new TblManagement();
        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => ':)']);
                return $this->redirect(['index']);
            }
        }

        return $this->render(
            'add',
            [
                'model' => $model,
            ]
        );
    }
}
