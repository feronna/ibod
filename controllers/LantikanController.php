<?php

namespace app\controllers;

use Yii;
use app\models\ejobs\TblpBiodata;
use yii\data\Pagination;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Department;
use app\models\hronline\Jabatan;
use app\models\hronline\Gelaran;
use app\models\hronline\Negeri;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\TblprcobiodataSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Notification;
use yii\helpers\Json;
use yii\filters\AccessControl;
use app\models\hronline\Tblretireage;
use app\models\hronline\Umsper;
use app\models\hronline\Umsperpks;
use app\models\hronline\AksesLevelkedua;
use app\models\hronline\AksesLevel;
use yii\rbac\DbManager;
use app\models\hronline\Senarailantikan;
use app\models\hronline\Tblpendidikan;
use app\models\hronline\TblPenempatan;
use app\models\hronline\Tblrscoapmtstatus;
use app\models\hronline\Tblrscoaptathy;
use app\models\hronline\Tblrscoconfirmstatus;
use app\models\hronline\Tblrscofileno;
use app\models\hronline\Tblrscoprobtnperiod;
use app\models\hronline\Tblrscopsnathy;
use app\models\hronline\Tblrscopsnstatus;
use app\models\hronline\Tblrscosalmovemth;
use app\models\hronline\Tblrscosaltype;
use app\models\hronline\Tblrscosandangan;
use app\models\hronline\Tblrscoservload;
use app\models\hronline\Tblrscoservstatus;
use app\models\hronline\Tblrscoservtype;
use app\models\hronline\StatusLantikan;
use app\models\hronline\TblStaffSalary;
use app\models\hronline\RefEpfType;
use app\models\hronline\RefTaxFormulaType;
use app\models\hronline\RefTaxCategory;
use app\models\hronline\RefSocsoType;
use app\models\hronline\Tables;
use app\models\hronline\Tbllantikanbelumselesai;
use app\models\gaji\Tblrscolpg;
use app\models\gaji\RefJadualGaji;
use app\models\hronline\FalseModel;
use app\models\hronline\GredJawatan;
use app\models\kehadiran\TblWp;
use app\models\keselamatan\TblStaffKeselamatan;
use app\models\klinikpanel\Tblmaxtuntutan;
use app\models\myidp\IdpMata;
use yii\helpers\VarDumper;


class LantikanController extends Controller
{

    /**
     * {@inheritdoc}
     */
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
                'only' => [
                    'index', 'adminview', 'userview', 'lihatbiodata', 'lihatbiodatakakitangan', 'tambahkakitangan', 'kemaskinikakitangan', 'kemaskini',
                    'penetapanpengguna', 'kemaskinipenetapanpengguna', 'padamkakitangan', 'resetpassword', 'test-email-suggestion'
                ],
                'rules' => [
                    Yii::$app->AccessManager->Allowed(Yii::$app->controller->id),
                    [
                        'actions' => [
                            'index', 'adminview', 'tambahkakitangan', 'lihatbiodatakakitangan', 'kemaskinikakitangan', 'penetapanpengguna', 'kemaskinipenetapanpengguna',
                            'padamkakitangan', 'resetpassword', 'test-email-suggestion'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $access = Yii::$app->user->identity->accessLevel;
                            switch ($access) {
                                case '1':
                                    return true;
                                    break;
                                case '2':
                                    $secondaccess = Yii::$app->user->identity->accessSecondLevel;
                                    if (in_array($secondaccess, ['1', '3'])) {
                                        return true;
                                    }
                                    return false;
                                    break;

                                default:
                                    return false;
                                    break;
                            }
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new Tblprcobiodata();
        $loginDept = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->getId()])->DeptId;
        $dept_name = Department::findOne(['id' => $loginDept])->fullname;
        $idlist = Senarailantikan::showOnlyLantikan($loginDept);
        if ($model->load(Yii::$app->request->post())) {
            switch ($model->jenislantikan) {
                case '1':
                case '2':
                case '3':
                    $redirect = 'lantikanstaffbaru';
                    break;
                case '4':
                    $redirect = 'sambilanakademik';
                    break;
                case '6':
                    $redirect = 'penerbitums';
                    break;
                case '7':
                    $redirect = 'lssu-index'; //lantik semula staf ums
                    break;
                default:
                    return $this->render('lantikan', ['model' => $model, 'idlist' => $idlist, 'dept_name' => $dept_name,]);
            }

            return $this->redirect([$redirect, 'AT' => $model->jenislantikan]);
        }
        //uncomment code below to restrict admin view by department
        return $this->render('index', [
            'model' => $model,
            'idlist' => $idlist,
            'dept_name' => $dept_name,
        ]);
        return $this->render('lantikan', [
            'model' => $model,
            'idlist' => $idlist,
            'dept_name' => $dept_name,
        ]);
        // return $this->render('lantikan',[
        //     'model'=>$model,
        // ]);
    }

