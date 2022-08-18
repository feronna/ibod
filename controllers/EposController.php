<?php

namespace app\controllers;

use app\models\hronline\Department;
use Yii;
use app\models\utilities\epos\PosTblPermohonan;
use app\models\utilities\epos\PosTblPermohonanSearch;
use app\models\utilities\epos\PosBarangMel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
use app\models\hronline\Model;
use yii\db\Exception;
use yii\filters\AccessControl;
use app\models\utilities\epos\TblAkses;
use app\models\utilities\epos\RefAkses;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblprcobiodata;

class EposController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['*'],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id),
                    [
                        'actions' => ['admin-senarai-permohonan', 'admin-lihat-permohonan', 'lulus-permohonan', 'tolak-permohonan'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $deptid = Yii::$app->user->identity->DeptId;
                            $flag = false;
                            if (($id = Yii::$app->request->get('id')) !== null) {
                                $flag = PosTblPermohonan::find()->where(['id' => $id])->andWhere(['DeptId' => $deptid])->exists();
                                return $flag;
                            }
                            return  Department::find()->where(['chief' => Yii::$app->user->getId()])->andWhere(['isActive' => 1])->exists();
                        }
                    ],
                    [
                        'actions' => ['mel-senarai-permohonan', 'mel-lihat-permohonan', 'mel-lulus-permohonan', 'mel-tolak-permohonan', 'tambah-maklumat-mel','tambah-akses'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            
                            if (TblAkses::find()->where(['icno' => Yii::$app->user->getId(), 'access_level' => 3])->exists()) {
                                return true;
                            }
                            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
                            return false;
                        }
                    ],
                    [
                        'actions' => ['lihat-permohonan', 'senarai-permohonan', 'mohon'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (TblAkses::find()->where(['icno' => Yii::$app->user->getId(), 'access_level' => 1])->exists()) {

                                return true;
                            } else {
                                Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
                                return $this->redirect('halaman-utama');
                            }
                            return false;
                        }
                    ],

                ],
            ],
        ];
    }


    protected function icno()
    {

        return Yii::$app->user->getId();
    }

    public function actionHalamanUtama()
    {
        $searchModel = new PosTblPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('halaman-utama', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLihatPermohonan($id)
    {
        $model = $this->findModel($id);

        return $this->render('lihat-permohonan', [
            'model' => $model,
        ]);
    }
    public function actionSenaraiPermohonan()
    {
        $searchModel = new PosTblPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('senarai_permohonan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMohon()
    {
        $modelmel = new PosTblPermohonan();
        $modelmel->scenario = 'mohon';
        $modelmel->DeptId = Yii::$app->user->identity->DeptId;
        $modelsBarang = $modelmel->barang;
        $modelmel->alamat_penghantar = Yii::$app->user->identity->department->address ? Yii::$app->user->identity->department->address : ' ';

        if ($modelmel->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsBarang, 'id', 'id');
            $modelsBarang = Model::createMultiple(PosBarangMel::classname(), $modelsBarang);
            Model::loadMultiple($modelsBarang, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsBarang, 'id', 'id')));

            $modelmel->icno_pemohon = Yii::$app->user->getId();
            $modelmel->tarikh_mohon = date('Y-m-d H:i:s');
            $modelmel->no_tel = trim($modelmel->no_tel);

            // validate all models
            $valid = $modelmel->validate();
            $valid = Model::validateMultiple($modelsBarang) && $valid;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = ($modelmel->save(false))) {

                        if (!empty($deletedIDs)) {
                            PosBarangMel::deleteAll(['id' => $deletedIDs]);
                        }

                        foreach ($modelsBarang as $i => $modelBarang) {
                            $modelBarang->permohonan_id = $modelmel->id;

                            if (!($flag = $modelBarang->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dihantar.']);
                        $transaction->commit();
                        Yii::$app->MP->SendNotification([
                            'icno' => Yii::$app->MP->PelulusEpos($modelmel->DeptId),
                            'title' => 'ePos: Terdapat Permohonan Baru.',
                            'content' => 'Permohonan menunggu tindakan anda.  <a class="btn btn-primary btn-sm" href="/staff/web/epos/admin-lihat-permohonan?id='.$modelmel->id.'">disini</a>',
                            'date' => date('Y-m-d H:i:s'),
                        ]);

                        Yii::$app->MP->SendEmail([
                            'from' => ['pengajianlanjutan@ums.edu.my'=>'ePos UMS'],
                            'to' => Yii::$app->MP->PelulusEpos($modelmel->DeptId,'emel'),
                            'subject' => 'ePos : Permohonan Baru.',
                            'htmlBody' => 'Permohonan penghantaran melalui ePos UMS. Menunggu tindakan anda.',
                        ]);
                        return $this->redirect(['senarai-permohonan']);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('mohon', [
            'modelmel' => $modelmel,
            'modelsBarang' => (empty($modelsBarang)) ? [new PosBarangMel()] : $modelsBarang,
        ]);
    }

    //admin jafpib//

    public function actionAdminSenaraiPermohonan()
    {
        $searchModel = new PosTblPermohonanSearch();
        $dataProvider = $searchModel->searchJAFPIB(Yii::$app->request->queryParams);

        return $this->render('admin/admin_senarai_permohonan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionAdminLihatPermohonan($id)
    {
        $model = $this->findModel($id);

        return $this->render('admin/admin_lihat_permohonan', [
            'model' => $model,
        ]);
    }

    public function actionLulusPermohonan($id)
    {
        $model = $this->findModel($id);
        $this->CheckStatus($model->status_jafpib, 'admin');
        $model->icno_pom = Yii::$app->user->getId();
        $model->tarikh_status_jafpib = date('Y-m-d h:i:s');
        $model->status_jafpib = 2;
        if ($model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Diluluskan']);
            Yii::$app->MP->SendNotification([
                'icno' => Yii::$app->MP->AdminEpos(),
                'title' => 'ePos: Terdapat Permohonan Baru.',
                'content' => 'Permohonan menunggu tindakan anda. Permohonan telah diluluskan di peringkat JAFPIB.',
                'date' => date('Y-m-d H:i:s'),
            ]);
            Yii::$app->MP->SendEmail([
                'from' => ['pengajianlanjutan@ums.edu.my'=>'ePos UMS'],
                'to' => Yii::$app->MP->AdminEpos('emel'),
                'subject' => 'ePos : Permohonan Baru.',
                'htmlBody' => 'Permohonan penghantaran melalui ePos UMS daripada jabatan menunggu tindakan anda.',
            ]);


        }
        return $this->redirect(['admin-senarai-permohonan']);
    }
    public function actionTolakPermohonan($id)
    {
        $model = $this->findModel($id);
        $this->CheckStatus($model->status_jafpib, 'admin');
        $model->icno_pom = Yii::$app->user->getId();
        $model->tarikh_status_jafpib = date('Y-m-d h:i:s');
        $model->status_jafpib = 3;
        if ($model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Ditolak']);
        }
        return $this->redirect(['admin-senarai-permohonan']);
    }

    //tamat admin jafpib//

    //admin pejabat mel//

    public function actionMelSenaraiPermohonan()
    {
        $searchModel = new PosTblPermohonanSearch();
        $dataProvider = $searchModel->searchPejabatMel(Yii::$app->request->queryParams);

        return $this->render('mel/mel_senarai_permohonan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionMelLihatPermohonan($id)
    {
        $model = $this->findModel($id);

        return $this->render('mel/mel_lihat_permohonan', [
            'model' => $model,
        ]);
    }

    public function actionMelLulusPermohonan($id)
    {
        $model = $this->findModel($id);
        $this->CheckStatus($model->status_pom, 'mel');
        $model->icno_pom = Yii::$app->user->getId();
        $model->tarikh_status_pom = date('Y-m-d h:i:s');
        $model->status_pom = 2;
        if ($model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Diluluskan']);
            Yii::$app->MP->SendNotification([
                'icno' => $model->icno_pemohon,
                'title' => 'ePos: Status Permohonan.',
                'content' => 'Permohonan anda telah diluluskan. <a class="btn btn-primary btn-sm" href="/staff/web/epos/lihat-permohonan?id='.$model->id.'">disini</a>',
                'date' => date('Y-m-d H:i:s'),
            ]);
            Yii::$app->MP->SendEmail([
                'from' =>['pengajianlanjutan@ums.edu.my'=>'ePos UMS'],
                'to' => $model->biodata->COEmail,
                'subject' => 'ePos : Status Permohonan.',
                'htmlBody' => 'Permohonan penghantaran melalui ePos UMS anda telah diluluskan.',
            ]);
        }
        return $this->redirect(['mel-senarai-permohonan']);
    }

    public function actionMelTolakPermohonan($id)
    {
        $model = $this->findModel($id);
        $this->CheckStatus($model->status_pom, 'mel');
        $model->icno_pom = Yii::$app->user->getId();
        $model->tarikh_status_pom = date('Y-m-d h:i:s');
        $model->status_pom = 3;
        if ($model->save()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan Ditolak']);
        }
        return $this->redirect(['mel-senarai-permohonan']);
    }

    public function actionTambahMaklumatMel($id)
    { //ajax
        $model = $this->findModel($id);
        $model->scenario = 'TambahMaklumatMel';

        if ($model->load(Yii::$app->request->post())) {
            // var_dump($model->errors);die;
            $model->save();
            return $this->redirect([
                'mel-lihat-permohonan',
                'id' => $model->id,
            ]);
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('mel/tambah_maklumat_mel', [
                'modelmel' => $model,
            ]);
        } else {
            return $this->redirect(['mel-senarai-permohonan']);
        }
    }

    //tamat admin pejabat mel//



    protected function findModel($id)
    {
        if (($model = PosTblPermohonan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function CheckStatus($status, $_f)
    {
        if ($status != 1) {
            Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Tidak perlu tindakan']);
            return $this->redirect([$_f . '-senarai-permohonan']);
        }

        return true;
    }
    protected function findBiodata()
    {
        if (($model = Tblprcobiodata::findOne(['ICNO' => $this->ICNO()])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findAkses($id)
    {

        if (($model = TblAkses::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function GridRekodAdmin()
    {
        $data = new ActiveDataProvider([
            'query' => TblAkses::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }
    public function actionTambahAkses($status =  null)
    {
        $icno = Yii::$app->user->getId();
        $staff = $this->GridRekodAdmin();
        $model = new TblAkses();
        $a = (TblAkses::find()->where(['status' => '1']));

        if ($model->load(Yii::$app->request->post())) {

            $model->DeptId = $model->kakitangan->DeptId;
            $prev_model = TblAkses::find()->where(['DeptId' => $model->DeptId])->andWhere(['status' => 1])->andWhere(['access_level' => $model->access_level])->one();
            if ($prev_model) {
                $prev_model->status = 0;
                $model->update_by = $icno;
                $model->update_dt = new \yii\db\Expression('NOW()');
                $prev_model->save(false);
            }
            $model->status = 1;
            $model->update_by = $icno;
            $model->update_dt = new \yii\db\Expression('NOW()');
            $model->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Ditambah!', 'type' => 'success', 'msg' => '']);
            return $this->redirect(['tambah-akses']);
        }

        isset(Yii::$app->request->queryParams['icno']) ? $staff->query->andFilterWhere(['like', 'icno', Yii::$app->request->queryParams['icno']]) : '';
        isset(Yii::$app->request->queryParams['DeptId']) ? $staff->query->andFilterWhere(['like', 'DeptId', Yii::$app->request->queryParams['DeptId']]) : '';
        isset(Yii::$app->request->queryParams['access_level']) ? $staff->query->andFilterWhere(['like', 'access_level', Yii::$app->request->queryParams['access_level']]) : '';
        isset(Yii::$app->request->queryParams['status']) ? $staff->query->andFilterWhere(['like', 'status', Yii::$app->request->queryParams['status']]) : '';
      
        return $this->render('admin/a_tambah_akses', [
            'staff' => $staff,
            'model' => $model,
            'status' => $status,

        ]);
    }
    public function actionDeleteAkses($id)
    {
        $model = TblAkses::find()->where(['id' => $id])->one();
        $model->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['tambah-akses']);
    }

    public function actionUpdateAkses($id)
    {

        $model = $this->findAkses($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->update_by = $icno;
            $model->update_dt = new \yii\db\Expression('NOW()');
            $model->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' =>
            'Telah dikemaskini/updated']);
            return $this->redirect(['tambah-akses']);
        }

        return $this->renderAjax('admin/update-akses', [
            'model' => $model,
        ]);
    }
    // dashboard
    
     public function actionDashboard() {
        return $this->render('dashboard', [
        ]);
    }
     public function Grid($query) {
        $data = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }
     public function actionRecordPermohonanByStatus($status) {
    
            $dataProvider = $this->Grid(PosTblPermohonan::find()->where(['status_pom' => $status])->orderBy(['tarikh_dihantar' => SORT_DESC]));
       
        return $this->render('mel/form_record', [
                    'dataProvider' => $dataProvider,
        ]);
    }
    
}
