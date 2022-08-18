<?php

namespace app\controllers;

use app\models\hronline\Agama;
use app\models\hronline\AgamaSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\JenisAlamat;
use app\models\hronline\JenisAlamatSearch;
use app\models\hronline\Bandar;
use app\models\hronline\BandarSearch;
use app\models\hronline\Institut;
use app\models\hronline\InstitutSearch;
use app\models\hronline\Negara;
use app\models\hronline\NegaraSearch;
use app\models\hronline\Negeri;
use app\models\hronline\NegeriSearch;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\PendidikanTertinggiSearch;
use app\models\hronline\Penaja;
use app\models\hronline\PenajaSearch;
use app\models\hronline\MajorMinor;
use app\models\hronline\MajorMinorSearch;
use app\models\hronline\NamaBahasa;
use app\models\hronline\NamaBahasaSearch;
use app\models\hronline\TahapKemahiranBahasa;
use app\models\hronline\TahapKemahiranBahasaSearch;
use app\models\hronline\TarafKeahlian;
use app\models\hronline\TarafKeahlianSearch;
use app\models\hronline\BadanProfesional;
use app\models\hronline\BadanProfesionalSearch;
use app\models\hronline\KategoriAnugerah;
use app\models\hronline\KategoriAnugerahSearch;
use app\models\hronline\Anugerah;
use app\models\hronline\AnugerahSearch;
use app\models\hronline\badanprofesional_skim;
use app\models\hronline\Bangsa;
use app\models\hronline\BangsaSearch;
use app\models\hronline\DianugerahkanOleh;
use app\models\hronline\DianugerahkanOlehSearch;
use app\models\hronline\Gelaran;
use app\models\hronline\GelaranSearch;
use app\models\hronline\Tblkod;
use app\models\hronline\Subjek;
use app\models\hronline\SubjekSearch;
use app\models\hronline\Gred;
use app\models\hronline\GredSearch;
use yii\filters\AccessControl;
use app\models\hronline\HubunganKeluarga;
use app\models\hronline\HubunganKeluargaSearch;
use app\models\hronline\TblAdminRP;
use app\models\hronline\TblAdminRPSearch;
use app\models\hronline\SubAppointmentstatus;
use app\models\hronline\SubAppointmentstatusSearch;
use app\models\hronline\Department;
use app\models\hronline\DepartmentSearch;
use app\models\hronline\Etnik;
use app\models\hronline\EtnikSearch;
use app\models\hronline\CawanganAkaun;
use app\models\hronline\CawanganAkaunSearch;
use app\models\hronline\Jantina;
use app\models\hronline\JantinaSearch;
use app\models\hronline\JenisAkaun;
use app\models\hronline\JenisAkaunSearch;
use app\models\hronline\Jenisdarah;
use app\models\hronline\JenisdarahSearch;
use app\models\hronline\GredJawatan;
use app\models\hronline\GredJawatanSearch;
use app\models\hronline\jenis_vaksin;
use app\models\hronline\jenis_vaksinSearch;
use app\models\hronline\RefPapJenisAkses;
use app\models\hronline\RefPapJenisAksesSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;
use app\models\hronline\KlasifikasiPerkhidmatan;
use app\models\hronline\KlasifikasiPerkhidmatanSearch;
use yii\helpers\ArrayHelper;

