<?php

namespace app\controllers\survey;

use app\models\hronline\Department;
use app\models\survey\TblAkses;
use app\models\survey\TblAktiviti;
use app\models\survey\TblCalon;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;
use yii\helpers\VarDumper;

class KetuaController extends \yii\web\Controller
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
                            return TblAkses::isUserKj(Yii::$app->user->identity->ICNO);
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'remove-staff' => ['post'],
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

    public function actionSenaraiAktiviti()
    {
        $this->view->title = "Senarai Aktiviti";

        $icno = Yii::$app->user->getId();
        $aktiviti = null;

        $department = Department::find()->where(['chief' => $icno])->all();

        $arr_dept = [];

        foreach($department as $dept){
            $arr_dept[] = $dept->id;
        }

        if ($department) {
            $aktiviti = TblAktiviti::find()->where(['dept_id' => $arr_dept, 'status' => 1])->all();
        }

        return $this->render('senarai-aktiviti', [
            'aktiviti' => $aktiviti,
            'bil' => 1,
            'icno' => $icno,
        ]);
    }

    public function actionResult($key)
    {
        $this->view->title = "Keputusan";

        $aktiviti = TblAktiviti::find()->where(['SHA2(id,"256")' => $key])->one();
        $calon = TblCalon::find()->where(['aktiviti_id' => $aktiviti->id])->orderBy(['total_vote'=> SORT_DESC])->all();

        return $this->render('result', [
            'aktiviti' => $aktiviti,
            'calon' => $calon,
            'bil' => 1,
        ]);
    }

    public function actionSyor($id)
    {
        $this->view->title = "Membuat Syor kepada Calon";
        $icno = Yii::$app->user->getId();

        $model = TblCalon::findOne($id);

        $aktiviti = TblAktiviti::findOne($model->aktiviti_id);

        if ($model->load(Yii::$app->request->post())) {

            $model->syor_dt = date('Y-m-d H:i:s');
            $model->syor_icno = $icno;

            if ($model->save()) {
                return $this->redirect(['result', 'key' => hash('sha256', $model->aktiviti_id)]);
            }
        }

        return $this->render('syor', [
            'model' => $model,
            'aktiviti' => $aktiviti,
        ]);
    }
}
