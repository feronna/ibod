<?php

namespace app\controllers\patrol;

use app\models\hronline\Tblprcobiodata;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\RefPosKawalanSearch;
use app\models\keselamatan\TblAkses;
use app\models\keselamatan\TblStaffKeselamatan;
use app\models\keselamatan\TempTable;
use app\models\patrol\PatrolExchangepos;
use Yii;
use app\models\patrol\PatrolMainTable;
use app\models\patrol\PatrolMainTableSearch;
use app\models\patrol\RefBit;
use app\models\patrol\RefBitSearch;
use app\models\patrol\RefRoute;
use app\models\patrol\RefRouteSearch;
use app\models\patrol\RekodSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Da\QrCode\QrCode;
use kartik\mpdf\Pdf;
use PhpOffice\PhpSpreadsheet\Reader\Xls\MD5;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * MainController implements the CRUD actions for PatrolMainTable model.
 */
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
                'only' => ['update-akses', 'index', 'akses-pengguna', 'import'],
                'rules' => [
                    [
                        'actions' => ['update-akses', 'index', 'akses-pengguna'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();

                            $check = TblAkses::find()->where(['icno' => $logicno])->andWhere(['isActive' => 1])->exists();
                            $boleh = false;
                            if ($check) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                    [
                        'actions' => ['import'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();

                            $check = TblAkses::find()->where(['icno' => $logicno])->andWhere(['isActive' => 1])
                                ->andWhere(['import-access' => 1])->exists();
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

    /**
     * Lists all PatrolMainTable models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TblAkses();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $today = date('Y-m-d');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProviders' => $dataProvider,
            'today' => $today,
        ]);
    }
    public function actionUpdateAkses($id)
    {
        $model = TblAkses::findOne(['id' => $id]);
        //        = TblStaffKeselamatan::findOne($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dikemaskini!']);
                return $this->redirect(['patrol/admin/akses-pengguna']);
            }
        }
        return $this->render('update-akses', [
            'model' => $model,
            'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm')
        ]);
    }
    public function actionDeleted($id)
    {
        $admin = TblAkses::findOne(['id' => $id]);
        $admin->delete();
        if (TblAkses::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {
            return $this->redirect(['patrol/admin/akses-pengguna']);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['patrol/admin/akses-pengguna']);
        }
    }

    public function actionAksesPengguna()
    {
        $admin = TblAkses::find()->where(['IN', 'akses_level', ['2', '3']])->all(); //cari senarai admin
        $adminbaru = new TblAkses(); //untuk admin baru
        if ($adminbaru->load(Yii::$app->request->post())) {
            if (TblAkses::find()->where(['icno' => $adminbaru->icno])->exists()) { //jika admin sudah wujud
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Sudah Wujud!']);
            } elseif ($adminbaru->kakitangan->CONm != NULL) { //jika icno tidak wujud dalam sistem
                $adminbaru->isActive = 1;
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                $adminbaru->save();
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
            }

            return $this->redirect(['patrol/admin/akses-pengguna']);
        }
        if (TblAkses::find()->where(['icno' => Yii::$app->user->getId()])->exists()) {
            return $this->render('akses-pengguna', [
                'admin' => $admin,
                'adminbaru' => $adminbaru,
                'allBiodata' => ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm')
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['patrol/admin/akses-pengguna']);
        }
    }

    // import bit
    public function actionImport($id)
    {
        $modelImport = new \yii\base\DynamicModel([
            'fileImport' => 'File Import',
        ]);
        $modelImport->addRule(['fileImport'], 'required');
        $modelImport->addRule(['fileImport'], 'file', ['extensions' => 'ods,xls,xlsx'], ['maxSize' => 1024 * 1024]);

        if (Yii::$app->request->post()) {
            $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport, 'fileImport');
            if ($modelImport->fileImport && $modelImport->validate()) {
                $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($modelImport->fileImport->tempName);
                $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $baseRow = 3;
                while (!empty($sheetData[$baseRow]['A'])) {

                    $model = new TempTable();
                    // var_dump($model);die;
                    $model->name = (string) $sheetData[$baseRow]['A']; // nama bit
                    $model->pos = $id; // route_id -> dapat dari refposkawalan pnya id
                    $model->bit = (string) $sheetData[$baseRow]['B']; // kedudukan bit
                    $model->lat = (string) $sheetData[$baseRow]['C']; // kedudukan bit
                    $model->lng = (string) $sheetData[$baseRow]['D']; // kedudukan bit
                    $model->completed = $this->check((string) $sheetData[$baseRow]['A']) ? 3 : 0;
                    $model->type = 1; // check table comment
                    $model->uploader = Yii::$app->user->getId();
                    $model->save(false);

                    $baseRow++;
                }
                // die;
                // Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Jadual Lebih Masa Berjadual Berjaya Di Muat Naik']);
                return $this->redirect(['view-import', 'ids' => $id]);
            } else {
                Yii::$app->getSession()->setFlash('error', 'Error');
            }
        }

        return $this->render('import-method', [
            'modelImport' => $modelImport,
        ]);
    }
    public static function check($id)
    {
        $val = false;
        $model = RefBit::find()->where(['=', 'bit_name', $id])->exists();
        if ($model) {
            $val = true;
        }
        return $val;
    }
    public function actionViewImport()
    {
        $id = Yii::$app->user->getId();
        // $v = false;

        $model = TempTable::find()->where(['uploader' => $id])->andWhere(['type' => 1])->all();
        $verifier = TempTable::find()->where(['uploader' => $id])->andWhere(['name' => 'UMSPER ERROR'])->exists();

        // var_dump($verifier);die;
        return $this->render('view-import', [
            'model' => $model,
            'bil' => 1,
            'verifier' => $verifier,
            'id' => $id,

        ]);
    }
    public function actionUpload($id, $route)
    {

        // var_dump($id,$route);die;
        $temp = TempTable::find()->where(['uploader' => $id])->andWhere(['type' => 1])->andWhere(['completed' => 0])->all();
        $temp1 = TempTable::find()->where(['uploader' => $id])->andWhere(['type' => 1])->andWhere(['completed' => 3])->all();
        $model = new RefBit();
        if ($temp) {
            foreach ($temp as $del) {
                $model->bit_name = $del->name;
                $model->route_id = $del->pos;
                $model->position = $del->bit;
                $model->lat = $del->lat;
                $model->lng = $del->lng;
                $model->isActive = 1;
                $model->updated_by = $id;
                $model->updated_dt = date('Y-m-d h:i:s');
                $model->save(false);
                $del->delete();
            }
        }
        foreach ($temp1 as $del1) {
            $del1->delete();
        }


        return $this->redirect(['patrol/main/bit-list', 'id' => $route]);
    }
    public function actionExchange($icno = null,$date = null,$pos = null,$shift = null)
    {
        $do_icno = Yii::$app->user->getId();
        $camp = TblAkses::find()->where(['icno'=>$do_icno])->one();
        $poskawalan = RefPosKawalan::find()->where(['kampus_id'=>$camp->campus_id])->all();
        $model = new PatrolExchangepos();
        if ($model->load(Yii::$app->request->post())) {

            $model->do_icno = $do_icno;
            $model->icno = $icno;
            $model->tarikh = $date;
            $model->pos_asal = $pos;
            if($model->save()){
                return $this->redirect(['patrol/main/indexs', 'pos' => $pos,'date' => $date]);
            }
        }
        return $this->render('exchange', [
            'model' => $model,
            'bil' => 1,
            'do_icno' => $do_icno,
            'icno' => $icno,
            'pos' => $pos,
            'shift' => $shift,
            'date' => $date,
            'poskawalan' => $poskawalan,

        ]);
    }
    /**
     * Finds the PatrolMainTable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PatrolMainTable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PatrolMainTable::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
