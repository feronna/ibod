<?php

namespace app\controllers;

use app\models\hronline\Tblprcobiodata;
use app\models\utilities\DiariDeleted;
use app\models\utilities\DiariKetuaJbtn;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;


class DiariController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['*'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return DiariKetuaJbtn::isKj(Yii::$app->user->identity->ICNO);
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete-catatan' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $this->view->title = 'Senarai Catatan Diari';

        $icno = Yii::$app->user->getId();

        $searchModel = new DiariKetuaJbtn();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $icno);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'total' => DiariKetuaJbtn::totalByStatus($icno),
        ]);
    }

    public function actionAddCatatan()
    {

        $this->view->title = 'Catatan Baharu';
        $icno = Yii::$app->user->getId();
        $dept_id = Yii::$app->user->identity->DeptId;
        $model = new DiariKetuaJbtn();

        $arrType = $model->arrType();

        $biodata = $this->senaraiNama($icno, $dept_id);

        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $icno;
            $model->create_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Maklumat berjaya disimpan!']);
                return $this->redirect(['index']);
            }
        }

        return $this->render('form-diari', [
            'model' => $model,
            'biodata' => $biodata,
            'arrType' => $arrType,
        ]);
    }

    public function actionUpdateCatatan($id)
    {

        $this->view->title = 'Kemaskini Catatan';

        $icno = Yii::$app->user->getId();
        $dept_id = Yii::$app->user->identity->DeptId;

        $model = DiariKetuaJbtn::findOne($id);
        $arrType = $model->arrType();


        $biodata = $this->senaraiNama($icno, $dept_id);

        if ($model->load(Yii::$app->request->post())) {

            $model->icno = $icno;
            $model->update_dt = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => ' Berjaya', 'type' => 'success', 'msg' => 'Catatan telah berjaya disimpan!']);
                return $this->redirect(['index']);
            }
        }

        return $this->render('form-diari', [
            'model' => $model,
            'biodata' => $biodata,
            'arrType' => $arrType,
        ]);
    }



    public function senaraiNama($icno, $dept_id)
    {

        $biodata = Tblprcobiodata::find()
            ->select(['ICNO', 'CONm'])
            ->where(['Status' => 1, 'deptId' => $dept_id])
            ->andWhere(['<>', 'ICNO', $icno])
            ->all();

        return $biodata;
    }

    public function actionDeleteCatatan($id)
    {

        $model = DiariKetuaJbtn::findOne($id);

        if ($model->delete()) {

            $mdl = new DiariDeleted();
            $mdl->staf_icno = $model->staf_icno;
            $mdl->icno = $model->icno;
            $mdl->title = $model->title;
            $mdl->detail = $model->detail;
            $mdl->status = $model->status;
            $mdl->create_dt = $model->create_dt;
            $mdl->update_dt = $model->update_dt;
            $mdl->delete_dt = date('Y-m-d H:i:s');
            $mdl->save();

            Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Catatan telah dibuang!']);
            return $this->redirect(['index']);
        }
    }

    public function actionView($id)
    {

        $model = DiariKetuaJbtn::findOne($id);

        return $this->renderAjax('view', [
            'model' => $model,
        ]);
    }
}
