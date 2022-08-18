<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Notification;
use yii\filters\AccessControl;
use app\models\penamatanperkhidmatan\TblPermohonan;
use app\models\penamatanperkhidmatan\TblJenispenamatan;
use app\models\penamatanperkhidmatan\TblAksespengguna;
use yii\data\ActiveDataProvider;
use app\models\penamatanperkhidmatan\RefPengesahan;
use app\models\penamatanperkhidmatan\TblPengesahan;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use yii\helpers\ArrayHelper;
use app\models\penamatanperkhidmatan\Model;
use app\models\penamatanperkhidmatan\TblPendeknotis;
use app\models\penamatanperkhidmatan\RefSoalanexitinterview;
use app\models\penamatanperkhidmatan\TblExitinterview;
use yii\web\UploadedFile;
use yii\helpers\Html;
use app\models\penamatanperkhidmatan\TblKontrak;
/**
 * KontrakController implements the CRUD actions for Kontrak model.
 */
class PenamatanperkhidmatanController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['pengesahanperpustakaan', 'menunggu', 'senarai','permohonankontrak','tambahadmin', 'tindakan_bsm', 'tindakan_jfpiu', 'tindakan_pp'],
                 'rules' => [
                        [
                        'actions' => ['pengesahanperpustakaan', 'menunggu', 'senarai','permohonankontrak','tambahadmin', 'tindakan_bsm', 'tindakan_jfpiu', 'tindakan_pp'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
//                    'logout' => ['post'],
                ],
            ],
        ];
    }
    protected function notifikasi($icno, $content){
        //--------Model Notification-----------//
                $ntf = new Notification(); //noti untuk kp
                $ntf->icno = $icno;
                $ntf->title = 'Penamatan Perkhidmatan';
                $ntf->content = $content;
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save(false);
                //--------Model Notification-----------//
    }
    
    protected function uploadfile($file) {
        if($file){
                $fileapi = Yii::$app->FileManager->UploadFile($file->name, $file->tempName, '04', 'penamatanperkhidmatan');
                $filepath = $fileapi->file_name_hashcode;   
                if($fileapi->status != true) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya Dihantar', 'type' => 'error', 'msg' => 'Permohonan anda gagal dihantar.']);
                    return $this->redirect(['permohonan']);
                }
            }
            else{
                $filepath = '';
            }
            
            return $filepath;
    }
    
    public function actionPermohonan(){
        $model = new TblPermohonan([]);
        
        return $this->render('permohonan', ['model' => $model]);
    }
    
    public function actionPelepasanjawatan()
    {
        $icno = Yii::$app->user->getId();
        $model1 = new TblPermohonan(['icno' => $icno, 'jenis_penamatan' => 1]);
        $model2 = [new TblKontrak];
        $model1->kj = TblPermohonan::ickj($icno);
        $model1->pp = TblPermohonan::icpp($icno);
        
        if ($model1->load(Yii::$app->request->post())) {
            $model1->tarikh_mohon=date('Y-m-d H:i:s');
            $model1->save(false);
            return $this->redirect(['jenispenamatan']);
        }
        
        return $this->render('pelepasan_jawatan', ['model1' => $model1, 'model2' => $model2]);
    } 
    
    public function actionPeletakanjawatan()
    {
        $icno = Yii::$app->user->getId();
        $model1 = new TblPermohonan(['icno' => $icno, 'jenis_penamatan' => 2]);
        $model2 = [new TblKontrak];
        $model1->kj = TblPermohonan::ickj($icno);
        $model1->pp = TblPermohonan::icpp($icno);
        
        if ($model1->load(Yii::$app->request->post())) {
            $model1->tarikh_mohon=date('Y-m-d H:i:s');
            $model1->save(false);
            return $this->redirect(['permohonan']);
        }
        
        return $this->render('peletakan_jawatan', ['model1' => $model1, 'model2' => $model2]);
    } 
    
    protected function notifiadmin($category) {
        foreach (TblAksespengguna::find()->all() as $a){
            if($a->department){
            ($category == 2 && $a->dept_id == 17)?'': $this->notifikasi($a->icno, 'Permohonan Penamatan Perkhidmatan menunggu tindakan anda'.Html::a('<i class="fa fa-arrow-right"></i>', ['penamatanperkhidmatan/senaraipengesahan'.strtolower($a->department->shortname)], ['class'=>'btn btn-primary btn-sm']));
        }
        elseif($a->dept_id == 0){
           $this->notifikasi($a->icno, 'Permohonan Penamatan Perkhidmatan menunggu tindakan anda'.Html::a('<i class="fa fa-arrow-right"></i>', ['penamatanperkhidmatan/senarai'], ['class'=>'btn btn-primary btn-sm'])); 
        }
            }
    }
    
    public function actionStatuspermohonan(){
        return $this->render('statuspermohonan', 
                ['model' => TblPermohonan::find()->where(['icno' => Yii::$app->user->getId()])->all(),
                    'mod' => TblPermohonan::find()->where(['icno' => Yii::$app->user->getId(), 'pendeknotis' => 'mohon'])->all()]);
    }
    
    public function actionJenispenamatan(){
        $model = new TblJenispenamatan();
        $senarai = TblJenispenamatan::find()->all();
        
        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);
            return $this->redirect(['jenispenamatan']);
        }
        
        return $this->render('jenispenamatan', ['model' => $model, 'senarai' => $senarai]);
    }
    
    public function actionDeletejenispenamatan($id)
    {
        $model = TblJenispenamatan::findOne(['id' => $id]);
        $model->delete();
        
        return $this->redirect(['jenispenamatan']);
    }
    
    //tetapanadmin
    public function actionAdmin(){
        $senarai = TblAksespengguna::find()->groupBy(['dept_id'])->all();
        $nama = ArrayHelper::map(Tblprcobiodata::find(['Status' => '1'])->all(), 'ICNO', 'CONm');
        $department = ArrayHelper::map(Department::find()->where(['isActive' => '1'])->andWhere(['!=', 'id', '158'])->all(), 'id', 'shortname')+
                array(158 => 'BSM [Seksyen Pengajian Lanjutan]')+array(0 => 'BSM');
        $model = new TblAksespengguna();
        
        if ($model->load(Yii::$app->request->post())) {
            $model->save(false);
            return $this->redirect(['admin']);
        }
        
        return $this->render('admin', 
                ['senarai' => $senarai,'model' => $model, 'nama' => $nama, 'department' => $department]);
    }
    
    public function actionDeleteadmin($id)
    {
        $model = TblAksespengguna::findOne(['id' => $id]);
        $model->delete();
        
        return $this->redirect(['admin']);
    }
    
    //ketua jabatan
    public function actionSenaraipermohonankj(){
       $icno=Yii::$app->user->getId();
        
        $senarai = new ActiveDataProvider([
            'query' => TblPermohonan::find()->where(['kj' => $icno])->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => ['pageSize' => 20,],
        ]);
        
        if(TblPermohonan::find()->where(['kj' => $icno])->exists()){
        return $this->render('senaraipermohonankj', [
            'icno' => $icno,'senarai' => $senarai
        ]);}
        else{
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['permohonan']);
        }
    }
    
    public function actionPengesahankj($id) {
        $model = TblPermohonan::find()->where(['id' => $id])->one();
        
        if($model->load(Yii::$app->request->post())){
            $model->tarikh_kj = date('Y-m-d H:i:s');
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dihantar']);
            $this->redirect('senaraipermohonankj');
            }
        return $this->render('pengesahankj', [
                    'model' => $model,
                    'id' => $id
        ]);
    }
    
    //bendahari
    public function actionSenaraipengesahanbn(){
        $icno=Yii::$app->user->getId();
        
        $senarai = new ActiveDataProvider([
            'query' => TblPermohonan::find()->where(['status_kj' => 1])->orderBy(['tarikh_kj' => SORT_DESC]),
            'pagination' => ['pageSize' => 20,],
        ]);
        
        if(TblAksespengguna::find()->where(['icno' => $icno, 'dept_id' => 8])->exists()){
        return $this->render('senaraipermohonan', [
            'icno' => $icno,'senarai' => $senarai,'jfpiu' => 'bn'
        ]);}
        else{
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['permohonan']);
        }
    }
    
    public function actionPengesahanbn($id) {
        $refbn = RefPengesahan::find()->where(['jfpiu' => 8])->andWhere(['!=', 'id', '5'])->all();     
        $array = ArrayHelper::map($refbn,'perkara', 'perkara');
        $model = TblPermohonan::find()->where(['id' => $id])->one();
        $modelsAddress = TblPengesahan::find()->where(['permohonan_id' => $id, 'dept_id' => 8])->andWhere(['not in', 'perkara',  $array])->all();
        $modelsAddress = (empty($modelsAddress)) ? [new TblPengesahan] : $modelsAddress;
        
        if(Yii::$app->request->post()){
        foreach ($refbn as $r){
            $m = TblPengesahan::find()->where(['permohonan_id' => $id, 'perkara' => $r->perkara])->one();
            if(Yii::$app->request->post($r->id) == '1'){
            $mod = (empty($m)) ? new TblPengesahan() : $m;
            $mod->permohonan_id = $id;
            $mod->dept_id = 8;
            $mod->perkara = $r->perkara;
            $mod->baki = Yii::$app->request->post('baki'.$r->id);
            $mod->save(false);
            }
            else{
                (empty($m)) ?  : $m->delete();
            }
            
        }
        
        $model->tarikh_bn = date('Y-m-d H:i:s');
        $this->dynamicform($modelsAddress, $model, 8, 'bn');
        $status = TblPengesahan::find()->where(['permohonan_id' => $id, 'dept_id' => 8])->exists()? 1 : 0;
        $model->status_bn = $status;
        $model->save(false);
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dihantar']);
            $this->redirect('senaraipengesahanbn');
            }
        return $this->render('pengesahanbn', [
                    'model' => $model, 'refbn' => $refbn, 'modelsAddress' => $modelsAddress,
                    'id' => $id
        ]);
    }
    
    //perpustakaan
    public function actionSenaraipengesahanperpustakaan(){
        $icno=Yii::$app->user->getId();
        
        $senarai = new ActiveDataProvider([
            'query' => TblPermohonan::find()->where(['status_kj' => 1])->orderBy(['tarikh_kj' => SORT_DESC]),
            'pagination' => ['pageSize' => 20,],
        ]);
        
        if(TblAksespengguna::find()->where(['icno' => $icno, 'dept_id' => 13])->exists()){
        return $this->render('senaraipermohonan', [
            'icno' => $icno,'senarai' => $senarai,'jfpiu' => 'perpustakaan'
        ]);}
        else{
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['permohonan']);
        }
    }
    
    public function actionPengesahanperpustakaan($id)
    {
        $modelCustomer = TblPermohonan::find()->where(['id' => $id])->one();
        $modelsAddress = TblPengesahan::find()->where(['permohonan_id' => $id, 'dept_id' => 13])->all();
        $modelsAddress = (empty($modelsAddress)) ? [new TblPengesahan] : $modelsAddress;
        
        
        if ($modelCustomer->load(Yii::$app->request->post())) {
            $modelCustomer->tarikh_perpustakaan = date('Y-m-d H:i:s');
            $this->dynamicform($modelsAddress, $modelCustomer, 13, 'perpustakaan');
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dihantar']);
            $this->redirect('senaraipengesahanperpustakaan');
        }
        
        $model = TblPermohonan::find()->where(['id' => $id])->one();
        return $this->render('pengesahanperpustakaan', [
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => $modelsAddress,
            'model' => $model
        ]);
    }
    
    //jtmk
    public function actionSenaraipengesahanjtmk(){
        $icno=Yii::$app->user->getId();
        
        $senarai = new ActiveDataProvider([
            'query' => TblPermohonan::find()->where(['status_kj' => 1])->orderBy(['tarikh_kj' => SORT_DESC]),
            'pagination' => ['pageSize' => 20,],
        ]);
        
        if(TblAksespengguna::find()->where(['icno' => $icno, 'dept_id' => 35])->exists()){
        return $this->render('senaraipermohonan', [
            'icno' => $icno,'senarai' => $senarai,'jfpiu' => 'jtmk'
        ]);}
        else{
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['permohonan']);
        }
    }
    
    public function actionPengesahanjtmk($id)
    {
        $modelCustomer = TblPermohonan::find()->where(['id' => $id])->one();
        $modelsAddress = TblPengesahan::find()->where(['permohonan_id' => $id, 'dept_id' => 35])->all();
        $modelsAddress = (empty($modelsAddress)) ? [new TblPengesahan] : $modelsAddress;
        
        
        if ($modelCustomer->load(Yii::$app->request->post())) {
            $modelCustomer->tarikh_jtmk = date('Y-m-d H:i:s');
            $this->dynamicform($modelsAddress, $modelCustomer, 35, 'jtmk');
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dihantar']);
            $this->redirect('senaraipengesahanjtmk');
        }
        
        $model = TblPermohonan::find()->where(['id' => $id])->one();
        return $this->render('pengesahanjtmk', [
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => $modelsAddress,
            'model' => $model
        ]);
    }
    
    //ppuu
    public function actionSenaraipengesahanppuu(){
        $icno=Yii::$app->user->getId();
        
        $senarai = new ActiveDataProvider([
            'query' => TblPermohonan::find()->where(['status_kj' => 1])->orderBy(['tarikh_kj' => SORT_DESC]),
            'pagination' => ['pageSize' => 20,],
        ]);
        
        if(TblAksespengguna::find()->where(['icno' => $icno, 'dept_id' => 181])->exists()){
        return $this->render('senaraipermohonan', [
            'icno' => $icno,'senarai' => $senarai,'jfpiu' => 'ppuu'
        ]);}
        else{
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['permohonan']);
        }
    }
    
    public function actionPengesahanppuu($id)
    {
        $modelCustomer = TblPermohonan::find()->where(['id' => $id])->one();
        $modelsAddress = TblPengesahan::find()->where(['permohonan_id' => $id, 'dept_id' => 181])->all();
        $modelsAddress = (empty($modelsAddress)) ? [new TblPengesahan] : $modelsAddress;
        
        
        if ($modelCustomer->load(Yii::$app->request->post())) {
            $modelCustomer->tarikh_ppuu = date('Y-m-d H:i:s');
            $this->dynamicform($modelsAddress, $modelCustomer, 181, 'ppuu');
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dihantar']);
            $this->redirect('senaraipengesahanppuu');
        }
        $model = TblPermohonan::find()->where(['id' => $id])->one();
        return $this->render('pengesahanppuu', [
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => $modelsAddress,
            'model' => $model
        ]);
    }
    
    //pppi
    public function actionSenaraipengesahanpppi(){
        $icno=Yii::$app->user->getId();
        
        $senarai = new ActiveDataProvider([
            'query' => TblPermohonan::find()->where(['status_kj' => 1, 'job_category' => 1])->orderBy(['tarikh_kj' => SORT_DESC]),
            'pagination' => ['pageSize' => 20,],
        ]);
        
        if(TblAksespengguna::find()->where(['icno' => $icno, 'dept_id' => 17])->exists()){
        return $this->render('senaraipermohonan', [
            'icno' => $icno,'senarai' => $senarai,'jfpiu' => 'pppi'
        ]);}
        else{
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['permohonan']);
        }
    }
    
    //bsm
    public function actionSenaraipengesahanbsm(){
        $icno=Yii::$app->user->getId();
        
        $senarai = new ActiveDataProvider([
            'query' => TblPermohonan::find()->where(['status_kj' => 1])->orderBy(['tarikh_kj' => SORT_DESC]),
            'pagination' => ['pageSize' => 20,],
        ]);
        
        if(TblAksespengguna::find()->where(['icno' => $icno, 'dept_id' => 158])->exists()){
        return $this->render('senaraipermohonan', [
            'icno' => $icno,'senarai' => $senarai,'jfpiu' => 'bsm'
        ]);}
        else{
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['permohonan']);
        }
    }
    
    public function actionPengesahanbsm($id)
    {
        $modelCustomer = TblPermohonan::find()->where(['id' => $id])->one();
        $modelsAddress = TblPengesahan::find()->where(['permohonan_id' => $id, 'dept_id' => 158])->one();
        $modelsAddress = (empty($modelsAddress)) ? new TblPengesahan() : $modelsAddress;
        
        
        if ($modelCustomer->load(Yii::$app->request->post())) {
            $modelCustomer->tarikh_bsm = date('Y-m-d H:i:s');
            $modelCustomer->save(false);
            if ($modelsAddress->load(Yii::$app->request->post())) {
            $modelsAddress->permohonan_id = $id;
            $modelsAddress->dept_id = 158;
            $modelsAddress->perkara = 'tempoh ikatan
seperti yang dinyatakan dalam perjanjian tajaan melanjutkan pengajian';
            $modelsAddress->save(false);}
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dihantar']);
            $this->redirect('senaraipengesahanbsm');
        }
        
        $model = TblPermohonan::find()->where(['id' => $id])->one();
        return $this->render('pengesahanbsm', [
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => $modelsAddress,
            'model' => $model
        ]);
    }
    
    //jfpiu
    public function actionSenaraipengesahanjfpiu(){
        $icno=Yii::$app->user->getId();
        
        $senarai = new ActiveDataProvider([
            'query' => TblPermohonan::find()->where(['status_kj' => 1, 'pp' => $icno])->orderBy(['tarikh_kj' => SORT_DESC]),
            'pagination' => ['pageSize' => 20,],
        ]);
        
        if(TblPermohonan::find()->where(['pp' => $icno])->exists()){
        return $this->render('senaraipermohonan', [
            'icno' => $icno,'senarai' => $senarai,'jfpiu' => 'jfpiu'
        ]);}
        else{
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['permohonan']);
        }
    }
    
    public function actionPengesahanjfpiu($id)
    {
        $modelCustomer = TblPermohonan::find()->where(['id' => $id])->one();
        $modelsAddress = TblPengesahan::find()->where(['permohonan_id' => $id, 'dept_id' => 0])->all();
        $modelsAddress = (empty($modelsAddress)) ? [new TblPengesahan] : $modelsAddress;
        
        
        if ($modelCustomer->load(Yii::$app->request->post())) {
            $modelCustomer->tarikh_jfpiu = date('Y-m-d H:i:s');
            $this->dynamicform($modelsAddress, $modelCustomer, 0, 'jfpiu');
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dihantar']);
            $this->redirect('senaraipengesahanjfpiu');
        }
        $model = TblPermohonan::find()->where(['id' => $id])->one();
        return $this->render('pengesahanjfpiu', [
            'modelCustomer' => $modelCustomer,
            'modelsAddress' => $modelsAddress,
            'model' => $model
        ]);
    }
    
    public function actionExitinterview() {
        $model = Tblprcobiodata::find()->where(['ICNO' => Yii::$app->user->getId()])->one();
        $soalan = RefSoalanexitinterview::find()->where(['status' => 1])->all();
        
        if (Yii::$app->request->post()){
            foreach ($soalan as $s){
                $exitinterview = TblExitinterview::find()->where(['icno' => Yii::$app->user->getId(), 'soalan_id' => $s->id])->exists()? 
                        TblExitinterview::find()->where(['icno' => Yii::$app->user->getId(), 'soalan_id' => $s->id])->one():new TblExitinterview();
                $exitinterview->icno = Yii::$app->user->getId();
                $exitinterview->soalan_id = $s->id;
                $exitinterview->jawapan = Yii::$app->request->post('jawapan'.$s->id);
                $exitinterview->save(false);
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Dihantar']);
            return $this->redirect('permohonan');
            
        }
//        if(!TblExitinterview::find()->where(['icno' => Yii::$app->user->getId()])->exists()){
        return $this->render('exitinterview', [
                    'model' => $model,
                    'soalan' => $soalan
        ]);
        
//        }
//        else{
//           Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda sudah lengkapkan borang ini']);
//           return $this->redirect('permohonan'); 
//        }
    }
    
    public function actionLihatbelumselesai($id, $dept_id, $tarikh) {
        $model = TblPengesahan::find()->where(['permohonan_id' => $id, 'dept_id' => $dept_id])->all();
        return $this->renderAjax('belumselesai', [
                    'model' => $model,
                    'tarikh' => $tarikh,
                    'dept_id' => $dept_id
        ]);
    }
    
    public function actionDaftartamat() {
        $model = new TblPermohonan();
        return $this->render('daftartamat', [
                    'model' => $model
        ]);
    }
    
    protected function bakikontrak($modelCustomer) {
        
            $oldIDs = ArrayHelper::map([new TblKontrak], 'id', 'id');
            $modelsAddress = Model::createMultiple(TblKontrak::classname(), [new TblKontrak]);
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsAddress, 'id', 'id')));
            
            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                        if (! empty($deletedIDs)) {
                            TblPengesahan::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsAddress as $i => $modelAddress) {
                            //$modelAddress->customer_id = $modelCustomer->id;
                            $modelAddress->mohon_id = $modelCustomer->id;
                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
//                        return $this->redirect(['senaraipermohonan?user='.$jfpiu]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
    }
    
    protected function dynamicform($modelsAddress, $modelCustomer, $dept_id, $jfpiu) {
        
            $oldIDs = ArrayHelper::map($modelsAddress, 'id', 'id');
            $modelsAddress = Model::createMultiple(TblPengesahan::classname(), $modelsAddress);
            Model::loadMultiple($modelsAddress, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsAddress, 'id', 'id')));
            
            $valid = $modelCustomer->validate();
            $valid = Model::validateMultiple($modelsAddress) && $valid;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelCustomer->save(false)) {
                        if (! empty($deletedIDs)) {
                            TblPengesahan::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsAddress as $i => $modelAddress) {
                            //$modelAddress->customer_id = $modelCustomer->id;
                            $modelAddress->permohonan_id = $modelCustomer->id;
                            $modelAddress->dept_id = $dept_id;
                            if (! ($flag = $modelAddress->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
//                        return $this->redirect(['senaraipermohonan?user='.$jfpiu]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
    }
    
     public function actionSenarai() {
        $icno=Yii::$app->user->getId();
        
        $senarai = new ActiveDataProvider([
            'query' => TblPermohonan::find()->orderBy(['tarikh_mohon' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        
        if(TblAksespengguna::find()->where(['icno' => $icno])->exists()){
        return $this->render('senarai', [
            'icno' => $icno,
            'senarai' => $senarai,
        ]);}
        else{
            Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
            return $this->redirect(['permohonan']);
        }
    }
    
    public function actionMaklumatpermohonan($id)
    {
        $model = TblPermohonan::find()->where(['id' => $id])->one();
        
         if ($model->load(Yii::$app->request->post())) {
             $model->save(false);
             return $this->redirect(['senarai']);
         }
        return $this->render('maklumatpermohonan', [
            'model' => $model
        ]);
    }
   
}
