<?php

namespace app\controllers\survey;

use app\models\survey\TblAkses;
use app\models\survey\TblAktiviti;
use app\models\survey\TblCalon;
use app\models\survey\TblPengundi;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

class UrusetiaJbtnController extends \yii\web\Controller
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
                            return TblAkses::isUserUrusetia(Yii::$app->user->identity->ICNO);
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
        $dept_id = Yii::$app->user->identity->DeptId;

        $aktiviti = TblAktiviti::find()->where(['status' => 1, 'dept_id'=>$dept_id])->all();

        return $this->render('senarai-aktiviti', [
            'model' => $aktiviti,
            'bil' => 1,
            'icno' => $icno,
        ]);
    }

    public function actionPerincianAktiviti($id)
    {
        $this->view->title = "Maklumat Aktiviti";

        $aktiviti = TblAktiviti::findOne($id);
        $calon = TblCalon::findAll(['aktiviti_id' => $id]);
        $pengundi = TblPengundi::find()->where(['aktiviti_id' => $id])->orderBy(['vote_status'=>SORT_DESC])->all();

        $completed = TblPengundi::find()->where(['aktiviti_id' => $id, 'vote_status' => 1])->count();
        $total = count($pengundi);

        return $this->render('perincian-aktiviti', [
            'aktiviti' => $aktiviti,
            'calon' => $calon,
            'pengundi' => $pengundi,
            'completed' => $completed,
            'total' => $total,
            'bil' => 1,
            'id' => $id,
        ]);
    }

   
}
