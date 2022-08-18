<?php

namespace app\controllers\cbadmin;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\hronline\Tblprcobiodata;
use app\models\cbelajar\TblPermohonan;
use app\models\cbelajar\TblPermohonanSearch;
use app\models\cbelajar\TblUrusMesyuarat;
use app\models\cbelajar\TblBiasiswa;
use app\models\cbelajar\TblPengajian;
use app\models\hronline\Tblkeluarga;
use app\models\hronline\Tblpendidikan;
use app\models\cbelajar\TblFilePemohon;
use app\models\cbelajar\TblFileKpm;
use app\models\cbelajar\TblFileLn;
use app\models\cbelajar\TblSurat;
use app\models\TblConfirm;
use app\models\hronline\Department;
use app\models\Notification;
use app\models\cutibelajar\TblAdmin;
use app\models\hronline\Tblrscoconfirmstatus;
use yii\web\UploadedFile;
use yii\helpers\Html;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
class AdminController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionSenaraiPemohon($DeptId)
    {
        $icno=Yii::$app->user->getId();
        $title = '';
        $fac = \app\models\hronline\Department::find()->where(['category_id'=> 1, 'dept_cat_id'=>['2','4']])->orWhere(['id'=>['15','104']])->orderBy(['shortname' => SORT_ASC])->all();
        $models = \app\models\cbelajar\TblPermohonan::find()->where(['status' => "Diluluskan", 'DeptId'=> $fac])->all();
        $tmp = TblUrusMesyuarat::find()->select(['kali_ke'])->orderBy(['kali_ke'=>SORT_DESC])->limit(1)->one();
        $senarai  = '';
        $status = ['Tunggu Kelulusan', 'Diluluskan', 'Tidak Diluluskan'];
        $selection=(array)Yii::$app->request->post('selection');//typecasting
        
            if (Yii::$app->request->post('simpan')){
                
                foreach ($models as $data) {
                    if('y'.$data->id == Yii::$app->request->post($data->id)){
                    $model = $this->findModelCB($data->id);
                    $model->status_bsm = 'Draft Diluluskan';
                    $model->save(false);
//                    return $this->redirect('index');
                    }
                    elseif('n'.$data->id == Yii::$app->request->post($data->id)){
                    $model = $this->findModelCB($data->id);
                    $model->status_bsm = 'Draft Ditolak';
                    $model->save(false);
                    }
            }
            }
            elseif (Yii::$app->request->post('hantar')) {
                foreach($selection as $id){
                $hantar= $this->findModelCB($id);//make a typecasting
                if('n'.$hantar->id == Yii::$app->request->post($hantar->id) ){
                    $hantar->status ='TIDAK LULUS';
                    $hantar->status_bsm='Tidak Diluluskan';
                    $hantar->ver_date = date('Y-m-d H:i:s');
                    
                    $this->notifikasi($hantar->icno, "Permohonan Pengajian Lanjutan anda tidak berjaya.".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm'])); 
                }
                elseif('y'.$hantar->id == Yii::$app->request->post($hantar->id)){
                    $hantar->status ='LULUS';
                    $hantar->status_bsm='Diluluskan';
                    $hantar->ver_date = date('Y-m-d H:i:s');
                    $hantar->ver_by = $icno;
                    $this->notifikasi($hantar->icno, "Permohonan Pengajian Lanjutan anda berjaya.".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
                    
                }
                $hantar->save(false);
                }
            }
          if(TblAdmin::find()->where( ['icno' => $icno] )->exists()){
            $senarai = \app\models\cbelajar\TblPermohonan::find()->where([ 'status' => "Diluluskan", 'DeptId'=>$DeptId ])->orderBy(['tarikh_m' => SORT_DESC]);
            $title='Senarai Menunggu Semakan';
        }

        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        if($title != NULL){ 
        return $this->render('senarai_tindakan_1', [
            'icno' => $icno,
            'senarai' => $senarais,
            'title' => $title,
            'tmp' => $tmp,
            'fac' =>$fac,
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect(['index']);}  
    }
    
    public function actionSenaraiPemohonSabatikal($DeptId)
    {
        $icno=Yii::$app->user->getId();
        $title = '';
        $fac = \app\models\hronline\Department::find()->where(['category_id'=> 1, 'dept_cat_id'=>['2','4']])->orWhere(['id'=>['15','104']])->orderBy(['shortname' => SORT_ASC])->all();
        $models = \app\models\cbelajar\TblPermohonan::find()->where(['status_proses' => "Selesai Permohonan", 'DeptId'=> $fac])->all();
        $tmp = TblUrusMesyuarat::find()->select(['kali_ke'])->orderBy(['kali_ke'=>SORT_DESC])->limit(1)->one();
        $senarai  = '';
        $status = ['Tunggu Kelulusan', 'Diluluskan', 'Tidak Diluluskan'];
        $selection=(array)Yii::$app->request->post('selection');//typecasting
        
            if (Yii::$app->request->post('simpan')){
                
                foreach ($models as $data) {
                    if('y'.$data->id == Yii::$app->request->post($data->id)){
                    $model = $this->findModelCB($data->id);
                    $model->status_bsm = 'Draft Diluluskan';
                    $model->save(false);
//                    return $this->redirect('index');
                    }
                    elseif('n'.$data->id == Yii::$app->request->post($data->id)){
                    $model = $this->findModelCB($data->id);
                    $model->status_bsm = 'Draft Ditolak';
                    $model->save(false);
                    }
            }
            }
            elseif (Yii::$app->request->post('hantar')) {
                foreach($selection as $id){
                $hantar= $this->findModelCB($id);//make a typecasting
                if('n'.$hantar->id == Yii::$app->request->post($hantar->id) ){
                    $hantar->status ='TIDAK LULUS';
                    $hantar->status_bsm='Tidak Diluluskan';
                    $hantar->ver_date = date('Y-m-d H:i:s');
                    
                    $this->notifikasi($hantar->icno, "Permohonan Pengajian Lanjutan anda tidak berjaya.".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm'])); 
                }
                elseif('y'.$hantar->id == Yii::$app->request->post($hantar->id)){
                    $hantar->status ='LULUS';
                    $hantar->status_bsm='Diluluskan';
                    $hantar->ver_date = date('Y-m-d H:i:s');
                    $hantar->ver_by = $icno;
                    $this->notifikasi($hantar->icno, "Permohonan Pengajian Lanjutan anda berjaya.".Html::a('<i class="fa fa-arrow-right"></i>', ['cutibelajar/permohonan-semasa'], ['class'=>'btn btn-primary btn-sm']));
                    
                }
                $hantar->save(false);
                }
            }
          if(TblAdmin::find()->where( ['icno' => $icno] )->exists()){
            $senarai = \app\models\cbelajar\TblPermohonan::find()->where([ 'status_proses' => "Selesai Permohonan", 'DeptId'=>$DeptId ])->orderBy(['tarikh_m' => SORT_DESC]);
//            $title='Senarai Menunggu Semakan';
        }

        $senarais = new ActiveDataProvider([
            'query' => $senarai,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        if($title != NULL){ 
        return $this->render('senarai_tindakan_1', [
            'icno' => $icno,
            'senarai' => $senarais,
            'title' => $title,
            'tmp' => $tmp,
            'fac' =>$fac
        ]);}
        else{
        Yii::$app->session->setFlash('alert', ['title' => 'Harap Maaf', 'type' => 'error', 'msg' => 'Anda tiada akses']);
        return $this->redirect(['index']);}  
    }
    
     public function actionRingkasan_data(){
       

      $fakulti = \app\models\hronline\Department::find()->where(['category_id'=> 1, 'dept_cat_id'=>['2','4']])->orWhere(['id'=>['15','104']])->orderBy(['shortname' => SORT_ASC])->all();
       return $this->render('ringkasan_data',
       [
        'fakulti' => $fakulti,   
       ]); 
    }
     public function actionDashboard($date = null, $jfpib = null, $category = null) {
        
        $date = $date? : date('d M yy');
        $listicno = $jfpib? Tblprcobiodata::find()->where(['DeptId' => $jfpib])->andWhere(['!=','Status', '6']): Tblprcobiodata::find()->where(['!=','Status', '6']);
        $listicno = $category? $listicno->joinWith('jawatan')->where(['gredjawatan.job_category' => $category]): $listicno;
//        $listicno = $campus? $listicno->where(['campus_id' => $campus]): $listicno;
        
        $biodata = Tblprcobiodata::find()->where(['Status' => 1])->all();
        $model = $date? \app\models\kehadiran\TblSelfhealth::find()->where(['like', 'date', date_format(date_create($date), 'yy-m-d')])->andWhere(['icno' => $listicno->select(['ICNO'])])->all(): TblSelfhealth::find()->where(['>', 'date', '2020-06-16'])->andWhere(['icno' => $listicno->select(['ICNO'])])->all();
        return $this->render('dashboard', ['model' => $model, 'date' => $date,'jfpib' => $jfpib, 'category' => $category, 'biodata' => $biodata]);
        
    }

}