class SelenggarakodController extends \yii\web\Controller {

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
                'only' => ['*'],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id),
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                           $access = Yii::$app->user->identity->accessLevel;
                           return $access === 1;  
                        }
                    ],
                ],
            ],
        ];
    }
    public function actionSkindex() {
        $model = Tblkod::find()->orderBy(['kodname' => SORT_ASC])->all();  
        return $this->render('skindex',['model'=>$model]);
    }
    public function actionTambahkod() {
        $model = new Tblkod;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skindex']);
        }
        return $this->render('tambahkod', [
                    'model' => $model,
        ]);
    }
    public function actionDeletekod($id) {
        $model = Tblkod::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['skindex']); 
    }
    //////jenisalamat
    public function actionSkjenisalamat() {
        $searchModel = new JenisAlamatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skjenisalamat', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTk_jenisalamat($id) {
        if (($model = JenisAlamat::findOne($id)) === null) {
            $model = new JenisAlamat();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skjenisalamat']);
        }
        return $this->render('tk_jenisalamat', [
                    'model' => $model,
        ]);
    }
    
    /////bandar || city
    public function actionSkbandar() {
        $searchModel = new BandarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skbandar', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionTk_bandar($id) {
        if (($model = Bandar::findOne($id)) === null) {
            $model = new Bandar();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skbandar']);
        }
        return $this->render('tk_bandar', [
                    'model' => $model,
        ]);
    }
    
    /////institut/////
    public function actionSkinstitut() {
        $searchModel = new InstitutSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skinstitut', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionTk_institut($id) {
        if (($model = Institut::findOne($id)) === null) {
            $model = new Institut();
        }

        if ($model->load(Yii::$app->request->post())){
            $model_id = Institut::find()->where(['InstLocation'=>$model->InstLocation])->orderBy(['InstCd'=>SORT_ASC])->all();
            if(!empty($model_id)){
                $count = count($model_id) + 1;
            }else{
                $count = 1;
            }
            $model->CountryCd = $model->InstLocation;
            $model->InstCd = $model->CountryCd.$count;
            if($model->save()){
                return $this->redirect(['skinstitut']);
            }
            
        }
        return $this->render('tk_institut', [
                    'model' => $model,
        ]);
    }
    
    /////negara/////
    public function actionSknegara() {
        $searchModel = new NegaraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('sknegara', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionTk_negara($id) {
        if (($model = Negara::findOne($id)) === null) {
            $model = new Negara();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['sknegara']);
        }
        return $this->render('tk_negara', [
                    'model' => $model,
        ]);
    }
    
    /////negeri
    public function actionSknegeri() {
        $searchModel = new NegeriSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('sknegeri', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionTk_negeri($id) {
        if (($model = Negeri::findOne($id)) === null) {
            $model = new Negeri();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['sknegeri']);
        }
        return $this->render('tk_negeri', [
                    'model' => $model,
        ]);
    }
    
    /////pendidikan tertinggi
    public function actionSktahappendidikan() {
        $searchModel = new PendidikanTertinggiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('sktahappendidikan', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_tahappendidikan($id) {
        if (($model = PendidikanTertinggi::findOne($id)) === null) {
            $model = new PendidikanTertinggi();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['sktahappendidikan']);
        }
        return $this->render('tk_tahappendidikan', [
                    'model' => $model,
        ]);
    }
    
    /////penaja
    public function actionSkpenaja() {
        $searchModel = new PenajaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skpenaja', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_penaja($id) {
        if (($model = Penaja::findOne($id)) === null) {
            $model = new Penaja();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skpenaja']);
        }
        return $this->render('tk_penaja', [
                    'model' => $model,
        ]);
    }
    
    /////majorminor
    public function actionSkmajorminor() {
        $searchModel = new MajorMinorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skmajorminor', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_majorminor($id) {
        if (($model = MajorMinor::findOne($id)) === null) {
            $model = new MajorMinor();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skmajorminor']);
        }
        return $this->render('tk_majorminor', [
                    'model' => $model,
        ]);
    }
    
    /////namabahasa
    public function actionSknamabahasa() {
        $searchModel = new NamaBahasaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('sknamabahasa', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_namabahasa($id) {
        if (($model = NamaBahasa::findOne($id)) === null) {
            $model = new NamaBahasa();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['sknamabahasa']);
        }
        return $this->render('tk_namabahasa', [
                    'model' => $model,
        ]);
    }
    
    /////tahappendidikan
    public function actionSktahapkemahiranbahasa() {
        $searchModel = new TahapKemahiranBahasaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('sktahapkemahiranbahasa', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_tahapkemahiranbahasa($id) {
        if (($model = TahapKemahiranBahasa::findOne($id)) === null) {
            $model = new TahapKemahiranBahasa();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['sktahapkemahiranbahasa']);
        }
        return $this->render('tk_tahapkemahiranbahasa', [
                    'model' => $model,
        ]);
    }
    
    /////badanprofesional
    public function actionSkbadanprofesional() {
        $searchModel = new BadanProfesionalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skbadanprofesional', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_badanprofesional($id) {
        $curr_id = null;
        if (($model = BadanProfesional::findOne($id)) === null) {
            $model = new BadanProfesional();
            $curr_id = BadanProfesional::find()->where(['isActive'=>1])->orderBy(['ProfBodyCd'=>SORT_DESC])->one()->ProfBodyCd;
            $model->ProfBodyCd = $curr_id + 1;
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skbadanprofesional']);
        }
        return $this->render('tk_badanprofesional', [
                    'model' => $model,
                    'curr_id' => $curr_id,
        ]);
    }
    
    /////taraf keahlian
    public function actionSktarafkeahlian() {
        $searchModel = new TarafKeahlianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('sktarafkeahlian', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_tarafkeahlian($id) {
        if (($model = TarafKeahlian::findOne($id)) === null) {
            $model = new TarafKeahlian();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['sktarafkeahlian']);
        }
        return $this->render('tk_tarafkeahlian', [
                    'model' => $model,
        ]);
    }
    
    /////kategorianugerah
    public function actionSkkategorianugerah() {
        $searchModel = new KategoriAnugerahSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skkategorianugerah', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_kategorianugerah($id) {
        if (($model = KategoriAnugerah::findOne($id)) === null) {
            $model = new KategoriAnugerah();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skkategorianugerah']);
        }
        return $this->render('tk_kategorianugerah', [
                    'model' => $model,
        ]);
    }
    
    /////namaanugerah
    public function actionSknamaanugerah() {
        $searchModel = new AnugerahSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('sknamaanugerah', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_namaanugerah($id) {
        if (($model = Anugerah::findOne($id)) === null) {
            $model = new Anugerah();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['sknamaanugerah']);
        }
        return $this->render('tk_namaanugerah', [
                    'model' => $model,
        ]);
    }
    
    /////gelaran
    public function actionSkgelaran() {
        $searchModel = new GelaranSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skgelaran', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_gelaran($id) {
        if (($model = Gelaran::findOne($id)) === null) {
            $model = new Gelaran();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skgelaran']);
        }
        return $this->render('tk_gelaran', [
                    'model' => $model,
        ]);
    }
    
    /////dianugerahkanoleh
    public function actionSkdianugerahkanoleh() {
        $searchModel = new DianugerahkanOlehSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skdianugerahkanoleh', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_dianugerahkanoleh($id) {
        if (($model = DianugerahkanOleh::findOne($id)) === null) {
            $model = new DianugerahkanOleh();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skdianugerahkanoleh']);
        }
        return $this->render('tk_dianugerahkanoleh', [
                    'model' => $model,
        ]);
    }
    
    public function actionSkhubungankeluarga() {
        $searchModel = new HubunganKeluargaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skhubungankeluarga', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_hubungankeluarga($id) {
        if (($model = HubunganKeluarga::findOne($id)) === null) {
            $model = new HubunganKeluarga();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skhubungankeluarga']);
        }
        return $this->render('tk_hubungankeluarga', [
                    'model' => $model,
        ]);
    }
    
    /////subjek
    public function actionSksubjek() {
        $searchModel = new SubjekSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('sksubjek', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_subjek($id) {
        if (($model = Subjek::findOne($id)) === null) {
            $model = new Subjek();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['sksubjek']);
        }
        return $this->render('tk_subjek', [
                    'model' => $model,
        ]);
    }
    
    /////Gred
    public function actionSkgred() {
        $searchModel = new GredSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skgred', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_gred($id) {
        if (($model = Gred::findOne($id)) === null) {
            $model = new Gred();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skgred']);
        }
        return $this->render('tk_gred', [
                    'model' => $model,
        ]);
    }

    /////AdminResetPassword
    public function actionSkadminrp() {
        $searchModel = new TblAdminRPSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skadminrp', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_adminrp($id) {
        if (($model = TblAdminRP::findOne($id)) === null) {
            $model = new TblAdminRP();
        }
        $user_set = [];
        $users = Tblprcobiodata::find()->select(['ICNO','CONm'])->where(['!=','Status','06'])->asArray()->all();
        foreach ($users as $user) {
            $user_set[$user['ICNO']] = sprintf("%s - %s",$user['CONm'],$user['ICNO']);

        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skadminrp']);
        }
        return $this->render('tk_adminrp', [
                    'model' => $model,
                    'user_set' => $user_set,
        ]);
    }

    /////Sub status lantikan
    // public function actionSksubapmtstatus() {
    //     $searchModel = new SubAppointmentstatusSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    //     return $this->render('sksubapmtstatus', [
    //                 'searchModel' => $searchModel,
    //                 'dataProvider' => $dataProvider,
    //     ]);
    // }
    // public function actionTk_subapmtstatus($id) {
    //     if (($model = SubAppointmentstatus::findOne($id)) === null) {
    //         $model = new SubAppointmentstatus();
    //     }
    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['sksubapmtstatus']);
    //     }
    //     return $this->render('tk_subapmtstatus', [
    //                 'model' => $model,
    //     ]);
    // }

    /////update department info
    public function actionSkupdatedepartmentinfo($fullname = null) {
        $searchModel = new DepartmentSearch();
        $query = Department::find();
        $dataProvider = new ActiveDataProvider([

            'query' => $query,

            'pagination' => [

                'pageSize' => 20,

            ],
        ]);

        $fullname? $dataProvider->query->andFilterWhere(['like', 'fullname',  $fullname ]):'';
        
        return $this->render('skupdatedepartmentinfo', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_updatedepartmentinfo($id) {
        if (($model = Department::findOne($id)) === null) {
            $model = new Department();
           
        }
        $model->scenario = 'update_department_info';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skupdatedepartmentinfo']);
        }
        return $this->render('tk_updatedepartmentinfo', [
                    'model' => $model,
        ]);
    }

    /////agama
    public function actionSkagama() {
        $searchModel = new AgamaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skagama', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_agama($id) {
        if (($model = Agama::findOne($id)) === null) {
            $model = new Agama();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skagama']);
        }
        return $this->render('tk_agama', [
                    'model' => $model,
        ]);
    }
    /////Bangsa
    public function actionSkbangsa() {
        $searchModel = new BangsaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skbangsa', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_bangsa($id) {
        if (($model = Bangsa::findOne($id)) === null) {
            $model = new Bangsa();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skbangsa']);
        }
        return $this->render('tk_bangsa', [
                    'model' => $model,
        ]);
    }
    /////Etnik
    public function actionSketnik() {
        $searchModel = new EtnikSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('sketnik', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_etnik($id) {
        if (($model = Etnik::findOne($id)) === null) {
            $model = new Etnik();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['sketnik']);
        }
        return $this->render('tk_etnik', [
                    'model' => $model,
        ]);
    }
    /////cawangan akaun
    public function actionSkcawanganakaun() {
        $searchModel = new EtnikSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('sketnik', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_cawanganakaun($id) {
        if (($model = Etnik::findOne($id)) === null) {
            $model = new Etnik();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['sketnik']);
        }
        return $this->render('tk_etnik', [
                    'model' => $model,
        ]);
    }
    /////Jantina
    public function actionSkjantina() {
        $searchModel = new JantinaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skjantina', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_jantina($id) {
        if (($model = Jantina::findOne($id)) === null) {
            $model = new Jantina();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skjantina']);
        }
        return $this->render('tk_jantina', [
                    'model' => $model,
        ]);
    }
    /////Jenis Akaun
    public function actionSkjenisakaun() {
        $searchModel = new JenisAkaunSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skjenisakaun', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_jenisakaun($id) {
        if (($model = JenisAkaun::findOne($id)) === null) {
            $model = new JenisAkaun();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skjenisakaun']);
        }
        return $this->render('tk_jenisakaun', [
                    'model' => $model,
        ]);
    }
    /////Jenis Akaun
    public function actionSkjenisdarah() {
        $searchModel = new JenisdarahSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skjenisdarah', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_jenisdarah($id) {
        if (($model = Jenisdarah::findOne($id)) === null) {
            $model = new Jenisdarah();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skjenisdarah']);
        }
        return $this->render('tk_jenisdarah', [
                    'model' => $model,
        ]);
    }

    /////jabatan
    public function actionSkjabatan($fullname = null, $shortname = null) {
        $searchModel = new DepartmentSearch();
        $query = Department::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $fullname? $dataProvider->query->andFilterWhere(['like', 'fullname',  $fullname ]):'';     
        $shortname? $dataProvider->query->andFilterWhere(['like', 'shortname',  $shortname ]):'';     
        return $this->render('skjabatan', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_jabatan($id) {
        if (($model = Department::findOne($id)) === null) {
            $model = new Department();
        }
        $model->scenario = 'tk_jabatan';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skjabatan']);
        }
        return $this->render('tk_jabatan', [
                    'model' => $model,
        ]);
    }
    public function actionTk_ad($id) {
        if (($model = Department::findOne($id)) !== null) {
            if ($model->isActive == 0) {
                $model->isActive = 1;
            } else {
                $model->isActive = 0;
            }
            $model->save(false);
        }
        // $model->scenario = 'tk_jabatan';

        
        return $this->redirect(['skjabatan']);

    }

    /////Gred Jawatan
    public function actionSkgredjawatan() {
        $searchModel = new GredJawatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skgredjawatan', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTk_gredjawatan($id) {
        if (($model = GredJawatan::findOne($id)) === null) {
            $model = new GredJawatan();
        }
        if ($model->load(Yii::$app->request->post())) {

            $model->gred = $model->gred_skim.$model->gred_no;
            if($model->save()){
                return $this->redirect(['skgredjawatan']);
            }
            
        }
        return $this->render('tk_gredjawatan', [
                    'model' => $model,
        ]);
    }
    /////Jenis Vaksin
    public function actionSkjenisvaksin() {
        $searchModel = new jenis_vaksinSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skjenisvaksin', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_jenisvaksin($id) {
        if (($model = jenis_vaksin::findOne($id)) === null) {
            $model = new jenis_vaksin();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skjenisvaksin']);
        }
        return $this->render('tk_jenisvaksin', [
                    'model' => $model,
        ]);
    }
    ///// PAP Jenis Akses
    public function actionSkpapjenisakses() {
        $searchModel = new RefPapJenisAksesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('skpapjenisakses', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTk_papjenisakses($id) {
        if (($model = RefPapJenisAkses::findOne($id)) === null) {
            $model = new RefPapJenisAkses();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skpapjenisakses']);
        }
        return $this->render('tk_papjenisakses', [
                    'model' => $model,
        ]);
    }


    //admin setting//

    public function actionIndexBadanprofesionalSkim(){
        $searchModel = new BadanProfesionalSearch();
        $dataProvider = $searchModel->searchBadanSkim(Yii::$app->request->queryParams);
        return $this->render('admin_setting/badan_profesional/index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLihatBadanprofesionalSkim($bp_id = null){
        $model = BadanProfesional::find()->where(['ProfBodyCd'=>$bp_id])->one();

        return $this->render('admin_setting/badan_profesional/lihat',[
            'model'=>$model,
        ]);
        
    }

    public function actionSetBadanprofesionalSkim($bp_id = null){
    
        $searchModel = new KlasifikasiPerkhidmatanSearch();
        $bp_id = $bp_id;
        // VarDumper::dump( Yii::$app->request->queryParams, $depth = 10, $highlight = true);die;
       
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(Yii::$app->request->post('submit_1') == '2'){
            // VarDumper::dump( Yii::$app->request->queryParams, $depth = 10, $highlight = true);die;
            $bp_id = ArrayHelper::keyExists('KlasifikasiPerkhidmatanSearch', Yii::$app->request->queryParams, false) ? Yii::$app->request->queryParams['KlasifikasiPerkhidmatanSearch']['bp_id'] : Yii::$app->request->queryParams['bp_id'] ;
            $selection = (array)Yii::$app->request->post('selection');
            foreach ($selection as $skim_id) {
                $model = new badanprofesional_skim();
                $model->skim_id = $skim_id;
                $model->ProfBodyCd = $bp_id;
                $model->save();
            }

            return $this->redirect(['lihat-badanprofesional-skim','bp_id'=>$bp_id]);
        }

        return $this->renderAjax('admin_setting/badan_profesional/_badanskim', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'bp_id' => $bp_id,
            ]);
    }

    public function actionSetBadanprofesionalSkim2(){
        $bp_id = 1;
        $model = new badanprofesional_skim();
        $array_skim_id = [];
        if($bp_id != null){
            $model->_profbodyid = $bp_id;
            if(($array = badanprofesional_skim::find()->select('skim_id')->where(['ProfBodyCd'=>$bp_id])->asArray()->all()) !== null){
                $array_skim_id = ArrayHelper::getColumn($array, 'skim_id');
            }
            
        }
        
        if($model->load(Yii::$app->request->post())){
            $selection = (array)Yii::$app->request->post('selection');
            $id = $model->_profbodyid;
            foreach ($selection as $bid) {
                $model = new badanprofesional_skim();
                $model->ProfBodyCd = $id;
                $model->skim_id = $bid;
                $model->save();
            }

            return $this->redirect(['lihat-badanprofesional-skim','bp_id'=>$id]);

        }
        
        $searchModel = new KlasifikasiPerkhidmatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$array_skim_id);
        return $this->render('admin_setting/badan_profesional/_badanskim', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    public function actionBuangSkim($badanskim_id){
        $model = badanprofesional_skim::find()->where(['id'=>$badanskim_id])->one();
        $model->delete();

        return $this->redirect(['lihat-badanprofesional-skim','bp_id'=>$model->ProfBodyCd]);
    }

    //tamat admin setting//
    

}
