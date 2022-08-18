<?php

namespace app\controllers;

use Yii;
use app\models\Notification;
use app\models\system_core\TblUserAccess;
use app\models\hronline\Pendidikan;
use yii\helpers\Html;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblrscoapmtstatus;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\models\hronline\StatusLantikan;
use app\models\hronline\Tblrscosandangan;
use app\models\hronline\Appointmenttype;
use app\models\hronline\GredJawatan;
use app\models\hronline\Tblkecacatan;
use app\models\hronline\Tblfmydisability;
use app\models\hronline\Tblrscoservstatus;
use app\models\hronline\TempPpv;
use app\models\kehadiran\TblWfh;
use app\models\myidp\Kehadiran;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\hronline\Kumpulankhidmat;
use app\models\hronline\Jawatankategori;
use app\models\hronline\ServiceStatus;
use yii\data\ArrayDataProvider;
use yii\helpers\VarDumper;
use app\models\hronline\TblprcobiodataSearch;
use app\models\cv\TblSwSociety;
use app\models\cv\TblSwUniversity;
use app\models\cv\TblSwUniversitySearch;
use app\models\cv\TblSwSocietySearch;
use app\models\myidp\KursusLatihan;
use app\models\hronline\KlasifikasiPerkhidmatan;
use kartik\mpdf\Pdf;