    public function actionLantikanEjobs()
    {
        $searchModel = new \app\models\ejobs\TblpPermohonanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_lantikanejobs', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLantikStafBaruEjobs($icno)
    {
        $user = TblpBiodata::findOne(['ICNO' => $icno]);

        $model = new Tblprcobiodata();
        $model->scenario = 'baru';

        if ($user->load(Yii::$app->request->post())) {
            $model->CONm = strtoupper($user->CONm);
            $model->startDateSandangan = $user->startDateLantik;
            $model->endDateSandangan = $user->endDateLantik; //new
            $model->Status = '1';
            $model->startDateStatus = $user->startDateLantik;
            $new_id = substr($model->COOldID, -5) . substr($model->ICNO, -4);
            $model->COOPass =  md5($new_id);

            //Maklumat Jawatan, JFPIU & Kampus Hakiki
            $model->DeptId_hakiki = $user->DeptId;
            $model->campus_id_hakiki = $user->campus_id;
            $model->gredJawatan_2 = $user->gredJawatan;
            // echo $model->jawatan->gred;
            // die;
            //email suggestion;
            $suit_email = strtolower($user->CONm);
            $pieces_suit_email = explode(" ", $suit_email);
            $s_email = "";
            for ($i = 1; $i < count($pieces_suit_email); $i++) {
                if (
                    strcasecmp('bin', $pieces_suit_email[$i]) == 0 || strcasecmp('binti', $pieces_suit_email[$i]) == 0 || strcasecmp('bte', $pieces_suit_email[$i]) == 0 || strcasecmp('A\P', $pieces_suit_email[$i]) == 0 || strcasecmp('A\L', $pieces_suit_email[$i]) == 0 || strcasecmp('anak', $pieces_suit_email[$i]) == 0
                ) {
                    $pieces_suit_email[$i] = '.';
                } else if (strcasecmp('@', $pieces_suit_email[$i]) == 0) {
                    $pieces_suit_email[$i] = '';
                }
                $pieces_suit_email[$i] = str_replace("@", '',  $pieces_suit_email[$i]);

                $s_email = $s_email . $pieces_suit_email[$i];
            }
            $s_email = $pieces_suit_email[0] . $s_email . '@ums.edu.my';
            $model->COEmail = $s_email;

            //--------------------insert model lain yg berkaitan----------------------------------------//
            if ($user->statLantikan == '6' || $user->statLantikan == '7') {
                $ConfirmStatusCd = '8'; //Tidak Kaitan Dengan Proses Pengesahan			
                $PsnStatusCd = '04'; //04:Tidak Layak Memilih
                $PsnAthyCd = '99'; //99:Tiada Berkaitan
            } else {
                if ($user->statLantikan == '1') {
                    $ConfirmStatusCd = '2';    //Dalam Percubaan Lantikan Pertama
                    $PsnStatusCd = '03'; //03:Belum Memilih
                    $PsnAthyCd = '99'; //99:Tiada Berkaitan
                } elseif ($user->statLantikan == '3') {
                    $ConfirmStatusCd = '8'; //Tidak Kaitan Dengan Proses Pengesahan
                    $PsnStatusCd = '04'; //04:Tidak Layak Memilih
                    $PsnAthyCd = '99'; //99:Tiada Berkaitan
                } else {
                    $ConfirmStatusCd = '8'; //Tidak Kaitan Dengan Proses Pengesahan
                    $PsnStatusCd = '04'; //04:Tidak Layak Memilih
                    $PsnAthyCd = '99'; //99:Tiada Berkaitan
                }
            }

            //creating new umsper; //sambilan tidak akan guna 's' ;
            $prev_umsper = Umsper::find()->orderBy(['COOldIDNo' => SORT_DESC])->one();
            $COOldIDNo = sprintf("%05s", ($prev_umsper->COOldIDNo + 1));
            $umsper_date = explode("-", $user->startDateStatus);
            $COOldIDDt = date("ymd", mktime(0, 0, 0, $umsper_date[1], $umsper_date[2], $umsper_date[0]));
            $COOldID = $COOldIDDt . '-' . $COOldIDNo;
            $model->COOldID = $COOldID;
            $model->COOUCTelNo = '1' . $COOldIDNo;

            //set probtnenddt based on register date
            $next3year = mktime(0, 0, 0, $umsper_date[1], $umsper_date[2], $umsper_date[0] + 3);
            $ProbtnEndDt = date('Y-m-d', $next3year);

            //set move month based on register date
            $movemonth = ($umsper_date[1] < '04' && $umsper_date[1] > '00' ? '01' : ($umsper_date[1] < '07' && $umsper_date[1] > '03' ? '04' : ($umsper_date[1] < '10' && $umsper_date[1] > '06' ? '07' : '10')));

            //------------------------------------start saving all related models------------------------------------------//
            if ($model->save()) {

                //HR: insert new record on umsper table
                $model_umsper = new Umsper();
                $model_umsper->scenario = 'baru';
                $model_umsper->ICNO = $user->ICNO;
                $model_umsper->JobId = $user->gredJawatan;
                $model_umsper->DeptId = $user->DeptId;
                $model_umsper->campus_id = $user->campus_id;
                $model_umsper->COOldID = $COOldID;
                $model_umsper->StartDate = $user->startDateLantik;
                $model_umsper->COOldIDDt = $COOldIDDt;
                $model_umsper->COOldIDNo = $COOldIDNo;
                if (!$model_umsper->save()) {
                    Tblprcobiodata::deleteAll(['ICNO' => $user->ICNO]);
                    Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Terdapat proses lantikan lain yang sedang berjalan. Sila cuba sebentar lagi.']);
                    return $this->render('_lantikstafbaruejobs', [
                        'model' => $model,
                    ]);
                }

                //HR: insert new record on tblrscosandangan table
                $model_sandangan = new Tblrscosandangan();
                //$model_sandangan->scenario='new';
                $model_sandangan->ICNO = $user->ICNO;
                $model_sandangan->gredjawatan = $user->gredJawatan;
                $model_sandangan->sandangan_id = $user->statSandangan;
                $model_sandangan->ApmtTypeCd = $user->ApmtTypeCd;
                $model_sandangan->start_date = $user->startDateLantik;
                $model_sandangan->save();

                //HR: insert new record on tblrscoapmtstatus table
                $model_apmtstatus = new Tblrscoapmtstatus();
                //$model_apmtstatus->scenario='new';
                $model_apmtstatus->ICNO = $user->ICNO;
                $model_apmtstatus->ApmtStatusCd = $user->statLantikan;
                $model_apmtstatus->ApmtStatusStDt = $user->startDateLantik;
                $model_apmtstatus->ApmtStatusEndDt = $user->endDateLantik;
                $model_apmtstatus->save();
                //HR: insert new record on tblrscoservstatus table
                $model_servstatus = new Tblrscoservstatus();
                //$model_servstatus->scenario='new';
                $model_servstatus->ICNO = $user->ICNO;
                $model_servstatus->ServStatusCd = '1';
                $model_servstatus->ServStatusDtl = '1';
                $model_servstatus->ServStatusStDt = $user->startDateLantik;
                $model_servstatus->save();

                //HR: insert new record on tblpreduach table
                $model_eduach = new Tblpendidikan();
                $model_eduach->ICNO = $user->ICNO;
                $model_eduach->InstCd = '999';
                $model_eduach->HighestEduLevelCd = $user->HighestEduLevelCd;
                $model_eduach->MajorCd = '0000';
                $model_eduach->SponsorshipCd = '0000';
                $model_eduach->EduCertTitle = Pendidikantertinggi::find()->where(['HighestEduLevelCd' => $user->HighestEduLevelCd])->one()->HighestEduLevel;
                $model_eduach->OverallGrade = 'PASS';
                $model_eduach->ConfermentDt = $user->ConfermentDt;
                $model_eduach->AcrtdEduAch = '1';
                $model_eduach->save(false);

                //HR: insert new record on tblpenempatan table
                $model_penempatan_pertama = new Tblpenempatan();
                $model_penempatan_pertama->ICNO = $user->ICNO;
                $model_penempatan_pertama->date_start = $user->startDateLantik;
                $model_penempatan_pertama->date_update = date('Y-m-d H:i:s');
                $model_penempatan_pertama->dept_id = $user->DeptId;
                $model_penempatan_pertama->campus_id = $user->campus_id;
                $model_penempatan_pertama->reason_id = 1;
                $model_penempatan_pertama->remark = 'Penempatan asal';
                $model_penempatan_pertama->letter_order_refno = '-';
                $model_penempatan_pertama->date_letter_order = $user->startDateLantik;
                $model_penempatan_pertama->letter_refno = 'Penempatan asal';
                $model_penempatan_pertama->update_by = Yii::$app->user->getId();
                $model_penempatan_pertama->save();

                //HR: insert new record on tblrscoaptathy table
                $model_tblrscoaptathy = new Tblrscoaptathy();
                $model_tblrscoaptathy->ICNO = $user->ICNO;
                $model_tblrscoaptathy->AptAthyCd = '387';
                $model_tblrscoaptathy->ICNOHeadServ = '530121125351'; //temporary ic datuk kamaruzaman, later will be auto detect VC ums
                $model_tblrscoaptathy->AptAthyStDt = $user->startDateLantik;
                $model_tblrscoaptathy->save();

                //HR: insert new record on tblrscoservload table
                $model_tblrscoservload = new Tblrscoservload();
                $model_tblrscoservload->ICNO = $user->ICNO;
                $model_tblrscoservload->ServLoadCd = '1'; //temporary 1 for sepenuh masa
                $model_tblrscoservload->ServLoadStDt = $user->startDateLantik;
                $model_tblrscoservload->save();

                //HR: insert new record on tblrscoconfirmstatus table
                $model_tblrscoconfirmstatus = new Tblrscoconfirmstatus();
                $model_tblrscoconfirmstatus->ICNO = $user->ICNO;
                $model_tblrscoconfirmstatus->ConfirmStatusCd = $ConfirmStatusCd; //temporary 7 Dalam Proses Pengesahan or 8 Tidak Kaitan Dengan Proses Pengesahan
                $model_tblrscoconfirmstatus->ConfirmStatusStDt = $user->startDateLantik;
                $model_tblrscoconfirmstatus->save();

                if ($model->statLantikan == '1') {
                    //HR: insert new record on tblrscoprobtnperiod table
                    $model_tblrscoprobtnperiod = new Tblrscoprobtnperiod();
                    $model_tblrscoprobtnperiod->ICNO = $user->ICNO;
                    $model_tblrscoprobtnperiod->ProbtnPeriod = '36'; //36 bulan max
                    $model_tblrscoprobtnperiod->ProbtnStDt = $user->startDateLantik;
                    $model_tblrscoprobtnperiod->ProbtnEndDt = $ProbtnEndDt;
                    $model_tblrscoprobtnperiod->ProbtnPeriodMin = '12'; //12 bulan min
                    $model_tblrscoprobtnperiod->save();
                }

                //HR: insert new record on tblrscopsnstatus table
                $model_tblrscopsnstatus = new Tblrscopsnstatus();
                $model_tblrscopsnstatus->ICNO = $user->ICNO;
                $model_tblrscopsnstatus->PsnStatusCd = $PsnStatusCd; //temporary 03:Belum Memilih,  04:Tidak Layak Memilih, 05:Tidak Berkaitan (Kontrak)
                $model_tblrscopsnstatus->PsnStatusNo = '';
                $model_tblrscopsnstatus->PsnIncomeTaxNo = '';
                $model_tblrscopsnstatus->PsnEpfNo = '';
                $model_tblrscopsnstatus->PsnStatusStDt = $user->startDateLantik;
                $model_tblrscopsnstatus->save();

                //HR: insert new record on tblrscopsnathy table
                $model_tblrscoaptathy = new Tblrscopsnathy();
                $model_tblrscoaptathy->ICNO = $user->ICNO;
                $model_tblrscoaptathy->PsnAthyCd = $PsnAthyCd; //99 Tiada Berkaitan, 0 Tidak Berkenaan - (Lantikan Kontrak / Sementara) 
                $model_tblrscoaptathy->PsnAthyStDt = $user->startDateLantik;
                $model_tblrscoaptathy->save();

                //HR: insert new record on tblrscosaltype table
                $model_tblrscosaltype = new Tblrscosaltype();
                $model_tblrscosaltype->ICNO = $user->ICNO;
                $model_tblrscosaltype->SalTypeCd = '01'; //01 bulanan
                $model_tblrscosaltype->SalStatus = '1'; //1 matrix gaji
                $model_tblrscosaltype->SalTypeStDt = $user->startDateLantik;
                $model_tblrscosaltype->save();

                //HR: insert new record on tblrscoservtype table
                $model_tblrscoservtype = new Tblrscoservtype();
                $model_tblrscoservtype->ICNO = $user->ICNO;
                $model_tblrscoservtype->ServTypeStDt = $user->startDateLantik;
                $model_tblrscoservtype->ServTypeCd = 'SSM'; //SSM: Sistem saraan Malaysia
                $model_tblrscoservtype->save();

                //HR: insert new record on tblrscosalmovemth table
                $model_tblrscosalmovemth = new Tblrscosalmovemth();
                $model_tblrscosalmovemth->ICNO = $user->ICNO;
                $model_tblrscosalmovemth->SalMoveMth = $movemonth;
                $model_tblrscosalmovemth->SalMoveMthType = '1';
                $model_tblrscosalmovemth->SalMoveMthStDt = $user->startDateLantik;
                $model_tblrscosalmovemth->save();

                //HR: insert new record on tblrscofileno table
                $model_tblrscofileno = new Tblrscofileno();
                $model_tblrscofileno->ICNO = $user->ICNO;
                $model_tblrscofileno->COFileNo = $COOldID;
                $model_tblrscofileno->COFileNoEftvDt = $user->startDateLantik;
                $model_tblrscofileno->save();

                if ($model->ApmtTypeCd == '2') {

                    //insert staf_keselamatan
                    $gredKeselamatan = ['KP11', 'KP14', 'KP16', 'KP18', 'KP19', 'KP22', 'KP27', 'KP29', 'KP32'];
                    if (in_array($user->jawatan->gred, $gredKeselamatan)) {
                        $model_keselamatan = new TblStaffKeselamatan();
                        $model_keselamatan->staff_icno = $user->ICNO;
                        $model_keselamatan->added_by = 'LANTIKAN PERTAMA';
                        $model_keselamatan->created_at = date('Y-m-d H:i:s');
                        $model_keselamatan->campus_id = $user->campus_id;
                        $model_keselamatan->save(false);
                    }

                    //insert WP
                    $model_wp = new TblWP();
                    $model_wp->wp_id = '40';
                    $model_wp->icno = $user->ICNO;
                    $model_wp->remark = 'LANTIKAN PERTAMA';
                    $model_wp->entry_dt = date('Y-m-d H:i:s');
                    $model_wp->start_date = date('Y-m-d');
                    $model_wp->status = 'APPROVED';
                    $model_wp->save(false);

                    //insert klinik panel
                    $model_klinik = new Tblmaxtuntutan();
                    $model_klinik->max_icno = $user->ICNO;
                    $model_klinik->max_tuntutan = 1000;
                    $model_klinik->current_balance = 1000;
                    $model_klinik->last_update = date('Y-m-d H:i:s');
                    $model_klinik->last_updater = 'E-jobs';
                    $model_klinik->save(false);
                }

                //send notification to IT admin
                $array_admin = ['940402125181', '840813125655', '811212125745'];
                for ($i = 0; $i < count($array_admin); $i++) {
                    $model_noty = new Notification();
                    $model_noty->icno = $array_admin[$i];
                    $model_noty->title = 'LANTIKAN BARU KAKITANGAN';
                    $model_noty->content = 'Semakkan maklumat kakitangan yang baru dilantik. No IC = ' . $user->ICNO
                        . '; No IC melantik = ' . Yii::$app->user->getId();
                    $model_noty->ntf_dt = date('Y-m-d H:i:s');
                    $model_noty->save(false);
                }

                //transfer data
                \app\models\ejobs\TblpAlamat::LaporDiri($user->ICNO);
                \app\models\ejobs\TblpBahasa::LaporDiri($user->ICNO);
                \app\models\ejobs\TblpEduHighest::LaporDiri($user->ICNO);
                \app\models\ejobs\TblpPengalamanKerja::LaporDiri($user->ICNO);
                \app\models\ejobs\TblpKecacatan::LaporDiri($user->ICNO);
                \app\models\ejobs\TblpKeluarga::LaporDiri($user->ICNO);
                \app\models\ejobs\TblpLesen::LaporDiri($user->ICNO);

                //redirect to admin page
                return $this->redirect([
                    'biodata/adminview',
                    'id' => $user->ICNO,
                ]);
            }
        }

        return $this->render('_lantikstafbaruejobs', [
            'user' => $user,
        ]);
    }

    //lantikan asal bsm

    public function actionLantikStafBaru()
    {
        $model = new Tblprcobiodata();
        $model->scenario = 'baru';
        // $model->scenario = 'test';
        $model->_action = 'lantikstafbaru';

        if (Yii::$app->request->post('janaemail') == 'janaemail') {
            $model->load(Yii::$app->request->post());
            if (!empty($model->CONm)) {
                //email suggestion;
                $s_email = $this->emailSuggestion($model->CONm);
                $model->COEmail = $s_email;
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sila masukkan nama kakitangan terlebih dahulu.']);
            }
        } elseif ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->CONm = strtoupper($model->CONm);
            $model->startDateSandangan = $model->startDateLantik;
            $model->endDateSandangan = $model->endDateLantik; //new
            $model->Status = '1';
            $model->startDateStatus = $model->startDateLantik;
            $new_id = substr($model->COOldID, -5) . substr($model->ICNO, -4);
            $model->COOPass =  md5($new_id);

            //Maklumat Jawatan, JFPIU & Kampus Hakiki
            $model->DeptId_hakiki = $model->DeptId;
            $model->campus_id_hakiki = $model->campus_id;
            $model->gredJawatan_2 = $model->gredJawatan;

            //emel validation//
            $flag = true;
            $msg = 'Terdapat masalah dalam proses.';
            $validation = $this->validateEmail($model->COEmail);
            if ($validation['flag'] == false) {
                $flag = false;
                $msg = $validation['message'];
            }

            if ($flag) {

                //--------------------insert model lain yg berkaitan----------------------------------------//
                if ($model->statLantikan == '6' || $model->statLantikan == '7') {
                    $ConfirmStatusCd = '8'; //Tidak Kaitan Dengan Proses Pengesahan			
                    $PsnStatusCd = '04'; //04:Tidak Layak Memilih
                    $PsnAthyCd = '99'; //99:Tiada Berkaitan
                } else {
                    if ($model->statLantikan == '1') {
                        $ConfirmStatusCd = '2';    //Dalam Percubaan Lantikan Pertama
                        $PsnStatusCd = '03'; //03:Belum Memilih
                        $PsnAthyCd = '99'; //99:Tiada Berkaitan
                    } elseif ($model->statLantikan == '3') {
                        $ConfirmStatusCd = '8'; //Tidak Kaitan Dengan Proses Pengesahan
                        $PsnStatusCd = '04'; //04:Tidak Layak Memilih
                        $PsnAthyCd = '99'; //99:Tiada Berkaitan
                    } else {
                        $ConfirmStatusCd = '8'; //Tidak Kaitan Dengan Proses Pengesahan
                        $PsnStatusCd = '04'; //04:Tidak Layak Memilih
                        $PsnAthyCd = '99'; //99:Tiada Berkaitan
                    }
                }

                //creating new umsper; //sambilan tidak akan guna 's' ;
                $prev_umsper = Umsper::find()->orderBy(['COOldIDNo' => SORT_DESC])->one();
                $COOldIDNo = sprintf("%05s", ($prev_umsper->COOldIDNo + 1));
                $umsper_date = explode("-", $model->startDateStatus);
                $COOldIDDt = date("ymd", mktime(0, 0, 0, $umsper_date[1], $umsper_date[2], $umsper_date[0]));
                $COOldID = $COOldIDDt . '-' . $COOldIDNo;
                $model->COOldID = $COOldID;
                $model->COOUCTelNo = '1' . $COOldIDNo;

                //set probtnenddt based on register date
                $next3year = mktime(0, 0, 0, $umsper_date[1], $umsper_date[2], $umsper_date[0] + 3);
                $ProbtnEndDt = date('Y-m-d', $next3year);

                //set move month based on register date
                $movemonth = ($umsper_date[1] < '04' && $umsper_date[1] > '00' ? '01' : ($umsper_date[1] < '07' && $umsper_date[1] > '03' ? '04' : ($umsper_date[1] < '10' && $umsper_date[1] > '06' ? '07' : '10')));

                //------------------------------------start saving all related models------------------------------------------//
                if ($model->save()) {

                    //HR: insert new record on umsper table
                    $model_umsper = new Umsper();
                    $model_umsper->scenario = 'baru';
                    $model_umsper->ICNO = $model->ICNO;
                    $model_umsper->JobId = $model->gredJawatan;
                    $model_umsper->DeptId = $model->DeptId;
                    $model_umsper->campus_id = $model->campus_id;
                    $model_umsper->COOldID = $COOldID;
                    $model_umsper->StartDate = $model->startDateLantik;
                    $model_umsper->COOldIDDt = $COOldIDDt;
                    $model_umsper->COOldIDNo = $COOldIDNo;
                    if (!$model_umsper->save(false)) {
                        Tblprcobiodata::deleteAll(['ICNO' => $model->ICNO]);
                        Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Terdapat proses lantikan lain yang sedang berjalan. Sila cuba sebentar lagi.']);
                        return $this->render('_lantikstafbaru', [
                            'model' => $model,
                        ]);
                    }

                    //HR: insert new record on tblrscosandangan table
                    $model_sandangan = new Tblrscosandangan();
                    $model_sandangan->_action = 'lantikstafbaru';
                    //$model_sandangan->scenario='new';
                    $model_sandangan->ICNO = $model->ICNO;
                    $model_sandangan->gredjawatan = $model->gredJawatan;
                    $model_sandangan->sandangan_id = $model->statSandangan;
                    $model_sandangan->ApmtTypeCd = $model->ApmtTypeCd;
                    $model_sandangan->start_date = $model->startDateLantik;
                    $model_sandangan->save(false);

                    //HR: insert new record on tblrscoapmtstatus table
                    $model_apmtstatus = new Tblrscoapmtstatus();
                    $model_apmtstatus->scenario = 'lantikstafbaru';
                    $model_apmtstatus->ICNO = $model->ICNO;
                    $model_apmtstatus->ApmtStatusCd = $model->statLantikan;
                    $model_apmtstatus->ApmtStatusStDt = $model->startDateLantik;
                    $model_apmtstatus->ApmtStatusEndDt = $model->endDateLantik;
                    $model_apmtstatus->save(false);
                    //HR: insert new record on tblrscoservstatus table
                    $model_servstatus = new Tblrscoservstatus();
                    //$model_servstatus->scenario='new';
                    $model_servstatus->ICNO = $model->ICNO;
                    $model_servstatus->ServStatusCd = '1';
                    $model_servstatus->ServStatusDtl = '1';
                    $model_servstatus->ServStatusStDt = $model->startDateLantik;
                    $model_servstatus->save(false);

                    //HR: insert new record on tblpreduach table
                    $model_eduach = new Tblpendidikan();
                    $model_eduach->ICNO = $model->ICNO;
                    $model_eduach->InstCd = '999';
                    $model_eduach->HighestEduLevelCd = $model->HighestEduLevelCd;
                    $model_eduach->MajorCd = '0000';
                    $model_eduach->SponsorshipCd = '0000';
                    $model_eduach->EduCertTitle = Pendidikantertinggi::find()->where(['HighestEduLevelCd' => $model->HighestEduLevelCd])->one()->HighestEduLevel;
                    $model_eduach->OverallGrade = 'PASS';
                    $model_eduach->ConfermentDt = $model->ConfermentDt;
                    $model_eduach->AcrtdEduAch = '1';
                    $model_eduach->save(false);

                    //HR: insert new record on tblpenempatan table
                    $model_penempatan_pertama = new Tblpenempatan();
                    $model_penempatan_pertama->_action = 'lantikstafbaru';
                    $model_penempatan_pertama->ICNO = $model->ICNO;
                    $model_penempatan_pertama->date_start = $model->startDateLantik;
                    $model_penempatan_pertama->date_update = date('Y-m-d H:i:s');
                    $model_penempatan_pertama->dept_id = $model->DeptId;
                    $model_penempatan_pertama->campus_id = $model->campus_id;
                    $model_penempatan_pertama->reason_id = 1;
                    $model_penempatan_pertama->remark = 'Penempatan asal';
                    $model_penempatan_pertama->letter_order_refno = '-';
                    $model_penempatan_pertama->date_letter_order = $model->startDateLantik;
                    $model_penempatan_pertama->letter_refno = 'Penempatan asal';
                    $model_penempatan_pertama->update_by = Yii::$app->user->getId();
                    $model_penempatan_pertama->save(false);

                    //HR: insert new record on tblrscoaptathy table
                    $model_tblrscoaptathy = new Tblrscoaptathy();
                    $model_tblrscoaptathy->ICNO = $model->ICNO;
                    $model_tblrscoaptathy->AptAthyCd = '387';
                    $model_tblrscoaptathy->ICNOHeadServ = Yii::$app->MP->getVC(); //temporary ic datuk kamaruzaman, later will be auto detect VC ums
                    $model_tblrscoaptathy->AptAthyStDt = $model->startDateLantik;
                    $model_tblrscoaptathy->save(false);

                    //HR: insert new record on tblrscoservload table
                    $model_tblrscoservload = new Tblrscoservload();
                    $model_tblrscoservload->ICNO = $model->ICNO;
                    $model_tblrscoservload->ServLoadCd = '1'; //temporary 1 for sepenuh masa
                    $model_tblrscoservload->ServLoadStDt = $model->startDateLantik;
                    $model_tblrscoservload->save(false);

                    //HR: insert new record on tblrscoconfirmstatus table
                    $model_tblrscoconfirmstatus = new Tblrscoconfirmstatus();
                    $model_tblrscoconfirmstatus->ICNO = $model->ICNO;
                    $model_tblrscoconfirmstatus->ConfirmStatusCd = $ConfirmStatusCd; //temporary 7 Dalam Proses Pengesahan or 8 Tidak Kaitan Dengan Proses Pengesahan
                    $model_tblrscoconfirmstatus->ConfirmStatusStDt = $model->startDateLantik;
                    $model_tblrscoconfirmstatus->save(false);

                    if ($model->statLantikan == '1') {
                        //HR: insert new record on tblrscoprobtnperiod table
                        $model_tblrscoprobtnperiod = new Tblrscoprobtnperiod();
                        $model_tblrscoprobtnperiod->ICNO = $model->ICNO;
                        $model_tblrscoprobtnperiod->ProbtnPeriod = '36'; //36 bulan max
                        $model_tblrscoprobtnperiod->ProbtnStDt = $model->startDateLantik;
                        $model_tblrscoprobtnperiod->ProbtnEndDt = $ProbtnEndDt;
                        $model_tblrscoprobtnperiod->ProbtnPeriodMin = '12'; //12 bulan min
                        $model_tblrscoprobtnperiod->save(false);
                    }

                    //HR: insert new record on tblrscopsnstatus table
                    $model_tblrscopsnstatus = new Tblrscopsnstatus();
                    $model_tblrscopsnstatus->ICNO = $model->ICNO;
                    $model_tblrscopsnstatus->PsnStatusCd = $PsnStatusCd; //temporary 03:Belum Memilih,  04:Tidak Layak Memilih, 05:Tidak Berkaitan (Kontrak)
                    $model_tblrscopsnstatus->PsnStatusNo = '';
                    $model_tblrscopsnstatus->PsnIncomeTaxNo = '';
                    $model_tblrscopsnstatus->PsnEpfNo = '';
                    $model_tblrscopsnstatus->PsnStatusStDt = $model->startDateLantik;
                    $model_tblrscopsnstatus->save(false);

                    //HR: insert new record on tblrscopsnathy table
                    $model_tblrscoaptathy = new Tblrscopsnathy();
                    $model_tblrscoaptathy->ICNO = $model->ICNO;
                    $model_tblrscoaptathy->PsnAthyCd = $PsnAthyCd; //99 Tiada Berkaitan, 0 Tidak Berkenaan - (Lantikan Kontrak / Sementara) 
                    $model_tblrscoaptathy->PsnAthyStDt = $model->startDateLantik;
                    $model_tblrscoaptathy->save(false);

                    //HR: insert new record on tblrscosaltype table
                    $model_tblrscosaltype = new Tblrscosaltype();
                    $model_tblrscosaltype->ICNO = $model->ICNO;
                    $model_tblrscosaltype->SalTypeCd = '01'; //01 bulanan
                    $model_tblrscosaltype->SalStatus = '1'; //1 matrix gaji
                    $model_tblrscosaltype->SalTypeStDt = $model->startDateLantik;
                    $model_tblrscosaltype->save(false);

                    //HR: insert new record on tblrscoservtype table
                    $model_tblrscoservtype = new Tblrscoservtype();
                    $model_tblrscoservtype->ICNO = $model->ICNO;
                    $model_tblrscoservtype->ServTypeStDt = $model->startDateLantik;
                    $model_tblrscoservtype->ServTypeCd = 'SSM'; //SSM: Sistem saraan Malaysia
                    $model_tblrscoservtype->save(false);

                    //HR: insert new record on tblrscosalmovemth table
                    $model_tblrscosalmovemth = new Tblrscosalmovemth();
                    $model_tblrscosalmovemth->ICNO = $model->ICNO;
                    $model_tblrscosalmovemth->SalMoveMth = $movemonth;
                    $model_tblrscosalmovemth->SalMoveMthType = '1';
                    $model_tblrscosalmovemth->SalMoveMthStDt = $model->startDateLantik;
                    $model_tblrscosalmovemth->save(false);

                    //HR: insert new record on tblrscofileno table
                    $model_tblrscofileno = new Tblrscofileno();
                    $model_tblrscofileno->ICNO = $model->ICNO;
                    $model_tblrscofileno->COFileNo = $COOldID;
                    $model_tblrscofileno->COFileNoEftvDt = $model->startDateLantik;
                    $model_tblrscofileno->save(false);

                    if ($model->ApmtTypeCd == '2') {

                        //insert staf_keselamatan
                        $gredKeselamatan = ['KP11', 'KP14', 'KP16', 'KP18', 'KP19', 'KP22', 'KP27', 'KP29', 'KP32'];
                        if (in_array($model->jawatan->gred, $gredKeselamatan)) {
                            $model_keselamatan = new TblStaffKeselamatan();
                            $model_keselamatan->staff_icno = $model->ICNO;
                            $model_keselamatan->added_by = 'LANTIKAN PERTAMA';
                            $model_keselamatan->created_at = date('Y-m-d H:i:s');
                            $model_keselamatan->campus_id = $model->campus_id;
                            $model_keselamatan->save(false);
                        }

                        //insert WP
                        $model_wp = new TblWP();
                        $model_wp->wp_id = '40';
                        $model_wp->icno = $model->ICNO;
                        $model_wp->remark = 'LANTIKAN PERTAMA';
                        $model_wp->entry_dt = date('Y-m-d H:i:s');
                        $model_wp->start_date = date('Y-m-d');
                        $model_wp->status = 'APPROVED';
                        $model_wp->save(false);

                        //insert klinik panel
                        if (!in_array($model->statLantikan, [6, 7])) {
                            $tuntutan_value = 1000;
                            if (in_array($model->MrtlStatusCd, ['2', '3', '4', '5'])) {
                                $tuntutan_value = 2000;
                            }
                            $model_klinik = new Tblmaxtuntutan();
                            $model_klinik->max_icno = $model->ICNO;
                            $model_klinik->max_tuntutan = $tuntutan_value;
                            $model_klinik->current_balance = $tuntutan_value;
                            $model_klinik->last_update = date('Y-m-d H:i:s');
                            $model_klinik->last_updater = 'LANTIKAN';
                            $model_klinik->save(false);
                        }
                    }

                    //send notification to IT admin
                    $array_admin = ['940402125181', '840813125655', '811212125745'];
                    for ($i = 0; $i < count($array_admin); $i++) {
                        $model_noty = new Notification();
                        $model_noty->icno = $array_admin[$i];
                        $model_noty->title = 'LANTIKAN BARU KAKITANGAN';
                        $model_noty->content = 'Semakkan maklumat kakitangan yang baru dilantik. No IC = ' . $model->ICNO
                            . '; No IC melantik = ' . Yii::$app->user->getId();
                        $model_noty->ntf_dt = date('Y-m-d H:i:s');
                        $model_noty->save(false);
                    }

                    IdpMata::addStaff($model->ICNO);

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat ata berjaya disimpan.']);
                    //redirect to admin page
                    return $this->redirect([
                        'biodata/adminview',
                        'id' => $model->ICNO,
                    ]);
                }
                // var_dump($model->errors);
                // die;
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => $msg]);
            }
        }
        // var_dump($model->errors);
        // die;


        return $this->render('_lantikstafbaru', [
            'model' => $model,
        ]);
    }

    private static function ValidateEmail($email)
    {
        $email = trim($email);
        $array_name = explode("@", $email);
        $flag = false;
        $msg = 'Terdapat masalah emel. Sila hubungi staf teknikal jika perlu. ';
        $valid = true;
        $too_long = ' ';

        if (strlen($array_name[0]) > 20) {
            $valid = false;
            $too_long = 'Emel lebih 20 abjad. Sila ubah secara manual.';
        }

        if ($valid && count($array_name) == 2) {
            if ($array_name[1] == 'ums.edu.my') {
                $ad = Yii::$app->ActiveDirectory->AdEmailExist($email, 'email');
                if (!$ad->exists) {
                    $flag = true;
                    $msg = 'Emel rasmi ums sah.';
                } else {
                    $msg = 'Emel rasmi sedang digunakan. Sila masukkan email rasmi yang baru.';
                }
            } else {
                $msg = 'Emel rasmi tidak mengandungi @ums.edu.my. Sila masukkan email rasmi yang baru.';
            }
        }
        return ['flag' => $flag, 'message' => $msg . $too_long];
    }

    private static function EmailSuggestion($staff_name, $exist = false) // version 1.0
    {
        $staff_name = strtolower($staff_name);
        $invalid_name = ['bin', 'binti', 'bte', 'a/p', 'a/l', 'anak'];
        $common_name = ['mohammad', 'mohd', 'muhamad', 'mohd.', 'ahmad', 'abdul', 'siti', 'nur', 'nor'];
        $unwanted_char = ['@'];

        $staff_name = str_replace("@", ' @ ',  $staff_name);
        $array_name = explode(" ", $staff_name);
        $s_email = "";
        $case = null;
        for ($i = 0; $i < count($array_name); $i++) {
            if (empty($array_name[$i])) {
                array_splice($array_name, $i, 1);
            }
        }
        for ($i = 0; $i < count($array_name); $i++) {
            for ($j = 0; $j < count($invalid_name); $j++) {
                if (strcasecmp($array_name[$i], $invalid_name[$j]) == 0) {
                    $case = 1;
                    break;
                }
            }
        }
        for ($i = 0; $i < count($array_name); $i++) {
            for ($j = 0; $j < count($common_name); $j++) {
                if (strcasecmp($array_name[$i], $common_name[$j]) == 0) {
                    array_splice($array_name, $i, 1);
                }
            }
        }
        for ($i = 0; $i < count($array_name); $i++) {
            if (($i + 1) < count($array_name)) {
                if (strpos($array_name[$i + 1], '@') !== false) {
                    array_splice($array_name, $i, 1);
                }
            }
            for ($j = 0; $j < count($unwanted_char); $j++) {
                if (strpos($array_name[$i], $unwanted_char[$j]) !== false) {
                    array_splice($array_name, $i, 1);
                }
            }
        }

        switch ($case) {
            case '1':
                for ($i = 0; $i < count($array_name); $i++) {
                    $flag = true;
                    if (
                        strcasecmp('bin', $array_name[$i]) == 0 ||
                        strcasecmp('binti', $array_name[$i]) == 0 ||
                        strcasecmp('bte', $array_name[$i]) == 0 ||
                        strcasecmp('A\P', $array_name[$i]) == 0 ||
                        strcasecmp('A\L', $array_name[$i]) == 0 ||
                        strcasecmp('anak', $array_name[$i]) == 0
                    ) {
                        $array_name[$i] = '.';
                    }
                    if ($flag) {
                        $s_email = $s_email . $array_name[$i];
                    }
                }
                $s_email = $s_email . '@ums.edu.my';

                break;
            default:
                if (count($array_name) >= 4) {
                    $s_email = $array_name[0] . '.' . $array_name[1] . '@ums.edu.my';
                } elseif (count($array_name) > 2) {
                    $s_email = $array_name[0] . $array_name[1] . '.' . $array_name[2] . '@ums.edu.my';
                } elseif (count($array_name) > 1) {
                    $s_email = $array_name[0] . '.' . $array_name[1] . '@ums.edu.my';
                } else {
                    $s_email = $array_name[0] . '@ums.edu.my';
                }
                break;
        }
        return $s_email;
    }

    public function actionTestEmailSuggestion()
    {
        $model = new Tblprcobiodata();
        $model->scenario = 'test';
        if ($model->load(Yii::$app->request->post())) {

            //email suggestion;
            $s_email = $this->emailSuggestion($model->CONm);
            $validation = $this->validateEmail($s_email);
            if ($validation['flag'] == false) {
                $flag = false;
                $msg = $validation['message'];
            } else {
                $flag = true;
                $msg = null;
                $model->COEmail = $s_email;
            }
        }

        return $this->render('test_email', [
            'model' => $model,
        ]);
    }

    public function actionTestAd($ad)
    {

        $res = Yii::$app->ActiveDirectory->AdEmailExist($ad, 'email');

        var_dump($res);
        die;
    }
    public function actionUpdateAd($ad, $icno)
    {

        $res = Yii::$app->ActiveDirectory->Update($ad, $icno);

        var_dump($res);
        die;
    }

    public function actionLantikPhs()
    {

        $model = new Tblprcobiodata();
        $model->scenario = 'phs';
        $model->_action = 'lantikphs';
        if (Yii::$app->request->post('janaemail') == 'janaemail') {
            $model->load(Yii::$app->request->post());
            if (!empty($model->CONm)) {
                //email suggestion;
                $s_email = $this->emailSuggestion($model->CONm);
                $model->COEmail = $s_email;
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sila masukkan nama kakitangan terlebih dahulu.']);
            }
        } elseif ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->CONm = strtoupper($model->CONm);
            $model->startDateSandangan = $model->startDateLantik;
            $model->Status = '1';
            $model->startDateStatus = $model->startDateLantik;
            $new_id = substr($model->COOldID, -5) . substr($model->ICNO, -4);
            $model->COOPass =  md5($new_id);

            //Maklumat Jawatan, JFPIU & Kampus Hakiki
            $model->DeptId_hakiki = $model->DeptId;
            $model->campus_id_hakiki = $model->campus_id;
            $model->gredJawatan_2 = $model->gredJawatan;

            //emel validation//
            $validation = $this->validateEmail($model->COEmail);
            if ($validation['flag']) {

                //--------------------insert model lain yg berkaitan----------------------------------------//
                if ($model->statLantikan == '6' || $model->statLantikan == '7') {
                    $ConfirmStatusCd = '8'; //Tidak Kaitan Dengan Proses Pengesahan			
                    $PsnStatusCd = '04'; //04:Tidak Layak Memilih
                    $PsnAthyCd = '99'; //99:Tiada Berkaitan
                } else {
                    if ($model->statLantikan == '1') {
                        $ConfirmStatusCd = '2';    //Dalam Percubaan Lantikan Pertama
                        $PsnStatusCd = '03'; //03:Belum Memilih
                        $PsnAthyCd = '99'; //99:Tiada Berkaitan
                    } elseif ($model->statLantikan == '3') {
                        $ConfirmStatusCd = '8'; //Tidak Kaitan Dengan Proses Pengesahan
                        $PsnStatusCd = '04'; //04:Tidak Layak Memilih
                        $PsnAthyCd = '99'; //99:Tiada Berkaitan
                    } else {
                        $ConfirmStatusCd = '8'; //Tidak Kaitan Dengan Proses Pengesahan
                        $PsnStatusCd = '04'; //04:Tidak Layak Memilih
                        $PsnAthyCd = '99'; //99:Tiada Berkaitan
                    }
                }

                //creating new umsper; //phs tidak akan guna 's' ;
                // $prev_umsper = Umsper::find()->orderBy(['COOldIDNo' => SORT_DESC])->one();
                // $COOldIDNo = sprintf("%05s", ($prev_umsper->COOldIDNo + 1));
                // $umsper_date = explode("-", $model->startDateStatus);
                // $COOldIDDt = date("ymd", mktime(0, 0, 0, $umsper_date[1], $umsper_date[2], $umsper_date[0]));
                // $COOldID = $COOldIDDt . '-' . $COOldIDNo;
                // $model->COOldID = $COOldID;
                // $model->COOUCTelNo = '1' . $COOldIDNo;

                $prev_umsper = Umsperpks::find()->orderBy(['COOldIDNo' => SORT_DESC])->one();
                $COOldIDNo = sprintf("%05s", ($prev_umsper->COOldIDNo + 1));
                $umsper_date = explode("-", $model->startDateStatus);
                $COOldIDDt = date("ymd", mktime(0, 0, 0, $umsper_date[1], $umsper_date[2], $umsper_date[0]));
                $COOldID = $COOldIDDt . '-' . $COOldIDNo . '(S)';
                $model->COOldID = $COOldID;
                $model->COOUCTelNo = '1' . $COOldIDNo;

                //set probtnenddt based on register date
                $next3year = mktime(0, 0, 0, $umsper_date[1], $umsper_date[2], $umsper_date[0] + 3);
                $ProbtnEndDt = date('Y-m-d', $next3year);

                //set move month based on register date
                $movemonth = ($umsper_date[1] < '04' && $umsper_date[1] > '00' ? '01' : ($umsper_date[1] < '07' && $umsper_date[1] > '03' ? '04' : ($umsper_date[1] < '10' && $umsper_date[1] > '06' ? '07' : '10')));

                //------------------------------------start saving all related models------------------------------------------//
                if ($model->save()) {

                    //HR: insert new record on umsper table
                    $model_umsper = new Umsperpks();
                    $model_umsper->ICNO = $model->ICNO;
                    $model_umsper->JobId = $model->gredJawatan;
                    $model_umsper->DeptId = $model->DeptId;
                    $model_umsper->campus_id = $model->campus_id;
                    $model_umsper->COOldID = $COOldID;
                    $model_umsper->StartDate = $model->startDateLantik;
                    $model_umsper->COOldIDDt = $COOldIDDt;
                    $model_umsper->COOldIDNo = $COOldIDNo;
                    if (!$model_umsper->save(false)) {
                        $icno = $model->ICNO;
                        Tblprcobiodata::deleteAll(['ICNO' => $icno]);
                        Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Terdapat data bertindih, sila cuba cuba sebentar lagi.']);
                        return $this->render('_lantikphs', [
                            'model' => $model,
                        ]);
                    }

                    //HR: insert new record on tblrscosandangan table
                    $model_sandangan = new Tblrscosandangan();
                    $model_sandangan->scenario = 'lantikan baru';
                    $model_sandangan->_action = 'lantikstafbaru';
                    $model_sandangan->ICNO = $model->ICNO;
                    $model_sandangan->gredjawatan = $model->gredJawatan;
                    $model_sandangan->sandangan_id = $model->statSandangan;
                    $model_sandangan->ApmtTypeCd = $model->ApmtTypeCd;
                    $model_sandangan->start_date = $model->startDateLantik;
                    $model_sandangan->save(false);

                    //HR: insert new record on tblrscoapmtstatus table
                    $model_apmtstatus = new Tblrscoapmtstatus();
                    //$model_apmtstatus->scenario='new';
                    $model_apmtstatus->ICNO = $model->ICNO;
                    $model_apmtstatus->ApmtStatusCd = $model->statLantikan;
                    $model_apmtstatus->ApmtStatusStDt = $model->startDateLantik;
                    $model_apmtstatus->ApmtStatusEndDt = $model->endDateLantik;
                    $model_apmtstatus->save(false);
                    //HR: insert new record on tblrscoservstatus table
                    $model_servstatus = new Tblrscoservstatus();
                    //$model_servstatus->scenario='new';
                    $model_servstatus->ICNO = $model->ICNO;
                    $model_servstatus->ServStatusCd = '1';
                    $model_servstatus->ServStatusDtl = '1';
                    $model_servstatus->ServStatusStDt = $model->startDateLantik;
                    $model_servstatus->save(false);

                    //HR: insert new record on tblpreduach table
                    $model_eduach = new Tblpendidikan();
                    $model_eduach->ICNO = $model->ICNO;
                    $model_eduach->InstCd = '999';
                    $model_eduach->HighestEduLevelCd = $model->HighestEduLevelCd;
                    $model_eduach->MajorCd = '0000';
                    $model_eduach->SponsorshipCd = '0000';
                    $model_eduach->EduCertTitle = Pendidikantertinggi::find()->where(['HighestEduLevelCd' => $model->HighestEduLevelCd])->one()->HighestEduLevel;
                    $model_eduach->OverallGrade = 'PASS';
                    $model_eduach->ConfermentDt = $model->ConfermentDt;
                    $model_eduach->AcrtdEduAch = '1';
                    $model_eduach->save(false);

                    //HR: insert new record on tblpenempatan table
                    $model_penempatan_pertama = new Tblpenempatan();
                    // $model_penempatan_pertama->scenario = 'lantikan baru';
                    $model_penempatan_pertama->_action = 'lantikstafbaru';
                    $model_penempatan_pertama->ICNO = $model->ICNO;
                    $model_penempatan_pertama->date_start = $model->startDateLantik;
                    $model_penempatan_pertama->date_update = date('Y-m-d H:i:s');
                    $model_penempatan_pertama->dept_id = $model->DeptId;
                    $model_penempatan_pertama->campus_id = $model->campus_id;
                    $model_penempatan_pertama->reason_id = 1;
                    $model_penempatan_pertama->remark = 'Penempatan asal';
                    $model_penempatan_pertama->letter_order_refno = '-';
                    $model_penempatan_pertama->date_letter_order = $model->startDateLantik;
                    $model_penempatan_pertama->letter_refno = 'Penempatan asal';
                    $model_penempatan_pertama->update_by = Yii::$app->user->getId();
                    $model_penempatan_pertama->save(false);

                    //HR: insert new record on tblrscoaptathy table
                    $model_tblrscoaptathy = new Tblrscoaptathy();
                    $model_tblrscoaptathy->ICNO = $model->ICNO;
                    $model_tblrscoaptathy->AptAthyCd = '387';
                    $model_tblrscoaptathy->ICNOHeadServ = Yii::$app->MP->getVC(); //temporary ic datuk kamaruzaman, later will be auto detect VC ums
                    $model_tblrscoaptathy->AptAthyStDt = $model->startDateLantik;
                    $model_tblrscoaptathy->save(false);

                    //HR: insert new record on tblrscoservload table
                    $model_tblrscoservload = new Tblrscoservload();
                    $model_tblrscoservload->ICNO = $model->ICNO;
                    $model_tblrscoservload->ServLoadCd = '1'; //temporary 1 for sepenuh masa
                    $model_tblrscoservload->ServLoadStDt = $model->startDateLantik;
                    $model_tblrscoservload->save(false);

                    $model_tblrscoconfirmstatus = new Tblrscoconfirmstatus();
                    $model_tblrscoconfirmstatus->ICNO = $model->ICNO;
                    $model_tblrscoconfirmstatus->ConfirmStatusCd = $ConfirmStatusCd; //temporary 7 Dalam Proses Pengesahan or 8 Tidak Kaitan Dengan Proses Pengesahan
                    $model_tblrscoconfirmstatus->ConfirmStatusStDt = $model->startDateLantik;
                    $model_tblrscoconfirmstatus->save(false);

                    if ($model->statLantikan == '1') { //need to remove i think
                        //HR: insert new record on tblrscoprobtnperiod table
                        $model_tblrscoprobtnperiod = new Tblrscoprobtnperiod();
                        $model_tblrscoprobtnperiod->ICNO = $model->ICNO;
                        $model_tblrscoprobtnperiod->ProbtnPeriod = '36'; //36 bulan max
                        $model_tblrscoprobtnperiod->ProbtnStDt = $model->startDateLantik;
                        $model_tblrscoprobtnperiod->ProbtnEndDt = $ProbtnEndDt;
                        $model_tblrscoprobtnperiod->ProbtnPeriodMin = '12'; //12 bulan min
                        $model_tblrscoprobtnperiod->save(false);
                    }

                    //HR: insert new record on tblrscopsnstatus table
                    $model_tblrscopsnstatus = new Tblrscopsnstatus();
                    $model_tblrscopsnstatus->ICNO = $model->ICNO;
                    $model_tblrscopsnstatus->PsnStatusCd = $PsnStatusCd; //temporary 03:Belum Memilih,  04:Tidak Layak Memilih, 05:Tidak Berkaitan (Kontrak)
                    $model_tblrscopsnstatus->PsnStatusNo = '';
                    $model_tblrscopsnstatus->PsnIncomeTaxNo = '';
                    $model_tblrscopsnstatus->PsnEpfNo = '';
                    $model_tblrscopsnstatus->PsnStatusStDt = $model->startDateLantik;
                    $model_tblrscopsnstatus->save(false);

                    //HR: insert new record on tblrscopsnathy table
                    $model_tblrscoaptathy = new Tblrscopsnathy();
                    $model_tblrscoaptathy->ICNO = $model->ICNO;
                    $model_tblrscoaptathy->PsnAthyCd = $PsnAthyCd; //99 Tiada Berkaitan, 0 Tidak Berkenaan - (Lantikan Kontrak / Sementara) 
                    $model_tblrscoaptathy->PsnAthyStDt = $model->startDateLantik;
                    $model_tblrscoaptathy->save(false);

                    //HR: insert new record on tblrscosaltype table
                    $model_tblrscosaltype = new Tblrscosaltype();
                    $model_tblrscosaltype->ICNO = $model->ICNO;
                    $model_tblrscosaltype->SalTypeCd = '01'; //01 bulanan
                    $model_tblrscosaltype->SalStatus = '1'; //1 matrix gaji
                    $model_tblrscosaltype->SalTypeStDt = $model->startDateLantik;
                    $model_tblrscosaltype->save(false);

                    //HR: insert new record on tblrscoservtype table
                    $model_tblrscoservtype = new Tblrscoservtype();
                    $model_tblrscoservtype->ICNO = $model->ICNO;
                    $model_tblrscoservtype->ServTypeStDt = $model->startDateLantik;
                    $model_tblrscoservtype->ServTypeCd = 'SSM'; //SSM: Sistem saraan Malaysia
                    $model_tblrscoservtype->save(false);

                    //HR: insert new record on tblrscosalmovemth table
                    $model_tblrscosalmovemth = new Tblrscosalmovemth();
                    $model_tblrscosalmovemth->ICNO = $model->ICNO;
                    $model_tblrscosalmovemth->SalMoveMth = $movemonth;
                    $model_tblrscosalmovemth->SalMoveMthType = '1';
                    $model_tblrscosalmovemth->SalMoveMthStDt = $model->startDateLantik;
                    $model_tblrscosalmovemth->save(false);

                    //HR: insert new record on tblrscofileno table
                    $model_tblrscofileno = new Tblrscofileno();
                    $model_tblrscofileno->ICNO = $model->ICNO;
                    $model_tblrscofileno->COFileNo = $COOldID;
                    $model_tblrscofileno->COFileNoEftvDt = $model->startDateLantik;
                    $model_tblrscofileno->save(false);

                    if ($model->ApmtTypeCd == '2') {
                        //insert WP
                        $model_wp = new TblWP();
                        $model_wp->wp_id = '40';
                        $model_wp->icno = $model->ICNO;
                        $model_wp->remark = 'PELAJAR LATIHAN INDUSTRI';
                        $model_wp->entry_dt = date('Y-m-d H:i:s');
                        $model_wp->start_date = date('Y-m-d');
                        $model_wp->status = 'APPROVED';
                        $model_wp->save(false);
                    }

                    //send notification to IT admin
                    $array_admin = ['940402125181', '840813125655', '811212125745'];
                    for ($i = 0; $i < count($array_admin); $i++) {
                        $model_noty = new Notification();
                        $model_noty->icno = $array_admin[$i];
                        $model_noty->title = 'LANTIKAN KAKITANGAN PSH';
                        $model_noty->content = 'Semakkan maklumat kakitangan psh yang baru dilantik. No IC = ' . $model->ICNO
                            . '; No IC melantik = ' . Yii::$app->user->getId();
                        $model_noty->ntf_dt = date('Y-m-d H:i:s');
                        $model_noty->save(false);
                    }

                    return $this->redirect([
                        'biodata/adminview',
                        'id' => $model->ICNO,
                    ]);
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => $validation['message']]);
            }
        }

        return $this->render('_lantikphs', [
            'model' => $model,
        ]);
    }

    public function actionLantikKhas()
    {

        $model = new Tblprcobiodata();
        $model->scenario = 'khas';
        $model->_action = 'lantikkhas';
        if (Yii::$app->request->post('janaemail') == 'janaemail') {
            $model->load(Yii::$app->request->post());
            if (!empty($model->CONm)) {
                //email suggestion;
                $s_email = $this->emailSuggestion($model->CONm);
                $model->COEmail = $s_email;
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sila masukkan nama kakitangan terlebih dahulu.']);
            }
        } elseif ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->CONm = strtoupper($model->CONm);
            $model->startDateSandangan = $model->startDateLantik;
            $model->Status = '1';
            $model->startDateStatus = $model->startDateLantik;
            $new_id = substr($model->COOldID, -5) . substr($model->ICNO, -4);
            $model->COOPass =  md5($new_id);

            //Maklumat Jawatan, JFPIU & Kampus Hakiki
            $model->DeptId_hakiki = $model->DeptId;
            $model->campus_id_hakiki = $model->campus_id;
            $model->gredJawatan_2 = $model->gredJawatan;

            //emel validation//
            $validation = $this->validateEmail($model->COEmail);
            if ($validation['flag']) {

                

                    $prev_umsper = Umsperpks::find()->orderBy(['COOldIDNo' => SORT_DESC])->one();
                    $COOldIDNo = sprintf("%05s", ($prev_umsper->COOldIDNo + 1));
                    $umsper_date = explode("-", $model->startDateStatus);
                    $COOldIDDt = date("ymd", mktime(0, 0, 0, $umsper_date[1], $umsper_date[2], $umsper_date[0]));
                    $COOldID = $COOldIDDt . '-' . $COOldIDNo . '(S)';
                    $model->COOldID = $COOldID;
                    $model->COOUCTelNo = '1' . $COOldIDNo;

                    $ConfirmStatusCd = '8'; //Tidak Kaitan Dengan Proses Pengesahan
                    $PsnStatusCd = '04'; //04:Tidak Layak Memilih
                    $PsnAthyCd = '99'; //99:Tiada Berkaitan

                    $next3year = mktime(0, 0, 0, $umsper_date[1], $umsper_date[2], $umsper_date[0] + 3);
                    $ProbtnEndDt = date('Y-m-d', $next3year);

                    //set move month based on register date
                    $movemonth = ($umsper_date[1] < '04' && $umsper_date[1] > '00' ? '01' : ($umsper_date[1] < '07' && $umsper_date[1] > '03' ? '04' : ($umsper_date[1] < '10' && $umsper_date[1] > '06' ? '07' : '10')));
                
                if ($model->save()) {
                    //------------------------begin saving all related models------------------------------------------------//

                    //HR: insert new record on umsper table
                    $model_umsper = new Umsperpks();
                    $model_umsper->ICNO = $model->ICNO;
                    $model_umsper->JobId = $model->gredJawatan;
                    $model_umsper->DeptId = $model->DeptId;
                    $model_umsper->campus_id = $model->campus_id;
                    $model_umsper->COOldID = $COOldID;
                    $model_umsper->StartDate = $model->startDateLantik;
                    $model_umsper->COOldIDDt = $COOldIDDt;
                    $model_umsper->COOldIDNo = $COOldIDNo;
                    if (!$model_umsper->save(false)) {
                        $icno = $model->ICNO;
                        Tblprcobiodata::deleteAll(['ICNO' => $icno]);
                        Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Terdapat data bertindih, sila cuba cuba sebentar lagi.']);
                        return $this->render('_lantikkhas', [
                            'model' => $model,
                        ]);
                    }

                    //HR: insert new record on tblrscosandangan table
                    $model_sandangan = new Tblrscosandangan();
                    //$model_sandangan->scenario='new';
                    $model_sandangan->ICNO = $model->ICNO;
                    $model_sandangan->_action = 'lantikkhas';
                    $model_sandangan->gredjawatan = $model->gredJawatan;
                    $model_sandangan->sandangan_id = $model->statSandangan;
                    $model_sandangan->ApmtTypeCd = $model->ApmtTypeCd;
                    $model_sandangan->start_date = $model->startDateLantik;
                    $model_sandangan->save(false);

                    //HR: insert new record on tblrscoapmtstatus table
                    $model_apmtstatus = new Tblrscoapmtstatus();
                    //$model_apmtstatus->scenario='new';
                    $model_apmtstatus->ICNO = $model->ICNO;
                    $model_apmtstatus->ApmtStatusCd = $model->statLantikan;
                    $model_apmtstatus->ApmtStatusStDt = $model->startDateLantik;
                    $model_apmtstatus->ApmtStatusEndDt = $model->endDateLantik;
                    $model_apmtstatus->save(false);
                    //HR: insert new record on tblrscoservstatus table
                    $model_servstatus = new Tblrscoservstatus();
                    //$model_servstatus->scenario='new';
                    $model_servstatus->ICNO = $model->ICNO;
                    $model_servstatus->ServStatusCd = '1';
                    $model_servstatus->ServStatusDtl = '1';
                    $model_servstatus->ServStatusStDt = $model->startDateLantik;
                    $model_servstatus->save(false);

                    //HR: insert new record on tblrscoapmtstatus table
                    $model_apmtstatus = new Tblrscoapmtstatus();
                    //$model_apmtstatus->scenario='new';
                    $model_apmtstatus->ICNO = $model->ICNO;
                    $model_apmtstatus->ApmtStatusCd = $model->statLantikan;
                    $model_apmtstatus->ApmtStatusStDt = $model->startDateLantik;
                    $model_apmtstatus->ApmtStatusEndDt = $model->endDateLantik;
                    $model_apmtstatus->save();
                    //HR: insert new record on tblrscoservstatus table
                    $model_servstatus = new Tblrscoservstatus();
                    //$model_servstatus->scenario='new';
                    $model_servstatus->ICNO = $model->ICNO;
                    $model_servstatus->ServStatusCd = '1';
                    $model_servstatus->ServStatusDtl = '1';
                    $model_servstatus->ServStatusStDt = $model->startDateLantik;
                    $model_servstatus->save();

                    //HR: insert new record on tblpenempatan table
                    $model_penempatan_pertama = new Tblpenempatan();
                    $model_penempatan_pertama->_action = 'lantikkhas';
                    $model_penempatan_pertama->ICNO = $model->ICNO;
                    $model_penempatan_pertama->date_start = $model->startDateLantik;
                    $model_penempatan_pertama->date_update = date('Y-m-d H:i:s');
                    $model_penempatan_pertama->dept_id = $model->DeptId;
                    $model_penempatan_pertama->campus_id = $model->campus_id;
                    $model_penempatan_pertama->reason_id = 1;
                    $model_penempatan_pertama->remark = 'Penempatan asal';
                    $model_penempatan_pertama->letter_order_refno = '-';
                    $model_penempatan_pertama->date_letter_order = $model->startDateLantik;
                    $model_penempatan_pertama->letter_refno = 'Penempatan asal';
                    $model_penempatan_pertama->update_by = Yii::$app->user->getId();
                    $model_penempatan_pertama->save(false);

                    //HR: insert new record on tblrscoaptathy table
                    $model_tblrscoaptathy = new Tblrscoaptathy();
                    $model_tblrscoaptathy->ICNO = $model->ICNO;
                    $model_tblrscoaptathy->AptAthyCd = '387';
                    $model_tblrscoaptathy->ICNOHeadServ = Yii::$app->MP->getVC(); //temporary ic datuk kamaruzaman, later will be auto detect VC ums
                    $model_tblrscoaptathy->AptAthyStDt = $model->startDateLantik;
                    $model_tblrscoaptathy->save(false);

                    //HR: insert new record on tblrscoservload table
                    $model_tblrscoservload = new Tblrscoservload();
                    $model_tblrscoservload->ICNO = $model->ICNO;
                    $model_tblrscoservload->ServLoadCd = '1'; //temporary 1 for sepenuh masa
                    $model_tblrscoservload->ServLoadStDt = $model->startDateLantik;
                    $model_tblrscoservload->save(false);

                    //HR: insert new record on tblrscoconfirmstatus table
                    $model_tblrscoconfirmstatus = new Tblrscoconfirmstatus();
                    $model_tblrscoconfirmstatus->ICNO = $model->ICNO;
                    $model_tblrscoconfirmstatus->ConfirmStatusCd = $ConfirmStatusCd; //temporary 7 Dalam Proses Pengesahan or 8 Tidak Kaitan Dengan Proses Pengesahan
                    $model_tblrscoconfirmstatus->ConfirmStatusStDt = $model->startDateLantik;
                    $model_tblrscoconfirmstatus->save(false);

                    //HR: insert new record on tblrscopsnstatus table
                    $model_tblrscopsnstatus = new Tblrscopsnstatus();
                    $model_tblrscopsnstatus->ICNO = $model->ICNO;
                    $model_tblrscopsnstatus->PsnStatusCd = $PsnStatusCd; //temporary 03:Belum Memilih,  04:Tidak Layak Memilih, 05:Tidak Berkaitan (Kontrak)
                    $model_tblrscopsnstatus->PsnStatusNo = '';
                    $model_tblrscopsnstatus->PsnIncomeTaxNo = '';
                    $model_tblrscopsnstatus->PsnEpfNo = '';
                    $model_tblrscopsnstatus->PsnStatusStDt = $model->startDateLantik;
                    $model_tblrscopsnstatus->save(false);

                    //HR: insert new record on tblrscopsnathy table
                    $model_tblrscoaptathy = new Tblrscopsnathy();
                    $model_tblrscoaptathy->ICNO = $model->ICNO;
                    $model_tblrscoaptathy->PsnAthyCd = $PsnAthyCd; //99 Tiada Berkaitan, 0 Tidak Berkenaan - (Lantikan Kontrak / Sementara) 
                    $model_tblrscoaptathy->PsnAthyStDt = $model->startDateLantik;
                    $model_tblrscoaptathy->save(false);

                    //HR: insert new record on tblrscosaltype table
                    $model_tblrscosaltype = new Tblrscosaltype();
                    $model_tblrscosaltype->ICNO = $model->ICNO;
                    $model_tblrscosaltype->SalTypeCd = '01'; //01 bulanan
                    $model_tblrscosaltype->SalStatus = '1'; //1 matrix gaji
                    $model_tblrscosaltype->SalTypeStDt = $model->startDateLantik;
                    $model_tblrscosaltype->save(false);

                    //HR: insert new record on tblrscoservtype table
                    $model_tblrscoservtype = new Tblrscoservtype();
                    $model_tblrscoservtype->ICNO = $model->ICNO;
                    $model_tblrscoservtype->ServTypeStDt = $model->startDateLantik;
                    $model_tblrscoservtype->ServTypeCd = 'SSM'; //SSM: Sistem saraan Malaysia
                    $model_tblrscoservtype->save(false);

                    //HR: insert new record on tblrscosalmovemth table
                    $model_tblrscosalmovemth = new Tblrscosalmovemth();
                    $model_tblrscosalmovemth->ICNO = $model->ICNO;
                    $model_tblrscosalmovemth->SalMoveMth = $movemonth;
                    $model_tblrscosalmovemth->SalMoveMthType = '1';
                    $model_tblrscosalmovemth->SalMoveMthStDt = $model->startDateLantik;
                    $model_tblrscosalmovemth->save(false);

                    //HR: insert new record on tblrscofileno table
                    $model_tblrscofileno = new Tblrscofileno();
                    $model_tblrscofileno->ICNO = $model->ICNO;
                    $model_tblrscofileno->COFileNo = $COOldID;
                    $model_tblrscofileno->COFileNoEftvDt = $model->startDateLantik;
                    $model_tblrscofileno->save(false);

                    //HR: insert new record on tblrscofileno table
                    $model_tblrscofileno = new Tblrscofileno();
                    $model_tblrscofileno->ICNO = $model->ICNO;
                    $model_tblrscofileno->COFileNo = $COOldID;
                    $model_tblrscofileno->COFileNoEftvDt = $model->startDateLantik;
                    $model_tblrscofileno->save();

                    if ($model->ApmtTypeCd == '2') {

                        //insert staf_keselamatan
                        $gredKeselamatan = ['KP11', 'KP14', 'KP16', 'KP18', 'KP19', 'KP22', 'KP27', 'KP29', 'KP32'];
                        if (in_array($model->jawatan->gred, $gredKeselamatan)) {
                            $model_keselamatan = new TblStaffKeselamatan();
                            $model_keselamatan->staff_icno = $model->ICNO;
                            $model_keselamatan->added_by = 'LANTIKAN PERTAMA';
                            $model_keselamatan->created_at = date('Y-m-d H:i:s');
                            $model_keselamatan->campus_id = $model->campus_id;
                            $model_keselamatan->save(false);
                        }

                        //insert WP
                        $model_wp = new TblWP();
                        $model_wp->wp_id = '40';
                        $model_wp->icno = $model->ICNO;
                        $model_wp->remark = 'LANTIKAN PERTAMA';
                        $model_wp->entry_dt = date('Y-m-d H:i:s');
                        $model_wp->start_date = date('Y-m-d');
                        $model_wp->status = 'APPROVED';
                        $model_wp->save(false);

                        //insert klinik panel
                        if (!in_array($model->statLantikan, [6, 7])) {
                            $tuntutan_value = 1000;
                            if (in_array($model->MrtlStatusCd, ['2', '3', '4', '5'])) {
                                $tuntutan_value = 2000;
                            }
                            $model_klinik = new Tblmaxtuntutan();
                            $model_klinik->max_icno = $model->ICNO;
                            $model_klinik->max_tuntutan = $tuntutan_value;
                            $model_klinik->current_balance = $tuntutan_value;
                            $model_klinik->last_update = date('Y-m-d H:i:s');
                            $model_klinik->last_updater = 'LANTIKAN';
                            $model_klinik->save(false);
                        }
                    }

                    $array_admin = ['940402125181', '840813125655', '811212125745'];
                    for ($i = 0; $i < count($array_admin); $i++) {
                        $model_noty = new Notification();
                        $model_noty->icno = $array_admin[$i];
                        $model_noty->title = 'LANTIKAN KAKITANGAN KHAS';
                        $model_noty->content = 'Semakkan maklumat kakitangan KHAS yang baru dilantik. No IC = ' . $model->ICNO
                        . '; No IC melantik = ' . Yii::$app->user->getId();
                        $model_noty->ntf_dt = date('Y-m-d H:i:s');
                        $model_noty->save(false);
                    }


                    //------------------------end of saving all related models------------------------------------------------//
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Semua data berjaya disimpan.']);

                    return $this->redirect([
                        'biodata/adminview',
                        'id' => $model->ICNO,
                    ]);
                }


            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => $validation['message']]);
            }
        }

        return $this->render('_lantikkhas', [
            'model' => $model,
        ]);
    }

    public function actionLssuIndex($AT = null)
    {
        $carian = new TblprcobiodataSearch();
        $dataProvider = $carian->carianLantikan(Yii::$app->request->queryParams);


        return $this->render('_lantiksemulastafumsindex', [
            'carian' => $carian,
            'model' => $dataProvider,
        ]);
    }

    public function actionLantikSemulaStafUms($id)
    {
        $model = $this->findModel($id);
        $umsper_date = explode("-", date("Y-m-d"));
        $umsper_date = date("ymd", mktime(0, 0, 0, $umsper_date[1], $umsper_date[2], $umsper_date[0]));
        $umsper_date = '******';
        $umsper_no = explode("-", $model->COOldID);
        $umsper_no = ' *****'; //$umsper_no[1];
        $model->scenario = 'kemaskini';
        $isPks = false;
        $prev_model = Tblprcobiodata::find()->where(['ICNO' => $id])->one();
        if (empty($model)) {
            return $this->redirect(['index']); //exit();
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->Status = '1';
            $umsper_date = explode("-", $model->startDateLantik);
            $COOldIDDt = date("ymd", mktime(0, 0, 0, $umsper_date[1], $umsper_date[2], $umsper_date[0]));
            $list_umsper = Umsper::find()->where(['ICNO' => $model->ICNO])->orderBy(['COOldIDNo' => SORT_DESC])->one();

            // if pks,kontrak jbtn,former staf n empty	
            if ($prev_model->statLantikan == 6 || $prev_model->statLantikan == 7) {

                $list_umsper_new = Umsperpks::find()->where(['ICNO' => $model->ICNO])->orderBy(['COOldIDNo' => SORT_DESC])->one();
                if (empty($list_umsper_new)) {

                    Yii::$app->session->setFlash('alert', ['title' => 'Fail', 'type' => 'error', 'msg' => 'UMSPER(S) NOT FOUND. Please Contact Technical Incharge.']);
                    return $this->redirect(['index']); //exit();
                }

                //masih pakai 's' lerrr pulakkk;
                if ($model->statLantikan == 6 || $model->statLantikan == 7) { //lantikan semasa adalah PSH atau Kontrak Jabatan;
                    $isPks = true;
                    $running_no = sprintf("%05s", $list_umsper_new->COOldIDNo);
                    $COOldIDNo = $running_no . '(S)';
                } else {
                    if (empty($list_umsper)) {
                        $list_umsper = Umsper::find()->orderBy(['COOldIDNo' => SORT_DESC])->one();
                        $list_umsper_new = $list_umsper->COOldIDNo + 1;
                        $running_no = sprintf("%05s", $list_umsper_new);
                    } else {
                        $running_no = sprintf("%05s", $list_umsper->COOldIDNo);
                    }

                    $COOldIDNo = $running_no;
                }
            } else {

                if (empty($list_umsper)) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Fail', 'type' => 'error', 'msg' => 'UMSPER NOT FOUND. Please Contact Technical Incharge.']);
                    return $this->redirect(['index']); //exit();
                }
                $COOldIDNo = $list_umsper->COOldIDNo;
            }


            $COOldID = $COOldIDDt . '-' . $COOldIDNo;
            $model->COOldID = $COOldID; //create new umsper;
            $model->COOUCTelNo = '1' . $COOldIDNo;

            //check if gredJawatan,statSandangan is changing
            if ($prev_model->gredJawatan != $model->gredJawatan || $prev_model->statSandangan != $model->statSandangan) {
                $model->startDateSandangan = $model->startDateLantik;
                $active_tblrscosandangan = true;
            }
            //check if statLantikan is changing
            $apmtstatus = Tblrscoapmtstatus::findAll(['ICNO' => $model->ICNO]);
            if ($prev_model->statLantikan != 1 || $prev_model->Status != 1 || $apmtstatus == null)
                $active_tblrscoapmtstatus = true;

            //check if Status is changing
            $servstatus = Tblrscoservstatus::findAll(['ICNO' => $model->ICNO]);
            if ($prev_model->Status != 1 || $servstatus == null) {
                $model->Status = '1';
                $model->startDateStatus = $model->startDateLantik;
                $active_tblrscoservstatus = true;
            }
            //check if HighestEduLevelCd, ConfermentDt is changing
            if ($prev_model->HighestEduLevelCd != $model->HighestEduLevelCd || $prev_model->ConfermentDt != $model->ConfermentDt)
                $active_tblpreduach = true;

            //check if DeptId,campus_id is changing
            if ($prev_model->DeptId != $model->DeptId || $prev_model->campus_id != $model->campus_id)
                $active_tblpenempatan = true;
            //check if aptathy is changing
            $aptathy = Tblrscoaptathy::findAll(['ICNO' => $model->ICNO]);
            if ($aptathy == null)
                $active_tblrscoaptathy = true;

            //check if servload is changing
            $servload = Tblrscoservload::findAll(['ICNO' => $model->ICNO]);
            if ($servload == null)
                $active_tblrscoservload = true;

            //check if wkghourbasis is changing
            // $wkghourbasis = tblrscowkghourbasis::model()->find('ICNO=:icno',array(':icno'=>$model->ICNO));
            // if($wkghourbasis==null) 
            // 	$active_tblrscowkghourbasis = true;	
            //check if psnstatus is changing
            $model_tblrscopsnstatus = Tblrscopsnstatus::find()->where(['ICNO' => $model->ICNO])->orderBy(['PsnStatusStDt' => SORT_DESC])->one();
            if ($model_tblrscopsnstatus == null)
                $active_tblrscopsnstatus = true;
            elseif ($model_tblrscopsnstatus->PsnStatusCd == '04' && $model->statLantikan == '1')
                $active_tblrscopsnstatus = true;

            //check if psnathy is changing // exist in table
            $psnathy = Tblrscopsnathy::findAll(['ICNO' => $model->ICNO]);
            if ($psnathy == null)
                $active_tblrscopsnathy = true;

            //check if saltype is changing // exist in table
            $saltype = Tblrscosaltype::findAll(['ICNO' => $model->ICNO]);
            if ($saltype == null)
                $active_tblrscosaltype = true;

            //check if servtype is changing // exist in table
            $servtype = Tblrscoservtype::findAll(['ICNO' => $model->ICNO]);
            if ($servtype == null)
                $active_tblrscoservtype = true;

            //--------------------------------------------------------------------------------------------------//
            //check value for confirmation status
            if ($model->statLantikan == '6' || $model->statLantikan == '7') {
                $ConfirmStatusCd = '8'; //Tidak Kaitan Dengan Proses Pengesahan					
                $PsnStatusCd = '04'; //04:Tidak Layak Memilih
                $PsnAthyCd = '99'; //99:Tiada Berkaitan
            } else {
                if ($model->statLantikan == '1') {
                    if ($model->ApmtTypeCd == '1') //Lantikan Semula Selepas Bersara
                        $ConfirmStatusCd = '4';    //Dalam Percubaan Lantikan Semula		
                    elseif ($model->ApmtTypeCd == '2') //Lantikan Pertama
                        $ConfirmStatusCd = '2';    //Dalam Percubaan Lantikan Pertama
                    elseif ($model->ApmtTypeCd == '3') //Kenaikan Pangkat Secara Lantikan			
                        $ConfirmStatusCd = '3';    //Dalam Percubaan Lantikan KPSL	
                    else //Lantikan Pegawai Sedang Berkhidmat
                        $ConfirmStatusCd = '4';    //Dalam Percubaan Lantikan Semula		

                    $PsnStatusCd = '03'; //03:Belum Memilih
                    $PsnAthyCd = '99'; //99:Tiada Berkaitan
                } elseif ($model->statLantikan == '3') {
                    $ConfirmStatusCd = '8'; //Tidak Kaitan Dengan Proses Pengesahan
                    $PsnStatusCd = '04'; //04:Tidak Layak Memilih
                    $PsnAthyCd = '99'; //99:Tiada Berkaitan
                } else {
                    $ConfirmStatusCd = '8'; //Tidak Kaitan Dengan Proses Pengesahan
                    $PsnStatusCd = '04'; //04:Tidak Layak Memilih
                    $PsnAthyCd = '99'; //99:Tiada Berkaitan
                }
            }

            //set probtnenddt based on register date
            $next3year = mktime(0, 0, 0, $umsper_date[1], $umsper_date[2], $umsper_date[0] + 3);
            $ProbtnEndDt = date('Y-m-d', $next3year);

            //set move month based on register date
            $movemonth = ($umsper_date[1] < '04' && $umsper_date[1] > '00' ? '01' : ($umsper_date[1] < '07' && $umsper_date[1] > '03' ? '04' : ($umsper_date[1] < '10' && $umsper_date[1] > '06' ? '07' : '10')));

            //salary gred value
            //$SalGrdCd = gredjawatan::findOne($model->gredJawatan);
            //------------------------------------saving--------------------------------------------------------//

            if ($model->save(false)) {
                if (isset($active_tblrscosandangan) == true) {
                    //JR: insert new record on tblrscosandangan table
                    $model_sandangan = new Tblrscosandangan();
                    $model_sandangan->ICNO = $model->ICNO;
                    $model_sandangan->gredjawatan = $model->gredJawatan;
                    $model_sandangan->sandangan_id = $model->statSandangan;
                    $model_sandangan->ApmtTypeCd = $model->ApmtTypeCd;
                    $model_sandangan->start_date = $model->startDateLantik;
                    $model_sandangan->save();
                }
                if (isset($active_tblrscoapmtstatus) == true) {
                    //JR: insert new record on tblrscoapmtstatus table
                    $model_tblrscoapmtstatus = new Tblrscoapmtstatus();
                    $model_tblrscoapmtstatus->ICNO = $model->ICNO;
                    $model_tblrscoapmtstatus->ApmtStatusCd = $model->statLantikan;
                    $model_tblrscoapmtstatus->ApmtStatusStDt = $model->startDateLantik;
                    $model_tblrscoapmtstatus->ApmtStatusEndDt = $model->endDateLantik;
                    $model_tblrscoapmtstatus->save();
                }
                if (isset($active_tblrscoservstatus) == true) {
                    //JR: insert new record on tblrscoservstatus table
                    $model_tblrscoservstatus = new Tblrscoservstatus();
                    $model_tblrscoservstatus->ICNO = $model->ICNO;
                    $model_tblrscoservstatus->ServStatusCd = '1';
                    $model_tblrscoservstatus->ServStatusDtl = '1';
                    $model_tblrscoservstatus->ServStatusStDt = $model->startDateLantik;
                    $model_tblrscoservstatus->save();
                }
                if (isset($active_tblpreduach) == true) {
                    //JR: insert new record on tblpreduach table
                    $model_eduach = new Tblpendidikan();
                    $model_eduach->ICNO = $model->ICNO;
                    $model_eduach->InstCd = '999';
                    $model_eduach->HighestEduLevelCd = $model->HighestEduLevelCd;
                    $model_eduach->MajorCd = '0000';
                    $model_eduach->SponsorshipCd = '0000';
                    $model_eduach->EduCertTitle = PendidikanTertinggi::find()->where(['HighestEduLevelCd' => $model->HighestEduLevelCd])->one()->HighestEduLevel;
                    $model_eduach->OverallGrade = 'PASS';
                    $model_eduach->ConfermentDt = $model->ConfermentDt;
                    $model_eduach->AcrtdEduAch = '1';
                    $model_eduach->save(false);
                }
                if (isset($active_tblpenempatan) == true) {
                    //JR: insert new record on tblpenempatan table
                    $model_penempatan = new TblPenempatan();
                    $model_penempatan->ICNO = $model->ICNO;
                    $model_penempatan->date_start = $model->startDateLantik;
                    $model_penempatan->date_update = date('Y-m-d H:i:s');
                    $model_penempatan->dept_id = $model->DeptId;
                    $model_penempatan->campus_id = $model->campus_id;
                    $model_penempatan->reason_id = 1;
                    $model_penempatan->remark = 'Lantikan Baru';
                    $model_penempatan->letter_order_refno = '-';
                    $model_penempatan->date_letter_order = $model->startDateLantik;
                    $model_penempatan->letter_refno = 'Lantikan Baru';
                    $model_penempatan->update_by = Yii::$app->user->getId();
                    $model_penempatan->save();
                }
                if (isset($active_tblrscoaptathy) == true) {
                    //JR: insert new record on tblrscoaptathy table
                    $model_tblrscoaptathy = new Tblrscoaptathy();
                    $model_tblrscoaptathy->ICNO = $model->ICNO;
                    $model_tblrscoaptathy->AptAthyCd = '387';
                    $model_tblrscoaptathy->ICNOHeadServ = '530121125351'; //temporary ic datuk kamaruzaman, later will be auto detect VC ums
                    $model_tblrscoaptathy->AptAthyStDt = $model->startDateLantik;
                    $model_tblrscoaptathy->save();
                }
                if (isset($active_tblrscoservload) == true) {
                    //JR: insert new record on tblrscoservload table
                    $model_tblrscoservload = new Tblrscoservload();
                    $model_tblrscoservload->ICNO = $model->ICNO;
                    $model_tblrscoservload->ServLoadCd = '1'; //temporary 1 for sepenuh masa
                    $model_tblrscoservload->ServLoadStDt = $model->startDateLantik;
                    $model_tblrscoservload->save();
                }
                // if(isset($active_tblrscowkghourbasis)==true) //will be in stars;
                // {				
                // 	//JR: insert new record on tblrscowkghourbasis table
                // 	$model_tblrscowkghourbasis=new tblrscowkghourbasis;
                // 	$model_tblrscowkghourbasis->ICNO = $model->ICNO;
                // 	$model_tblrscowkghourbasis->WkgHourBasisCd = 'WP2'; //temporary WP2
                // 	$model_tblrscowkghourbasis->WkgHourBasisStDt = $model->startDateLantik;
                // 	$model_tblrscowkghourbasis->save();		
                // }

                //JR: insert new record on tblrscoconfirmstatus table
                $model_tblrscoconfirmstatus = new Tblrscoconfirmstatus();
                $model_tblrscoconfirmstatus->ICNO = $model->ICNO;
                $model_tblrscoconfirmstatus->ConfirmStatusCd = $ConfirmStatusCd; //temporary 7 Dalam Proses Pengesahan or 8 Tidak Kaitan Dengan Proses Pengesahan
                $model_tblrscoconfirmstatus->ConfirmStatusStDt = $model->startDateLantik;
                $model_tblrscoconfirmstatus->save();

                if ($model->statLantikan == '1') {
                    //JR: insert new record on tblrscoprobtnperiod table
                    $model_tblrscoprobtnperiod = new Tblrscoprobtnperiod();
                    $model_tblrscoprobtnperiod->ICNO = $model->ICNO;
                    $model_tblrscoprobtnperiod->ProbtnPeriod = '36'; //36 bulan max
                    $model_tblrscoprobtnperiod->ProbtnStDt = $model->startDateLantik;
                    $model_tblrscoprobtnperiod->ProbtnEndDt = $ProbtnEndDt;
                    $model_tblrscoprobtnperiod->ProbtnPeriodMin = '12'; //12 bulan min
                    $model_tblrscoprobtnperiod->save();
                }
                if (isset($active_tblrscopsnstatus) == true) {
                    //JR: insert new record on tblrscopsnstatus table
                    $model_tblrscopsnstatus = new Tblrscopsnstatus();
                    $model_tblrscopsnstatus->ICNO = $model->ICNO;
                    $model_tblrscopsnstatus->PsnStatusCd = $PsnStatusCd; //temporary 03:Belum Memilih,  04:Tidak Layak Memilih, 
                    $model_tblrscopsnstatus->PsnStatusNo = '';
                    $model_tblrscopsnstatus->PsnIncomeTaxNo = '';
                    $model_tblrscopsnstatus->PsnEpfNo = '';
                    $model_tblrscopsnstatus->PsnStatusStDt = $model->startDateLantik;
                    $model_tblrscopsnstatus->save();
                }
                if (isset($active_tblrscopsnathy) == true) {
                    //JR: insert new record on tblrscopsnathy table
                    $model_tblrscoaptathy = new Tblrscopsnathy();
                    $model_tblrscoaptathy->ICNO = $model->ICNO;
                    $model_tblrscoaptathy->PsnAthyCd = $PsnAthyCd; //99 Tiada Berkaitan, 
                    $model_tblrscoaptathy->PsnAthyStDt = $model->startDateLantik;
                    $model_tblrscoaptathy->save();
                }
                if (isset($active_tblrscosaltype) == true) {
                    //JR: insert new record on tblrscosaltype table
                    $model_tblrscosaltype = new Tblrscosaltype();
                    $model_tblrscosaltype->ICNO = $model->ICNO;
                    $model_tblrscosaltype->SalTypeCd = '01'; //01 bulanan
                    $model_tblrscosaltype->SalStatus = '1'; //1 matrix gaji
                    $model_tblrscosaltype->SalTypeStDt = $model->startDateLantik;
                    $model_tblrscosaltype->save();
                }
                if (isset($active_tblrscoservtype) == true) {
                    //JR: insert new record on tblrscoservtype table
                    $model_tblrscoservtype = new Tblrscoservtype();
                    $model_tblrscoservtype->ICNO = $model->ICNO;
                    $model_tblrscoservtype->ServTypeStDt = $model->startDateLantik;
                    $model_tblrscoservtype->ServTypeCd = 'SSM'; //SSM: Sistem saraan Malaysia
                    $model_tblrscoservtype->save();
                }
                //JR: insert new record on tblrscosalmovemth table
                $model_tblrscosalmovemth = new Tblrscosalmovemth();
                $model_tblrscosalmovemth->ICNO = $model->ICNO;
                $model_tblrscosalmovemth->SalMoveMth = $movemonth;
                $model_tblrscosalmovemth->SalMoveMthType = '1';
                $model_tblrscosalmovemth->SalMoveMthStDt = $model->startDateLantik;
                $model_tblrscosalmovemth->save();

                //JR: insert new record on tblrscofileno table
                $model_tblrscofileno = new Tblrscofileno();
                $model_tblrscofileno->ICNO = $model->ICNO;
                $model_tblrscofileno->COFileNo = $COOldID;
                $model_tblrscofileno->COFileNoEftvDt = $model->startDateLantik;
                $model_tblrscofileno->save();

                // for now umsper is without 's' at the end;
                if ($isPks) {
                    $model_umsper = new Umsperpks();
                } else {
                    $model_umsper = new Umsper();
                }

                $model_umsper->ICNO = $model->ICNO;
                $model_umsper->JobId = $model->gredJawatan;
                $model_umsper->DeptId = $model->DeptId;
                $model_umsper->campus_id = $model->campus_id;
                $model_umsper->COOldID = $COOldID;
                $model_umsper->StartDate = $model->startDateLantik;
                $model_umsper->COOldIDDt = $COOldIDDt;
                $model_umsper->COOldIDNo = $COOldIDNo;
                $model_umsper->save(false);

                return $this->redirect([
                    'biodata/adminview',
                    'id' => $model->ICNO
                ]);
            }
            Yii::$app->session->setFlash('alert', ['title' => 'Fail', 'type' => 'error', 'msg' => 'FAILED TO SAVE. Please Contact Technical Incharge.']);

            // var_dump($model->errors);
            // die;
        }
        //paste render code;
        return $this->render('_lantiksemulastafums', [
            'model' => $model,
            'umsper_ex' => $umsper_date . ' - ' . $umsper_no,

        ]);
    }

    // tamat lantikan asal bsm

    public function actionLantikPli()
    {
        $model = new Tblprcobiodata();
        $model->scenario = 'pli';
        $model->_action = 'lantikpli';
        $model->statLantikan = 54;
        $model->gredJawatan = 482;
        $model->ApmtTypeCd = 12;
        $model->statSandangan = 21;

        if (Yii::$app->request->post('janaemail') == 'janaemail') {
            $model->load(Yii::$app->request->post());
            if (!empty($model->CONm)) {
                //email suggestion;
                $s_email = $this->emailSuggestion($model->CONm);
                $model->COEmail = $s_email;
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Sila masukkan nama kakitangan terlebih dahulu.']);
            }
        } elseif ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->CONm = strtoupper($model->CONm);
            $model->startDateSandangan = $model->startDateLantik;
            $model->endDateSandangan = $model->endDateLantik; //new
            $model->Status = '1';
            $model->startDateStatus = $model->startDateLantik;
            $new_id = substr($model->COOldID, -5) . substr($model->ICNO, -4);
            $model->COOPass =  md5($new_id);

            //Maklumat Jawatan, JFPIU & Kampus Hakiki
            $model->DeptId_hakiki = $model->DeptId;
            $model->campus_id_hakiki = $model->campus_id;
            $model->gredJawatan_2 = $model->gredJawatan;

            //emel validation//
            $flag = true;
            $msg = 'Terdapat masalah dalam proses.';
            $validation = $this->validateEmail($model->COEmail);
            if ($validation['flag'] == false) {
                $flag = false;
                $msg = $validation['message'];
            }

            if ($flag) {

                //--------------------insert model lain yg berkaitan----------------------------------------//

                $ConfirmStatusCd = '8'; //Tidak Kaitan Dengan Proses Pengesahan			
                $PsnStatusCd = '04'; //04:Tidak Layak Memilih
                $PsnAthyCd = '99'; //99:Tiada Berkaitan

                $prev_umsper = Umsperpks::find()->orderBy(['COOldIDNo' => SORT_DESC])->one();
                $COOldIDNo = sprintf("%05s", ($prev_umsper->COOldIDNo + 1));
                $umsper_date = explode("-", $model->startDateStatus);
                $COOldIDDt = date("ymd", mktime(0, 0, 0, $umsper_date[1], $umsper_date[2], $umsper_date[0]));
                $COOldID = $COOldIDDt . '-' . $COOldIDNo . '(S)';
                $model->COOldID = $COOldID;
                $model->COOUCTelNo = '1' . $COOldIDNo;

                //set move month based on register date
                $movemonth = ($umsper_date[1] < '04' && $umsper_date[1] > '00' ? '01' : ($umsper_date[1] < '07' && $umsper_date[1] > '03' ? '04' : ($umsper_date[1] < '10' && $umsper_date[1] > '06' ? '07' : '10')));

                //------------------------------------start saving all related models------------------------------------------//
                if ($model->save()) {

                    //HR: insert new record on umsper table
                    $model_umsper = new Umsperpks();
                    $model_umsper->ICNO = $model->ICNO;
                    $model_umsper->JobId = $model->gredJawatan;
                    $model_umsper->DeptId = $model->DeptId;
                    $model_umsper->campus_id = $model->campus_id;
                    $model_umsper->COOldID = $COOldID;
                    $model_umsper->StartDate = $model->startDateLantik;
                    $model_umsper->COOldIDDt = $COOldIDDt;
                    $model_umsper->COOldIDNo = $COOldIDNo;
                    if (!$model_umsper->save(false)) {
                        $icno = $model->ICNO;
                        Tblprcobiodata::deleteAll(['ICNO' => $icno]);
                        Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Terdapat data bertindih, sila cuba cuba sebentar lagi.']);
                        return $this->render('_lantikphs', [
                            'model' => $model,
                        ]);
                    }

                    //HR: insert new record on tblrscosandangan table
                    $model_sandangan = new Tblrscosandangan();
                    $model_sandangan->_action = 'lantikpli';
                    //$model_sandangan->scenario='new';
                    $model_sandangan->ICNO = $model->ICNO;
                    $model_sandangan->gredjawatan = $model->gredJawatan;
                    $model_sandangan->sandangan_id = $model->statSandangan;
                    $model_sandangan->ApmtTypeCd = $model->ApmtTypeCd;
                    $model_sandangan->start_date = $model->startDateLantik;
                    $model_sandangan->save(false);

                    //HR: insert new record on tblrscoapmtstatus table
                    $model_apmtstatus = new Tblrscoapmtstatus();
                    $model_apmtstatus->ICNO = $model->ICNO;
                    $model_apmtstatus->ApmtStatusCd = $model->statLantikan;
                    $model_apmtstatus->ApmtStatusStDt = $model->startDateLantik;
                    $model_apmtstatus->ApmtStatusEndDt = $model->endDateLantik;
                    $model_apmtstatus->save(false);

                    //HR: insert new record on tblrscoservstatus table
                    $model_servstatus = new Tblrscoservstatus();
                    $model_servstatus->ICNO = $model->ICNO;
                    $model_servstatus->ServStatusCd = '1';
                    $model_servstatus->ServStatusDtl = '1';
                    $model_servstatus->ServStatusStDt = $model->startDateLantik;
                    $model_servstatus->save(false);

                    //HR: insert new record on tblpreduach table
                    $model_eduach = new Tblpendidikan();
                    $model_eduach->ICNO = $model->ICNO;
                    $model_eduach->InstCd = '999';
                    $model_eduach->HighestEduLevelCd = $model->HighestEduLevelCd;
                    $model_eduach->MajorCd = '0000';
                    $model_eduach->SponsorshipCd = '0000';
                    $model_eduach->EduCertTitle = Pendidikantertinggi::find()->where(['HighestEduLevelCd' => $model->HighestEduLevelCd])->one()->HighestEduLevel;
                    $model_eduach->OverallGrade = 'PASS';
                    $model_eduach->ConfermentDt = $model->ConfermentDt;
                    $model_eduach->AcrtdEduAch = '1';
                    $model_eduach->save(false);

                    //HR: insert new record on tblpenempatan table
                    $model_penempatan_pertama = new Tblpenempatan();
                    $model_penempatan_pertama->_action = 'lantikpli';
                    $model_penempatan_pertama->ICNO = $model->ICNO;
                    $model_penempatan_pertama->date_start = $model->startDateLantik;
                    $model_penempatan_pertama->date_update = date('Y-m-d H:i:s');
                    $model_penempatan_pertama->dept_id = $model->DeptId;
                    $model_penempatan_pertama->campus_id = $model->campus_id;
                    $model_penempatan_pertama->reason_id = 1;
                    $model_penempatan_pertama->remark = 'Penempatan sebagai PLI';
                    $model_penempatan_pertama->letter_order_refno = '-';
                    $model_penempatan_pertama->date_letter_order = $model->startDateLantik;
                    $model_penempatan_pertama->letter_refno = 'Penempatan sebagai PLI';
                    $model_penempatan_pertama->update_by = Yii::$app->user->getId();
                    $model_penempatan_pertama->save(false);

                    //HR: insert new record on tblrscoaptathy table
                    $model_tblrscoaptathy = new Tblrscoaptathy();
                    $model_tblrscoaptathy->ICNO = $model->ICNO;
                    $model_tblrscoaptathy->AptAthyCd = '387';
                    $model_tblrscoaptathy->ICNOHeadServ = Yii::$app->MP->getVC();
                    $model_tblrscoaptathy->AptAthyStDt = $model->startDateLantik;
                    $model_tblrscoaptathy->save(false);

                    //HR: insert new record on tblrscoservload table
                    $model_tblrscoservload = new Tblrscoservload();
                    $model_tblrscoservload->ICNO = $model->ICNO;
                    $model_tblrscoservload->ServLoadCd = '1'; //temporary 1 for sepenuh masa
                    $model_tblrscoservload->ServLoadStDt = $model->startDateLantik;
                    $model_tblrscoservload->save(false);

                    //HR: insert new record on tblrscoconfirmstatus table
                    $model_tblrscoconfirmstatus = new Tblrscoconfirmstatus();
                    $model_tblrscoconfirmstatus->ICNO = $model->ICNO;
                    $model_tblrscoconfirmstatus->ConfirmStatusCd = $ConfirmStatusCd; //temporary 7 Dalam Proses Pengesahan or 8 Tidak Kaitan Dengan Proses Pengesahan
                    $model_tblrscoconfirmstatus->ConfirmStatusStDt = $model->startDateLantik;
                    $model_tblrscoconfirmstatus->save(false);

                    //HR: insert new record on tblrscopsnstatus table
                    $model_tblrscopsnstatus = new Tblrscopsnstatus();
                    $model_tblrscopsnstatus->ICNO = $model->ICNO;
                    $model_tblrscopsnstatus->PsnStatusCd = $PsnStatusCd; //temporary 03:Belum Memilih,  04:Tidak Layak Memilih, 05:Tidak Berkaitan (Kontrak)
                    $model_tblrscopsnstatus->PsnStatusNo = '';
                    $model_tblrscopsnstatus->PsnIncomeTaxNo = '';
                    $model_tblrscopsnstatus->PsnEpfNo = '';
                    $model_tblrscopsnstatus->PsnStatusStDt = $model->startDateLantik;
                    $model_tblrscopsnstatus->save(false);

                    //HR: insert new record on tblrscopsnathy table
                    $model_tblrscoaptathy = new Tblrscopsnathy();
                    $model_tblrscoaptathy->ICNO = $model->ICNO;
                    $model_tblrscoaptathy->PsnAthyCd = $PsnAthyCd; //99 Tiada Berkaitan, 0 Tidak Berkenaan - (Lantikan Kontrak / Sementara) 
                    $model_tblrscoaptathy->PsnAthyStDt = $model->startDateLantik;
                    $model_tblrscoaptathy->save(false);

                    //HR: insert new record on tblrscosaltype table
                    $model_tblrscosaltype = new Tblrscosaltype();
                    $model_tblrscosaltype->ICNO = $model->ICNO;
                    $model_tblrscosaltype->SalTypeCd = '99'; //01 bulanan
                    $model_tblrscosaltype->SalStatus = '1'; //1 matrix gaji
                    $model_tblrscosaltype->SalTypeStDt = $model->startDateLantik;
                    $model_tblrscosaltype->save(false);

                    //HR: insert new record on tblrscoservtype table
                    $model_tblrscoservtype = new Tblrscoservtype();
                    $model_tblrscoservtype->ICNO = $model->ICNO;
                    $model_tblrscoservtype->ServTypeStDt = $model->startDateLantik;
                    $model_tblrscoservtype->ServTypeCd = 'SSM'; //SSM: Sistem saraan Malaysia
                    $model_tblrscoservtype->save(false);

                    //HR: insert new record on tblrscosalmovemth table
                    $model_tblrscosalmovemth = new Tblrscosalmovemth();
                    $model_tblrscosalmovemth->ICNO = $model->ICNO;
                    $model_tblrscosalmovemth->SalMoveMth = $movemonth;
                    $model_tblrscosalmovemth->SalMoveMthType = '1';
                    $model_tblrscosalmovemth->SalMoveMthStDt = $model->startDateLantik;
                    $model_tblrscosalmovemth->save(false);

                    //HR: insert new record on tblrscofileno table
                    $model_tblrscofileno = new Tblrscofileno();
                    $model_tblrscofileno->ICNO = $model->ICNO;
                    $model_tblrscofileno->COFileNo = $COOldID;
                    $model_tblrscofileno->COFileNoEftvDt = $model->startDateLantik;
                    $model_tblrscofileno->save(false);

                    //insert WP
                    $model_wp = new TblWP();
                    $model_wp->wp_id = '40';
                    $model_wp->icno = $model->ICNO;
                    $model_wp->remark = 'PELAJAR LATIHAN INDUSTRI';
                    $model_wp->entry_dt = date('Y-m-d H:i:s');
                    $model_wp->start_date = date('Y-m-d');
                    $model_wp->status = 'APPROVED';
                    $model_wp->save(false);

                    //send notification to IT admin
                    $array_admin = ['940402125181', '840813125655', '811212125745'];
                    for ($i = 0; $i < count($array_admin); $i++) {
                        $model_noty = new Notification();
                        $model_noty->icno = $array_admin[$i];
                        $model_noty->title = 'LANTIKAN PLI';
                        $model_noty->content = 'Semakkan maklumat kakitangan yang baru dilantik. No IC = ' . $model->ICNO
                            . '; No IC melantik = ' . Yii::$app->user->getId();
                        $model_noty->ntf_dt = date('Y-m-d H:i:s');
                        $model_noty->save(false);
                    }

                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Maklumat ata berjaya disimpan.']);
                    //redirect to admin page
                    return $this->redirect([
                        'biodata/adminview',
                        'id' => $model->ICNO,
                    ]);
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => $msg]);
            }
        }

        return $this->render('_lantikpli', [
            'model' => $model,
        ]);
    }


    public function actionLantikSambilanakademik()
    {
        $model = new Tblprcobiodata();
        $model->scenario = 'sambilanakademik';
        $model->isBsm = 2;
        $statlantik = ['53'];
        $sandangan = $sandangan = [26];

        if ($model->load(Yii::$app->request->post())) {
            $model->COOPass = md5($model->ICNO);
            $model->CONm = strtoupper($model->CONm);
            $model->startDateSandangan = $model->startDateLantik;
            $model->Status = '1';
            $model->startDateStatus = $model->startDateLantik;

            //Maklumat Jawatan, JFPIU & Kampus Hakiki
            $model->DeptId_hakiki = $model->DeptId;
            $model->campus_id_hakiki = $model->campus_id;
            $model->gredJawatan_2 = $model->gredJawatan;

            //--------------------insert model lain yg berkaitan----------------------------------------//
            if ($model->statLantikan == '6' || $model->statLantikan == '7') {
                $ConfirmStatusCd = '8'; //Tidak Kaitan Dengan Proses Pengesahan			
                $PsnStatusCd = '04'; //04:Tidak Layak Memilih
                $PsnAthyCd = '99'; //99:Tiada Berkaitan
            } else {
                if ($model->statLantikan == '1') {
                    $ConfirmStatusCd = '2'; //Dalam Percubaan Lantikan Pertama
                    $PsnStatusCd = '03'; //03:Belum Memilih
                    $PsnAthyCd = '99'; //99:Tiada Berkaitan
                } elseif ($model->statLantikan == '3') {
                    $ConfirmStatusCd = '8'; //Tidak Kaitan Dengan Proses Pengesahan
                    $PsnStatusCd = '04'; //04:Tidak Layak Memilih
                    $PsnAthyCd = '99'; //99:Tiada Berkaitan
                } else {
                    $ConfirmStatusCd = '8'; //Tidak Kaitan Dengan Proses Pengesahan
                    $PsnStatusCd = '04'; //04:Tidak Layak Memilih
                    $PsnAthyCd = '99'; //99:Tiada Berkaitan
                }
            }

            //creating new umsper; //sambilan tidak akan guna 's' ;
            $prev_umsper = Umsper::find()->orderBy(['COOldIDNo' => SORT_DESC])->one();
            $COOldIDNo = sprintf("%05s", ($prev_umsper->COOldIDNo + 1));
            $umsper_date = explode("-", $model->startDateStatus);
            $COOldIDDt = date("ymd", mktime(0, 0, 0, $umsper_date[1], $umsper_date[2], $umsper_date[0]));
            $COOldID = $COOldIDDt . '-' . $COOldIDNo;
            $model->COOldID = $COOldID;

            //------------------------------------start saving all related models------------------------------------------//
            if ($model->save()) {

                //HR: insert new record on umsper table
                $model_umsper = new Umsper();
                $model_umsper->scenario = 'lantikan';
                $model_umsper->ICNO = $model->ICNO;
                $model_umsper->JobId = $model->gredJawatan;
                $model_umsper->DeptId = $model->DeptId;
                $model_umsper->campus_id = $model->campus_id;
                $model_umsper->COOldID = $COOldID;
                $model_umsper->StartDate = $model->startDateLantik;
                $model_umsper->COOldIDDt = $COOldIDDt;
                $model_umsper->COOldIDNo = $COOldIDNo;
                if (!$model_umsper->save()) {
                    $icno = $model->ICNO;
                    Tblprcobiodata::deleteAll(['ICNO' => $icno]);
                    Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Terdapat data bertindih, sila cuba cuba sebentar lagi.']);
                    return $this->render('_sambilanakademik', [
                        'model' => $model,
                    ]);
                }

                //HR: insert new record on tblrscosandangan table
                $model_sandangan = new Tblrscosandangan();
                $model_sandangan->ICNO = $model->ICNO;
                $model_sandangan->gredjawatan = $model->gredJawatan;
                $model_sandangan->sandangan_id = $model->statSandangan;
                $model_sandangan->ApmtTypeCd = $model->ApmtTypeCd;
                $model_sandangan->start_date = $model->startDateLantik;
                $model_sandangan->save();

                //HR: insert new record on tblrscoapmtstatus table
                $model_apmtstatus = new Tblrscoapmtstatus();
                $model_apmtstatus->ICNO = $model->ICNO;
                $model_apmtstatus->ApmtStatusCd = $model->statLantikan;
                $model_apmtstatus->ApmtStatusStDt = $model->startDateLantik;
                $model_apmtstatus->ApmtStatusEndDt = $model->endDateLantik;
                $model_apmtstatus->save();

                //HR: insert new record on tblrscoservstatus table
                $model_servstatus = new Tblrscoservstatus();
                $model_servstatus->ICNO = $model->ICNO;
                $model_servstatus->ServStatusCd = '1';
                $model_servstatus->ServStatusDtl = '1';
                $model_servstatus->ServStatusStDt = $model->startDateLantik;
                $model_servstatus->save();

                //HR: insert new record on tblpreduach table
                $model_eduach = new Tblpendidikan();
                $model_eduach->ICNO = $model->ICNO;
                $model_eduach->InstCd = '999';
                $model_eduach->HighestEduLevelCd = $model->HighestEduLevelCd;
                $model_eduach->MajorCd = '0000';
                $model_eduach->SponsorshipCd = '0000';
                $model_eduach->EduCertTitle = Pendidikantertinggi::find()->where(['HighestEduLevelCd' => $model->HighestEduLevelCd])->one()->HighestEduLevel;
                $model_eduach->OverallGrade = 'PASS';
                $model_eduach->ConfermentDt = $model->ConfermentDt;
                $model_eduach->AcrtdEduAch = '1';
                $model_eduach->save(false);

                //HR: insert new record on tblpenempatan table
                $model_penempatan_pertama = new Tblpenempatan();
                $model_penempatan_pertama->ICNO = $model->ICNO;
                $model_penempatan_pertama->date_start = $model->startDateLantik;
                $model_penempatan_pertama->date_update = date('Y-m-d H:i:s');
                $model_penempatan_pertama->dept_id = $model->DeptId;
                $model_penempatan_pertama->campus_id = $model->campus_id;
                $model_penempatan_pertama->reason_id = 1;
                $model_penempatan_pertama->remark = 'Penempatan asal';
                $model_penempatan_pertama->letter_order_refno = '-';
                $model_penempatan_pertama->date_letter_order = $model->startDateLantik;
                $model_penempatan_pertama->letter_refno = 'Penempatan asal';
                $model_penempatan_pertama->update_by = Yii::$app->user->getId();
                $model_penempatan_pertama->save();

                //HR: insert new record on tblrscoaptathy table
                // $model_tblrscoaptathy = new Tblrscoaptathy();
                // $model_tblrscoaptathy->ICNO = $model->ICNO;
                // $model_tblrscoaptathy->AptAthyCd = '387';
                // $model_tblrscoaptathy->ICNOHeadServ = '530121125351'; //temporary ic datuk kamaruzaman, later will be auto detect VC ums
                // $model_tblrscoaptathy->AptAthyStDt = $model->startDateLantik;
                // $model_tblrscoaptathy->save();	
                //HR: insert new record on tblrscoservload table
                $model_tblrscoservload = new Tblrscoservload();
                $model_tblrscoservload->ICNO = $model->ICNO;
                $model_tblrscoservload->ServLoadCd = '1'; //temporary 1 for sepenuh masa
                $model_tblrscoservload->ServLoadStDt = $model->startDateLantik;
                $model_tblrscoservload->save();

                // //HR: insert new record on tblrscosaltype table
                // $model_tblrscosaltype = new Tblrscosaltype();
                // $model_tblrscosaltype->ICNO = $model->ICNO;
                // $model_tblrscosaltype->SalTypeCd = '01'; //01 bulanan
                // $model_tblrscosaltype->SalStatus = '1'; //1 matrix gaji
                // $model_tblrscosaltype->SalTypeStDt = $model->startDateLantik;
                // $model_tblrscosaltype->save();

                $lantikan_belum_selesai = new Tbllantikanbelumselesai();
                $lantikan_belum_selesai->ICNO = $model->ICNO;
                $lantikan_belum_selesai->Staff_Id = $model->COOldID;
                $lantikan_belum_selesai->Admin_ICNO = Yii::$app->user->getId();
                $lantikan_belum_selesai->lantikan = '1';
                $lantikan_belum_selesai->save();

                return $this->redirect([
                    'biodata/adminview',
                    'id' => $model->ICNO,
                ]);
            }

            // var_dump($model->errors);
            // die;
        }

        return $this->render('_lantiksambilanakademik', [
            'model' => $model,
            'statlantik' => $statlantik,
            'sandangan' => $sandangan,
        ]);
    }

    //code lama sebagai reference; will delete later;

    public function actionSambilanakademik($AT)
    {
        $model = new Tblprcobiodata();
        $statlantik = ['53'];
        $sandangan = $sandangan = [26];
        $gredjawatan = [432, 433, 434, 435];
        $jenislantikan = [10];

        return $this->render('_sambilanakademik', [
            'model' => $model,
            'statlantik' => $statlantik,
            'sandangan' => $sandangan,
            'gredjawatan' => $gredjawatan,
            'jenislantikan' => $jenislantikan,
        ]);
    }

    public function actionPenerbitums()
    {
        $model = new Tblprcobiodata();
        $statlantik = ['2'];
        $sandangan = [21];
        $gredjawatan = [436, 437, 438];
        $jenislantikan = [2, 10];

        return $this->render('_penerbitums', [
            'model' => $model,
            'statlantik' => $statlantik,
            'sandangan' => $sandangan,
            'gredjawatan' => $gredjawatan,
            'jenislantikan' => $jenislantikan,
        ]);
    }

    public function actionRollbackLantikan($icno, $pw)
    {
        if ($pw == '25d55ad283aa400af464c76d713c07ad') {
            Yii::$app->MP->RollBackLantikanBaru($icno);
            echo "berjaya";
            die;
        }
        echo "gagal";
        die;
    }

    //mula view lantikan//

    public function actionStatusSandangan($icno)
    {
        if ($this->findModel($icno)) {
            $msg = 'Berjaya Dikemakini';
            if (!$model = Tblrscosandangan::find()->where(['ICNO' => $icno])->one()) {
                $model = new Tblrscosandangan();
                $model->ICNO = $icno;
                $msg = 'Berjaya Ditambah';
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $msg]);
                return $this->redirect(['view-lantikan', 'id' => $model->ICNO]);
            }

            return $this->render('_statussandangan', [
                'model' => $model,
            ]);
        }
        echo "Staff ICNO not exist in Database. Please contact ICT Unit.";
    }

    public function actionStatusPerkhidmatan($icno)
    {
        if ($this->findModel($icno)) {
            $msg = 'Berjaya Dikemakini';
            if (!$model = Tblrscoservstatus::find()->where(['ICNO' => $icno])->one()) {
                $model = new Tblrscoservstatus();
                $model->ICNO = $icno;
                $msg = 'Berjaya Ditambah';
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $msg]);
                return $this->redirect(['view-lantikan', 'id' => $model->ICNO]);
            }

            return $this->render('_statusperkhidmatan', [
                'model' => $model,
            ]);
        }
        echo "Staff ICNO not exist in Database. Please contact ICT Unit.";
    }

    public function actionStatusLantikan($icno)
    {
        if ($this->findModel($icno)) {
            $msg = 'Berjaya Dikemakini';
            if (!$model = Tblrscoapmtstatus::find()->where(['ICNO' => $icno])->one()) {
                $model = new Tblrscoapmtstatus();
                $model->ICNO = $icno;
                $msg = 'Berjaya Ditambah';
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $msg]);
                return $this->redirect(['view-lantikan', 'id' => $model->ICNO]);
            }

            return $this->render('_statuslantikan', [
                'model' => $model,
            ]);
        }
        echo "Staff ICNO not exist in Database. Please contact ICT Unit.";
    }

    public function actionPendidikan($icno)
    {
        if ($this->findModel($icno)) {
            $msg = 'Berjaya Dikemakini';
            if (!$model = Tblpendidikan::find()->where(['ICNO' => $icno])->one()) {
                $model = new Tblpendidikan();
                $model->ICNO = $icno;
                $msg = 'Berjaya Ditambah';
            }

            if ($model->load(Yii::$app->request->post())) {
                $model->InstCd = '999';
                $model->HighestEduLevelCd = $model->HighestEduLevelCd;
                $model->MajorCd = '0000';
                $model->SponsorshipCd = '0000';
                $model->EduCertTitle = '-';
                $model->EduCertTitleBI = '-';
                $model->SerialNo = '-';
                $model->OverallGrade = 'PASS';
                $model->ConfermentDt = $model->ConfermentDt;
                $model->AcrtdEduAch = '1';
                $model->Bon = '0';
                if ($model->save()) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $msg]);
                    return $this->redirect(['view-lantikan', 'id' => $model->ICNO]);
                }
            }

            return $this->render('_pendidikan', [
                'model' => $model,
            ]);
        }
        echo "Staff ICNO not exist in Database. Please contact ICT Unit.";
    }

    public function actionPenempatan($icno)
    {
        if ($this->findModel($icno)) {
            $msg = 'Berjaya Dikemakini';
            if (!$model = Tblpenempatan::find()->where(['ICNO' => $icno])->one()) {
                $model = new Tblpenempatan();
                $model->ICNO = $icno;
                $msg = 'Berjaya Ditambah';
            }

            if ($model->load(Yii::$app->request->post())) {
                $model->date_update = date('Y-m-d H:i:s');
                $model->reason_id = 1;
                $model->remark = 'Penempatan asal';
                $model->letter_order_refno = '-';
                $model->date_letter_order = $model->date_start;
                $model->letter_refno = 'Penempatan asal';
                $model->update_by = Yii::$app->user->getId();
                if ($model->save()) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $msg]);
                    return $this->redirect(['view-lantikan', 'id' => $model->ICNO]);
                }
            }
            return $this->render('_penempatan', [
                'model' => $model,
            ]);
        }
        echo "Staff ICNO not exist in Database. Please contact ICT Unit.";
    }

    public function actionPihakBerkuasaMelantik($icno)
    {
        if ($this->findModel($icno)) {
            $msg = 'Berjaya Dikemakini';
            if (!$model = Tblrscoaptathy::find()->where(['ICNO' => $icno])->one()) {
                $model = new Tblrscoaptathy();
                $model->ICNO = $icno;
                $model->AptAthyCd = '387';
                $msg = 'Berjaya Ditambah';
            }

            if ($model->load(Yii::$app->request->post())) {
                //$model->AptAthyCd = '387'; //Lembaga Pengarah Universiti, Universiti Malaysia Sabah
                //$model->ICNOHeadServ = NULL; //temporary ic datuk kamaruzaman, later will be auto detect VC ums 
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $msg]);
                    return $this->redirect(['view-lantikan', 'id' => $model->ICNO]);
                }
            }

            return $this->render('_pihakberkuasamelantik', [
                'model' => $model,
            ]);
        }
        echo "Staff ICNO not exist in Database. Please contact ICT Unit.";
    }

    public function actionBebanPerkhidmatan($icno)
    {
        if ($this->findModel($icno)) {
            $msg = 'Berjaya Dikemakini';
            if (!$model = Tblrscoservload::find()->where(['ICNO' => $icno])->one()) {
                $model = new Tblrscoservload();
                $model->ICNO = $icno;
                $msg = 'Berjaya Ditambah';
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $msg]);
                return $this->redirect(['view-lantikan', 'id' => $model->ICNO]);
            }

            return $this->render('_bebanperkhidmatan', [
                'model' => $model,
            ]);
        }
        echo "Staff ICNO not exist in Database. Please contact ICT Unit.";
    }

    public function actionStatusPengesahan($icno)
    {
        if ($this->findModel($icno)) {
            $msg = 'Berjaya Dikemakini';
            if (!$model = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->one()) {
                $model = new Tblrscoconfirmstatus();
                $model->ICNO = $icno;
                $msg = 'Berjaya Ditambah';
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $msg]);
                return $this->redirect(['view-lantikan', 'id' => $model->ICNO]);
            }

            return $this->render('_statuspengesahan', [
                'model' => $model,
            ]);
        }
        echo "Staff ICNO not exist in Database. Please contact ICT Unit.";
    }

    public function actionTempohPercubaan($icno)
    {
        if ($this->findModel($icno)) {
            $msg = 'Berjaya Dikemakini';
            if (!$model = Tblrscoprobtnperiod::find()->where(['ICNO' => $icno])->one()) {
                $model = new Tblrscoprobtnperiod();
                $model->ICNO = $icno;
                $model->ProbtnPeriod = '36'; //36 bulan max
                $model->ProbtnPeriodMin = '12'; //12 bulan min
                $msg = 'Berjaya Ditambah';
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $msg]);
                return $this->redirect(['view-lantikan', 'id' => $model->ICNO]);
            }

            return $this->render('_tempohpercubaan', [
                'model' => $model,
            ]);
        }
        echo "Staff ICNO not exist in Database. Please contact ICT Unit.";
    }

    public function actionStatusPencen($icno)
    {
        if ($this->findModel($icno)) {
            $msg = 'Berjaya Dikemakini';
            if (!$model = Tblrscopsnstatus::find()->where(['ICNO' => $icno])->one()) {
                $model = new Tblrscopsnstatus();
                $model->ICNO = $icno;
                $msg = 'Berjaya Ditambah';
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $msg]);
                return $this->redirect(['view-lantikan', 'id' => $model->ICNO]);
            }

            return $this->render('_statuspencen', [
                'model' => $model,
            ]);
        }
        echo "Staff ICNO not exist in Database. Please contact ICT Unit.";
    }

    public function actionPihakBerkuasaPencen($icno)
    {
        if ($this->findModel($icno)) {
            $msg = 'Berjaya Dikemakini';
            if (!$model = Tblrscopsnathy::find()->where(['ICNO' => $icno])->one()) {
                $model = new Tblrscopsnathy();
                $model->ICNO = $icno;
                $msg = 'Berjaya Ditambah';
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $msg]);
                return $this->redirect(['view-lantikan', 'id' => $model->ICNO]);
            }

            return $this->render('_pihakberkuasapencen', [
                'model' => $model,
            ]);
        }
        echo "Staff ICNO not exist in Database. Please contact ICT Unit.";
    }

    public function actionJenisGaji($icno)
    {
        if ($this->findModel($icno)) {
            $msg = 'Berjaya Dikemakini';
            if (!$model = Tblrscosaltype::find()->where(['ICNO' => $icno])->one()) {
                $model = new Tblrscosaltype();
                $model->ICNO = $icno;
                $msg = 'Berjaya Ditambah';
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $msg]);
                return $this->redirect(['view-lantikan', 'id' => $model->ICNO]);
            }

            return $this->render('_jenisgaji', [
                'model' => $model,
            ]);
        }
        echo "Staff ICNO not exist in Database. Please contact ICT Unit.";
    }

    public function actionJenisPerkhidmatan($icno)
    {
        if ($this->findModel($icno)) {
            $msg = 'Berjaya Dikemakini';
            if (!$model = Tblrscoservtype::find()->where(['ICNO' => $icno])->one()) {
                $model = new Tblrscoservtype();
                $model->ICNO = $icno;
                $msg = 'Berjaya Ditambah';
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $msg]);
                return $this->redirect(['view-lantikan', 'id' => $model->ICNO]);
            }

            return $this->render('_jenisperkhidmatan', [
                'model' => $model,
            ]);
        }
        echo "Staff ICNO not exist in Database. Please contact ICT Unit.";
    }

    public function actionPergerakanGaji($icno)
    {
        if ($this->findModel($icno)) {
            $msg = 'Berjaya Dikemakini';
            if (!$model = Tblrscosalmovemth::find()->where(['ICNO' => $icno])->one()) {
                $model = new Tblrscosalmovemth();
                $model->ICNO = $icno;
                $msg = 'Berjaya Ditambah';
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $msg]);
                return $this->redirect(['view-lantikan', 'id' => $model->ICNO]);
            }

            return $this->render('_pergerakangaji', [
                'model' => $model,
            ]);
        }
        echo "Staff ICNO not exist in Database. Please contact ICT Unit.";
    }

    public function actionFailPerkhidmatan($icno)
    {
        if ($this->findModel($icno)) {
            $msg = 'Berjaya Dikemakini';
            if (!$model = Tblrscofileno::find()->where(['ICNO' => $icno])->one()) {
                $model = new Tblrscofileno();
                $model->ICNO = $icno;
                $msg = 'Berjaya Ditambah';
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $msg]);
                return $this->redirect(['view-lantikan', 'id' => $model->ICNO]);
            }

            return $this->render('_fileperkhidmatan', [
                'model' => $model,
            ]);
        }
        echo "Staff ICNO not exist in Database. Please contact ICT Unit.";
    }

    // tamat view lantikan //

    public function actionLantikanBelumSelesai()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tbllantikanbelumselesai::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('lantikanbelumselesai', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewUtama($id)
    {
        $model = Tbllantikanbelumselesai::findOne(['ICNO' => $id]);

        if (!empty($model)) {
            $bio = Tblprcobiodata::findOne(['ICNO' => $id]);
            // var_dump($bio);
            // die;
            return $this->render('utama', [
                'model' => $model,
                'bio' => $bio,
            ]);
        }
        throw new NotFoundHttpException('ICNO not Exist!');
    }

    public function actionViewLantikan($id)
    {
        $coolid = Tblprcobiodata::findOne(['ICNO' => $id])->COOldID;
        $tbllist = [
            'Tblrscosandangan', 'Tblrscoapmtstatus', 'Tblrscoservstatus', 'Tblpendidikan', 'TblPenempatan', 'Tblrscoaptathy',
            'Tblrscoservload', 'Tblrscoconfirmstatus', 'Tblrscoprobtnperiod', 'Tblrscopsnstatus', 'Tblrscopsnathy', 'Tblrscosaltype', 'Tblrscoservtype',
            'Tblrscosalmovemth', 'Tblrscofileno',
        ];

        $tblval = [];
        $tblnms = [];
        $tbllink = [];

        for ($i = 0; $i < count($tbllist); $i++) {
            ${$tbllist[$i]} = $this->convertModel($tbllist[$i])::find()->where(['ICNO' => $id])->one();
        }
        for ($i = 0; $i < count($tbllist); $i++) {
            $tblnm = Tables::getTablename($tbllist[$i]);
            //$tbllink = Tables::getLink($tbllist[$i]);
            //echo $tbllink; //Tables::getLink($tbllist[$i]);
            //echo $i."</br>";

            array_push($tblnms, $tblnm);
            array_push($tbllink, Tables::getLink($tbllist[$i]));
            if (!empty(${$tbllist[$i]})) {
                $tblval[$tbllist[$i]] = 1;
                //echo "Data on table ".$tbllist[$i]." is inserted ".$tblval[$tbllist[$i]]." </br>";
            } else {
                $tblval[$tbllist[$i]] = 0;
                //echo "Data on table ".$tbllist[$i]." is not inserted ".$tblval[$tbllist[$i]]."</br>";
            }
        }
        //die;
        return $this->render('verify', [
            'icno' => $id,
            'id' => $coolid,
            'tblval' => $tblval,
            'tbllist' => $tbllist,
            'tblnms' => $tblnms,
            'tbllink' => $tbllink,
        ]);
    }

    public function actionTkpg($ICNO, $id = null)
    {
        if ($biodata = $this->findModel($ICNO)) {

            if ($id != null) {
                $model = TblStaffSalary::findOne(['SS_STAFF_ID' => $id]);
                $msg = 'Berjaya Dikemaskini';
            } else {
                $model = new TblStaffSalary();
                $model->SS_STAFF_ID = $biodata->COOldID;
                $model->SS_START_DATE = $biodata->startDateLantik;
                $model->SS_END_DATE = $biodata->endDateLantik;
                $model->SS_REF_CODE = 'SS' . date('YmdHis');
                $model->SS_ENTER_BY = Yii::$app->user->identity->getId();
                $model->SS_ENTER_DATE = date('Y-m-d H:i:s');
                $model->SS_CMPY_CODE = 'UMS';

                $msg = 'Berjaya Ditambah';
            }

            if ($model->load(Yii::$app->request->post())) {
                switch ($model->SS_SALARY_TYPE) {
                    case '1':
                        $model->SS_BASIC_SALARY = self::gajiPokok($biodata->jawatan->gred);
                        break;

                    default:
                        $model->SS_BASIC_SALARY = 0.00;
                        break;
                }

                if ($model->save()) {
                    $tbl_lbs = Tbllantikanbelumselesai::findOne(['Staff_Id' => $model->SS_STAFF_ID]);
                    $tbl_lbs->profil_gaji = $model->id;
                    $tbl_lbs->save();
                }

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $msg]);
                return $this->redirect(['view-utama', 'id' => $ICNO]);
            }

            return $this->render('_profilegaji', [
                'model' => $model,
                'ICNO' => $ICNO,
            ]);
        }
        echo "Staff ICNO not exist in Database. Please contact ICT Unit.";
    }

    public function actionLpg($ID)
    {
        $bio = Tblprcobiodata::findOne(['ICNO' => $ID]);
        $model = Tblrscolpg::findOne(['t_lpg_ICNO' => $ID]);

        return $this->render('rekodlpg', [
            'model' => $model,
            'bio' => $bio,
        ]);
    }

    public function actionTklpg($ICNO, $id = null)
    {
        if ($bio = Tblprcobiodata::findOne(['ICNO' => $ICNO])) {
            $data = [];
            if ($id != null) {
                $model = Tblrscolpg::findOne(['t_lpg_ICNO' => $ICNO]);
                $msg = 'Berjaya Dikemaskini';
            } else {
                $model = new Tblrscolpg();
                $model->t_lpg_ICNO = $ICNO;
                $model->t_lpg_amount = TblStaffSalary::findOne(['SS_STAFF_ID' => $bio->COOldID])->SS_BASIC_SALARY;
                $model->created_by = Yii::$app->user->identity->ICNO;
                $model->created_datetime = date('Y-m-d H:i:s');
                $msg = 'Berjaya Ditambah';
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                //$model->validate();
                //var_dump($model);
                var_dump($model->t_lpg_ICNO);
                echo '</br>'; //
                var_dump($model->t_lpg_cd);
                echo '</br>';
                var_dump($model->t_lpg_date_start);
                echo '</br>';
                var_dump($model->t_lpg_date_end);
                echo '</br>';
                var_dump($model->t_lpg_peringkat);
                echo '</br>'; //
                var_dump($model->t_lpg_tingkat);
                echo '</br>'; //
                var_dump($model->t_lpg_amount);
                echo '</br>';
                var_dump($model->t_lpg_remark);
                echo '</br>';
                var_dump($model->t_lpg_jawatan_id);
                echo '</br>';
                var_dump($model->t_lpg_dept_id);
                echo '</br>';
                var_dump($model->t_lpg_marital_cd);
                echo '</br>'; //
                var_dump($model->t_lpg_app_by);
                echo '</br>'; //
                var_dump($model->t_lpg_app_status);
                echo '</br>'; //
                var_dump($model->t_lpg_app_by_datetime);
                echo '</br>'; //
                var_dump($model->t_lpg_ver_by);
                echo '</br>'; //
                var_dump($model->t_lpg_ver_status);
                echo '</br>'; //
                var_dump($model->t_lpg_ver_by_datetime);
                echo '</br>'; //
                var_dump($model->t_lpg_id_sort);
                echo '</br>'; //
                var_dump($model->created_by);
                echo '</br>';
                var_dump($model->created_datetime);
                echo '</br>';
                var_dump($model->updated_by);
                echo '</br>'; //
                var_dump($model->updated_datetime);
                echo '</br>'; //
                die;
                // if($model->save(false)){
                //     $tbl_lbs = Tbllantikanbelumselesai::findOne(['Staff_Id'=>$model->SS_STAFF_ID]);
                //     $tbl_lbs->profil_gaji = $model->id;
                //     $tbl_lbs->save();
                // }                

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => $msg]);
                return $this->redirect(['view-lantikan-staf', 'id' => $ICNO]);
            }

            $gred_jawatan = GredJawatan::find()->orderBy(['gred' => SORT_ASC])->all();
            foreach ($gred_jawatan as $gj) {
                $data[$gj->id] = $gj->gred ? $gj->gred . ' - ' . $gj->nama : $gj->nama . ' - ' . $gj->nama;
            }

            return $this->render('_lpg', [
                'bio' => $bio,
                'model' => $model,
                'ICNO' => $ICNO,
                'data' => $data,
            ]);
        }
        echo "Staff ICNO not exist in Database. Please contact ICT Unit.";
    }

    //protected function
    protected function findModel($id)
    {
        if (($model = Tblprcobiodata::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelByID($id)
    {
        if (($model = Tblprcobiodata::findOne(['COOldID' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function convertModel($model)
    {
        $modelx = Yii::createObject([
            'class' => "app\models\hronline\\" . $model,
        ]);
        return $modelx;
    }

    protected function gajiPokok($gred)
    {

        if ($gaji_pokok = RefJadualGaji::findOne(['r_jg_gred' => $gred])->r_jg_min) {
            return $gaji_pokok;
        }
        return '-';
    }
}
