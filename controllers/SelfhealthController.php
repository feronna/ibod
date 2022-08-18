<?php

namespace app\controllers;

use app\models\cuti\AksesPengguna;
use Yii;
use yii\web\Controller;
use app\models\kehadiran\TblSelfhealth;
use app\models\kehadiran\TblselfhealthSearch;
use yii\data\ActiveDataProvider;
use app\models\cuti\SetPegawai;
use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;
use app\models\kehadiran\TblAksesselfhealth;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\kehadiran\TblRekod;
class SelfhealthController extends \yii\web\Controller
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
    public function actionIndex($status = null, $user = null)
    {
        $icno=Yii::$app->user->getId();
        $today = date('Y-m-d');
        $model = TblSelfhealth::find()->where(['icno' => $icno, 'DATE(date)'=>$today])->one()? TblSelfhealth::find()->where(['icno' => $icno, 'DATE(date)'=>$today])->one():new TblSelfhealth();
        
        $model->icno = $icno; 
        $model->health_status = 1;
        $model->temperature = '36.0 - 37.5';
        if ($model->load(Yii::$app->request->post()))
        {  
            $model->status = 'Work from office';
            $model->date = date('Y-m-d H:i:s');
            if($model->status == 'Work from office' && ($model->health_status == '' || $model->temperature == '')){
                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Please fill all the required field']);
                return $this->redirect(['index']);
            }
            $model->save();
//            if(($model->health_status == 2 || $model->temperature == '> 37.5') && $model->status == 'Work from office'){
//                Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'warning', 'msg' => 'Please go to Pusat Rawatan Warga immediately (Compulsory)']);
//            }else{
//                Yii::$app->session->setFlash('alert', ['title' => 'Allowed to clock in', 'type' => 'success', 'msg' => '']);
//            }
        // if($user == 'skb'){
        //     return $this->redirect(['keselamatan/index']);
        // }
        // if ($model->kakitangan->DeptId == '12' || $model->kakitangan->department->sub_of == '12') {
        //                 return $this->redirect(['dashboard/index']);
        //             }
            return $this->redirect([$model->kakitangan->return_url]);
        }
        return $this->render('index', ['model' => $model, 'status'=>$status]);
    }
    
    public function actionViewself($my = null){
        $my = $my? : date('M yy');
        $biodata = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->getId()]);
        $dataProvider = new ActiveDataProvider([

            'query' => TblSelfhealth::find()->where(['icno' => Yii::$app->user->getId()])->andWhere(['like', 'date', date_format(date_create($my), 'yy-m')]),

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);

        return $this->render('viewself', [
            'dataProvider' => $dataProvider,
            'my'=> $my, 'biodata' => $biodata
        ]);
    }
    
    public function actionViewstaff($date = null, $icno = null, $symptom = null, $temp = null, $status = null, $category = null){
        
        $date = $date? :date('d M Y');
        $login=Yii::$app->user->getId();
        //$listicno = SetPegawai::find()->where(['peraku_icno' => $login])->orWhere(['pelulus_icno' => $login])->select(['pemohon_icno']);
        $akses = Department::find()->where(['or', 'pp='.$login,'chief='.$login])->andWhere(['isActive' => 1])->one();
        $listicno = '';
        if($akses){
            $listicno = Tblprcobiodata::find()->where(['DeptId' => $akses->id])->andWhere(['!=', 'Status', 6])->select(['ICNO']);
            $namajfpiu = $akses->fullname;
        }
        elseif(TblAksesselfhealth::find()->where(['icno' => $login, 'role' => 2])->exists()){
            $akses = TblAksesselfhealth::find()->where(['icno' => $login, 'role' => 2])->one();
            $listicno = Tblprcobiodata::find()->where(['DeptId' => $akses->dept_id])->andWhere(['!=', 'Status', 6])->select(['ICNO']);
            $namajfpiu = Department::find()->where(['id' => $akses->dept_id])->one()->fullname;
        }
        
        $query = TblSelfhealth::find()->where(['like', 'date', date_format(date_create($date), 'Y-m-d')])->andWhere(['icno' => $listicno]);
        $dataProvider = new ActiveDataProvider([

            'query' => $query,

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
        
        $icno!=''?$dataProvider->query->andFilterWhere(['like', 'icno',  Yii::$app->request->queryParams['icno'] ]):'';
        $symptom!=''?$dataProvider->query->andFilterWhere(['health_status' => Yii::$app->request->queryParams['symptom'] ]):'';
        $status!=''?$dataProvider->query->andFilterWhere(['status' => Yii::$app->request->queryParams['status'] ]):'';
        $temp == '< 36.0'? $dataProvider->query->andFilterWhere(['or', 'temperature < 36.0', 'temperature = "< 36.0"']):'';
        $temp == '36.0 - 37.5'? $dataProvider->query->andFilterWhere(['or', 'temperature < 36.0 and temperature < 37.5', 'temperature = "36.0 - 37.5"']):'';
        $temp == '> 37.5'? $dataProvider->query->andFilterWhere(['or', 'temperature > 37.5', 'temperature = "> 37.5"']):'';
        return $this->render('viewstaff', [
            'dataProvider' => $dataProvider, 'query' => $query,
            'date'=> $date, 'icno' => $icno,'campus'=>'', 'akses' => $akses, 'symptom' => $symptom, 'temp' => $temp, 'status' => $status, 'jfpiu' => $namajfpiu, 'role' => 0, 'category' => $category
        ]);
    }
    
    public function actionAdminviewstaff($campus = null, $date = null, $icno = null, $symptom = null, $temp = null, $status = null, $jfpiu = null, $category = null){
        
        $date = $date? :date('d M Y');
        $login=Yii::$app->user->getId();
        $akses = TblAksesselfhealth::find()->where(['icno' => $login, 'role' => 1])->one();
        $listicno = $jfpiu? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['!=','Status', '6']): Tblprcobiodata::find()->where(['!=','Status', '6']);
        $listicno = $category? $listicno->joinWith('jawatan')->where(['gredjawatan.job_category' => $category]): $listicno;
        $listicno = $campus? $listicno->where(['campus_id' => $campus]): $listicno;
        
        $query = TblSelfhealth::find()->where(['like', 'date', date_format(date_create($date), 'Y-m-d')])->andWhere(['icno' => $listicno->select(['ICNO'])]);
        $dataProvider = new ActiveDataProvider([

            'query' => $query,

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
        
        $icno!=''?$dataProvider->query->andFilterWhere(['like', 'icno',  Yii::$app->request->queryParams['icno'] ]):'';
        $symptom!=''?$dataProvider->query->andFilterWhere(['health_status' => Yii::$app->request->queryParams['symptom'] ]):'';
        if($status){
            $status == 'from ctto'? $dataProvider->query->andFilterWhere(['status' => 'Work from home', 'comment' => 'Changed from ctto']):$dataProvider->query->andFilterWhere(['status' => Yii::$app->request->queryParams['status']]);
        }
        $temp == '< 36.0'? $dataProvider->query->andFilterWhere(['or', 'temperature < 36.0 and temperature != "> 37.5"', 'temperature = "< 36.0"']):'';
        $temp == '36.0 - 37.5'? $dataProvider->query->andFilterWhere(['or', 'temperature >= 36.0 and temperature < 37.5', 'temperature = "36.0 - 37.5"']):'';
        $temp == '> 37.5'? $dataProvider->query->andFilterWhere(['or', 'temperature > 37.5', 'temperature = "> 37.5"']):'';
        if($akses){
        return $this->render('viewstaff', [
            'dataProvider' => $dataProvider, 'query' => $query,
            'date'=> $date,'campus'=>$campus, 'icno' => $icno, 'akses' => $akses, 'symptom' => $symptom, 'temp' => $temp, 'status' => $status, 'jfpiu' => $jfpiu, 'role' => 1, 'category' => $category
        ]);}
    }
    
    public function actionViewstaffreport($my = null, $icno){
        $my = $my? : date('M yy');
        $login=Yii::$app->user->getId();
        $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $dataProvider = new ActiveDataProvider([

            'query' => TblSelfhealth::find()->where(['icno' => $icno])->andWhere(['like', 'date', date_format(date_create($my), 'yy-m')]),

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
//        $pegawai = SetPegawai::find()->where(['pemohon_icno' => $icno])->one();
//        if($pegawai->peraku_icno == $login || $pegawai->pelulus_icno == $login){
        return $this->render('viewself', [
            'dataProvider' => $dataProvider,
            'my'=> $my, 'biodata' => $biodata
        ]);
    }


    public function actionPenyelia($campus = null, $date = null, $icno = null, $symptom = null, $temp = null, $status = null, $jfpiu = null, $category = null){
        
        $date = $date? :date('d M Y');
        $login=Yii::$app->user->getId();

        // $akses = \app\models\kehadiran\TblAksesselfhealth::find()->where(['icno' => $login, 'role' => 1])->one();

        $akses = AksesPengguna::find()->where(['akses_cuti_icno'=>$login])->one();

        // $listicno = $jfpiu? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->select(['ICNO']): Tblprcobiodata::find()->select(['ICNO']);

        $listicno = Tblprcobiodata::find()->where(['IN','DeptId', $akses->akses_jspiu_id])->andWhere(['!=','Status', '6'])->select(['ICNO']);
        $query = TblSelfhealth::find()->where(['like', 'date', date_format(date_create($date), 'Y-m-d')])->andWhere(['icno' => $listicno]);
        $dataProvider = new ActiveDataProvider([

            'query' => $query,

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
        
        $icno!=''?$dataProvider->query->andFilterWhere(['like', 'icno',  Yii::$app->request->queryParams['icno'] ]):'';
        $symptom!=''?$dataProvider->query->andFilterWhere(['health_status' => Yii::$app->request->queryParams['symptom'] ]):'';
        if($status){
            $status == 'from ctto'? $dataProvider->query->andFilterWhere(['status' => 'Work from home', 'comment' => 'Changed from ctto']):$dataProvider->query->andFilterWhere(['status' => Yii::$app->request->queryParams['status']]);
        }
        $temp == '< 36.0'? $dataProvider->query->andFilterWhere(['or', 'temperature < 36.0 and temperature != "> 37.5"', 'temperature = "< 36.0"']):'';
        $temp == '36.0 - 37.5'? $dataProvider->query->andFilterWhere(['or', 'temperature >= 36.0 and temperature < 37.5', 'temperature = "36.0 - 37.5"']):'';
        $temp == '> 37.5'? $dataProvider->query->andFilterWhere(['or', 'temperature > 37.5', 'temperature = "> 37.5"']):'';
        if($akses){
        return $this->render('viewstaff', [
            'dataProvider' => $dataProvider, 'query' => $query,
            'date'=> $date, 'campus'=>$campus,'icno' => $icno, 'akses' => $akses, 'symptom' => $symptom, 'temp' => $temp, 'status' => $status, 'jfpiu' => $jfpiu, 'role' => 0, 'category' => $category
        ]);}
    }

    public function actionPrw($campus = null, $date = null,$icno = null, $symptom = null, $temp = null, $status = null, $jfpiu = null, $category = null){
        
//        $date = $date? :date('d M Y');
        $login=Yii::$app->user->getId();
        $akses = TblAksesselfhealth::find()->where(['icno' => $login, 'role' => 3])->one();
        $listicno = $jfpiu? Tblprcobiodata::find()->where(['DeptId' => $jfpiu])->andWhere(['!=','Status', '6']): Tblprcobiodata::find()->where(['!=','Status', '6']);
        $listicno = $category? $listicno->joinWith('jawatan')->where(['gredjawatan.job_category' => $category]): $listicno;
        $listicno = $campus? $listicno->where(['campus_id' => $campus]): $listicno;
        
        $query = TblSelfhealth::find()->andWhere(['>', 'date' , '2020-06-16'])->andWhere(['icno' => $listicno->select(['ICNO']), 'status' => 'Work from office'])->andWhere(['or', 'health_status=2', 'temperature="> 37.5"']);
        $dataProvider = new ActiveDataProvider([

            'query' => $query,

            'pagination' => [

                'pageSize' => 30,

            ],
        ]);
        $date? $dataProvider->query->andFilterWhere(['like', 'date',  date_format(date_create($date), 'Y-m-d') ]):'';
        $icno!=''?$dataProvider->query->andFilterWhere(['like', 'icno',  Yii::$app->request->queryParams['icno'] ]):'';
        $symptom!=''?$dataProvider->query->andFilterWhere(['health_status' => Yii::$app->request->queryParams['symptom'] ]):'';
        if($status){
            $status == 'from ctto'? $dataProvider->query->andFilterWhere(['status' => 'Work from home', 'comment' => 'Changed from ctto']):$dataProvider->query->andFilterWhere(['status' => Yii::$app->request->queryParams['status']]);
        }
        $temp == '< 36.0'? $dataProvider->query->andFilterWhere(['or', 'temperature < 36.0 and temperature != "> 37.5"', 'temperature = "< 36.0"']):'';
        $temp == '36.0 - 37.5'? $dataProvider->query->andFilterWhere(['or', 'temperature >= 36.0 and temperature < 37.5', 'temperature = "36.0 - 37.5"']):'';
        $temp == '> 37.5'? $dataProvider->query->andFilterWhere(['or', 'temperature > 37.5', 'temperature = "> 37.5"']):'';
        
        
        if($akses){
        return $this->render('prw', [
            'dataProvider' => $dataProvider, 'query' => $query,
            'icno' => $icno, 'campus' => $campus, 'date' => $date, 'akses' => $akses, 'symptom' => $symptom, 'temp' => $temp, 'status' => $status, 'jfpiu' => $jfpiu, 'role' => 3, 'category' => $category
        ]);}
    }
    
     public function actionStatusprw($id) {
        
        $model = TblSelfhealth::find()->where(['id' => $id])->one();
        $icno = Yii::$app->user->getId();
        $model->date_prw = date('Y-m-d H:i:s');
        $model->updatedby_prw = $icno;
        $model->treatment_place = 'prw';
        
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => '']);
            return $this->redirect(['prw']);
        }
        
        return $this->renderAjax('statusprw', [
                    'model' => $model,
        ]);
    }
    
    public function actionDashboard($date = null, $jfpib = null) {
        
        $date = $date? : date('d M Y');
        $fdate = date_format(date_create($date), 'Y-m-d');
        $biodata = Tblprcobiodata::find()->where(['<>','Status',6]);
        $listicno = $jfpib? $biodata->andWhere(['DeptId' => $jfpib]): $biodata;
        
        $icstaff = \array_column($listicno->all(), 'ICNO');
        $kehadiran = TblRekod::find()->select('icno')->where(['tarikh' => $fdate,'icno' => $icstaff])->asArray()->all();
        $keselamatan = \app\models\keselamatan\TblRekod::find()->select('icno')->where(['tarikh' => $fdate,'icno' => $icstaff])->asArray()->all();
        $all = array_column($kehadiran + $keselamatan, 'icno');
        
        $wfh = \app\models\kehadiran\TblWfh::find()->with('kakitangan')->select('icno')->distinct()->where(['icno' => $icstaff, 'start_date' => $fdate])->asArray()->all();
        $wfo = \array_diff($all, array_column($wfh, 'icno'));
        
        $non1 = \array_diff($icstaff, $wfo, array_column($wfh, 'icno'));
//        $sqlwfh = 'SELECT a.icno, b.campus_id FROM attendance.tbl_rekod a LEFT JOIN hronline.tblprcobiodata b on a.icno = b.ICNO WHERE EXISTS (SELECT * FROM attendance.tbl_wfh b WHERE b.start_date = a.tarikh AND b.icno = a.icno AND b.status = "APPROVED")AND a.tarikh = :date';
//        $wfh = TblRekod::findBySql($sqlwfh, [':date' => date_format(date_create($date), 'Y-m-d')])->andFilterWhere(['icno' => $listicno->select(['ICNO'])])->asArray()->all();
//        $sqlwfo = 'SELECT a.icno FROM attendance.tbl_rekod a WHERE NOT EXISTS (SELECT * FROM attendance.tbl_wfh b WHERE b.start_date = a.tarikh AND b.icno = a.icno AND b.status = "APPROVED")AND a.tarikh = :date';
//        $wfo = TblRekod::findBySql($sqlwfo, [':date' => date_format(date_create($date), 'Y-m-d')])->andFilterWhere(['icno' => $listicno->select(['ICNO'])])->asArray()->all();
//        $sqlnon = 'SELECT a.ICNO, a.campus_id FROM hronline.tblprcobiodata a WHERE NOT EXISTS (SELECT * FROM attendance.tbl_rekod b WHERE b.tarikh = :date AND b.icno = a.ICNO)AND a.Status = 1';
        $non = Tblprcobiodata::find()->where(['ICNO' => $non1])->asArray()->all();
        //var_dump(count($icstaff).' '.count($all).' '.count($non1).' '.count($wfh).' '.count($wfo));        die;
        $dwfo = TblSelfhealth::find()->with('kakitangan')->where(['like', 'date', $fdate])->andWhere(['icno' => $wfo])->asArray()->all();
        
        return $this->render('dashboard', 
                ['wfh' => $wfh,
                    'wfo' => $wfo,
                    'dwfo' => $dwfo,
                    'non' => $non,
                    'date' => $date,
                    'jfpib' => $jfpib,
                    'listicno' => $listicno, 
                    ]);
        
    }
    
    public function actionReset($id, $url){
        $model = TblSelfhealth::find()->where(['id' => $id])->one();
        
        if ($model->load(Yii::$app->request->post())) {
            $icno = Yii::$app->user->getId();
            $model->reset_date = date('Y-m-d H:i:s');
            $model->reset_by = $icno;
            $model->save();
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => '']);
            return $this->redirect([$url]);
        }
        
        return $this->renderAjax('reset', [
                    'model' => $model,'url'=>$url
        ]); 
    }
    
    public function actionDelete($id, $url){
        TblSelfhealth::find()->where(['id' => $id])->one()->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => '']);
            return $this->redirect([$url]);
    }
}