class DataController extends \yii\web\Controller
{
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
                    ],
                    [
                        'actions' => ['senaraistaf-oku', 'senaraitanggungan-oku'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();
                            $id = Yii::$app->request->get('id');
                            if (TblUserAccess::find()->where(['icno' => $logicno])->andWhere(['access' => 4])->exists()) {
                                $check = TblUserAccess::find()->where(['icno' => $logicno])->andWhere(['access' => 4]);
                            }

                            $boleh = false;
                            if (!empty($check)) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }

                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    protected function notifikasi($icno, $content)
    {
        //--------Model Notification-----------//
        $ntf = new Notification(); //noti untuk kp
        $ntf->icno = $icno;
        $ntf->title = 'KEMASKINI MAKLUMAT PENDIDIKAN';
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save(false);
        //--------Model Notification-----------//
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPemurnian()
    {
        return $this->render('pemurnian');
    }

    public function actionLaporanStatistik()
    {
        return $this->render('laporan-statistik');
    }

    public function actionHrmis()
    {
        return $this->render('hrmis');
    }

    public function actionGlosari()
    {
        return $this->render('glosari'); 
    }

    public function GridPendidikan()
    {
        //        $data = new ActiveDataProvider([
        //            'query' => \app\models\hronline\Tblprcobiodata::
        //            find() 
        //           
        //            ->where(['!=','ICNO', '`pendidikan`.`ICNO`'])
        //            ->andWhere(['!=','Status', 6])
        //            ->orderBy(['ICNO'=>SORT_DESC])->groupby('ICNO'),
        //            'pagination' => [
        //            'pageSize' => 10,
        //            ],
        //        ]);

        $biodata_icno_array = \app\models\hronline\Tblprcobiodata::find()->select(['ICNO'])->where(['!=', 'Status', '06'])->asArray()->all();
        $pendidikan_inco_array = \app\models\hronline\Tblpendidikan::find()->select(['ICNO'])->distinct()->asArray()->all();
        for ($i = 0; $i < count($pendidikan_inco_array); $i++) {
            if (($key = array_search($pendidikan_inco_array[$i], $biodata_icno_array)) !== false) {
                unset($biodata_icno_array[$key]);
            }
        }
        //        var_dump($biodata_icno_array);
        //        die;
        $data = new ActiveDataProvider([
            'query' => \app\models\hronline\Tblprcobiodata::find()
                ->where(['IN', 'ICNO', $biodata_icno_array])
                ->orderBy(['ICNO' => SORT_DESC])->groupby('ICNO'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $data;
    }


    public function actionDataPendidikan()
    {

        $urus = $this->GridPendidikan();
        isset(Yii::$app->request->queryParams['ICNO']) ? $urus->query->andFilterWhere(['like', 'ICNO',  Yii::$app->request->queryParams['ICNO']]) : '';
        if (Yii::$app->request->post('notifistaf')) {
            $this->notifistaf();
            return $this->refresh();
        }
        if (TblUserAccess::find()->where(['icno' => Yii::$app->user->getId(), 'access' => [2, 3]])->exists()) {
            return $this->render('a_pendidikan', [
                'urus' => $urus,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->render('index');
        }
    }
    public function actionSenaraiPendidikan()
    {

        $urus = $this->GridPendidikan();
        if (Yii::$app->request->post('notifistaf')) {
            $this->notifistaf();
            return $this->refresh();
        }
        if (TblUserAccess::find()->where(['icno' => Yii::$app->user->getId(), 'access' => [2, 3]])->exists()) {
            return $this->render('a_pendidikan', [
                'urus' => $urus,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->render('index');
        }
    }


    public  function actionNotifistaf()
    {

        $model = Pendidikan::find()->all();
        foreach ($model as $edu) {
            $this->notifikasi(
                $edu->icno,
                "Salam Sejahtera, UMS sedang dalam proses pemurnian data Universiti, oleh itu Tuan/Puan diminta"
                    . " untuk mengemaskini Maklumat Pendidikan <b>DALAM KADAR SEGERA</b>"
                    . Html::a('<i class="fa fa-arrow-right"></i>', ['pendidikan/view'], ['class' => 'btn btn-primary btn-sm'])
            );
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'PERINGATAN MESRA BERJAYA DIHANTAR']);
        return $this->redirect('data-pendidikan');
    }

    protected function findPendidikan($id)
    {
        if (($model = Pendidikan::findOne(['icno' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionAdminStatusLantikan($DeptId = null, $gredJawatan = null, $ICNO = null)
    {
        $dataProvider = new ActiveDataProvider([

            'query' => Tblprcobiodata::find(),
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        if (isset(Yii::$app->request->queryParams['ICNO'])) {
            $ICNO ? $dataProvider->query->andFilterWhere(['ICNO' => $ICNO]) : '';
        }

        if (isset(Yii::$app->request->queryParams['DeptId'])) {
            $DeptId ? $dataProvider->query->andFilterWhere(['DeptId' => $DeptId]) : '';
        }

        if (isset(Yii::$app->request->queryParams['gredJawatan'])) {
            $gredJawatan ? $dataProvider->query->andFilterWhere(['gredJawatan' => $gredJawatan]) : '';
        }

        return $this->render('admin-status-lantikan', [
            'DeptId' => $DeptId,
            'gredJawatan' => $gredJawatan,
            'ICNO' => $ICNO,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetailLantikan($icno)
    {
        $model = Tblrscoapmtstatus::find()->where(['ICNO' => $icno])->one();
        $lantikan = Tblrscoapmtstatus::find()->where(['ICNO' => $icno])->orderBy(['ApmtStatusStDt' => SORT_DESC])->all();
        return $this->render('detail-lantikan', ['lantikan' => $lantikan, 'model' => $model]);
    }

    public function actionTambahLantikan($icno)
    {
        $model = Tblrscoapmtstatus::find()->where(['ICNO' => $icno])->one();
        $models = new Tblrscoapmtstatus();
        $senaraiLantikan =  ArrayHelper::map(StatusLantikan::find()->all(), 'ApmtStatusCd', 'ApmtStatusNm');

        if ($models->load(Yii::$app->request->post())) {
            $models->ICNO = $model->ICNO;
            $models->save();

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
            return $this->redirect(['detail-lantikan', 'icno' => $model->ICNO]);
        }

        return $this->renderAjax('tambah-lantikan', [
            'senaraiLantikan' => $senaraiLantikan, 'model' => $model, 'models' => $models
        ]);
    }

    public function actionKemaskiniLantikan($id)
    {
        $model = Tblrscoapmtstatus::find()->where(['id' => $id])->one();
        $senaraiLantikan =  ArrayHelper::map(StatusLantikan::find()->all(), 'ApmtStatusCd', 'ApmtStatusNm');

        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
            return $this->redirect(['detail-lantikan', 'icno' => $model->ICNO]);
        }

        return $this->renderAjax('kemaskini-lantikan', [
            'senaraiLantikan' => $senaraiLantikan, 'model' => $model
        ]);
    }

    public function actionPadamLantikan($id)
    {
        $model = Tblrscoapmtstatus::find()->where(['id' => $id])->one();
        $model->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['detail-lantikan', 'icno' => $model->ICNO]);
    }

    public function actionAdminStatusSandangan($DeptId = null, $gredJawatan = null, $ICNO = null)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tblprcobiodata::find(),
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        if (isset(Yii::$app->request->queryParams['ICNO'])) {
            $ICNO ? $dataProvider->query->andFilterWhere(['ICNO' => $ICNO]) : '';
        }

        if (isset(Yii::$app->request->queryParams['DeptId'])) {
            $DeptId ? $dataProvider->query->andFilterWhere(['DeptId' => $DeptId]) : '';
        }

        if (isset(Yii::$app->request->queryParams['gredJawatan'])) {
            $gredJawatan ? $dataProvider->query->andFilterWhere(['gredJawatan' => $gredJawatan]) : '';
        }

        return $this->render('admin-status-sandangan', [
            'DeptId' => $DeptId,
            'gredJawatan' => $gredJawatan,
            'ICNO' => $ICNO,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetailSandangan($icno)
    {
        $model = Tblrscosandangan::find()->where(['ICNO' => $icno])->one();
        $sandangan = Tblrscosandangan::find()->where(['ICNO' => $icno])->orderBy(['start_date' => SORT_DESC])->all();
        return $this->render('detail-sandangan', ['sandangan' => $sandangan, 'model' => $model]);
    }

    public function actionTambahSandangan($icno)
    {
        $model = Tblrscosandangan::find()->where(['ICNO' => $icno])->one();
        $models = new Tblrscosandangan();
        $gredJawatan =  ArrayHelper::map(\app\models\hronline\GredJawatan::find()->all(), 'id', 'fname');
        $jenisLantikan =  ArrayHelper::map(Appointmenttype::find()->all(), 'ApmtTypeCd', 'ApmtTypeNm');
        $senaraiSandangan =  ArrayHelper::map(\app\models\hronline\Sandangan::find()->all(), 'sandangan_id', 'sandangan_name');

        if ($models->load(Yii::$app->request->post())) {
            $models->ICNO = $model->ICNO;
            $models->save();

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
            return $this->redirect(['detail-sandangan', 'icno' => $model->ICNO]);
        }

        return $this->renderAjax('tambah-sandangan', [
            'gredJawatan' => $gredJawatan, 'jenisLantikan' => $jenisLantikan, 'senaraiSandangan' => $senaraiSandangan, 'model' => $model, 'models' => $models
        ]);
    }

    public function actionKemaskiniSandangan($id)
    {
        $model = Tblrscosandangan::find()->where(['id' => $id])->one();
        $senaraiLantikan =  ArrayHelper::map(StatusLantikan::find()->all(), 'ApmtStatusCd', 'ApmtStatusNm');
        $gredJawatan =  ArrayHelper::map(\app\models\hronline\GredJawatan::find()->all(), 'id', 'fname');
        $jenisSandangan =  ArrayHelper::map(Appointmenttype::find()->all(), 'ApmtTypeCd', 'ApmtTypeNm');
        $senaraiSandangan =  ArrayHelper::map(\app\models\hronline\Sandangan::find()->all(), 'sandangan_id', 'sandangan_name');

        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
            return $this->redirect(['detail-sandangan', 'icno' => $model->ICNO]);
        }

        return $this->renderAjax('kemaskini-sandangan', ['senaraiLantikan' => $senaraiLantikan, 'model' => $model, 'gredJawatan' => $gredJawatan, 'jenisSandangan' => $jenisSandangan, 'senaraiSandangan' => $senaraiSandangan]);
    }

    public function actionPadamSandangan($id)
    {
        $model = Tblrscosandangan::find()->where(['id' => $id])->one();
        $model->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['detail-sandangan', 'icno' => $model->ICNO]);
    }


    public function actionAdminStatusPerkhidmatan($DeptId = null, $gredJawatan = null, $ICNO = null)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tblprcobiodata::find(),
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        if (isset(Yii::$app->request->queryParams['ICNO'])) {
            $ICNO ? $dataProvider->query->andFilterWhere(['ICNO' => $ICNO]) : '';
        }

        if (isset(Yii::$app->request->queryParams['DeptId'])) {
            $DeptId ? $dataProvider->query->andFilterWhere(['DeptId' => $DeptId]) : '';
        }

        if (isset(Yii::$app->request->queryParams['gredJawatan'])) {
            $gredJawatan ? $dataProvider->query->andFilterWhere(['gredJawatan' => $gredJawatan]) : '';
        }

        return $this->render('admin-status-perkhidmatan', [
            'DeptId' => $DeptId,
            'gredJawatan' => $gredJawatan,
            'ICNO' => $ICNO,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetailPerkhidmatan($icno)
    {
        $model = Tblrscoservstatus::find()->where(['ICNO' => $icno])->one();
        $perkhidmatan = Tblrscoservstatus::find()->where(['ICNO' => $icno])->orderBy(['ServStatusStDt' => SORT_DESC])->all();
        return $this->render('detail-perkhidmatan', ['perkhidmatan' => $perkhidmatan, 'model' => $model]);
    }


    public function actionTambahPerkhidmatan($icno)
    {
        $model = Tblrscoservstatus::find()->where(['ICNO' => $icno])->one();
        $models = new Tblrscoservstatus();
        $statusPerkhidmatan =  ArrayHelper::map(\app\models\hronline\ServiceStatus::find()->all(), 'ServStatusCd', 'ServStatusNm');
        $statusTerperinci =  ArrayHelper::map(\app\models\hronline\Servicestatusdetail::find()->all(), 'id', 'name');

        if ($models->load(Yii::$app->request->post())) {
            $models->ICNO = $model->ICNO;
            $models->save();

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
            return $this->redirect(['detail-perkhidmatan', 'icno' => $model->ICNO]);
        }

        return $this->renderAjax('tambah-perkhidmatan', [
            'statusPerkhidmatan' => $statusPerkhidmatan, 'statusTerperinci' => $statusTerperinci, 'model' => $model, 'models' => $models
        ]);
    }

    public function actionKemaskiniPerkhidmatan($id)
    {
        $model = Tblrscoservstatus::find()->where(['id' => $id])->one();
        $statusPerkhidmatan =  ArrayHelper::map(\app\models\hronline\ServiceStatus::find()->all(), 'ServStatusCd', 'ServStatusNm');
        $statusTerperinci =  ArrayHelper::map(\app\models\hronline\Servicestatusdetail::find()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
            return $this->redirect(['detail-perkhidmatan', 'icno' => $model->ICNO]);
        }

        return $this->renderAjax('kemaskini-perkhidmatan', ['model' => $model, 'statusPerkhidmatan' => $statusPerkhidmatan, 'statusTerperinci' => $statusTerperinci]);
    }

    public function actionPadamPerkhidmatan($id)
    {
        $model = Tblrscoservstatus::find()->where(['id' => $id])->one();
        $model->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['detail-perkhidmatan', 'icno' => $model->ICNO]);
    }

    public function actionCarianAdmin()
    {
        $permohonan = $this->SenaraiRekodKakitangan();
        $search = new \app\models\hronline\TempHrmis();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-admin', 'icno' => $search->icno]);
        }

        return $this->render('carian-admin', [
            'permohonan' => $permohonan,
            'search' => $search,
        ]);
    }



    public function SenaraiRekodKakitangan()
    {
        $data = new ActiveDataProvider([
            'query' => \app\models\hronline\TempHrmis::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function actionCarianPermohonanAdmin($icno)
    {
        $permohonan = $this->GridCarianPermohonanAdmin($icno);
        $search = new \app\models\hronline\TempHrmis();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-admin', 'icno' => $search->icno]);
        }

        return $this->render('carian-admin', [
            'permohonan' => $permohonan,
            'search' => $search,
            'icno' => $icno,
        ]);
    }


    public function GridCarianPermohonanAdmin($icno)
    {
        $data = new ActiveDataProvider([
            'query' => \app\models\hronline\TempHrmis::find()->where(['icno' => $icno]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }
    public function GridRekodAdmin()
    {
        $data = new ActiveDataProvider([
            'query' => TblUserAccess::find()->where(['access' => [2, 3]]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }
    public function actionTambahAdmin()
    {

        $staff = $this->GridRekodAdmin();
        $model = new TblUserAccess();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Ditambah!', 'type' => 'success', 'msg' => '']);
            return $this->redirect(['tambah-admin']);
        }
        if (TblUserAccess::find()->where(['icno' => Yii::$app->user->getId(), 'access' => 2])->exists()) {
            return $this->render('a_tambah_admin', [
                'staff' => $staff,
                'model' => $model,
            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect('../cutibelajar/index');
        }
    }
    public function actionStatistikStaff()
    {
        //        $model = Department::find()
        //                ->where(['id' => [5, 6, 7, 15, 104, 135, 136, 137, 138, 139, 140,
        //                141, 142, 143, 188, 209, 210, 193], 'isActive' => '1']);
        //
        //        $dataProvider = new ActiveDataProvider([
        //            'query' => $model,
        //            'pagination' => false,
        //        ]);

        return $this->render('statistik_keseluruhan');
    }

    public function actionDashboard($date = null, $jfpib = null, $category = null)
    {

        $date = $date ?: date('d M Y');
        $listicno = $jfpib ? Tblprcobiodata::find()->where(['DeptId' => $jfpib])->andWhere(['!=', 'Status', '6']) : Tblprcobiodata::find()->where(['!=', 'Status', '6']);
        $listicno = $category ? $listicno->joinWith('jawatan')->where(['gredjawatan.job_category' => $category]) : $listicno;
        //        $listicno = $campus? $listicno->where(['campus_id' => $campus]): $listicno;

        $biodata = Tblprcobiodata::find()->where(['Status' => 1])->all();
        $model = $date ? \app\models\kehadiran\TblWfh::find()->where(['like', 'start_date', date_format(date_create($date), 'Y-m-d')])->andWhere(['icno' => $listicno->select(['ICNO'])])->all() : \app\models\kehadiran\TblWfh::find()->where(['>', 'start_date', '2020-06-16'])->andWhere(['icno' => $listicno->select(['ICNO'])])->all();
        return $this->render('dashboard', ['model' => $model, 'date' => $date, 'jfpib' => $jfpib, 'category' => $category, 'biodata' => $biodata]);
    }

    public function actionLaporanKehadiran($date = null, $jfpib = null, $category = null)
    {

        $date = $date ?: date('d M Y');
        $listicno = $jfpib ? Tblprcobiodata::find()->where(['DeptId' => $jfpib])->andWhere(['!=', 'Status', '6']) : Tblprcobiodata::find()->where(['!=', 'Status', '6']);
        $listicno = $category ? $listicno->joinWith('jawatan')->where(['gredjawatan.job_category' => $category]) : $listicno;
        //        $listicno = $campus? $listicno->where(['campus_id' => $campus]): $listicno;
        $mpdf = new \Mpdf\Mpdf();

        $biodata = Tblprcobiodata::find()->where(['Status' => 1])->all();
        $model = $date ? \app\models\kehadiran\TblWfh::find()->where(['like', 'start_date', date_format(date_create($date), 'Y-m-d')])->andWhere(['icno' => $listicno->select(['ICNO'])])->all() : \app\models\kehadiran\TblWfh::find()->where(['>', 'start_date', '2020-06-16'])->andWhere(['icno' => $listicno->select(['ICNO'])])->all();
        $mpdf->WriteHTML($this->renderPartial('download', ['model' => $model, 'start_date' => $date, 'jfpib' => $jfpib, 'category' => $category, 'biodata' => $biodata]));
        $mpdf->Output();
    }

    public function actionListKakitanganKeseluruhan($ICNO = null, $DeptId = null, $campus_id = null)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tblprcobiodata::find()
                ->joinWith('department')
                ->joinWith('jawatan')
                ->joinWith('kampus')
                ->where(['<>', 'tblprcobiodata.Status', '6,2,4,5,3'])
                ->andWhere(['campus.campus_id' => 1]),
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        $dataProvider->query->orderBy([
            //       new \yii\db\Expression("Status = 1 ASC"),
            //'id' => SORT_ASC,
            //'ICNO' => SORT_ASC,
        ]);

        if (isset(Yii::$app->request->queryParams['ICNO'])) {
            $ICNO ? $dataProvider->query->andFilterWhere(['ICNO' => $ICNO]) : '';
        }

        if (isset(Yii::$app->request->queryParams['DeptId'])) {
            $DeptId ? $dataProvider->query->andFilterWhere(['DeptId' => $DeptId]) : '';
        }

        if (isset(Yii::$app->request->queryParams['campus_id'])) {
            $campus_id ? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]) : '';
        }

        return $this->render('list-kakitangan-keseluruhan', [
            'ICNO' => $ICNO,
            'DeptId' => $DeptId,
            'campus_id' => $campus_id,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListKakitanganSandakan($ICNO = null, $DeptId = null, $campus_id = null)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tblprcobiodata::find()
                ->joinWith('department')
                ->joinWith('jawatan')
                ->joinWith('kampus')
                ->where(['<>', 'tblprcobiodata.Status', '6,2,4,5,3'])
                ->andWhere(['campus.campus_id' => 3]),
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        $dataProvider->query->orderBy([
            //       new \yii\db\Expression("Status = 1 ASC"),
            //'id' => SORT_ASC,
            //'ICNO' => SORT_ASC,
        ]);

        if (isset(Yii::$app->request->queryParams['ICNO'])) {
            $ICNO ? $dataProvider->query->andFilterWhere(['ICNO' => $ICNO]) : '';
        }

        if (isset(Yii::$app->request->queryParams['DeptId'])) {
            $DeptId ? $dataProvider->query->andFilterWhere(['DeptId' => $DeptId]) : '';
        }

        if (isset(Yii::$app->request->queryParams['campus_id'])) {
            $campus_id ? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]) : '';
        }

        return $this->render('list-kakitangan-sandakan', [
            'ICNO' => $ICNO,
            'DeptId' => $DeptId,
            'campus_id' => $campus_id,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListKakitanganLabuan($ICNO = null, $DeptId = null, $campus_id = null)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tblprcobiodata::find()
                ->joinWith('department')
                ->joinWith('jawatan')
                ->joinWith('kampus')
                ->where(['<>', 'tblprcobiodata.Status', '6,2,4,5,3'])
                ->andWhere(['campus.campus_id' => 2]),
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        $dataProvider->query->orderBy([
            //       new \yii\db\Expression("Status = 1 ASC"),
            //'id' => SORT_ASC,
            //'ICNO' => SORT_ASC,
        ]);

        if (isset(Yii::$app->request->queryParams['ICNO'])) {
            $ICNO ? $dataProvider->query->andFilterWhere(['ICNO' => $ICNO]) : '';
        }

        if (isset(Yii::$app->request->queryParams['DeptId'])) {
            $DeptId ? $dataProvider->query->andFilterWhere(['DeptId' => $DeptId]) : '';
        }

        if (isset(Yii::$app->request->queryParams['campus_id'])) {
            $campus_id ? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]) : '';
        }

        return $this->render('list-kakitangan-labuan', [
            'ICNO' => $ICNO,
            'DeptId' => $DeptId,
            'campus_id' => $campus_id,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListKakitanganKudat($ICNO = null, $DeptId = null, $campus_id = null)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tblprcobiodata::find()
                ->joinWith('department')
                ->joinWith('jawatan')
                ->joinWith('kampus')
                ->where(['<>', 'tblprcobiodata.Status', '6,2,4,5,3'])
                ->andWhere(['campus.campus_id' => 4]),
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        $dataProvider->query->orderBy([
            //       new \yii\db\Expression("Status = 1 ASC"),
            //'id' => SORT_ASC,
            //'ICNO' => SORT_ASC,
        ]);

        if (isset(Yii::$app->request->queryParams['ICNO'])) {
            $ICNO ? $dataProvider->query->andFilterWhere(['ICNO' => $ICNO]) : '';
        }

        if (isset(Yii::$app->request->queryParams['DeptId'])) {
            $DeptId ? $dataProvider->query->andFilterWhere(['DeptId' => $DeptId]) : '';
        }

        if (isset(Yii::$app->request->queryParams['campus_id'])) {
            $campus_id ? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]) : '';
        }

        return $this->render('list-kakitangan-kudat', [
            'ICNO' => $ICNO,
            'DeptId' => $DeptId,
            'campus_id' => $campus_id,
            'dataProvider' => $dataProvider,
        ]);
    }


    
    public function actionListCbKk($ICNO = null, $DeptId = null, $campus_id = null)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tblprcobiodata::find()
                ->joinWith('department')
                ->joinWith('jawatan')
                ->joinWith('kampus')
                ->where(['Status' => 2])
                ->andWhere(['campus.campus_id' => 1]),
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        $dataProvider->query->orderBy([
            //       new \yii\db\Expression("Status = 1 ASC"),
            //'id' => SORT_ASC,
            //'ICNO' => SORT_ASC,
        ]);

        if (isset(Yii::$app->request->queryParams['ICNO'])) {
            $ICNO ? $dataProvider->query->andFilterWhere(['ICNO' => $ICNO]) : '';
        }

        if (isset(Yii::$app->request->queryParams['DeptId'])) {
            $DeptId ? $dataProvider->query->andFilterWhere(['DeptId' => $DeptId]) : '';
        }

        if (isset(Yii::$app->request->queryParams['campus_id'])) {
            $campus_id ? $dataProvider->query->andFilterWhere(['campus_id' => $campus_id]) : '';
        }

        return $this->render('list-cb-kk', [
            'ICNO' => $ICNO,
            'DeptId' => $DeptId,
            'campus_id' => $campus_id,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSenaraistafOku()
    {
        $icno = Yii::$app->user->getId();
        $akses = TblUserAccess::find(['icno' => $icno])->where(['access' => 4])->all();
        if ($akses) {
            $dataProvider = Tblkecacatan::find()
                ->joinWith(['biodata'])
                ->where(['<>', 'tblprcobiodata.Status', '6'])
                ->orderBy(['SocialWelfareNo' => SORT_DESC]);

            $query = new ActiveDataProvider([
                'query' => $dataProvider,
                'pagination' => [
                    'pageSize' => 30,
                ],
            ]);

            return $this->render('senaraistaf-oku', [
                'query' => $query,

            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Haraf Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses.']);
            return $this->redirect(['data/index']);
        }
    }

    public function actionViewStafoku($id)
    {
        $model = Tblkecacatan::find()->where(['ICNO' => $id])->one();

        return $this->render('view-stafoku', [
            'model' => $model,
        ]);
    }

    public function actionSenaraiOku()
    {
        $model = Tblkecacatan::find()
            ->joinWith(['biodata'])
            ->where(['<>', 'tblprcobiodata.Status', '6'])
            ->orderBy(['SocialWelfareNo' => SORT_DESC])->all();

        return $this->render('senarai-oku', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    public function actionSenaraitanggunganOku()
    {
        $icno = Yii::$app->user->getId();
        $akses = TblUserAccess::find(['icno' => $icno])->where(['access' => 4])->all();
        if ($akses) {
            $dataProvider = Tblfmydisability::find()
                ->joinWith(['keluarga'])
                ->joinWith(['keluarga.biodata'])
                ->where(['<>', 'hronline.tblprcobiodata.Status', '6'])
                ->orderBy(['SocialWelfareNo' => SORT_DESC]);

            $query = new ActiveDataProvider([
                'query' => $dataProvider,
                'pagination' => [
                    'pageSize' => 30,
                ],
            ]);

            return $this->render('senaraitanggungan-oku', [
                'query' => $query,

            ]);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Haraf Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses.']);
            return $this->redirect(['data/index']);
        }
    }

    public function actionViewTanggunganoku($id)
    {
        $model = Tblfmydisability::find()->where(['tblfmy_id' => $id])->one();

        return $this->render('view-tanggunganoku', [
            'model' => $model,
        ]);
    }

    public function actionTanggunganOku()
    {
        $model = Tblfmydisability::find()
            ->joinWith(['keluarga'])
            ->joinWith(['keluarga.biodata'])
            ->where(['<>', 'hronline.tblprcobiodata.Status', '6'])
            ->orderBy(['SocialWelfareNo' => SORT_DESC])->all();

        return $this->render('tanggungan-oku', [
            'model' => $model,
            'bil' => 1,
        ]);
    }

    //maklumat eksekutif//

    public function actionMaklumatEksekutif()
    {

        return $this->render('maklumat-eksekutif/index');
    }

    public function actionKategori()
    { //main menu

        $query = Jawatankategori::find()->joinWith('gredJawatan.biodata')->select('`jawatankategori`.`id`,`jawatankategori`.`kategori`,count(`tblprcobiodata`.`ICNO`) AS `_totalCount`')->where(['IN', '`jawatankategori`.`id`', ['1', '2']])->andWhere(['!=', '`tblprcobiodata`.`Status`', '06'])->groupBy(['kategori']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $dp = new ArrayDataProvider([
            'allModels' => $query->all(),
        ]);
        $array = [];
        foreach ($dp->getModels() as $data) {
            array_push($array, [$data->kategori, $data->_totalCount]);
        }

        return $this->render('maklumat-eksekutif/kategori', [
            'dataProvider' => $dataProvider,
            'array' => $array,
        ]);
    }

    public function actionKumpulan($k)
    { //kategori
        if (empty($k) || !in_array($k, [1, 2])) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $query = Kumpulankhidmat::find()->joinWith('gredJawatan.biodata')->select('`kumpkhidmat`.`id`,`kumpkhidmat`.`name`,count(`tblprcobiodata`.`ICNO`) AS `_totalCount`')->where(['`gredjawatan`.`job_category`' => $k])->andWhere(['!=', '`tblprcobiodata`.`Status`', '06'])->groupBy(['`gredjawatan`.`job_group`']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        $dp = new ArrayDataProvider([
            'allModels' => $query->all(),
        ]);
        $array = [];
        foreach ($dp->getModels() as $data) {
            array_push($array, [$data->name, $data->_totalCount]);
        }
        return $this->render('maklumat-eksekutif/Kumpulan', [
            'dataProvider' => $dataProvider,
            'array' => $array,
            'params' => ['k' => $k],
        ]);
    }

    public function actionStatusLantikan($k, $s)
    { //kategori // kumpulan //PengurusanTertinggiAkademik

        $query = StatusLantikan::find()->joinWith('biodata.jawatan')->select('`ApmtStatusCd`,`ApmtStatusNm`,count(`tblprcobiodata`.`ICNO`) AS `_totalCount`')->where(['`gredjawatan`.`job_category`' => $k])
            ->andWhere(['`gredjawatan`.`job_group`' => $s])
            ->andWhere(['!=', '`tblprcobiodata`.`Status`', '06'])->groupBy(['`appointmentstatus`.`ApmtStatusCd`']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $dp = new ArrayDataProvider([
            'allModels' => $query->all(),
        ]);
        $array = [];
        foreach ($dp->getModels() as $data) {
            array_push($array, [$data->ApmtStatusNm, $data->_totalCount]);
        }
        return $this->render('maklumat-eksekutif/kumpulan/statusLantikan', [
            'dataProvider' => $dataProvider,
            'array' => $array,
            'params' => ['k' => $k, 's' => $s],
        ]);
    }

    public function actionStatusPerkhidmatan($k, $s, $p)
    {
        $query = GredJawatan::find()->joinWith('biodata')->select('`id`,`nama`,`gred`,count(`tblprcobiodata`.`ICNO`) AS `_totalCount`')
            ->where(['`gredjawatan`.`job_category`' => $k])
            ->andWhere(['`gredjawatan`.`job_group`' => $s])->andWhere(['`tblprcobiodata`.`statLantikan`' => $p])
            ->andWhere(['!=', '`tblprcobiodata`.`Status`', '06'])->orderBy(['id' => SORT_ASC])->groupBy('id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        
        return $this->render('maklumat-eksekutif/kumpulan/status-lantikan/statusPerkhidmatan', [
            'dataProvider' => $dataProvider,
            'params' => ['k' => $k, 's' => $s, 'p' => $p],
        ]);
    }

    public function actionSenaraiKakitangan($sl,$k, $s, $p, $j)
    { //kumpulan, status lantikan, status perkhidmatan, gredjawatan

        $query = Tblprcobiodata::find()->joinWith(['jawatan', 'department'])->select('`ICNO`,`COOldID`,`CONm`,`department`.`fullname` AS _temp')->where(['`gredjawatan`.`job_category`' => $k])
            ->andWhere(['`gredjawatan`.`job_group`' => $s])->andWhere(['statLantikan' => $p])
            ->andWhere(['`gredjawatan`.`id`' => $j]);
        if($sl == '06'){
            $query->andWhere(['!=','Status',$sl]);
        }else{
            $query->andWhere(['Status'=>$sl]);
        }
        $query->orderBy(['CONm' => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('maklumat-eksekutif/kumpulan/status-lantikan/status-perkhidmatan/senaraiKakitangan', [
            'dataProvider' => $dataProvider,
            'params' => ['sl'=>$sl,'k' => $k, 's' => $s, 'p' => $p, 'j' => $j],
        ]);
    }

    public function actionUrlTo($id)
    {
        $_pages = [
            'akademik' => 'akademik',
            'penadbiran' => 'pentadbiran',
            'pengurusan tertinggi akademik' => 'pengurusan-tertinggi-akademik',
            'lantikan tetap pengurusan tertinggi akademik' => 'status-lantikan-pta',
        ];

        return $this->redirect([$_pages[strtolower($id)]]);
    }




    //tamat maklumat eksekutif//

    public function actionCheckImage()
    {

        $model = Tblprcobiodata::find()
            ->joinWith('pic')
            ->where(['<>', 'hronline.tblprcobiodata.Status', 6]);

        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 150,
            ],
        ]);

        return $this->render(
            'check-image',
            [
                'dataProvider' => $dataProvider,
                'bil' => 1
            ]
        );
    }
    public function actionSearch() {
//        $model = TblAccess::findOne(['ICNO' => Yii::$app->user->getId()]);
//
//        if ($model) {
            $layout = 'profiling/a_search';
//        }

        $searchModel = new TblprcobiodataSearch();
        $dataProvider = $searchModel->searchProfil(Yii::$app->request->queryParams, [1, 2]);

        $model_klasifikasi = KlasifikasiPerkhidmatan::find()->select(["id AS id,concat(gred_skim, ' - ',nama) AS nama"])->orderBy(['gred_skim' => SORT_ASC])->all();
        $arrKlasifikasi = ArrayHelper::map($model_klasifikasi, 'id', 'nama');

        return $this->render($layout, [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'arrKlasifikasi' => $arrKlasifikasi,
        ]);
    }
    public function actionSearchAll() {
//        $model = TblAccess::findOne(['ICNO' => Yii::$app->user->getId()]);
//
//        if ($model) {
            $layout = 'profiling/a_search_all';
//        }

        $searchModel = new TblprcobiodataSearch();
        $dataProvider = $searchModel->searchProfilAll(Yii::$app->request->queryParams, [1, 2]);

        $model_klasifikasi = KlasifikasiPerkhidmatan::find()->select(["id AS id,concat(gred_skim, ' - ',nama) AS nama"])->orderBy(['gred_skim' => SORT_ASC])->all();
        $arrKlasifikasi = ArrayHelper::map($model_klasifikasi, 'id', 'nama');

        return $this->render($layout, [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'arrKlasifikasi' => $arrKlasifikasi,
        ]);
    }
     public function actionDownloadProfil($id) {
        $biodata = $this->findBiodata($id);

        $content = $this->renderPartial('profiling/u_resume', ['biodata' => $biodata]);

        $pdf = $this->findPdf($content);

        return $pdf->render();
    }
     public function findPdf($content) {
        // setup kartik\mpdf\Pdf component
        $data = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => ''],
            // call mPDF methods on the fly
            'marginTop' => 25,
            'marginLeft' => 24,
            'marginRight' => 24,
            'methods' => [
                'SetHeader' => [''],
                'SetFooter' => [''],
                'WriteHTML' => ['']
            ]
        ]);

        return $data;
    }
     public function actionRingkasan($id) {
        $biodata = Tblprcobiodata::find()->where(['ICNO'=>$id])->one();

//        $b = $this->findStudy($id);
//        $pengajian = $this->findPengajian($icno);
//        $test = $this->findBiasiswa($icno);
        return $this->renderAjax('profiling/_ringkasan', [
                'biodata' => $biodata,
                'id'=>$id,
                                 
                   
        ]);
    }
    
    
        public function findBiodata($ICNO) {
            if (($model = Tblprcobiodata::findOne($ICNO)) !== null) {
                return $model;
            }
            throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    
        public function actionResumeCv() {
        $biodata = Tblprcobiodata::findOne(['ICNO' => $this->ICNO()]);

        return $this->render('/profiling/u_1_personal', [
                    'biodata' => $biodata,
        ]);
    }
    
     public function actionViewCv($id, $title) {

        $query1 = Tblprcobiodata::find()->where(['ICNO'=>$id]); 

         $biodata = $this->findBiodata($id);
        

        
              $query1 = (new \yii\db\Query())
               ->select(" hronline.tblprcobiodata.CONm, hrd.idp_sirilatihan.tarikhMula , hrd.idp_kursuslatihan.tajukLatihan, hrd.idp_kursuslatihan.kategori_latihan,  hrd.idp_ref_kategori.kategori_nama_bi ")
               ->from('hrd.idp_kehadiran_siri')
               ->leftJoin('hrd.idp_sirilatihan', 'hrd.idp_kehadiran_siri.siriLatihanID = hrd.idp_sirilatihan.siriLatihanID')
               ->leftJoin('hrd.idp_kursuslatihan', 'hrd.idp_kursuslatihan.kursusLatihanID = hrd.idp_sirilatihan.kursusLatihanID')
               ->leftJoin('hrd.idp_ref_kategori', 'hrd.idp_kehadiran_siri.kompetensi = hrd.idp_ref_kategori.kategori_id')
               ->leftJoin('hronline.tblprcobiodata', 'hrd.idp_kehadiran_siri.staffID = hronline.tblprcobiodata.ICNO')
               ->where(['hrd.idp_kursuslatihan.kategori_latihan' => 1])
               ->andWhere(['hrd.idp_kehadiran_siri.staffID' => $id]);
               
        $query2 = (new \yii\db\Query())
             ->select("hronline.tblprcobiodata.CONm, hronline.v_cpd_latihan.vcl_tkh_mula, hronline.v_cpd_senarai_latihan.vcsl_nama_latihan, hronline.v_cpd_senarai_latihan.kategori_latihan, hrd.idp_ref_kategori.kategori_nama_bi ")
             ->from('hronline.v_cpd_latihan')
             ->leftJoin('hronline.v_cpd_senarai_latihan', 'hronline.v_cpd_latihan.vcl_kod_latihan = hronline.v_cpd_senarai_latihan.vcsl_kod_latihan')
             ->leftJoin('hrd.idp_ref_kategori', 'hronline.v_cpd_latihan.vcl_kod_kompetensi = hrd.idp_ref_kategori.kategori_id')
             ->leftJoin('hronline.tblprcobiodata', 'hronline.v_cpd_latihan.vcl_id_staf = hronline.tblprcobiodata.ICNO')
             ->where(['hronline.v_cpd_senarai_latihan.kategori_latihan' => 1])
             ->andWhere(['hronline.v_cpd_latihan.vcl_id_staf' => $id]);

        $query = $query1->union($query2, true);
           $dataProvider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
           'pageSize' =>  30
           ],
            
       ]);
                       
           $senarai = TblSwSociety::find()->where(['kategori_servis' =>1])->andWhere(['hrm.cv_sw_society.ICNO' =>$biodata->ICNO]);

        

          $senarai = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
         $senarai1 = TblSwUniversity::find()->where(['kategori_servis' =>1])->andWhere(['hrm.cv_sw_university.ICNO' =>$biodata->ICNO]);;

        
//        return $this->render('profiling/view-services', [
//         //   'searchModel' => $searchModel,
////            'dataProvider' => $dataProvider,
//            'senarai' => $senarai,
//    
//            'bil' => 1,
//          
//        ]);
          $senarai1 = new ActiveDataProvider([
            'query' => $senarai1,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        

        if ($title == 'personal') {
            $layout = 'profiling/u_1_personal';
        } elseif ($title == 'teaching') {
            $layout = 'u_2_teaching';
        } elseif ($title == 'supervisory') {
            $layout = 'u_3_supervisory';
        } elseif ($title == 'research') {
            $layout = 'u_4_research';
        } elseif ($title == 'publication') {
            $layout = 'u_5_publication';
        } elseif ($title == 'conferences') {
            $layout = 'u_6_conferences';
        } elseif ($title == 'consultancy') {
            $layout = 'u_7_consultancy';
        } elseif ($title == 'services') {
            $layout = 'u_8_services';
        } elseif ($title == 'esteem') {
            $layout = 'u_9_esteem';
        }
        // VarDumper::dump($biodata->recognition, $depth = 10, $highlight = true);die;

        return $this->render($layout, [
                    'biodata' => $biodata,'dataProvider' => $dataProvider,   'senarai'=>$senarai,'senarai1'=>$senarai1
        ]);
    }
    
    
      public function actionSenaraiLatihan($page = null){

        $searchModel = new \app\models\myidp\KursusLatihanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy([           
          'kursusLatihanID' => SORT_ASC,   
           ]);
                

                $models = KursusLatihan::find()->all();

        
          if (Yii::$app->request->post('simpan')) {

            foreach ($models as $data) {
                if ('1' . $data->kursusLatihanID == Yii::$app->request->post($data->kursusLatihanID)) {
                    $data->kategori_latihan = 1;
                      $data->updated = date('Y-m-d H:i:s');
                      $data->updated_by = Yii::$app->user->getId();
                      $data->save();
                      Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);

//                    return $this->redirect('index');
                } elseif ('0' . $data->kursusLatihanID == Yii::$app->request->post($data->kursusLatihanID)) {
                     $data->kategori_latihan = 0;
                      $data->updated = date('Y-m-d H:i:s');
                      $data->updated_by = Yii::$app->user->getId();
                      $data->save();
                      Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);

                }
            }
        }
       
        return $this->render('senarai-latihan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider ,
         
        ]);
    }
      public function actionSenaraiAktivitikomuniti($page = null){
 
        $searchModel = new TblSwSocietySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider->query->orderBy([]);

        
        $selection=(array)Yii::$app->request->post('selection'); 
        
        if (Yii::$app->request->post('simpan'))  {
                 
      
            foreach ($selection as $recId ){

                $model = TblSwSociety::findOne(['fid' => $recId]);
                 
                
                   if($model){
                      $model->peringkat = Yii::$app->request->post('t'.$model->fid);
                      
                     if('y'.$model->fid == Yii::$app->request->post($model->fid)){
                    $model->kategori_servis = '1';
                    }
                    elseif('n'.$model->fid == Yii::$app->request->post($model->fid)){
                    $model->kategori_servis = '0';
                    }
                    
                    
                      $model->updated = date('Y-m-d H:i:s');
                      $model->updated_by = Yii::$app->user->getId();
                      $model->save(false);
                      
                      Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);
          
                  }
              
            }
         }
         
         
   
        return $this->render('senarai-aktivitikomuniti', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
   
        ]);
    }
      public function actionSenaraiAktivitiuniversiti($page = null){
 
        $searchModel = new TblSwUniversitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider->query->orderBy([]);

        
       $selection=(array)Yii::$app->request->post('selection'); 
                
        if (Yii::$app->request->post('simpan'))  {

            foreach ($selection as $recId){

                $model = TblSwUniversity::findOne(['fid' => $recId]);
                 
                 if($model){
                      $model->peringkat = Yii::$app->request->post('t'.$model->fid);
                      
                     if('y'.$model->fid == Yii::$app->request->post($model->fid)){
                    $model->kategori_servis = '1';
                    }
                    elseif('n'.$model->fid == Yii::$app->request->post($model->fid)){
                    $model->kategori_servis = '0';
                    }
                    
                    
                      $model->updated = date('Y-m-d H:i:s');
                      $model->updated_by = Yii::$app->user->getId();
                      $model->save(false);
                      
                      Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);
          
                  }
              
            }
         }
   
        return $this->render('senarai-aktivitiuniversiti', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
   
        ]);
    }
    

    
    
     public function actionSenaraiLatihanLama($page = null){

        $searchModel = new \app\models\hronline\VCpdSenaraiLatihanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy([           
          'vcsl_kod_latihan' => SORT_ASC,   
           ]);
                
            $models = \app\models\hronline\Vcpdsenarailatihan::find()->all();

        
          if (Yii::$app->request->post('simpan')) {

            foreach ($models as $data) {
                if ('1' . $data->vcsl_kod_latihan == Yii::$app->request->post($data->vcsl_kod_latihan)) {
                    $data->kategori_latihan = 1;
                      $data->updated = date('Y-m-d H:i:s');
                      $data->updated_by = Yii::$app->user->getId();
                      $data->save();
                      Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);

//                    return $this->redirect('index');
                } elseif ('0' . $data->vcsl_kod_latihan == Yii::$app->request->post($data->vcsl_kod_latihan)) {
                     $data->kategori_latihan = 0;
                      $data->updated = date('Y-m-d H:i:s');
                      $data->updated_by = Yii::$app->user->getId();
                      $data->save();
                      Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);

                }
            }
        }
       
        return $this->render('senarai-latihan-lama', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider   
        ]);
    }
    
    
       public function actionSenaraiLatihanLuar($page = null){

        $searchModel = new \app\models\myidp\PermohonanKursusLuarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy([           
          'permohonanID' => SORT_ASC,   
           ]);
    
          $selection=(array)Yii::$app->request->post('selection');  
      
          if (Yii::$app->request->post('simpan'))  {
              foreach ($selection as $permohonanID ){

                  $model = \app\models\myidp\PermohonanKursusLuar::findOne(['permohonanID' => $permohonanID]);
                   
                  if($model){
                      $model->peringkat = Yii::$app->request->post('t'.$model->permohonanID);
                      
                     if('y'.$model->permohonanID == Yii::$app->request->post($model->permohonanID)){
                    $model->kategori_latihan = '1';
                    }
                    elseif('n'.$model->permohonanID == Yii::$app->request->post($model->permohonanID)){
                    $model->kategori_latihan = '0';
                    }
                    
                    
                      $model->updated = date('Y-m-d H:i:s');
                      $model->updated_by = Yii::$app->user->getId();
                      $model->save(false);
                      
                      Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);
    
                  }
                      
              }
              
              
            
                      
              
             
             
              
           }

        return $this->render('senarai-latihan-luar', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider   
        ]);
    }
    
    
     public function actionViewLatihan()
    {
         
        $query1 = (new \yii\db\Query())
               ->select(" hronline.tblprcobiodata.CONm, hrd.idp_sirilatihan.tarikhMula , hrd.idp_kursuslatihan.tajukLatihan, hrd.idp_kursuslatihan.kategori_latihan,  hrd.idp_ref_kategori.kategori_nama_bi ")
               ->from('hrd.idp_kehadiran_siri')
               ->leftJoin('hrd.idp_sirilatihan', 'hrd.idp_kehadiran_siri.siriLatihanID = hrd.idp_sirilatihan.siriLatihanID')
               ->leftJoin('hrd.idp_kursuslatihan', 'hrd.idp_kursuslatihan.kursusLatihanID = hrd.idp_sirilatihan.kursusLatihanID')
               ->leftJoin('hrd.idp_ref_kategori', 'hrd.idp_kehadiran_siri.kompetensi = hrd.idp_ref_kategori.kategori_id')
               ->leftJoin('hronline.tblprcobiodata', 'hrd.idp_kehadiran_siri.staffID = hronline.tblprcobiodata.ICNO')
               ->where(['hrd.idp_kursuslatihan.kategori_latihan' => 1]);
    
               
        $query2 = (new \yii\db\Query())
             ->select("hronline.tblprcobiodata.CONm, hronline.v_cpd_latihan.vcl_tkh_mula, hronline.v_cpd_senarai_latihan.vcsl_nama_latihan, hronline.v_cpd_senarai_latihan.kategori_latihan, hrd.idp_ref_kategori.kategori_nama_bi ")
             ->from('hronline.v_cpd_latihan')
             ->leftJoin('hronline.v_cpd_senarai_latihan', 'hronline.v_cpd_latihan.vcl_kod_latihan = hronline.v_cpd_senarai_latihan.vcsl_kod_latihan')
             ->leftJoin('hrd.idp_ref_kategori', 'hronline.v_cpd_latihan.vcl_kod_kompetensi = hrd.idp_ref_kategori.kategori_id')
               ->leftJoin('hronline.tblprcobiodata', 'hronline.v_cpd_latihan.vcl_id_staf = hronline.tblprcobiodata.ICNO')
             ->where(['hronline.v_cpd_senarai_latihan.kategori_latihan' => 1]);
       
        

        $query = $query1->union($query2, true);
           $dataProvider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => [
           'pageSize' =>  30
           ],
            
       ]);
        
        return $this->render('profiling/view-latihan', [
         //   'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'query' => $query,
    
            'bil' => 1,
          
        ]);
    }
    
      public function actionViewServices()
    {
         
        $senarai = TblSwSociety::find()->where(['kategori_servis' =>1]);

        
//        return $this->render('profiling/view-services', [
//         //   'searchModel' => $searchModel,
////            'dataProvider' => $dataProvider,
//            'senarai' => $senarai,
//    
//            'bil' => 1,
//          
//        ]);
          $senarai = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
             return $this->render('profiling/view-services', [
                       'senarai' => $senarai
            ]);
    }
    
     public function actionViewUniversity()
    {
         
        $senarai1 = TblSwUniversity::find()->where(['kategori_servis' =>1]);

        
//        return $this->render('profiling/view-services', [
//         //   'searchModel' => $searchModel,
////            'dataProvider' => $dataProvider,
//            'senarai' => $senarai,
//    
//            'bil' => 1,
//          
//        ]);
          $senarai1 = new ActiveDataProvider([
            'query' => $senarai1,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
             return $this->render('profiling/view-services', [
                       'senarai1' => $senarai1
            ]);
    }

    
    
    

}
