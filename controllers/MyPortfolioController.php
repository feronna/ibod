<?php

namespace app\controllers;

use Yii;
use app\models\myportfolio\TblAkauntabiliti;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\myportfolio\TblKompetensi;
use app\models\myportfolio\TblDimensi;
use app\models\myportfolio\TblTugasUtama;
use app\models\ptb\Model;
use app\models\myportfolio\TblIkhtisas;
use yii\helpers\ArrayHelper;
use app\models\myportfolio\TblPengalaman;
use app\models\hronline\Tblprcobiodata;

error_reporting(0);

use app\models\myportfolio\TblSyaratTambahan;
use app\models\myportfolio\TblLog;
use yii\data\ActiveDataProvider;
use app\models\Notification;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use app\models\myportfolio\TblPortfolio;
use app\models\kontrak\Kontrak;
use yii\helpers\Html;
use app\models\lppums\Lpp;

class MyPortfolioController extends Controller {

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
                        [
                        //  'actions' => ['tujuan-jawatan','lihat-akauntabiliti','lihat-dimensi','lihat-kelayakan', 'lihat-kompetensi', 'lihat-pengalaman'],
                        'allow' => true,
                        'roles' => ['@'],
//                        'matchCallback' => function ($rule, $action) {
//                            $model = TblPortfolio::find()->where(['icno'=>Yii::$app->user->getId()])->andWhere(['status_hantar'=>'1'])->one();
//                            if(!empty($model)){
//                                return false;
//                            }
//                            return true;
//                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionGenerateAP() {
        $model = TblPortfolio::find()->all();

        foreach ($model as $m) {
            $mkj = Tblprcobiodata::find()->where(['ICNO' => $m->icno])->andWhere(['!=', 'Status', '06'])->one();
            if ($mkj) {
                // var_dump($mkj->jawatan->job_category);
                // var_dump($mkj->ICNO);
                // var_dump($m->icno);
                //$m->kategori_jawatan = $mkj->jawatan->job_category;
                $m->kumpulan_jawatan = $mkj->jawatan->job_group;
                if ($m->save(false)) {
                    var_dump("berjaya");
                } else {
                    var_dump("gagal");
                }
            }
        }
        die;
    }

    protected function findModel($id) {
        if (($model = TblPortfolio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function notification($title, $content, $ic = null) {
        if ($ic == null) {
            //default user login selalu guna ic   // null if the user not authenticated.    //get userid after login
            $ic = Yii::$app->user->getId();
        }
        $ntf = new Notification();
        $ntf->icno = $ic;
        $ntf->title = $title;
        $ntf->content = $content;
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
        return true;
    }
    

    public function actionContactInfo() {
        return $this->render('contact-info');
    }

    public function actionDeskripsiTugas($id) {
        //  $icno = Yii::$app->user->getId();
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->with('applicant')->one();

        $ikhtisas = TblIkhtisas::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatDimensi = TblDimensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $pengalaman = TblPengalaman::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatKompetensi = TblKompetensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $akauntabiliti = TblAkauntabiliti::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $syarat = TblSyaratTambahan::find()->where(['portfolio_id' => $deskripsi->id])->all();
        return $this->render('deskripsi-tugas', ['deskripsi' => $deskripsi, 'lihatDimensi' => $lihatDimensi, 'ikhtisas' => $ikhtisas, 'pengalaman' => $pengalaman, 'lihatKompetensi' => $lihatKompetensi
                    , 'akauntabiliti' => $akauntabiliti, 'syarat' => $syarat]);
    }

    public function actionDeskripsiTugasAdmin($id) {
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->with('applicant')->limit(1)->one();
        $ikhtisas = TblIkhtisas::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatDimensi = TblDimensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $pengalaman = TblPengalaman::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatKompetensi = TblKompetensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $akauntabiliti = TblAkauntabiliti::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $tugas = TblTugasUtama::find()->where(['akauntabiliti_id' => $id])->all();
        $syarat = TblSyaratTambahan::find()->where(['portfolio_id' => $deskripsi->id])->all();
        return $this->render('deskripsi-tugas-admin', compact('ikhtisas', 'deskripsi', 'pengalaman', 'lihatKompetensi', 'akauntabiliti', 'tugas', 'lihatDimensi', 'syarat'));
    }

    public function actionKemaskiniKompetensi($id, $portfolio_id) {
        $request = Yii::$app->request;
        //     $icno = Yii::$app->user->getId(); 
        $portfolio = TblPortfolio::find()->where(['id' => $portfolio_id])->one();
        $lihatKompetensi = TblKompetensi::find()->where(['id' => $id, 'portfolio_id' => $portfolio_id, 'icno' => $portfolio->icno])->one();

        if ($lihatKompetensi->load(Yii::$app->request->post())) {
            $TblKompetensi = $request->post()['TblKompetensi'];
            $kompetensi = $TblKompetensi['kompetensi'];
            $lihatKompetensi->kompetensi = $kompetensi;
            $lihatKompetensi->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Telah Dikemaskini']);


            return $this->redirect(['my-portfolio/lihat-kompetensi', 'id' => $portfolio->id]);
        }
        return $this->render('kemaskini-kompetensi', [
                    'lihatKompetensi' => $lihatKompetensi, 'portfolio' => $portfolio
        ]);
    }

    public function actionKemaskiniDimensi($id, $portfolio_id) {
        $request = Yii::$app->request;
        //    $icno = Yii::$app->user->getId(); 
        $portfolio = TblPortfolio::find()->where(['id' => $portfolio_id])->one();
        $lihatDimensi = TblDimensi::find()->where(['id' => $id, 'portfolio_id' => $portfolio_id, 'icno' => $portfolio->icno])->one();
        if ($lihatDimensi->load(Yii::$app->request->post())) {
            $TblDimensi = $request->post()['TblDimensi'];
            $dimensi = $TblDimensi['dimensi'];
            $dimensi_utama = $TblDimensi['dimensi_utama'];
            $lihatDimensi->dimensi = $dimensi;
            $lihatDimensi->dimensi_utama = $dimensi_utama;
            $lihatDimensi->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Telah Dikemaskini']);


            return $this->redirect(['my-portfolio/lihat-dimensi', 'id' => $portfolio->id]);
        }

        return $this->render('kemaskini-dimensi', ['lihatDimensi' => $lihatDimensi, 'portfolio' => $portfolio
        ]);
    }

    public function actionDeleteDimensi($id, $portfolio_id) {
        //   $icno = Yii::$app->user->getId(); 
        $portfolio = TblPortfolio::find()->where(['id' => $portfolio_id])->one();
        $lihatDimensi = TblDimensi::find()->where(['id' => $id, 'portfolio_id' => $portfolio->id, 'icno' => $portfolio->icno])->one();
        $lihatDimensi->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);

        return $this->redirect(['lihat-dimensi', 'id' => $portfolio->id]);
    }

    public function actionKemaskiniIkhtisas($id, $portfolio_id) {
        $request = Yii::$app->request;
        // $icno = Yii::$app->user->getId(); 
        $portfolio = TblPortfolio::find()->where(['id' => $portfolio_id])->one();
        $lihatIkhtisas = TblIkhtisas::find()->where(['id' => $id, 'portfolio_id' => $portfolio->id, 'icno' => $portfolio->icno])->one();

        if ($lihatIkhtisas->load(Yii::$app->request->post())) {
            $TblIkhtisas = $request->post()['TblIkhtisas'];
            $ikhtisas = $TblIkhtisas['ikhtisas'];
            $lihatIkhtisas->ikhtisas = $ikhtisas;
            $lihatIkhtisas->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Telah Dikemaskini']);


            return $this->redirect(['my-portfolio/lihat-kelayakan', 'id' => $portfolio->id]);
        }

        return $this->render('kemaskini-ikhtisas', ['lihatIkhtisas' => $lihatIkhtisas, 'portfolio' => $portfolio]);
    }

    public function actionDeleteIkhtisas($id, $portfolio_id) {
        //   $icno = Yii::$app->user->getId(); 
        $portfolio = TblPortfolio::find()->where(['id' => $portfolio_id])->one();
        $lihatIkhtisas = TblIkhtisas::find()->where(['id' => $id, 'portfolio_id' => $portfolio->id, 'icno' => $portfolio->icno])->one();
        $lihatIkhtisas->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);

        return $this->redirect(['lihat-kelayakan', 'id' => $portfolio->id]);
    }

    public function actionKemaskiniSyaratTambahan($id, $portfolio_id) {
        $request = Yii::$app->request;
        //  $icno = Yii::$app->user->getId(); 
        $portfolio = TblPortfolio::find()->where(['id' => $portfolio_id])->one();
        $lihatSyarat = TblSyaratTambahan::find()->where(['id' => $id, 'portfolio_id' => $portfolio_id, 'icno' => $portfolio->icno])->one();

        if ($lihatSyarat->load(Yii::$app->request->post())) {
            $TblSyaratTambahan = $request->post()['TblSyaratTambahan'];
            $ikhtisas = $TblSyaratTambahan['syarat_tambahan'];
            $lihatSyarat->syarat_tambahan = $ikhtisas;
            $lihatSyarat->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Telah Dikemaskini']);


            return $this->redirect(['my-portfolio/lihat-kelayakan', 'id' => $portfolio->id]);
        }

        return $this->render('kemaskini-syarat-tambahan', ['lihatSyarat' => $lihatSyarat, 'portfolio' => $portfolio]);
    }

    public function actionDeleteSyaratTambahan($id, $portfolio_id) {
        //  $icno = Yii::$app->user->getId(); 
        $portfolio = TblPortfolio::find()->where(['id' => $portfolio_id])->one();
        $lihatSyarat = TblSyaratTambahan::find()->where(['id' => $id, 'portfolio_id' => $portfolio->id, 'icno' => $portfolio->icno])->one();
        $lihatSyarat->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);

        return $this->redirect(['lihat-kelayakan', 'id' => $portfolio->id]);
    }

