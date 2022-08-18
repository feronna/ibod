<?php

namespace app\controllers;

use app\models\saman\SamanKategori;
use app\models\saman\SamanOld;
use Yii;
use app\models\saman\SamanStatus;
use app\models\saman\SamanStatusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;

/**
 * SamanController implements the CRUD actions for SamanStatus model.
 */
class SamanController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['saman-status','bayar-saman','create','update','saman-status-user'],
                'rules' => [
                    [
                        'actions' => ['saman-status','bayar-saman','create','update'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                              
                                // $check = \app\models\system_core\TblUserAccess::find()->where(['icno' => $logicno])->exists();

                                $user =  array('760809125345','840822125577','870317125207',
                                '871228495921','890618126105','920619125301','900823126063',
                                '770422125825','821229125177','710116125435','860613496249',
                                '940808126459','760410125474','910519125372','881214495321',
                                '690312065577','940808126459','760410125474','910519125372');
                                
                                $check1 = false;
                                if (in_array($logicno, $user))      
                                {
                                    $check1 = true;
                                }                          //$check1 = \app\models\hronline\Tblprcobiodata::find()->where(['IN', 'ICNO', ['881214495321','690312065577','940808126459','760410125474','910519125372']])->andWhere(['!=','Status' , 6 ])->exists();

                                $boleh = false;
                            if ($check1) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all SamanStatus models.
     * @return mixed
     */
    public function actionSamanStatus() {
//        $find = \app\models\stickerold\StickerOld::find()->where(['v_c0_icno'=>820131125975])->one();
//        var_dump($find);die;
        $searchModel = new SamanStatusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('saman-status', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSamanStatusUser($nosaman = null, $nokenderaan = null, $tsaman = null) {
        $icno = Yii::$app->user->getId();
        if (!$nosaman || !$nokenderaan || !$tsaman = null) {
            $staff = \app\models\saman\SamanOld::find()->where(['ICNO' => $icno]);
        }
        if (!$tsaman) {
            $tsaman = '';
        }

        if ($nosaman) {
            $staff = \app\models\saman\SamanOld::find()->where(['ICNO' => $icno])->andWhere(['LIKE', 'NOSAMAN', $nosaman]);
        }
        if ($nokenderaan) {
            $staff = \app\models\saman\SamanOld::find()->where(['ICNO' => $icno])->andWhere(['LIKE', 'NO_KENDERAAN', $nokenderaan]);
        }
        if ($tsaman) {
            $staff = \app\models\saman\SamanOld::find()->where(['ICNO' => $icno])->andWhere(['LIKE', 'TRKHSAMAN', $tsaman])->one();
        }

//        $test = \app\models\saman\SamanOld::find()->where(['ICNO' => 901021125258])->andWhere(['LIKE', 'NO_KENDERAAN', 'sab4703v'])->one();
//        var_dump($test->NOSAMAN);die;
        $searchModel = new \app\models\saman\SamanOldSearch();

//        $staff = \app\models\saman\SamanOld::find()->where(['ICNO' => $icno]);
//        var_dump($staff);die;
        $dataProvider = new ActiveDataProvider([
            'query' => $staff,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        return $this->render('saman-status-user', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'nosaman' => $nosaman,
                    'nokenderaan' => $nokenderaan,
                    'tsaman' => $tsaman,
                    'jenis' => 1,
        ]);
    }

    /**
     * Displays a single SamanStatus model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SamanStatus model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new SamanOld();
        $summon = new SamanStatus();
        $category = SamanKategori::find()->all();
        if ($model->load(Yii::$app->request->post())) {
            $model->TRKHSAMAN = date('Y-m-d H:i:s');
            $model->NO_KENDERAAN = strtoupper(preg_replace('/\s/','',$model->NO_KENDERAAN));
            $model->SIRI_PELEKAT = strtoupper(preg_replace('/\s/','',$model->SIRI_PELEKAT));
            $model->NOSAMAN = strtoupper(preg_replace('/\s/','',$model->NOSAMAN));

            $summon->NOSAMAN = $model->NOSAMAN;
            $summon->INSERTDATE = date('Y-m-d H:i:s');
            $summon->AMOUNT_PENDING = $model->TOTALAMN4;
            $summon->AMNKUNCI = $model->AMNKUNCI;
            $summon->STATUS = "PENDING";
            // var_dump($summon);die;
            $summon->save(false);
            if($model->save()){
                return $this->redirect(['create']);

            }
        }

        return $this->render('create', [
                    'model' => $model,
                    'category' => $category
        ]);
    }

    /**
     * Updates an existing SamanStatus model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->NOSAMAN]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    public function actionBayarSaman($id) {
        $model = $this->findModel($id);
        $model = SamanStatus::find()->joinWith('saman')->where(['ekeselamatan.t_19_eks_bayar.NOSAMAN' => $id])->one();
    //    VarDumper::dump( $model, $depth = 10, $highlight = true);die;
        if ($model->load(Yii::$app->request->post())) {
            $model->PAIDDATE = date('Y-m-d H:i:s');
            $model->UPDATER = Yii::$app->user->getId();
            if($model->save()){
                
                return $this->redirect(['saman-status']);

            }
        }

        return $this->render('bayar-saman', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SamanStatus model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SamanStatus model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SamanStatus the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = SamanStatus::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