    public function actionKemaskiniAkauntabiliti($id, $portfolio_id) {
        $request = Yii::$app->request;
        //   $icno = Yii::$app->user->getId(); 
        $portfolio = TblPortfolio::find()->where(['id' => $portfolio_id])->one();
        $lihatAkauntabiliti = TblAkauntabiliti::find()->where(['id' => $id, 'portfolio_id' => $portfolio->id, 'icno' => $portfolio->icno])->one();

        if ($lihatAkauntabiliti->load(Yii::$app->request->post())) {
            $TblAkauntabiliti = $request->post()['TblAkauntabiliti'];
            $akauntabiliti = $TblAkauntabiliti['description'];
            $lihatAkauntabiliti->description = $akauntabiliti;
            //    $lihatAkauntabiliti->kata_kerja = implode(",",$lihatAkauntabiliti->kata_kerja);       
            $lihatAkauntabiliti->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);


            return $this->redirect(['my-portfolio/lihat-akauntabiliti', 'id' => $portfolio_id]);
        }

        return $this->render('kemaskini-akauntabiliti', ['lihatAkauntabiliti' => $lihatAkauntabiliti, 'portfolio' => $portfolio
        ]);
    }

    public function actionDeleteAkauntabiliti($id, $portfolio_id) {
        //  $icno = Yii::$app->user->getId(); 
        $portfolio = TblPortfolio::find()->where(['id' => $portfolio_id])->one();
        $lihatAkauntabiliti = TblAkauntabiliti::find()->where(['id' => $id])->one();
        $lihatAkauntabiliti->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);

        return $this->redirect(['lihat-akauntabiliti', 'id' => $portfolio->id]);
    }

    public function actionKemaskiniTugas($id, $portfolio_id, $akauntabiliti_id) {
        $request = Yii::$app->request;
        $lihatTugass = TblTugasUtama::find()->where(['id' => $id])->one();
        $akauntabilitiTitle = TblAkauntabiliti::find()->where(['id' => $akauntabiliti_id])->one();

        if ($lihatTugass->load(Yii::$app->request->post())) {

            $TblTugasUtama = $request->post()['TblTugasUtama'];
            $tugas = $TblTugasUtama['description'];
            $lihatTugass->description = $tugas;
            $lihatTugass->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);
            return $this->redirect(['my-portfolio/lihat-akauntabiliti', 'id' => $portfolio_id]);
        }

        return $this->render('kemaskini-tugas', ['akauntabilitiTitle' => $akauntabilitiTitle, 'lihatTugass' => $lihatTugass]);
    }

    public function actionDeleteTugas($id, $portfolio_id) {
        $lihatTugas = TblTugasUtama::find()->where(['id' => $id])->one();
        $lihatTugas->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);

        return $this->redirect(['lihat-akauntabiliti', 'id' => $portfolio_id]);
    }

    public function actionDeleteKompetensi($id, $portfolio_id) {
        //  $icno = Yii::$app->user->getId(); 
        //  $portfolio = TblPortfolio::find()->where(['icno' => $icno])->one();
        $lihatKompetensi = TblKompetensi::find()->where(['id' => $id, 'portfolio_id' => $portfolio_id])->one();
        $lihatKompetensi->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);

        return $this->redirect(['lihat-kompetensi', 'id' => $portfolio_id]);
    }

    public function actionMaklumatUmum() {
        $request = Yii::$app->request;
        $icno = Yii::$app->user->getId();
        $lpp = Lpp::find()->where(['PYD' => $icno])->orderBy(['lpp_id' => SORT_DESC])->one();
        $model = new TblPortfolio();

        if ($model->load($request->post())) {
            $model->icno = $icno;
            $model->name = Yii::$app->user->getIdentity()->CONm;
            $model->gred = Yii::$app->user->getIdentity()->gredJawatan;
            $model->jawatan = Yii::$app->user->getIdentity()->jawatan->nama;
            $model->status_jawatan = Yii::$app->user->getIdentity()->statusLantikan->ApmtStatusNm;
            $model->jabatan_semasa = Yii::$app->user->getIdentity()->department->id;
            $model->skim_perkhidmatan = Yii::$app->user->getIdentity()->jawatan->skimPerkhidmatan->name;
            //  $model->kp = Yii::$app->user->getIdentity()->rujukan->peraku->ICNO;
            $model->kp = $lpp->PPP;
            $model->kategori_jawatan = Yii::$app->user->getIdentity()->jawatan->job_category;
            $model->kumpulan_jawatan = Yii::$app->user->getIdentity()->jawatan->job_group;
            if (Yii::$app->user->getIdentity()->department->chief == $icno) {
                $model->kj = Yii::$app->user->getIdentity()->rujukan->pelulus->ICNO;
            } else {
                $model->kj = Yii::$app->user->getIdentity()->department->chief;
            }
            $model->created_at = date('d-m-Y');
            $model->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Telah Disimpan']);
            return $this->redirect(['view-maklumat-umum', 'id' => $model->id]);
        }

        return $this->render('maklumat-umum', ['model' => $model]);
    }

    public function actionViewMaklumatUmum($id) {
        $icno = Yii::$app->user->getId();
        $per = TblPortfolio::find()->joinWith('applicant')->where(['myjd_tbl_portfolio.icno' => $icno])->andWhere(['not in', 'DeptId', [158,2,4,159,35]])->exists();
  
        $display ='none';
        
       if ($per == false){
           $display= '';   
           $display2 = 'none'; 
        }
        else if($per == true){  
           $display = 'none';
            $display2 = ''; 
        }
   
        
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        return $this->render('view/view-maklumat-umum', ['deskripsi' => $deskripsi,'display' => $display, 'display2' => $display2
        ]);
    }

    public function actionKemaskiniMaklumatUmum($id) {
        // $icno = Yii::$app->user->getId();
        //  $tmp = TblPortfolio::find()->where(['icno' => $icno])->select(['tujuan'])->orderBy(['tujuan'=>SORT_DESC])->limit(1)->one();
        $request = Yii::$app->request;
        $model = TblPortfolio::find()->where(['id' => $id])->with('applicant')->one();
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();

        if ($model->load($request->post())) {
            $model->created_at = date('d-m-Y');
            //  $model->gred =  Yii::$app->user->getIdentity()->gredJawatan;
            //  $model->jawatan =  Yii::$app->user->getIdentity()->jawatan->nama;
            $model->status_jawatan = Yii::$app->user->getIdentity()->statusLantikan->ApmtStatusNm;
            //  $model->jabatan_semasa = Yii::$app->user->getIdentity()->department->id;
            $model->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Telah Dikemaskini']);
            return $this->redirect(['view-maklumat-umum', 'id' => $id]);
        }
        return $this->render('kemaskini-maklumat-umum', ['model' => $model, 'deskripsi' => $deskripsi]);
    }

    public function actionTambahTujuan($id) {
        //   $icno = Yii::$app->user->getId();
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        $model = TblPortfolio::findOne(['id' => $id]);
        $listdata = ArrayHelper::map(\app\models\myportfolio\RefAkauntabiliti::find()->all(), 'id', 'name');

        if ($model->icno != null) {

            if ($model->load(Yii::$app->request->post())) {
                $model->kata_kerja = implode(",", $model->kata_kerja);
                $model->save(false);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya disimpan']);
                return $this->redirect(['tujuan-jawatan', 'id' => $id]);
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Wajib Mengisi Maklumat Umum Terlebih Dahulu']);
            return $this->redirect(['maklumat-umum']);
        }
        return $this->render('tambah-tujuan', ['model' => $model, 'listdata' => $listdata, 'deskripsi' => $deskripsi]);
    }

    public function actionKemaskiniTujuan($id) {
        //     $icno = Yii::$app->user->getId();        
        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        $tambah = TblPortfolio::find()->where(['id' => $id])->orderBy(['id' => SORT_DESC])->one();
        $listdata = ArrayHelper::map(\app\models\myportfolio\RefAkauntabiliti::find()->all(), 'id', 'name');

        if ($tambah->load(Yii::$app->request->post())) {
            $tambah->kata_kerja = implode(",", $tambah->kata_kerja);
            $tambah->save(false);


            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya dikemaskini']);
            return $this->redirect(['tujuan-jawatan', 'id' => $deskripsi->id]);
        } else {
            $tambah->kata_kerja = explode(",", $tambah->kata_kerja);
        }


        return $this->render('kemaskini-tujuan', ['tambah' => $tambah, 'listdata' => $listdata, 'deskripsi' => $deskripsi]);
    }

    public function actionTujuanJawatan($id) {
        //   $icno = Yii::$app->user->getId();
        $deskripsi = Tblportfolio::find()->where(['id' => $id])->one();
        $lihat = TblPortfolio::find()->where(['id' => $id])->one();
        if (TblPortfolio::find()->where(['id' => $id])->exists()) {
            $display = '';
        } else {
            $display = 'none';
        }
        
        $icno = Yii::$app->user->getId();
        $per = TblPortfolio::find()->joinWith('applicant')->where(['myjd_tbl_portfolio.icno' => $icno])->andWhere(['not in', 'DeptId', [158,2,4,159,35]])->exists();
  
        $display ='none';
        
       if ($per == false){
           $display= '';   
           $display2 = 'none'; 
        }
        else if($per == true){  
           $display = 'none';
            $display2 = ''; 
        }
   
        
        
        return $this->render('tujuan-jawatan', ['lihat' => $lihat, 'display' => $display, 'deskripsi' => $deskripsi, 'display' => $display, 'display2' => $display2]);
    }

    public function actionDeletePengalaman($id, $portfolio_id) {
        //  $icno = Yii::$app->user->getId(); 
        $portfolio = TblPortfolio::find()->where(['id' => $portfolio_id])->one();
        $lihatPengalaman = TblPengalaman::find()->where(['id' => $id, 'portfolio_id' => $portfolio_id, 'icno' => $portfolio->icno])->one();
        $lihatPengalaman->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);

        return $this->redirect(['lihat-pengalaman', 'id' => $portfolio_id]);
    }

    public function actionKemaskiniPengalaman($id, $portfolio_id) {
        $request = Yii::$app->request;
        // $icno = Yii::$app->user->getId(); 
        $portfolio = Tblportfolio::find()->where(['id' => $portfolio_id])->one();
        $lihatPengalaman = TblPengalaman::find()->where(['id' => $id, 'portfolio_id' => $portfolio->id, 'icno' => $portfolio->icno])->one();

        if ($lihatPengalaman->load(Yii::$app->request->post())) {
            $TblPengalaman = $request->post()['TblPengalaman'];
            $p = $TblPengalaman['pengalaman'];
            $lihatPengalaman->pengalaman = $p;
            $lihatPengalaman->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Telah Dikemaskini']);


            return $this->redirect(['my-portfolio/lihat-pengalaman', 'id' => $portfolio_id]);
        }

        return $this->render('kemaskini-pengalaman', ['lihatPengalaman' => $lihatPengalaman, 'portfolio' => $portfolio]);
    }

    
    
    
    public function actionAkauntabiliti($id) {
    
         $deskripsi = Tblportfolio::find()->where(['id' => $id])->one();
         $modelPerson = Tblportfolio::find()->where(['id' => $id])->one();

         $modelmel = new TblAkauntabiliti();
         $modelsBarang = [new TblTugasUtama()];

      if ($deskripsi->icno != null) {

          if ($modelmel->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsBarang, 'id', 'id');
            $modelsBarang = Model::createMultiple(TblTugasUtama::classname(), $modelsBarang);
            Model::loadMultiple($modelsBarang, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsBarang, 'id', 'id')));

            $modelmel->icno = $modelPerson->icno;
            $modelmel->portfolio_id = $modelPerson->id;

            // validate all models
            $valid = $modelmel->validate();
            $valid = Model::validateMultiple($modelsBarang) && $valid;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
           Yii::$app->session->setFlash('alert', ['title' => 'Success', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
                    if ($flag = ($modelmel->save(false))) {
                       
                        if (!empty($deletedIDs)) {
                            TblTugasUtama::deleteAll(['id' => $deletedIDs]);
                        }

                        foreach ($modelsBarang as $i => $modelBarang) {

                           $modelBarang->akauntabiliti_id = $modelmel->id;
                           $modelBarang->icno = $modelmel->icno;
                                 
                            if (!($flag = $modelBarang->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
            
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['lihat-akauntabiliti', 'id' => $deskripsi->id]);
                    }

                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            } 
        }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Wajib Mengisi Maklumat Umum Terlebih Dahulu']);
            return $this->redirect(['maklumat-umum']);
        }

        return $this->render('_form', [
            'modelmel' => $modelmel,
            'modelsBarang'=> (empty($modelsBarang)) ? [new TblTugasUtama()] : $modelsBarang,
            'deskripsi' =>$deskripsi
        ]);
    }
    

    public function actionDimensi($id) {
        //  $icno = Yii::$app->user->getId(); 
        $portfolio = Tblportfolio::find()->where(['id' => $id])->one();
        $modelDimensi = [new TblDimensi];

        if ($portfolio->icno != null) {

            if (Yii::$app->request->post()) {

                $modelDimensi = Model::createMultiple(TblDimensi::className());
                Model::loadMultiple($modelDimensi, Yii::$app->request->post());

                // ajax validation
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ArrayHelper::merge(
                                    ActiveForm::validateMultiple($modelDimensi)
                    );
                }

                // validate all models
                //$valid = $modelCustomer->validate();
                $valid = Model::validateMultiple($modelDimensi);

                if ($valid) {

                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        $bio = Tblportfolio::find()->where(['id' => $id])->one();
                        $biodata = $bio->icno;

                        //if ($flag = $modelCustomer->save(false)) {
                        foreach ($modelDimensi as $dimensi) {
                            $dimensi->icno = $biodata;
                            $dimensi->portfolio_id = $portfolio->id;

                            if (!($flag = $dimensi->save(false))) {
                                $transaction->rollBack();
                                break;
                            }

                            $dimensi->save(false);
                        }

                        //}
                        if ($flag) {


                            $transaction->commit();

                            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Telah Disimpan']);


                            return $this->redirect(['lihat-dimensi', 'id' => $portfolio->id]);
                        }
                    } catch (Exception $e) {

                        $transaction->rollBack();
                    }
                }
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Wajib Mengisi Maklumat Umum Terlebih Dahulu']);
            return $this->redirect(['maklumat-umum']);
        }

        return $this->render('dimensi', ['modelDimensi' => (empty($modelDimensi)) ? [new TblDimensi] : $modelDimensi, 'portfolio' => $portfolio]);
    }

    public function actionLihatDimensi($id) {
        // $icno = Yii::$app->user->getId();
        $deskripsi = Tblportfolio::find()->where(['id' => $id])->one();
        $lihatDimensi = TblDimensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        if (Tblportfolio::find()->where(['id' => $id])->exists()) {
            $display3 = '';
        } else {
            $display3 = 'none';
        }
        
         $icno = Yii::$app->user->getId();
        $per = TblPortfolio::find()->joinWith('applicant')->where(['myjd_tbl_portfolio.icno' => $icno])->andWhere(['not in', 'DeptId', [158,2,4,159,35]])->exists();
  
        $display ='none';
        
       if ($per == false){
           $display= '';   
           $display2 = 'none'; 
        }
        else if($per == true){  
           $display = 'none';
            $display2 = ''; 
        }
        return $this->render('lihat-dimensi', ['deskripsi' => $deskripsi, 'lihatDimensi' => $lihatDimensi,
            'display' => $display, 'display2' => $display2, 'display3' => $display3]);
    }

    public function actionLihatKelayakan($id) {
        //   $icno = Yii::$app->user->getId();
        $deskripsi = Tblportfolio::find()->where(['id' => $id])->one();
        $ikhtisas = TblIkhtisas::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $syarat = TblSyaratTambahan::find()->where(['portfolio_id' => $deskripsi->id])->all();
        if (Tblportfolio::find()->where(['id' => $id])->exists()) {
            $display3 = '';
        } else {
            $display3 = 'none';
        }
             $icno = Yii::$app->user->getId();
        $per = TblPortfolio::find()->joinWith('applicant')->where(['myjd_tbl_portfolio.icno' => $icno])->andWhere(['not in', 'DeptId', [158,2,4,159,35]])->exists();
  
        $display ='none';
        
       if ($per == false){
           $display= '';   
           $display2 = 'none'; 
        }
        else if($per == true){  
           $display = 'none';
            $display2 = ''; 
        }
        return $this->render('lihat-kelayakan', ['deskripsi' => $deskripsi, 'ikhtisas' => $ikhtisas, 'syarat' => $syarat, 
            'display' => $display, 'display2' => $display2, 'display3' => $display3]);
    }

    public function actionLihatAkauntabiliti($id) {
        // $icno = Yii::$app->user->getId();  
        $deskripsi = Tblportfolio::find()->where(['id' => $id])->one();
        $akauntabiliti = TblAkauntabiliti::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $models = TblTugasUtama::find()->where(['akauntabiliti_id' => $akauntabiliti->id])->all();
        if (Tblportfolio::find()->where(['id' => $id])->exists()) {
            $display3 = '';
        } else {
            $display3 = 'none';
        }
        
        $icno = Yii::$app->user->getId();
        $per = TblPortfolio::find()->joinWith('applicant')->where(['myjd_tbl_portfolio.icno' => $icno])->andWhere(['not in', 'DeptId', [158,2,4,159,35]])->exists();
  
        $display ='none';
        
       if ($per == false){
           $display= '';   
           $display2 = 'none'; 
        }
        else if($per == true){  
           $display = 'none';
            $display2 = ''; 
        }
   
        
        
        return $this->render('lihat-akauntabiliti', ['deskripsi' => $deskripsi, 'akauntabiliti' => $akauntabiliti, ' models' => $models,
            'display3' => $display3, 'display' => $display, 'display2' => $display2
        ]);
    }

    public function actionKompetensi($id) {
        //   $icno = Yii::$app->user->getId(); 
        $modelKompetensi = [new TblKompetensi];
        $portfolio = Tblportfolio::find()->where(['id' => $id])->one();

        if ($portfolio->icno != null) {

            if (Yii::$app->request->post()) {


                $modelKompetensi = Model::createMultiple(TblKompetensi::className());
                Model::loadMultiple($modelKompetensi, Yii::$app->request->post());

                // ajax validation
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ArrayHelper::merge(
                                    ActiveForm::validateMultiple($modelKompetensi)
                    );
                }

                // validate all models
                //$valid = $modelCustomer->validate();
                $valid = Model::validateMultiple($modelKompetensi);

                if ($valid) {

                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        $bio = Tblportfolio::find()->where(['id' => $id])->one();
                        $biodata = $bio->icno;

                        //if ($flag = $modelCustomer->save(false)) {
                        foreach ($modelKompetensi as $kompetensi) {

                            $kompetensi->icno = $biodata;
                            $kompetensi->portfolio_id = $portfolio->id;

                            if (!($flag = $kompetensi->save(false))) {
                                $transaction->rollBack();
                                break;
                            }

                            $kompetensi->save(false);
                        }
                        //}
                        if ($flag) {


                            $transaction->commit();

                            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Telah disimpan']);


                            return $this->redirect(['my-portfolio/lihat-kompetensi', 'id' => $portfolio->id]);
                        }
                    } catch (Exception $e) {

                        $transaction->rollBack();
                    }
                }
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Wajib Mengisi Maklumat Umum Terlebih Dahulu']);
            return $this->redirect(['maklumat-umum']);
        }


        return $this->render('kompetensi', [
                    'modelKompetensi' => (empty($modelKompetensi)) ? [new TblKompetensi] : $modelKompetensi, 'portfolio' => $portfolio]);
    }

    public function actionPengalaman($id) {
        //  $icno = Yii::$app->user->getId(); 
        $modelPengalaman = [new TblPengalaman];

        $portfolio = Tblportfolio::find()->where(['id' => $id])->one();

        if ($portfolio->icno != null) {
            if (Yii::$app->request->post()) {
                $modelPengalaman = Model::createMultiple(TblPengalaman::className());
                Model::loadMultiple($modelPengalaman, Yii::$app->request->post());

                // ajax validation
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ArrayHelper::merge(
                                    ActiveForm::validateMultiple($modelPengalaman)
                    );
                }

                // validate all models
                //$valid = $modelCustomer->validate();
                $valid = Model::validateMultiple($modelPengalaman);

                if ($valid) {

                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        $bio = Tblportfolio::find()->where(['id' => $id])->one();
                        $biodata = $bio->icno;

                        //if ($flag = $modelCustomer->save(false)) {
                        foreach ($modelPengalaman as $pengalaman) {
                            $pengalaman->icno = $biodata;
                            $pengalaman->portfolio_id = $portfolio->id;

                            if (!($flag = $pengalaman->save(false))) {
                                $transaction->rollBack();
                                break;
                            }

                            $pengalaman->save(false);
                        }

                        //}
                        if ($flag) {


                            $transaction->commit();

                            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Telah Disimpan']);


                            return $this->redirect(['lihat-pengalaman', 'id' => $portfolio->id]);
                        }
                    } catch (Exception $e) {

                        $transaction->rollBack();
                    }
                }
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Wajib Mengisi Maklumat Umum Terlebih Dahulu']);
            return $this->redirect(['maklumat-umum']);
        }
        return $this->render('pengalaman', ['modelPengalaman' => (empty($modelPengalaman)) ? [new TblPengalaman] : $modelPengalaman, 'portfolio' => $portfolio]);
    }

    public function actionKelayakan($id) {

        //  $icno = Yii::$app->user->getId(); 

        $modelKelayakan = [new TblIkhtisas];

        $portfolio = Tblportfolio::find()->where(['id' => $id])->one();

        if ($portfolio->icno != null) {

            if (Yii::$app->request->post()) {


                $modelKelayakan = Model::createMultiple(TblIkhtisas::className());
                Model::loadMultiple($modelKelayakan, Yii::$app->request->post());

                // ajax validation
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ArrayHelper::merge(
                                    ActiveForm::validateMultiple($modelKelayakan)
                    );
                }

                // validate all models
                //$valid = $modelCustomer->validate();
                $valid = Model::validateMultiple($modelKelayakan);

                if ($valid) {

                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        $bio = Tblportfolio::find()->where(['id' => $id])->one();
                        $biodata = $bio->icno;

                        //if ($flag = $modelCustomer->save(false)) {
                        foreach ($modelKelayakan as $kelayakan) {

                            $kelayakan->icno = $biodata;
                            $kelayakan->portfolio_id = $portfolio->id;

                            if (!($flag = $kelayakan->save(false))) {
                                $transaction->rollBack();
                                break;
                            }

                            $kelayakan->save(false);
                        }

                        if ($flag) {


                            $transaction->commit();

                            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod Telah disimpan']);


                            return $this->redirect(['my-portfolio/lihat-kelayakan', 'id' => $portfolio->id]);
                        }
                    } catch (Exception $e) {

                        $transaction->rollBack();
                    }
                }
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Wajib Mengisi Maklumat Umum Terlebih Dahulu']);
            return $this->redirect(['maklumat-umum']);
        }

        return $this->render('kelayakan', ['modelKelayakan' => (empty($modelKelayakan)) ? [new TblIkhtisas] : $modelKelayakan, 'portfolio' => $portfolio]);
    }

    public function actionLihatKompetensi($id) {
        // $icno = Yii::$app->user->getId();
        $deskripsi = Tblportfolio::find()->where(['id' => $id])->one();
        $lihatKompetensi = TblKompetensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        if (Tblportfolio::find()->where(['id' => $id])->exists()) {
            $display3 = '';
        } else {
            $display3 = 'none';
        }
                 $icno = Yii::$app->user->getId();
        $per = TblPortfolio::find()->joinWith('applicant')->where(['myjd_tbl_portfolio.icno' => $icno])->andWhere(['not in', 'DeptId', [158,2,4,159,35]])->exists();
  
        $display ='none';
        
       if ($per == false){
           $display= '';   
           $display2 = 'none'; 
        }
        else if($per == true){  
           $display = 'none';
            $display2 = ''; 
        }
        return $this->render('lihat-kompetensi', ['deskripsi' => $deskripsi, 'lihatKompetensi' => $lihatKompetensi, 'display' => $display, 'display2' => $display2, 'display3' => $display3]);
    }

    public function actionLihatPengalaman($id) {
        //  $icno = Yii::$app->user->getId();
        $deskripsi = Tblportfolio::find()->where(['id' => $id])->one();
        $pengalaman = TblPengalaman::find()->where(['portfolio_id' => $deskripsi->id])->all();
        if (Tblportfolio::find()->where(['id' => $id])->exists()) {
            $display3 = '';
        } else {
            $display3 = 'none';
        }
                        $icno = Yii::$app->user->getId();
        $per = TblPortfolio::find()->joinWith('applicant')->where(['myjd_tbl_portfolio.icno' => $icno])->andWhere(['not in', 'DeptId', [158,2,4,159,35]])->exists();
  
        $display ='none';
        
       if ($per == false){
           $display= '';   
           $display2 = 'none'; 
        }
        else if($per == true){  
           $display = 'none';
            $display2 = ''; 
        }
        return $this->render('lihat-pengalaman', ['deskripsi' => $deskripsi, 'pengalaman' => $pengalaman, 
            'display' => $display,'display2' => $display2, 'display3' => $display3]);
    }

    public function actionLogHistory() {
        $icno = Yii::$app->user->getId();
        $query = TblLog::find()->where(['icno' => $icno]);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
        ]);
        return $this->render('log-history', ['provider' => $provider]);
    }

    public function actionKeteranganLog($id) {
        $model = TblLog::find()->where(['id' => $id])->one();
        return $this->renderAjax('keterangan-log', compact('model'));
    }

    public function actionCarianBsm() {
        $permohonan = $this->SenaraiRekodJd();
        $search = new TblPortfolio();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-bsm', 'icno' => $search->icno, 'jabatan_semasa' => $search->jabatan_semasa, 'gred' => $search->gred]);
        }

        return $this->render('carian-bsm', [
                    'permohonan' => $permohonan,
                    'search' => $search,
        ]);
    }

    public function SenaraiRekodJd() {
      
        $data = new ActiveDataProvider([
            'query' => Tblportfolio::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function GridCarianBsm($icno, $jabatan_semasa, $gred) {
    //    $biodata = Tblprcobiodata::find()->where(['ICNO' => $icno])->orWhere(['DeptId' => $jabatan_semasa])->one();
        $data = new ActiveDataProvider([
            'query' => Tblportfolio::find()->where(['icno' => $icno])->andWhere(['jabatan_semasa' => $jabatan_semasa])->andWhere(['gred' => $gred]),
            // $query = Tblportfolio::find()->where(['icno' => $icno])->orWhere(['jabatan_semasa' => $jabatan_semasa->DeptId])->orWhere(['gred' => $gred])->with('biodata');

            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionCarianPermohonanBsm($icno, $jabatan_semasa, $gred) {
        $permohonan = $this->GridCarianPermohonan($icno, $jabatan_semasa, $gred);
        $search = new TblPortfolio();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-bsm', 'icno' => $search->icno, 'jabatan_semasa' => $search->$jabatan_semasa, 'gred' => $search->gred]);
        }

        return $this->render('carian-bsm', [
                    'permohonan' => $permohonan,
                    'search' => $search,
        ]);
    }

//    public function GridCarianPermohonan($icno, $jabatan_semasa, $gred) {
//
////        var_dump($icno, $jabatan_semasa, $gred);die;
//        if ($icno == "" ) {
////            var_dump('d');die;
//
//            $sql = 'SELECT a.* FROM hrm.`myjd_tbl_portfolio` a 
//JOIN hronline.`tblprcobiodata` b ON b.`ICNO` = a.`icno`
//WHERE b.`DeptId` = :dept';
//
//            $query = TblPortfolio::findBySql($sql, [':dept' => $jabatan_semasa]);
//        }else{
//                    $query = Tblportfolio::find()->where(['icno' => $icno])->orWhere(['jabatan_semasa' => $jabatan_semasa])->orWhere(['gred' => $gred]);
//
//        }
//
//        $data = new ActiveDataProvider([
//            'query' => $query,
//            'pagination' => [
//                'pageSize' => 10,
//            ],
//        ]);
//        return $data;
//    }
    
        public function GridCarianPermohonan($icno, $jabatan_semasa, $gred) {

      $query = Tblportfolio::find()->where(['icno' => $icno])->orWhere(['jabatan_semasa' => $jabatan_semasa])->orWhere(['gred' => $gred]);

        $data = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionKemaskiniKetua() {
        $query = Tblportfolio::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20
            ],]);
        return $this->render('kemaskini-ketua', ['provider' => $provider]);
    }

    public function actionKemaskiniDataPensetuju() {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $model = Tblportfolio::find()->where(['id' => $id])->one();
        $pegawai = ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
        if ($request->post()) {
            $model->kp = $request->post()['TblPortfolio']['kp'];
            if ($model->save(false)) {
                //    $this->notification('MYJD', "Semakan Deskripsi Tugas kakitangan selian untuk tindakan pihak tuan. ", $model->kp);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Ketua Perkhidmatan berjaya dikemaskini']);
                return $this->redirect(['my-portfolio/carian-ketua']);
            }
        }

        return $this->render('kemaskini-data-pensetuju', compact('model', 'pensetuju', 'new', 'pegawai'));
    }

    public function actionKemaskiniDataPeraku() {
        $request = Yii::$app->request;
        $id = $request->get('id');
        $model = Tblportfolio::find()->where(['id' => $id])->one();
        $pegawai = ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');

        #jika peraku telah dibuat
        if (!is_null($model->kj_agree)) {
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Perubahan Ketua Jabatan tidak dibenarkan kerana perakuan telah dibuat!']);
            return $this->redirect(['my-portfolio/carian-ketua']);
        }

        if ($request->post()) {
            $model->kj = $request->post()['TblPortfolio']['kj'];
            if ($model->save(false)) {
                //      $this->notification('MYJD', "Semakan Deskripsi Tugas kakitangan selian untuk tindakan pihak tuan. ", $model->kj);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Ketua Jabatan berjaya dikemaskini']);
                return $this->redirect(['my-portfolio/carian-ketua']);
            }
        }

        return $this->render('kemaskini-data-peraku', compact('model', 'peraku', 'new', 'pegawai'));
    }

    public function actionHalamanKj() {
        $permohonan = $this->GridSenaraiKj();
        return $this->render('halaman-kj', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function GridSenaraiKj() {
     $icno = Yii::$app->user->getId();
       $staf_jabatan = Tblprcobiodata::find()->select('ICNO')->where(['DeptId'=>Yii::$app->user->identity->DeptId])->all();
        $array_icno = [];
        foreach ($staf_jabatan as $staf_jabatan){
            array_push($array_icno, $staf_jabatan->ICNO);
        }

        $data = new ActiveDataProvider([
            'query' => Tblportfolio::find()->where(['in','icno',$array_icno])->andWhere(['kj' => $icno])->andWhere(['status_hantar' => 1]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function actionHalamanKp() {
        $permohonan = $this->GridSenaraiKp();
        return $this->render('halaman-kp', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function GridSenaraiKp() {
       $icno = Yii::$app->user->getId();
       $staf_jabatan = Tblprcobiodata::find()->select('ICNO')->where(['DeptId'=>Yii::$app->user->identity->DeptId])->all();
        $array_icno = [];
        foreach ($staf_jabatan as $staf_jabatan){
            array_push($array_icno, $staf_jabatan->ICNO);
        }

        $data = new ActiveDataProvider([
            'query' => Tblportfolio::find()->where(['in','icno',$array_icno])->andWhere(['kp' => $icno])->andWhere(['status_hantar' => 1]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function actionHalamanPpp() {
        $permohonan = $this->GridSenaraiPPP();
        return $this->render('halaman-ppp', [
                    'permohonan' => $permohonan,
        ]);
    }

    public function GridSenaraiPPP() {
        //  $icno = Yii::$app->user->getId();
        $data = new ActiveDataProvider([
            'query' => Tblportfolio::find()->where(['jabatan_semasa' => 181]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function actionSahkanKj($id) {

        $model = TblPortfolio::find()->where(['id' => $id])->one();

        if ($model->kp != null) {
            if ($model->kp_agree == null) {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => '', 'msg' => 'Menunggu Perakuan PP terlebih dahulu']);
                return $this->redirect(['my-portfolio/halaman-kj', 'id' => $model->id]);
            }
        }

        if ($model->load(Yii::$app->request->post())) {
            $request = Yii::$app->request;
            $model->perakuan_kj = $request->post()['TblPortfolio']['perakuan_kj'];
            $model->tarikh_perakuan_kj = date('Y-m-d H:i:s');
            $model->save(false);


            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumbalas telah selesai']);

            if ($model->kj_agree == 2) {
                $this->notification('MYJD', 'Deskripsi Tugas' . "$model->name" . '&nbsp' . "tidak Diluluskan oleh Ketua Jabatan." . Html::a('Klik Sini', ['my-portfolio/halaman-kp'], ['class' => 'btn btn-primary btn-sm']), $model->kp);
                //  $this->notification('MYJD', "Deskripsi Tugas Tidak Diluluskan oleh Ketua Jabatan.", $model->kp);
            }if ($model->kj_agree == 1) {
                $this->notification('MYJD', "Deskripsi Tugas Telah Diluluskan oleh Ketua Jabatan", $model->icno);
            }


            return $this->redirect(['my-portfolio/halaman-kj', 'id' => $model->id]);
        }
        return $this->render('sahkan-kj', [
                    'model' => $model,
        ]);
    }

    public function actionSahkanKp($id) {

        $model = TblPortfolio::find()->where(['id' => $id])->one();
        if ($model->load(Yii::$app->request->post())) {
            $request = Yii::$app->request;
            $model->perakuan_kp = $request->post()['TblPortfolio']['perakuan_kp'];
            $model->tarikh_perakuan_kp = date('Y-m-d H:i:s');
            $model->save(false);

            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Maklumbalas telah selesai']);

            if ($model->kp_agree == 2) {
                $kakitangan = TblPortfolio::find()->where(['id' => $id])->one();
                $kakitangan->status_hantar = null;
                $kakitangan->save(false);
                $this->notification('MYJD', "Deskripsi Tugas Tidak Diperakukan oleh Ketua Perkhidmatan. Sila perbaiki deskripsi tugas anda", $model->icno);
            }if ($model->kp_agree == 1) {
                $this->notification('MYJD', "Deskripsi Tugas Telah Diperakukan oleh Ketua Perkhidmatan ", $model->icno);
                //  $this->notification('MYJD', "Semakan Deskripsi Tugas kakitangan selian untuk tindakan pihak tuan", $model->kj);
                $this->notification('MYJD', 'Semakan Deskripsi Tugas' . "$model->name" . '&nbsp' . "untuk tindakan pihak tuan/puan." . Html::a('Klik Sini', ['my-portfolio/halaman-kj'], ['class' => 'btn btn-primary btn-sm']), $model->kj);
            }

            return $this->redirect(['my-portfolio/halaman-kp', 'id' => $model->id]);
        }
        return $this->render('sahkan-kp', [
                    'model' => $model, 'kakitangan' => $kakitangan
        ]);
    }

    public function actionIndex($id) {
        //   $icno = Yii::$app->user->getId();
        $deskripsi = Tblportfolio::find()->where(['id' => $id])->one();
        $model = TblPortfolio::find()->where(['id' => $id])->one();
        return $this->render('index', [
                    'model' => $model, 'deskripsi' => $deskripsi
        ]);
    }

    public function actionPengesahan($id) {
        //  $icno = Yii::$app->user->getId();
        $model = TblPortfolio::find()->where(['id' => $id])->one();
        $request = Yii::$app->request;
        $deskripsi = Tblportfolio::find()->where(['id' => $id])->one();
        $mod = TblPortfolio::find()->where(['id' => $id, 'status_hantar' => 1])->exists();
        $displaymohon = 'none';

        if ($mod) {
            $displaymohon = 'none';
        } elseif (!$mod) {
            $displaymohon = '';
        }


        if ($model->load($request->post())) {
            $model->status_hantar = 1;
            $model->tarikh_hantar = date('Y-m-d H:i:s');
            $model->created_at = date('d-m-Y');
            $model->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dihantar']);

            if ($model->kp != null) {
                $this->notification('MYJD', 'Semakan Deskripsi Tugas ' . "$model->name" . '&nbsp' . "untuk tindakan pihak tuan/puan." . Html::a('Klik Sini', ['my-portfolio/halaman-kp'], ['class' => 'btn btn-primary btn-sm']), $model->kp);
            } else {
                $this->notification('MYJD', 'Semakan Deskripsi Tugas ' . "$model->name" . '&nbsp' . "untuk tindakan pihak tuan/puan." . Html::a('Klik Sini', ['my-portfolio/halaman-kj'], ['class' => 'btn btn-primary btn-sm']), $model->kj);
            }

            $this->notification('MYJD', "Deskripsi Tugas tuan/puan berjaya dihantar ", $model->icno);
            return $this->redirect(['/my-portfolio/index', 'id' => $deskripsi->id]);
        }
        return $this->render('pengesahan', [
                    'model' => $model, 'mod' => $mod, 'displaymohon' => $displaymohon, 'deskripsi' => $deskripsi
        ]);
    }

    public function actionTambahSyarat($id) {
        $request = Yii::$app->request;
        // $icno = Yii::$app->user->getId();
        $model = TblPortfolio::findOne(['id' => $id]);
        $syarat = new TblSyaratTambahan();

        if ($model->icno != null) {
            if ($syarat->load(Yii::$app->request->post())) {

                $syarat->portfolio_id = $model->id;
                $syarat->icno = $model->icno;
                $syarat->datetime = date('Y-m-d H:i:s');
                $TblSyaratTambahan = $request->post()['TblSyaratTambahan'];
                $a = $TblSyaratTambahan['syarat_tambahan'];
                $syarat->syarat_tambahan = $a;
                $syarat->save(false);

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Rekod berjaya disimpan']);
                return $this->redirect(['lihat-kelayakan', 'id' => $id]);
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'error', 'msg' => 'Wajib Mengisi Maklumat Umum Terlebih Dahulu']);
            return $this->redirect(['maklumat-umum']);
        }
        return $this->render('tambah-syarat', ['model' => $model, 'syarat' => $syarat]);
    }

    public function actionTambahTugasUtama($id) {
        $icno = Yii::$app->user->getId();
        $akauntabilitiTitle = TblAkauntabiliti::find()->where(['id' => $id])->one();
        $lihatTugass = new TblTugasUtama();

        if ($lihatTugass->load(Yii::$app->request->post())) {

            $lihatTugass->icno = $icno;
            $lihatTugass->akauntabiliti_id = $id;
            $lihatTugass->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah']);
            return $this->redirect(['my-portfolio/lihat-akauntabiliti', 'id' => $akauntabilitiTitle->portfolio_id]);
        }

        return $this->render('tambah-tugas-utama', ['akauntabilitiTitle' => $akauntabilitiTitle, 'lihatTugass' => $lihatTugass]);
    }

    public function actionGenerateLetterAdmin($id) {

        $deskripsi = TblPortfolio::find()->where(['id' => $id])->one();
        $ikhtisas = TblIkhtisas::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatDimensi = TblDimensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $pengalaman = TblPengalaman::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatKompetensi = TblKompetensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $akauntabiliti = TblAkauntabiliti::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $tugas = TblTugasUtama::find()->where(['akauntabiliti_id' => $id])->all();
        $syarat = TblSyaratTambahan::find()->where(['portfolio_id' => $deskripsi->id])->all();
        // get your HTML raw content without any layouts or scripts

        $content = $this->renderPartial('cetak-deskripsi-tugas-admin', ['deskripsi' => $deskripsi, 'ikhtisas' => $ikhtisas, 'lihatDimensi' => $lihatDimensi, 'pengalaman' => $pengalaman, 'lihatKompetensi' => $lihatKompetensi, 'akauntabiliti' => $akauntabiliti, 'syarat' => $syarat, 'tugas' => $tugas]);


        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
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
            'options' => ['title' => 'Isytihar Harta'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => [''],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionGenerateLetter($id) {
        //   $icno = Yii::$app->user->getId();
        $deskripsi = TblPortfolio::findOne(['id' => $id]);
        $ikhtisas = TblIkhtisas::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatDimensi = TblDimensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $pengalaman = TblPengalaman::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatKompetensi = TblKompetensi::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $lihatSyarat = TblSyaratTambahan::find()->where(['portfolio_id' => $deskripsi->id])->all();
        $akauntabiliti = TblAkauntabiliti::find()->where(['portfolio_id' => $deskripsi->id])->all();
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('cetak-deskripsi-tugas', ['deskripsi' => $deskripsi, 'ikhtisas' => $ikhtisas, 'lihatDimensi' => $lihatDimensi, 'pengalaman' => $pengalaman, 'lihatKompetensi' => $lihatKompetensi, 'akauntabiliti' => $akauntabiliti, 'lihatSyarat' => $lihatSyarat]);


        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
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
            'options' => ['title' => 'Isytihar Harta'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => [''],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionCarianKetua() {
        $permohonan = $this->SenaraiRekodKetua();
        $search = new \app\models\hronline\Tblprcobiodata();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-ketua', 'ICNO' => $search->ICNO, 'DeptId' => $search->DeptId]);
        }

        return $this->render('carian-ketua', [
                    'permohonan' => $permohonan,
                    'search' => $search,
        ]);
    }

    public function SenaraiRekodKetua() {
        $data = new ActiveDataProvider([
            'query' => Tblportfolio::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $data;
    }

    public function GridCarianKetua($icno, $jabatan_semasa) {
        $data = new ActiveDataProvider([
            'query' => Tblportfolio::find()->where(['icno' => $icno])->andWhere(['jabatan_semasa' => $jabatan_semasa]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionCarianPermohonanKetua($ICNO, $DeptId) {
        $permohonan = $this->GridCarianPermohonanKetua($ICNO, $DeptId);
        $search = new \app\models\hronline\Tblprcobiodata();

        if ($search->load(Yii::$app->request->post())) {
            return $this->redirect(['carian-permohonan-ketua', 'ICNO' => $search->ICNO, 'DeptId' => $search->DeptId]);
        }

        return $this->render('carian-ketua', [
                    'permohonan' => $permohonan,
                    'search' => $search,
                    'ICNO' => $ICNO,
                    'DeptId' => $DeptId
        ]);
    }

    public function GridCarianPermohonanKetua($icno, $jabatan_semasa) {
        $data = new ActiveDataProvider([
            'query' => Tblportfolio::find()->where(['icno' => $icno])->orWhere(['jabatan_semasa' => $jabatan_semasa]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $data;
    }

    public function actionKemaskiniPpIndividu($id) {
        $request = Yii::$app->request;
        // $id = $request->get('id');
        $model = TblPortfolio::find()->where(['id' => $id])->one();
        $pegawai = ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
        if ($request->post()) {
            $model->kp = $request->post()['TblPortfolio']['kp'];
            if ($model->save(false)) {
                //    $this->notification('MYJD', "Semakan Deskripsi Tugas kakitangan selian untuk tindakan pihak tuan. ", $model->kp);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'PP berjaya dikemaskini']);
                return $this->redirect(['view-maklumat-umum', 'id' => $id]);
            }
        }

        return $this->render('kemaskini-pp-individu', compact('model', 'pensetuju', 'new', 'pegawai'));
    }

    public function actionKemaskiniKjIndividu($id) {
        $request = Yii::$app->request;
        //  $id = $request->get('id');
        $model = TblPortfolio::find()->where(['id' => $id])->one();
        $pegawai = ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');


        if ($request->post()) {
            $model->kj = $request->post()['TblPortfolio']['kj'];
            if ($model->save(false)) {
                //      $this->notification('MYJD', "Semakan Deskripsi Tugas kakitangan selian untuk tindakan pihak tuan. ", $model->kj);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Ketua Jabatan berjaya dikemaskini']);
                return $this->redirect(['view-maklumat-umum', 'id' => $id]);
            }
        }

        return $this->render('kemaskini-kj-individu', compact('model', 'peraku', 'new', 'pegawai'));
    }

    public function actionBorangNaziran($id) {
        $ic = Yii::$app->user->getId();
        $model = TblPortfolio::find()->where(['id' => $id])->one();
        $lantikan = \app\models\hronline\Tblrscoapmtstatus::find()->where(['ICNO' => $model->icno])->all();
        $kontrak = Kontrak::find()->where(['icno' => $model->icno])->one();
        $anugerah = \app\models\hronline\Tblanugerah::findAll(['ICNO' => $model->icno]);
        $latihan = \app\models\hronline\Vcpdlatihan::findAll(['vcl_id_staf' => $model->icno]);
        $pegawai = ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
        $tahapLnpt = ArrayHelper::map(\app\models\myportfolio\RefLnpt::find()->all(), 'id', 'tahap_lnpt');
        $tahapTugas = ArrayHelper::map(\app\models\myportfolio\RefTugasHakiki::find()->all(), 'id', 'tahap_tugas');
        $tahapKehadiran = ArrayHelper::map(\app\models\myportfolio\RefKehadiran::find()->all(), 'id', 'tahap_kehadiran');
        $tahapProduktiviti = ArrayHelper::map(\app\models\myportfolio\RefProduktiviti::find()->all(), 'id', 'tahap_produktiviti');
        $lpp = \app\models\lppums\Lpp::findAll(['PYD' => $model->icno]);
        $naziran = new \app\models\myportfolio\TblNaziran();

        if ($lantikan) {
            $countlantikan = count($lantikan);
        }

        if ($naziran->load(Yii::$app->request->post())) {
            $naziran->icno = $model->icno;
            $naziran->portfolio_id = $model->id;
            $naziran->icno_naziran = $ic;
            $naziran->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);

            return $this->redirect(['my-portfolio/carian-bsm']);
        }


        return $this->render('borang-naziran', [
                    'model' => $model,
                    'lantikan' => $lantikan,
                    'latihan' => $latihan,
                    'anugerah' => $anugerah,
                    'lpp' => $lpp,
                    'kontrak' => $kontrak,
                    'countlantikan' => $countlantikan,
                    'pegawai' => $pegawai,
                    'naziran' => $naziran,
                    'tahapLnpt' => $tahapLnpt,
                    'tahapKehadiran' => $tahapKehadiran,
                    'tahapProduktiviti' => $tahapProduktiviti,
                    'tahapTugas' => $tahapTugas
        ]);
    }

    public function actionKemaskiniBorangNaziran($id) {
        $model = TblPortfolio::find()->where(['id' => $id])->one();
        $lantikan = \app\models\hronline\Tblrscoapmtstatus::find()->where(['ICNO' => $model->icno])->all();
        $kontrak = Kontrak::find()->where(['icno' => $model->icno])->one();
        $anugerah = \app\models\hronline\Tblanugerah::findAll(['ICNO' => $model->icno]);
        $latihan = \app\models\hronline\Vcpdlatihan::findAll(['vcl_id_staf' => $model->icno]);
        $pegawai = ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
        $tahapLnpt = ArrayHelper::map(\app\models\myportfolio\RefLnpt::find()->all(), 'id', 'tahap_lnpt');
        $tahapTugas = ArrayHelper::map(\app\models\myportfolio\RefTugasHakiki::find()->all(), 'id', 'tahap_tugas');
        $tahapKehadiran = ArrayHelper::map(\app\models\myportfolio\RefKehadiran::find()->all(), 'id', 'tahap_kehadiran');
        $tahapProduktiviti = ArrayHelper::map(\app\models\myportfolio\RefProduktiviti::find()->all(), 'id', 'tahap_produktiviti');
        $lpp = \app\models\lppums\Lpp::findAll(['PYD' => $model->icno]);
        $naziran = \app\models\myportfolio\TblNaziran::find()->where(['icno' => $model->icno])->orderBy(['id' => SORT_DESC])->one();

        if ($lantikan) {
            $countlantikan = count($lantikan);
        }

        if ($naziran->load(Yii::$app->request->post())) {
            $naziran->icno_naziran = Yii::$app->user->getId();
            $naziran->save(false);
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dikemaskini']);

            return $this->redirect(['my-portfolio/carian-bsm']);
        }


        return $this->render('kemaskini-borang-naziran', [
                    'model' => $model,
                    'lantikan' => $lantikan,
                    'latihan' => $latihan,
                    'anugerah' => $anugerah,
                    'lpp' => $lpp,
                    'kontrak' => $kontrak,
                    'countlantikan' => $countlantikan,
                    'pegawai' => $pegawai,
                    'naziran' => $naziran,
                    'tahapLnpt' => $tahapLnpt,
                    'tahapKehadiran' => $tahapKehadiran,
                    'tahapProduktiviti' => $tahapProduktiviti,
                    'tahapTugas' => $tahapTugas
        ]);
    }

    public function actionSenaraiMyjd() {
        $icno = Yii::$app->user->getId();
        $models = TblPortfolio::find()->where(['icno' => $icno])->all();

        return $this->render('senarai-myjd', [
                    'models' => $models
        ]);
    }

    public function actionDeletePortfolio($id) {
        //   $icno = Yii::$app->user->getId(); 
        $portfolio = TblPortfolio::find()->where(['id' => $id])->one();
        $portfolio->delete();
        Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Rekod Berjaya Dipadam']);

        return $this->redirect(['senarai-myjd']);
    }
    
    
    
      public function actionAdminViewMyjd($DeptId = null, $gredJawatan = null, $ICNO = null, $status_hantar = NULL)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tblprcobiodata::find()->where(['tblprcobiodata.Status' => 1])
                    ->with('myjd'),
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
        
        if (isset(Yii::$app->request->queryParams['status_hantar'])) {
            $gredJawatan ? $dataProvider->query->andFilterWhere(['status_hantar' => $status_hantar]) : '';
        }

        return $this->render('admin-view-myjd', [
            'DeptId' => $DeptId,
            'gredJawatan' => $gredJawatan,
            'ICNO' => $ICNO,
            'dataProvider' => $dataProvider,
            'status_hantar' => $status_hantar
        ]);
    }
    
    
    
         public function actionViewMyjd($DeptId = null, $gredJawatan = null, $ICNO = null, $status_hantar = NULL)
    {
        $icno = Yii::$app->user->getId();
        $penyelia = \app\models\myportfolio\AksesPenyelia::find()->where(['akses_icno' => $icno])->one();
        $dataProvider = new ActiveDataProvider([
            'query' => Tblprcobiodata::find()->where(['Status' => 1])
                     ->andWhere(['DeptId' => $penyelia->penyeliaBiodata->DeptId])
                     ->with('myjd')->with('myjdPenyelia'),
            'pagination' => [
                'pageSize' => 20,
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
        
        if (isset(Yii::$app->request->queryParams['status_hantar'])) {
            $gredJawatan ? $dataProvider->query->andFilterWhere(['status_hantar' => $status_hantar]) : '';
        }

        return $this->render('view-myjd', [
            'DeptId' => $DeptId,
            'gredJawatan' => $gredJawatan,
            'ICNO' => $ICNO,
            'dataProvider' => $dataProvider,
            'status_hantar' => $status_hantar
        ]);
    }
    
    
      public function actionKemaskiniDataPpp($id, $page = null) {
        $request = Yii::$app->request;
        $model = Tblportfolio::find()->where(['id' => $id])->one();
        $pegawai = ArrayHelper::map(Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm');
        if ($request->post()) {
            $model->kp = $request->post()['TblPortfolio']['kp'];
            if ($model->save(false)) {
                //    $this->notification('MYJD', "Semakan Deskripsi Tugas kakitangan selian untuk tindakan pihak tuan. ", $model->kp);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dikemaskini']);
                return $this->redirect(['my-portfolio/view-myjd', 'page' => $page]);
                
            }
        }

        return $this->render('kemaskini-data-ppp', compact('model', 'pensetuju', 'new', 'pegawai'));
    }

    public function actionKemaskiniDataPpk($id, $page = null) {
        $request = Yii::$app->request;
        $model = Tblportfolio::find()->where(['id' => $id])->one();
        $pegawai = ArrayHelper::map(Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm');

 
        if ($request->post()) {
            $model->kj = $request->post()['TblPortfolio']['kj'];
            if ($model->save(false)) {
                //      $this->notification('MYJD', "Semakan Deskripsi Tugas kakitangan selian untuk tindakan pihak tuan. ", $model->kj);
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya dikemaskini']);
                  return $this->redirect(['my-portfolio/view-myjd', 'page' => $page]);
            }
        }

        return $this->render('kemaskini-data-ppk', compact('model', 'peraku', 'new', 'pegawai'));
    }
    
    
         public  function actionNotifistaf()
    {
             
       $model = ArrayHelper::map(\app\models\myportfolio\AksesPenyelia::find()->where(['jenis_akses' => 2])->all(), 'akses_icno', 'akses_icno');

        foreach ($model as $models) {
        $ntf = new Notification(); //noti untuk kp
        $ntf->icno = $models;
        $ntf->title = 'MyJD';
        $ntf->content = 'Salam Sejahtera, Tuan/Puan, anda kini adalah Penyelia Sistem MyJD. Emelkan terus ke hafizah.hassan@ums.edu.my (teknikal sistem)
                        sekiranya berlaku sebarang perubahan atau pertambahan staf sebagai penyelia sistem. Terima Kasih.'
                     .Html::a('<i class="fa fa-arrow-right">Klik Disini</i>', ['my-portfolio/view-myjd'],['class' => 'btn btn-primary btn-sm'],$models->akses_icno);
 
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save(false);
        
       
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'BERJAYA DIHANTAR']);
        return $this->redirect('pengumuman');
    }
    
       public function actionPengumuman(){
           if (Yii::$app->request->post('notifistaf')) {
            $this->notifistaf();
            return $this->refresh();
        }
              
        $request = Yii::$app->request;
        if($request->post()){

            $title = $request->post('title');
            $content = $request->post('content');

           $allBiodata = ArrayHelper::map(\app\models\myportfolio\AksesPenyelia::find()->where(['jenis_akses' => 2])->all(), 'akses_icno', 'akses_icno');
            foreach ($allBiodata as $ic){
                $ntf = new Notification();
                $ntf->icno = $ic;
                $ntf->title = $title;
                $ntf->content = $content;
                $ntf->ntf_dt = date('Y-m-d H:i:s');
                $ntf->save();
            }

            Yii::$app->session->setFlash('alert', ['title' => '', 'type' => 'success', 'msg' => 'Notifikasi Berjaya dihantar']);
            return $this->redirect(['my-portfolio/pengumuman']);

        }
        return $this->render('pengumuman', ['allBiodata' => $allBiodata, 'content' => $content, 'title' => $title]);
    }
    
    
   
       public function actionViewAkses($akses_dept = null, $akses_campus = null, $akses_icno = null, $jenis_akses = NULL)
    {
       // $icno = Yii::$app->user->getId();
      //  $penyelia = \app\models\myportfolio\AksesPenyelia::find()->where(['akses_icno' => $icno])->one();
        $dataProvider = new ActiveDataProvider([
            'query' => \app\models\myportfolio\AksesPenyelia::find()
                       ->with('penyeliaBiodata'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        if (isset(Yii::$app->request->queryParams['akses_icno'])) {
            $akses_icno ? $dataProvider->query->andFilterWhere(['akses_icno' => $akses_icno]) : '';
        }

        if (isset(Yii::$app->request->queryParams['akses_dept'])) {
            $akses_dept ? $dataProvider->query->andFilterWhere(['akses_dept' => $akses_dept]) : '';
        }

        if (isset(Yii::$app->request->queryParams['akses_campus'])) {
            $akses_campus ? $dataProvider->query->andFilterWhere(['akses_campus' => $akses_campus]) : '';
        }
        
        if (isset(Yii::$app->request->queryParams['jenis_akses'])) {
            $jenis_akses ? $dataProvider->query->andFilterWhere(['jenis_akses' => $jenis_akses]) : '';
        }

        return $this->render('view-akses', [
            'akses_icno' => $akses_icno,
            'akses_dept' => $akses_dept,
            'akses_campus' => $akses_campus,
            'jenis_akses' => $jenis_akses,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
      public function actionTambahAkses() {
        $adminbaru = new \app\models\myportfolio\AksesPenyelia(); //untuk admin baru
        $allbiodata =  ArrayHelper::map(Tblprcobiodata::find()->all(), 'ICNO', 'CONm');
        $department =  ArrayHelper::map(\app\models\hronline\Department::find()->where(['isActive' => 1])->all(), 'id', 'fullname');
        $campus =  ArrayHelper::map(\app\models\hronline\Campus::find()->all(), 'campus_id', 'campus_name');
        if ($adminbaru->load(Yii::$app->request->post())) {
            
                    if(\app\models\myportfolio\AksesPenyelia::find()->where( [ 'akses_icno' => $adminbaru->akses_icno ] )->exists()){ //jika admin sudah wujud
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Sudah Ditambah Sebelum Ini!']);
                        return $this->redirect(['my-portfolio/tambah-akses']);
                    }
                    if($adminbaru->penyeliaBiodata->CONm != NULL){ //jika icno tidak wujud dalam sistem
                        $adminbaru->save();
                        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Ditambah!']);
                       $this->notification('MyJD', 'Salam Sejahtera, Anda kini adalah Penyelia Sistem MyJd. Terima Kasih.' .'&nbsp'.Html::a('Klik Sini', ['my-portfolio/view-myjd'], ['class' => 'btn btn-primary btn-sm']), $adminbaru->akses_icno);
         
                    }
                    else{
                        Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'No Kad Pengenalan Tidak Wujud Dalam Sistem!']);
                    
                    }
                    
                    return $this->redirect(['my-portfolio/view-akses']);
                }
        if(\app\models\myportfolio\AksesPenyelia::find()->where(['akses_icno' => Yii::$app->user->getId()] )->exists()){
        return $this->render('tambah-akses', [
       //     'admin' => $admin,
            'adminbaru' => $adminbaru,
            'allbiodata' => $allbiodata,
            'department' => $department,
            'campus' => $campus
        ]);}
    }
     public function actionDeleteAkses($id)
    {
        $admin = \app\models\myportfolio\AksesPenyelia::findOne(['id' => $id]);
        $admin->delete();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Dipadam']);
        return $this->redirect(['view-akses']);
        
    }
    
    

}
