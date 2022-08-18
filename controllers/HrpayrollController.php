<?php

namespace app\controllers;

use app\models\gaji\TblKumpLpg;
use app\models\gaji\TblKumpStaf;
use app\models\gaji\TblKumpulan;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\TblprcobiodataSearch;
use app\models\hronline\Tblakaun;
use app\models\hronline\TblStaffSalary as HronlineTblStaffSalary;
use app\models\hronline_gaji\Tblmonthly_payment_detl;
use Yii;
use yii\web\NotFoundHttpException;

use app\models\hronline_gaji\Tblstaffsalary;
use app\models\hronline_gaji\TblstaffsalarySearch;
use yii\debug\models\timeline\DataProvider;
use yii\data\ActiveDataProvider;
use app\models\hronline_gaji\Tblstaffroc;
use app\models\hronline_gaji\Tblstaffrocbatch;
use app\models\hronline_gaji\Tblrscolpg;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\hronline_gaji\JadualGaji;
use app\models\hronline_gaji\TblGajiTemplateLpg;
use app\models\hronline_gaji\Model;
use app\models\hronline_gaji\TblstaffrocbatchSearch;
use app\models\hronline_gaji\RefElaunName;

class HrpayrollController extends \yii\web\Controller
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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['kemasukan','kemasukan-l-p-g','viewpayroll','staff','tambah-kumpulan','view-kumpulan','tambah-elaun',
                    'tindakan-kemasukan','tindakan-kemasukan-hantar','tindakan-kemasukan-buang','kemaskini-elaun','tambah-elaun','padam-elaun'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                           return TblKumpulan::findRole(Yii::$app->user->getId(), 'ENTRY') ? true : false;
                        }
                    ],
                    [
                        'actions' => ['semakan','semakan-l-p-g','viewpayroll','staff','view-kumpulan',
                        'tindakan-semakan','tindakan-semakan-disemak','tindakan-semakan-tolak'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return TblKumpulan::findRole(Yii::$app->user->getId(), 'VERIFY') ? true : false;
                        }
                    ],
                    [
                        'actions' => ['kelulusan','kelulusan-l-p-g','viewpayroll','staff','view-kumpulan',
                        'tindakan-kelulusan','tindakan-kelulusan-terima','tindakan-kelulusan-tolak'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return TblKumpulan::findRole(Yii::$app->user->getId(), 'APPROVE') ? true : false;
                        }
                    ],

                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $icno = Yii::$app->user->getId();
        $carian = new TblprcobiodataSearch();
        $dataProvider = $carian->carian(Yii::$app->request->queryParams);
        $roles_list = TblKumpStaf::RoleList($icno);
        // var_dump($roles_list);
        // die;
        $tasks = [];
        for($i = 0; $i < count($roles_list); $i++){
            $tasks[$roles_list[$i]] = Tblstaffrocbatch::Tasks($icno, $roles_list[$i]);
        }
        // var_dump($tasks);
        // die;
        return $this->render('index', [
            'carian' => $carian,
            'dataProvider' => $dataProvider,
            'tasks' => $tasks,
        ]);
    }

    public function actionViewpayroll($id)
    {

        $model = $this->findModel($id); // $id is icno staff;

        return $this->render('viewpayroll', [
            'model' => $model,
        ]);
    }

    public function actionProfileGaji($umsper)
    {
        $models = Tblprcobiodata::find()->where(['COOldID' => $umsper])->one();
        $model = HronlineTblStaffSalary::find()->where(['SS_STAFF_ID' => $umsper])->orderBy(['id' => SORT_DESC])->all();

        //$staff_salary->jenisKwsp->ET_DESC;

        return $this->render('_profileTab', [
            'model' => $model, 'models' => $models
        ]);
    }

    public function actionViewAllowance()
    {
        $carian = new TblstaffsalarySearch();
        $dataProvider = $carian->search(Yii::$app->request->queryParams);
        $data = Yii::$app->request->queryParams;
        $bio = [];
        if (!empty($data['TblstaffsalarySearch']['sm_ic_no'])) {
            $bio = Tblprcobiodata::find()->where(['ICNO' => $data['TblstaffsalarySearch']['sm_ic_no']])->one();
        }

        return $this->render('view_allowances', [
            'carian' => $carian,
            'model' => $dataProvider,
            'biodata' => $bio,
        ]);
    }
    public function actionViewSlip($staff_id)
    {
        $elaun = Tblmonthly_payment_detl::find()->where(['MPD_STAFF_ID' => $staff_id])->andWhere(['OR', ['LIKE', 'MPD_INCOME_CODE', 'E'], ['LIKE', 'MPD_INCOME_CODE', 'B']]);
        $elaunlain = Tblmonthly_payment_detl::find()->where(['MPD_STAFF_ID' => $staff_id])->andWhere(['LIKE', 'MPD_INCOME_CODE', 'M']);
        $potongan = Tblmonthly_payment_detl::find()->where(['MPD_STAFF_ID' => $staff_id])->andWhere(['LIKE', 'MPD_INCOME_CODE', 'D']);
        $dataElaun = new ActiveDataProvider([
            'query' => $elaun,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $dataElaunLain = new ActiveDataProvider([
            'query' => $elaunlain,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $dataPotongan = new ActiveDataProvider([
            'query' => $potongan,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);


        return $this->render('view_slip', [
            'elaun' => $dataElaun,
            'elaunlain' => $dataElaunLain,
            'potongan' => $dataPotongan,
            'icno' => Tblmonthly_payment_detl::find()->where(['MPD_STAFF_ID' => $staff_id])->one()->umsper->ICNO,
        ]);
    }

    public function actionStaff($umsper)
    {
        \yii\helpers\Url::remember();
        $bio = Tblprcobiodata::findOne(['COOldID' => $umsper]);

        $max = Tblstaffroc::find()
            ->select(['SR_ROC_TYPE, max(SR_ENTER_DATE) as SR_ENTER_DATE'])
            ->where(['SR_STAFF_ID' => $umsper])
            ->groupBy('SR_ROC_TYPE');

        $query_gaji = Tblstaffroc::find()
            ->innerJoin(['b' => $max], 'b.SR_ROC_TYPE = hronline_gaji.staff_roc.SR_ROC_TYPE AND b.SR_ENTER_DATE = hronline_gaji.staff_roc.SR_ENTER_DATE')
            ->where(['SR_STAFF_ID' => $umsper, 'SR_DATE_TO' => null])
            ->orderBy(['SR_ENTER_DATE' => SORT_DESC, 'SR_ROC_TYPE' => SORT_ASC]);

        $query_lpg = Tblstaffrocbatch::find()
            ->where(['srb_staff_id' => $umsper])->andWhere(['!=','srb_status','CANCEL'])
            ->orderBy(['srb_effective_date' => SORT_DESC, 'srb_enter_date' => SORT_ASC]);

        $query3 = Tblstaffroc::find()
            ->leftJoin(['a' => '`hronline_gaji`.`migbkp_incometype_180226`'], '`a`.`it_income_code` = `SR_ROC_TYPE`')
            ->where(['`a`.`it_trans_type`' => 'ALLOWANCE', 'SR_STAFF_ID' => $umsper])
            ->orderBy(['SR_ENTER_DATE' => SORT_DESC]);

        $query4 = Tblstaffroc::find()
            ->leftJoin(['a' => '`gaji`.`migbkp_incometype_180226`'], '`a`.`it_income_code` = `SR_ROC_TYPE`')
            ->where(['`a`.`it_trans_type`' => 'DEDUCTION', 'SR_STAFF_ID' => $umsper])
            ->orderBy(['SR_ENTER_DATE' => SORT_DESC]);

        // return VarDumper::dump($query3->asArray()->all(), 10, true);

        $gaji = new ActiveDataProvider([
            'query' => $query_gaji,
            // 'pagination' => [
            //     //'pageSize' => 20,
            //     'pageSize' => 10,
            //     ],
            'sort' => false,
        ]);

        $lpg = new ActiveDataProvider([
            'query' => $query_lpg,
            'sort' => false,
        ]);

        $dataProvider3 = new ActiveDataProvider([
            'query' => $query3,
            'sort' => false,
        ]);

        $dataProvider4 = new ActiveDataProvider([
            'query' => $query4,
            'sort' => false,
        ]);
        $akaun = new ActiveDataProvider([
            'query' => Tblakaun::find()->where(['ICNO' => $bio->ICNO])->orderBy(['id' => SORT_DESC]),
            'sort' => false,
        ]);

        return $this->render('staff', [
            'gaji' => $gaji,
            'lpg' => $lpg,
            'dataProvider3' => $dataProvider3,
            'dataProvider4' => $dataProvider4,
            'bio' => $bio,
            'akaun' => $akaun,
        ]);
    }

    //LPG//
    public function actionTambahLpg($icno)
    {
        $bio = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $model = new Tblrscolpg();

        $model->t_lpg_jawatan_id = $bio->gredJawatan;

        if ($model->load(Yii::$app->request->post())) {
            $model->t_lpg_ICNO = $bio->ICNO;

            $model->created_by = Yii::$app->user->identity->ICNO;
            $model->created_datetime = new \yii\db\Expression('NOW()');

            if ($model->save(false)) {
                if ($model->t_lpg_cd == 11) {
                    $this->GenerateLpg($icno, $model->bulan, $model->t_lpg_cd, $model->getPrimaryKey());
                }
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'LPG berjaya ditambah!']);
                //                return $this->redirect(['saraan/rekod-lpg', 'icno' => $bio->ICNO]);
                return $this->goBack();
            }
        }

        return $this->renderAjax('tambah_lpg', [
            'model' => $model,
            'bio' => $bio,
        ]);
    }

    public function actionTambahKumpulan($staff_id)
    {
        $model = new Tblstaffrocbatch();
        $sg_bsalary = '0';
        $sg_biw = '0';
        $sg_itp = '0';
        $sg_itka = '0';
        $cur_elaun = [];
        $lpg_ids = TblKumpLpg::LpgId(Yii::$app->user->getId());

        if ($model->load(Yii::$app->request->post())) {

            $model->srb_cmpy_code = 'UMS';
            $date = date('Y-m-d h:i:s');
            preg_match_all('!\d+!', $date, $matches);
            $kod_tarikh =  implode('', $matches[0]);
            $model->srb_batch_code = 'SRB' . $kod_tarikh;
            $model->srb_staff_id = $staff_id;
            $model->srb_status = 'ENTRY';
            $model->srb_enter_by = Yii::$app->user->getId();
            $model->srb_enter_date = $date;
            $model->srb_dept_code = (string)$model->processDept->dm_dept_code; //department
            $model->srb_job_code = (string)$model->biodataSendiri->gredJawatan; //gred jawatan

            $lpg_attribute = [
                'SR_ROC_TYPE' => '', 'SR_CHANGE_REASON' => '', 'SR_NEW_VALUE' => '', 'SR_OLD_VALUE' => '',
                'SR_CALC_TYPE' => '', 'SR_DATE_FROM' => '', 'SR_DATE_TO' => '', 'SR_PROJECT_CODE' => '', 'sr_process_dept' => '',
                'SR_REMARK' => '',
            ];

           

            if ($model->save()) {

                if ($model->srb_change_reason == '11') {
                    //fetching allowances
                    $array_elaun = TblGajiTemplateLpg::find()->select('elaun_id')->where(['jenis_lpg_id'=>'11'])->asArray()->all();
                    $elauns_id = [];
                    for($i=0;$i < count($array_elaun);$i++){
                        array_push($elauns_id,$array_elaun[$i]['elaun_id']);
                    }
                    $saga_code_array = RefElaunName::find()->select('kod_saga')->where(['IN','id',$elauns_id])->all();
                    $saga_codes = [];
                    for($i=0;$i < count($saga_code_array);$i++){
                        array_push($saga_codes,$saga_code_array[$i]['kod_saga']);
                    }
                    // var_dump($saga_codes);
                    // die;
                    //end fetching allowances                    
                   
                    //keyin elaun
                    for ($i = 0; $i < count($saga_codes); $i++) {
                        $elaun_value = Tblmonthly_payment_detl::find()->where(['MPD_STAFF_ID' => $staff_id])->andWhere(['MPD_INCOME_CODE' => $saga_codes[$i]])->one();
                        if (!empty($elaun_value)) {
                            //keyin lpg attribute 
                            $lpg_attribute['SR_ROC_TYPE'] = 1;
                            $lpg_attribute['SR_CHANGE_REASON'] = $model->srb_change_reason;
                            switch ($saga_codes[$i]) {
                                case 'B1000':
                                    $gp = JadualGaji::find()->where(['r_jg_gred' => $model->gredJawatan->gred])->one();
                                    $new_elaun = $elaun_value->MPD_PAID_AMT + $gp->r_jg_kgt;
                                    if ($new_elaun > $gp->r_jg_maks) {
                                        $new_elaun = $gp->r_jg_maks;
                                    }
                                    break;
                                case 'E4000':
                                    $new_elaun = $elaun_value->MPD_PAID_AMT;

                                case 'E5000':
                                    $new_elaun = $elaun_value->MPD_PAID_AMT;

                                case 'E7200':
                                    $new_elaun = $elaun_value->MPD_PAID_AMT;

                                default:
                                    # code...
                                    break;
                            }

                            $lpg_attribute['SR_NEW_VALUE'] = $new_elaun;
                            $lpg_attribute['SR_OLD_VALUE'] = $elaun_value->MPD_PAID_AMT;
                            $lpg_attribute['SR_CALC_TYPE'] = '1';
                            $lpg_attribute['SR_DATE_FROM'] = $model->srb_effective_date;
                            $lpg_attribute['SR_DATE_TO'] = $date;
                            $lpg_attribute['SR_PROJECT_CODE'] = 1;
                            $lpg_attribute['sr_process_dept'] = $model->srb_process_dept;
                            $lpg_attribute['SR_REMARK'] = 'ok';

                            $res = self::AutoElaun($model->srb_batch_code, $staff_id, $lpg_attribute, $elaun_type = $saga_codes[$i]);
                            if ($res == false) {
                                echo 'Terdapat elaun yang tidak berjaya disimpan : '.$saga_codes[$i];
                                echo '</br>';
                                echo 'Hubungi Pegawai IT.';
                                die;
                            }
                        }
                        
                    }// end keyin elaun
                }

                return $this->redirect([
                    'view-kumpulan',
                    'bid' => $model->srb_batch_code,
                    'sid' => $staff_id,
                ]);
            }

            var_dump($model->errors); // delete this line for production
            die;
        }

        return $this->render('lpg/tambah_kumpulan', [
            'model' => $model,
            'lpg_ids' => $lpg_ids,
        ]);
        // return $this->renderAjax('lpg/tambah_kumpulan',[
        //     'model' => $model,
        // ]);
    }

    private static function AutoElaun($bid, $sid, $lpg_attribute, $elaun_type)
    {
        $tdate = date('Y-m-d h:i:s');
        $model = new Tblstaffroc();

        $model->SR_ROC_TYPE = $elaun_type;
        $model->SR_CHANGE_REASON = $lpg_attribute['SR_CHANGE_REASON'];
        $model->SR_NEW_VALUE = $lpg_attribute['SR_NEW_VALUE'];
        $model->SR_OLD_VALUE = $lpg_attribute['SR_OLD_VALUE'];
        $model->SR_CALC_TYPE = $lpg_attribute['SR_CALC_TYPE'];
        $model->SR_DATE_FROM = $lpg_attribute['SR_DATE_FROM'];
        $model->SR_DATE_TO = $lpg_attribute['SR_DATE_TO'];
        $model->SR_PROJECT_CODE = $lpg_attribute['SR_PROJECT_CODE'];
        $model->sr_process_dept = $lpg_attribute['sr_process_dept'];
        $model->SR_REMARK = $lpg_attribute['SR_REMARK'];

        $model->SR_REF_ID = $elaun_type . $sid . $bid . $tdate;
        $model->SR_CMPY_CODE = 'UMS';
        $model->SR_STAFF_ID = $sid;
        $model->SR_ACCOUNT_NO = '111';
        $model->SR_ACCHOLDER_NAME = 'from table akaun';
        $model->SR_CCTR_CHARGE = 'dummy';
        $model->SR_ALLOWANCE_CODE = 'dummy';
        $model->SR_ENTRY_BATCH = $bid;
        $model->SR_CHANGE_TYPE = 'dummy';
        $model->SR_OLD_CCTR_CHARGE = 'dummy';
        $model->SR_OLD_PROJECT_CODE = 'dummy';
        $model->SR_OLD_ACCOUNT_NO = 'dummy';
        $model->SR_OLD_ACCHOLDER_NAME = 'dummy';
        $model->SR_ACTUAL_MONTH = 'dummy';
        $model->SR_STATUS = 'ENTRY';
        $model->SR_ENTER_BY = Yii::$app->user->getId();
        $model->SR_ENTER_DATE = date('Y-m-d h:i:s');
        $model->SR_SUBSYSTEM = 'dummy';
        $model->SR_SUBSYSTEM_REFID = 'dummy';
        $model->SR_PA_SEQ_NO = 'dummy';
        $model->sr_update_seq_no = 'dummy';
        $model->save(false);

        return true;
    }

    public function actionTambahElaun($bid, $sid, $key = null)
    { //id = staff_id
        $tdate = date('Y-m-d h:i:s');
        $model = new Tblstaffroc();

        if ($model->load(Yii::$app->request->post())) {
            $model->SR_REF_ID = $model->SR_ROC_TYPE . $sid . $bid . $tdate;
            $model->SR_CMPY_CODE = 'UMS';
            $model->SR_STAFF_ID = $sid;
            $model->SR_ACCOUNT_NO = '111';
            $model->SR_ACCHOLDER_NAME = 'from table akaun';
            $model->SR_CCTR_CHARGE = 'dummy';
            $model->SR_ALLOWANCE_CODE = 'dummy';
            $model->SR_ENTRY_BATCH = $bid;
            $model->SR_CHANGE_TYPE = 'dummy';
            $model->SR_OLD_CCTR_CHARGE = 'dummy';
            $model->SR_OLD_PROJECT_CODE = 'dummy';
            $model->SR_OLD_ACCOUNT_NO = 'dummy';
            $model->SR_OLD_ACCHOLDER_NAME = 'dummy';
            $model->SR_ACTUAL_MONTH = 'dummy';
            $model->SR_STATUS = 'APPLY';
            $model->SR_ENTER_BY = Yii::$app->user->getId();
            $model->SR_ENTER_DATE = date('Y-m-d h:i:s');
            $model->SR_SUBSYSTEM = 'dummy';
            $model->SR_SUBSYSTEM_REFID = 'dummy';
            $model->SR_PA_SEQ_NO = 'dummy';
            $model->sr_update_seq_no = 'dummy';
            $model->save(false);

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Elaun berjaya ditambah!']);

            return $this->redirect(['view-kumpulan', 'bid' => $bid, 'sid' => $sid]);
        }

        return $this->renderAjax('lpg/tambah_elaun', [
            'model' => $model,
        ]);
    }

    public function actionKemaskiniElaun($eid)
    {
        $elaun = Tblstaffroc::find()->where(['SR_REF_ID' => $eid])->one();

        if ($elaun->load(Yii::$app->request->post()) && $elaun->save()) {

            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Elaun berjaya dikemaskini!']);

            return $this->redirect(['view-kumpulan', 'bid' => $elaun->SR_ENTRY_BATCH, 'sid' => $elaun->SR_STAFF_ID]);
        }

        return $this->renderAjax('lpg/tambah_elaun', [
            'model' => $elaun,
        ]);
    }

    public function actionPadamElaun($eid)
    {

        $elaun = $this->FindTblstaffroc($eid);
        if ($elaun->delete()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Elaun berjaya dibuang!']);
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'Gagal', 'type' => 'error', 'msg' => 'Elaun tidak berjaya dibuang!']);
        }

        return $this->redirect(['view-kumpulan', 'bid' => $elaun->SR_ENTRY_BATCH, 'sid' => $elaun->SR_STAFF_ID]);
    }

    public function actionViewKumpulan($bid, $sid)
    { // bid = batch code


        $model = new ActiveDataProvider([
            'query' => Tblstaffrocbatch::find()->where(['srb_batch_code' => $bid]),
            'sort' => false,
        ]);

        $query = TblStaffRoc::find()->where(['SR_ENTRY_BATCH' => $bid])->orderBy(['SR_CHANGE_TYPE' => 'ASC']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => false,
        ]);

        return $this->render('lpg/lihat_kumpulan', [
            'model' => $model,
            'id' => $bid,
            'staff_id' => $sid,
            'dataProvider2' => $dataProvider,

        ]);
    }

    public function GenerateLpg($icno, $month, $lpgCd, $id)
    {
        $cd = null;
        $remark = null;
        $i_amt = null;
        $i_amt_max = null;

        $bio = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $date = date("Y") . "-" . $month . "-01 00:01:00";
        //$date = html_entity_decode($date);

        $max_date = TblStaffRocBatch::find()
            ->select(['MAX(srb_verify_date)'])
            ->where(['srb_staff_id' => $bio->COOldID])
            ->andWhere(['>=', 'srb_verify_date', '2012-01-01'])
            ->andWhere(['srb_status' => 'APPROVE'])
            ->andWhere(['srb_change_reason' => $lpgCd])
            ->asArray()
            ->one();

        $cnt = TblStaffRocBatch::find()
            ->where(['srb_staff_id' => $bio->COOldID])
            ->andWhere(['>=', 'srb_verify_date', '2012-01-01'])
            ->andWhere(['srb_status' => 'APPROVE'])
            ->andWhere(['srb_verify_date' => $max_date])
            ->andWhere(['srb_change_reason' => $lpgCd])
            ->count();

        if ($cnt == 1) {
            $old_lpg = TblStaffRocBatch::find()
                ->select(['MAX(srb_batch_code)'])
                ->where(['srb_staff_id' => $bio->COOldID])
                ->andWhere(['srb_status' => 'APPROVE'])
                ->andWhere(['srb_verify_date' => $max_date])
                ->andWhere(['srb_change_reason' => $lpgCd])
                ->asArray()
                ->one();
        } else {
            $old_lpg = TblStaffRocBatch::find()
                ->select(['MAX(srb_batch_code)'])
                ->where(['srb_staff_id' => $bio->COOldID])
                ->andWhere(['srb_job_code' => $bio->jawatan->id])
                ->andWhere(['srb_status' => 'APPROVE'])
                ->andWhere(['srb_verify_date' => $max_date])
                ->andWhere(['srb_change_reason' => $lpgCd])
                ->asArray()
                ->one();
        }

        if (is_null($old_lpg) == false) {

            $insert_id = $id;

            $elaun = TblStaffRoc::find()
                ->select(['hrm.gaji_staff_roc.*', 'hrm.gaji_mig_Income_code_mapping.hronline_id'])
                ->joinWith('elaunn')
                ->where(['SR_STAFF_ID' => $bio->COOldID])->andWhere(['SR_ENTRY_BATCH' => $old_lpg])
                ->asArray()
                ->all();

            $arryy = array();

            $arryy1 = array();

            foreach ($elaun as $aaa) {
                array_push($arryy, $aaa['hronline_id']);
            }

            foreach ($elaun as $aaa) {
                array_push($arryy1, $aaa['SR_NEW_VALUE']);
            }

            foreach ($arryy as $key => $el) {
                if (is_null($el)) {
                    continue;
                }

                $elaun_amt = $this->JumlahElaun($insert_id, $el);

                if (is_null($elaun_amt)) {
                    $elaun_amt = $arryy1[$key];
                }

                $mod = new Tblrscoelaun();
                $mod->el_lpg_id = $insert_id;
                $mod->el_elaun_cd = $el;
                $mod->el_amount = $elaun_amt;
                $mod->el_created_by = null;
                $mod->el_bln_khidmat = 0;
                $mod->save(false);
            }
        }

        //echo \yii\helpers\VarDumper::dump($elaun, 10, true);
        //return $this->render('index');

    }

    //tamat LPG//

    //kemasukan @ entry//

    public function actionKemasukan(){
        $carian = new TblprcobiodataSearch();
        $dataProvider = $carian->payroll_carian(Yii::$app->request->queryParams);
        
        return $this->render('kemasukan/index',[
            'carian' => $carian,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionKemasukanLPG(){
        $search = new TblstaffrocbatchSearch();
        $dataProvider = $search->searchKemasukan(Yii::$app->request->queryParams);

        $selection = (array)Yii::$app->request->post('selection');
        if (Yii::$app->request->post('hantar')) {
            foreach ($selection as $bid) {
                $user_staff_id = $this->findModel(Yii::$app->user->getId())->COOldID;
                $kumpulan = $this->FindTblstaffrocbatch($bid);
                $kumpulan->srb_verify_by = $user_staff_id;
                $kumpulan->srb_verify_date = date('Y-m-d h:i:s');
                $kumpulan->srb_status = 'APPLY';
                $kumpulan->save(false);
        
                $elaun = $this->FindTblstaffroc(null, $bid);
                if (!empty($elaun)) {
                    foreach ($elaun as $elaun) {
                        $elaun->SR_VERIFY_BY = $user_staff_id;
                        $elaun->SR_VERIFY_DATE = date('Y-m-d h:i:s');
                        $elaun->SR_STATUS = 'APPLY';
                        $elaun->save(false);
                    }
                }
            }
            // Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Disimpan', 'type' => 'success', 'msg' => '']); 
            //return $this->refresh();
        }else if(Yii::$app->request->post('buang')){
            foreach ($selection as $bid) {
                $user_staff_id = $this->findModel(Yii::$app->user->getId())->COOldID;
                $kumpulan = $this->FindTblstaffrocbatch($bid);
                $kumpulan->srb_verify_by = $user_staff_id;
                $kumpulan->srb_verify_date = date('Y-m-d h:i:s');
                $kumpulan->srb_status = 'CANCEL';
                $kumpulan->save(false);
        
                $elaun = $this->FindTblstaffroc(null, $bid);
                if (!empty($elaun)) {
                    foreach ($elaun as $elaun) {
                        $elaun->SR_VERIFY_BY = $user_staff_id;
                        $elaun->SR_VERIFY_DATE = date('Y-m-d h:i:s');
                        $elaun->SR_STATUS = 'CANCEL';
                        $elaun->save(false);
                    }
                }
            }
        }
        
        return $this->render('kemasukan/LPG_Entry',[
            'search' => $search,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTindakanKemasukan($id){
      
        $kumpulan = new ActiveDataProvider([
            'query' => Tblstaffrocbatch::find()->where(['srb_batch_code'=>$id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $elaun = new ActiveDataProvider([
            'query' => Tblstaffroc::find()->where(['SR_ENTRY_BATCH'=>$id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if($kumpulan->totalCount == 0){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('kemasukan/tindakanTTP',[
            'kumpulan'=>$kumpulan,
            'elaun'=>$elaun,
            'srb_batch_code'=>$id,
        ]);

    }

    public function actionTindakanKemasukanHantar($bid){
        $user_staff_id = $this->findModel(Yii::$app->user->getId())->COOldID;
        $kumpulan = $this->FindTblstaffrocbatch($bid);
        $kumpulan->srb_verify_by = $user_staff_id;
        $kumpulan->srb_verify_date = date('Y-m-d h:i:s');
        $kumpulan->srb_status = 'APPLY';
        $kumpulan->save(false);

        $elaun = $this->FindTblstaffroc(null, $bid);
        if (!empty($elaun)) {
            foreach ($elaun as $elaun) {
                $elaun->SR_VERIFY_BY = $user_staff_id;
                $elaun->SR_VERIFY_DATE = date('Y-m-d h:i:s');
                $elaun->SR_STATUS = 'APPLY';
                $elaun->save(false);
            }
        }

        return $this->redirect([
            'tindakan-kemasukan',
            'id' => $bid,
        ]);
    }

    public function actionTindakanKemasukanBuang($bid){
        $user_staff_id = $this->findModel(Yii::$app->user->getId())->COOldID;
        $kumpulan = $this->FindTblstaffrocbatch($bid);
        $kumpulan->srb_verify_by = $user_staff_id;
        $kumpulan->srb_verify_date = date('Y-m-d h:i:s');
        $kumpulan->srb_status = 'CANCEL';
        $kumpulan->save(false);

        $elaun = $this->FindTblstaffroc(null, $bid);
        if (!empty($elaun)) {
            foreach ($elaun as $elaun) {
                $elaun->SR_VERIFY_BY = $user_staff_id;
                $elaun->SR_VERIFY_DATE = date('Y-m-d h:i:s');
                $elaun->SR_STATUS = 'CANCEL';
                $elaun->save(false);
            }
        }

        return $this->redirect([
            'kemasukan',
        ]);
    }
    //tamat kemasukan @ entry//

    //semakan//
    public function actionSemakan(){
        $carian = new TblprcobiodataSearch();
        $dataProvider = $carian->payroll_carian(Yii::$app->request->queryParams);
        
        return $this->render('semakan/index',[
            'carian' => $carian,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionSemakanLPG(){
        $search = new TblstaffrocbatchSearch();
        $dataProvider = $search->searchSemakan(Yii::$app->request->queryParams);

        $selection = (array)Yii::$app->request->post('selection');
        if (Yii::$app->request->post('semak')) {
            foreach ($selection as $bid) {
                $user_staff_id = $this->findModel(Yii::$app->user->getId())->COOldID;
                $kumpulan = $this->FindTblstaffrocbatch($bid);
                $kumpulan->srb_verify_by = $user_staff_id;
                $kumpulan->srb_verify_date = date('Y-m-d h:i:s');
                $kumpulan->srb_status = 'VERIFY';
                $kumpulan->save(false);
        
                $elaun = $this->FindTblstaffroc(null, $bid);
                if (!empty($elaun)) {
                    foreach ($elaun as $elaun) {
                        $elaun->SR_VERIFY_BY = $user_staff_id;
                        $elaun->SR_VERIFY_DATE = date('Y-m-d h:i:s');
                        $elaun->SR_STATUS = 'VERIFY';
                        $elaun->save(false);
                    }
                }
            }
            // Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Disimpan', 'type' => 'success', 'msg' => '']); 
            //return $this->refresh();
        }else if(Yii::$app->request->post('pulang')){
            foreach ($selection as $bid) {
                $user_staff_id = $this->findModel(Yii::$app->user->getId())->COOldID;
                $kumpulan = $this->FindTblstaffrocbatch($bid);
                $kumpulan->srb_verify_by = $user_staff_id;
                $kumpulan->srb_verify_date = date('Y-m-d h:i:s');
                $kumpulan->srb_status = 'ENTRY';
                $kumpulan->save(false);
        
                $elaun = $this->FindTblstaffroc(null, $bid);
                if (!empty($elaun)) {
                    foreach ($elaun as $elaun) {
                        $elaun->SR_VERIFY_BY = $user_staff_id;
                        $elaun->SR_VERIFY_DATE = date('Y-m-d h:i:s');
                        $elaun->SR_STATUS = 'ENTRY';
                        $elaun->save(false);
                    }
                }
            }
        }else if(Yii::$app->request->post('tolak')){
            foreach ($selection as $bid) {
                $user_staff_id = $this->findModel(Yii::$app->user->getId())->COOldID;
                $kumpulan = $this->FindTblstaffrocbatch($bid);
                $kumpulan->srb_verify_by = $user_staff_id;
                $kumpulan->srb_verify_date = date('Y-m-d h:i:s');
                $kumpulan->srb_status = 'REJECT';
                $kumpulan->save(false);
        
                $elaun = $this->FindTblstaffroc(null, $bid);
                if (!empty($elaun)) {
                    foreach ($elaun as $elaun) {
                        $elaun->SR_VERIFY_BY = $user_staff_id;
                        $elaun->SR_VERIFY_DATE = date('Y-m-d h:i:s');
                        $elaun->SR_STATUS = 'REJECT';
                        $elaun->save(false);
                    }
                }
            }
        }
        
        return $this->render('semakan/LPG_Entry',[
            'search' => $search,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTindakanSemakan($id){
      
        $kumpulan = new ActiveDataProvider([
            'query' => Tblstaffrocbatch::find()->where(['srb_batch_code' => $id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $elaun = new ActiveDataProvider([
            'query' => Tblstaffroc::find()->where(['SR_ENTRY_BATCH' => $id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('semakan/tindakanTTP',[
            'kumpulan'=>$kumpulan,
            'elaun'=>$elaun,
            'srb_batch_code'=>$id,
        ]);
    }
    public function actionSemakanDiterima(){  //will see later
        $search = new TblstaffrocbatchSearch();
        $dataProvider = $search->searchSemakanDiterima(Yii::$app->request->queryParams);
        
        return $this->render('semakan/diterima',[
            'search' => $search,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionSemakanDitolak(){ //will see later
        $search = new TblstaffrocbatchSearch();
        $dataProvider = $search->searchSemakanDiterima(Yii::$app->request->queryParams);
        
        return $this->render('semakan/ditolak',[
            'search' => $search,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionSemakanDipulangkan(){ //will see later
        $search = new TblstaffrocbatchSearch();
        $dataProvider = $search->searchSemakanDiterima(Yii::$app->request->queryParams);
        
        return $this->render('semakan/dipulangkan',[
            'search' => $search,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTindakanSemakanDisemak($bid){
        $user_staff_id = $this->findModel(Yii::$app->user->getId())->COOldID;
        $kumpulan = $this->FindTblstaffrocbatch($bid);
        $kumpulan->srb_verify_by = $user_staff_id;
        $kumpulan->srb_verify_date = date('Y-m-d h:i:s');
        $kumpulan->srb_status = 'VERIFY';
        $kumpulan->save(false);

        $elaun = $this->FindTblstaffroc(null, $bid);
        if (!empty($elaun)) {
            foreach ($elaun as $elaun) {
                $elaun->SR_VERIFY_BY = $user_staff_id;
                $elaun->SR_VERIFY_DATE = date('Y-m-d h:i:s');
                $elaun->SR_STATUS = 'VERIFY';
                $elaun->save(false);
            }
        }

        return $this->redirect([
            'tindakan-semakan',
            'id' => $bid,
        ]);
    }
    public function actionTindakanSemakanTolak($bid)
    {
        $user_staff_id = $this->findModel(Yii::$app->user->getId())->COOldID;
        $kumpulan = $this->FindTblstaffrocbatch($bid);
        $kumpulan->srb_verify_by = $user_staff_id;
        $kumpulan->srb_verify_date = date('Y-m-d h:i:s');
        $kumpulan->srb_status = 'REJECT';
        $kumpulan->save(false);

        $elaun = $this->FindTblstaffroc(null, $bid);
        if (!empty($elaun)) {
            foreach ($elaun as $elaun) {
                $elaun->SR_VERIFY_BY = $user_staff_id;
                $elaun->SR_VERIFY_DATE = date('Y-m-d h:i:s');
                $elaun->SR_STATUS = 'REJECT';
                $elaun->save(false);
            }
        }

        return $this->redirect([
            'tindakan-semakan',
            'id' => $bid,
        ]);
    }
    public function actionTindakanSemakanPulang($bid)
    {
        $user_staff_id = $this->findModel(Yii::$app->user->getId())->COOldID;
        $kumpulan = $this->FindTblstaffrocbatch($bid);
        $kumpulan->srb_verify_by = $user_staff_id;
        $kumpulan->srb_verify_date = date('Y-m-d h:i:s');
        $kumpulan->srb_status = 'ENTRY';
        $kumpulan->save(false);

        $elaun = $this->FindTblstaffroc(null, $bid);
        if (!empty($elaun)) {
            foreach ($elaun as $elaun) {
                $elaun->SR_VERIFY_BY = $user_staff_id;
                $elaun->SR_VERIFY_DATE = date('Y-m-d h:i:s');
                $elaun->SR_STATUS = 'ENTRY';
                $elaun->save(false);
            }
        }

        return $this->redirect([
            'tindakan-semakan',
            'id' => $bid,
        ]);
    }
    //tamat semakan//

    //kelulusan//
    public function actionKelulusan(){
        $carian = new TblprcobiodataSearch();
        $dataProvider = $carian->payroll_carian(Yii::$app->request->queryParams);
        
        return $this->render('kelulusan/index',[
            'carian' => $carian,
            'dataProvider' => $dataProvider,
        ]); 
    }

    public function actionKelulusanLPG(){ //batch
        $search = new TblstaffrocbatchSearch();
        $dataProvider = $search->searchKelulusan(Yii::$app->request->queryParams);

        $selection = (array)Yii::$app->request->post('selection');
        if (Yii::$app->request->post('lulus')) {
            foreach ($selection as $bid) {
                $user_staff_id = $this->findModel(Yii::$app->user->getId())->COOldID;
                $kumpulan = $this->FindTblstaffrocbatch($bid);
                $kumpulan->srb_verify_by = $user_staff_id;
                $kumpulan->srb_verify_date = date('Y-m-d h:i:s');
                $kumpulan->srb_status = 'APPROVE';
                $kumpulan->save(false);
        
                $elaun = $this->FindTblstaffroc(null, $bid);
                if (!empty($elaun)) {
                    foreach ($elaun as $elaun) {
                        $elaun->SR_VERIFY_BY = $user_staff_id;
                        $elaun->SR_VERIFY_DATE = date('Y-m-d h:i:s');
                        $elaun->SR_STATUS = 'APPROVE';
                        $elaun->save(false);
                    }
                }
            }
            // Yii::$app->session->setFlash('alert', ['title' => 'Berjaya Disimpan', 'type' => 'success', 'msg' => '']); 
            //return $this->refresh();
        }else if(Yii::$app->request->post('pulang')){
            foreach ($selection as $bid) {
                $user_staff_id = $this->findModel(Yii::$app->user->getId())->COOldID;
                $kumpulan = $this->FindTblstaffrocbatch($bid);
                $kumpulan->srb_verify_by = $user_staff_id;
                $kumpulan->srb_verify_date = date('Y-m-d h:i:s');
                $kumpulan->srb_status = 'ENTRY';
                $kumpulan->save(false);
        
                $elaun = $this->FindTblstaffroc(null, $bid);
                if (!empty($elaun)) {
                    foreach ($elaun as $elaun) {
                        $elaun->SR_VERIFY_BY = $user_staff_id;
                        $elaun->SR_VERIFY_DATE = date('Y-m-d h:i:s');
                        $elaun->SR_STATUS = 'ENTRY';
                        $elaun->save(false);
                    }
                }
            }
        }else if(Yii::$app->request->post('tolak')){
            foreach ($selection as $bid) {
                $user_staff_id = $this->findModel(Yii::$app->user->getId())->COOldID;
                $kumpulan = $this->FindTblstaffrocbatch($bid);
                $kumpulan->srb_verify_by = $user_staff_id;
                $kumpulan->srb_verify_date = date('Y-m-d h:i:s');
                $kumpulan->srb_status = 'REJECT';
                $kumpulan->save(false);
        
                $elaun = $this->FindTblstaffroc(null, $bid);
                if (!empty($elaun)) {
                    foreach ($elaun as $elaun) {
                        $elaun->SR_VERIFY_BY = $user_staff_id;
                        $elaun->SR_VERIFY_DATE = date('Y-m-d h:i:s');
                        $elaun->SR_STATUS = 'REJECT';
                        $elaun->save(false);
                    }
                }
            }
        }
        
        return $this->render('kelulusan/LPG_Entry',[
            'search' => $search,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTindakanKelulusan($id)
    {

        $kumpulan = new ActiveDataProvider([
            'query' => Tblstaffrocbatch::find()->where(['srb_batch_code' => $id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $elaun = new ActiveDataProvider([
            'query' => Tblstaffroc::find()->where(['SR_ENTRY_BATCH' => $id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        return $this->render('kelulusan/tindakanTTP',[
            'kumpulan'=>$kumpulan,
            'elaun'=>$elaun,
            'srb_batch_code'=>$id,
        ]);
    }
    public function actionTindakanKelulusanTerima($bid)
    {
        $user_staff_id = $this->findModel(Yii::$app->user->getId())->COOldID;
        $kumpulan = $this->FindTblstaffrocbatch($bid);
        $kumpulan->srb_verify_by = $user_staff_id;
        $kumpulan->srb_verify_date = date('Y-m-d h:i:s');
        $kumpulan->srb_status = 'APPROVE';
        $kumpulan->save(false);

        $elaun = $this->FindTblstaffroc(null, $bid);
        if (!empty($elaun)) {
            foreach ($elaun as $elaun) {
                $elaun->SR_VERIFY_BY = $user_staff_id;
                $elaun->SR_VERIFY_DATE = date('Y-m-d h:i:s');
                $elaun->SR_STATUS = 'APPROVE';
                $elaun->save(false);
            }
        }

        return $this->redirect([
            'tindakan-kelulusan',
            'id' => $bid,
        ]);
    }
    public function actionTindakanKelulusanPulang($bid){
        $user_staff_id = $this->findModel(Yii::$app->user->getId())->COOldID;
        $kumpulan = $this->FindTblstaffrocbatch($bid);
        $kumpulan->srb_verify_by = $user_staff_id;
        $kumpulan->srb_verify_date = date('Y-m-d h:i:s');
        $kumpulan->srb_status = 'ENTRY';
        $kumpulan->save(false);

        $elaun = $this->FindTblstaffroc(null, $bid);
        if(!empty($elaun)){
            foreach ($elaun as $elaun) {
                $elaun->SR_VERIFY_BY = $user_staff_id;
                $elaun->SR_VERIFY_DATE = date('Y-m-d h:i:s');
                $elaun->SR_STATUS = 'ENTRY';
                $elaun->save(false);
            }
        }
        
        return $this->redirect([
            'tindakan-kelulusan',
            'id' => $bid,
        ]);
    }
    public function actionTindakanKelulusanTolak($bid){
        $user_staff_id = $this->findModel(Yii::$app->user->getId())->COOldID;
        $kumpulan = $this->FindTblstaffrocbatch($bid);
        $kumpulan->srb_verify_by = $user_staff_id;
        $kumpulan->srb_verify_date = date('Y-m-d h:i:s');
        $kumpulan->srb_status = 'REJECT';
        $kumpulan->save(false);

        $elaun = $this->FindTblstaffroc(null, $bid);
        if (!empty($elaun)) {
            foreach ($elaun as $elaun) {
                $elaun->SR_VERIFY_BY = $user_staff_id;
                $elaun->SR_VERIFY_DATE = date('Y-m-d h:i:s');
                $elaun->SR_STATUS = 'REJECT';
                $elaun->save(false);
            }
        }

        return $this->redirect([
            'tindakan-kelulusan',
            'id' => $bid,
        ]);
    }
    //tamat kelulusan//


    protected function findModel($id)
    {
        if (($model = Tblprcobiodata::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    private static function FindTblstaffrocbatch($bid)
    {

        $model = Tblstaffrocbatch::find()->where(['srb_batch_code' => $bid])->one();
        if ($model != null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist. (Elaun Not Found!)');
    }

    private static function FindTblstaffroc($eid = null, $bid = null)
    {
        if ($eid != null) {
            $model = Tblstaffroc::find()->where(['SR_REF_ID' => $eid])->one();
        } else {
            $model = Tblstaffroc::find()->where(['SR_ENTRY_BATCH' => $bid])->all();
        }
        return $model;

        if ($model != null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist. (Elaun Not Found!)');
    }

    public function actionListTemplateLpgKew8()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TblGajiTemplateLpg::find()->orderBy([
                'jenis_lpg_id' => SORT_ASC,
            ]),
        ]);

        return $this->render('lpg/list_template_lpg', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreateTemplate()
    {

        $model = new \yii\base\DynamicModel([
            'jenis_lpg',
        ]);
        $model->addRule(['jenis_lpg'], 'integer')
            ->addRule(['jenis_lpg'], 'required');

        $modelsElaun = [new TblGajiTemplateLpg];

        if ($model->load(Yii::$app->request->post())) {

            $modelsElaun = Model::createMultiple(TblGajiTemplateLpg::classname(), null, 'TblGajiTemplateLpg');

            Model::loadMultiple($modelsElaun, Yii::$app->request->post('TblGajiTemplateLpg'), '');

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return \yii\helpers\ArrayHelper::merge(
                    \yii\widgets\ActiveForm::validateMultiple($modelsElaun),
                    \yii\widgets\ActiveForm::validate($model)
                );
            }

            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsElaun) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $flag = true;
                    foreach ($modelsElaun as $modelElaun) {

                        $modelElaun->jenis_lpg_id = $model->jenis_lpg;
                        $modelElaun->create_by = Yii::$app->user->identity->ICNO;
                        $modelElaun->create_dt = new \yii\db\Expression('NOW()');
                        if (($flag = $modelElaun->save()) == false) {
                            $transaction->rollBack();
                            Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => 'Duplicate Entry']);
                            return $this->redirect(['list-template-lpg-kew8']);
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
                        return $this->redirect(['list-template-lpg-kew8']);
                    }
                } catch (\yii\base\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => 'Problem Occurred While Saving']);
                    return $this->redirect(['list-template-lpg-kew8']);
                }
            }
        }

        return $this->renderAjax('lpg/template_form', [
            'model' => $model,
            'modelsElaun' => (empty($modelsElaun)) ? [new TblGajiTemplateLpg] : $modelsElaun
        ]);
    }

    public function actionUpdateTemplate($id)
    {
        $modelsElaun = TblGajiTemplateLpg::find()->where(['jenis_lpg_id' => $id])->all();
        $model = new \yii\base\DynamicModel([
            'jenis_lpg',
        ]);
        $model->addRule(['jenis_lpg'], 'integer')
            ->addRule(['jenis_lpg'], 'required');
        $model->jenis_lpg = $modelsElaun[0]->jenis_lpg_id;

        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = \yii\helpers\ArrayHelper::map($modelsElaun, 'id', 'id');
            $modelsElaun = Model::createMultiple(TblGajiTemplateLpg::classname(), $modelsElaun);
            Model::loadMultiple($modelsElaun, Yii::$app->request->post('TblGajiTemplateLpg'), '');
            $deletedIDs = array_diff($oldIDs, array_filter(\yii\helpers\ArrayHelper::map($modelsElaun, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return \yii\helpers\ArrayHelper::merge(
                    \yii\widgets\ActiveForm::validateMultiple($modelsElaun),
                    \yii\widgets\ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsElaun) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $flag = true;
                    if (!empty($deletedIDs)) {
                        TblGajiTemplateLpg::deleteAll(['id' => $deletedIDs]);
                    }
                    foreach ($modelsElaun as $modelElaun) {
                        $modelElaun->jenis_lpg_id = $model->jenis_lpg;
                        if (is_null($modelElaun->create_by)) {
                            $modelElaun->create_by = Yii::$app->user->identity->ICNO;
                            $modelElaun->create_dt = new \yii\db\Expression('NOW()');
                        } else {
                            $modelElaun->update_by = Yii::$app->user->identity->ICNO;
                            $modelElaun->update_dt = new \yii\db\Expression('NOW()');
                        }

                        if (!($flag = $modelElaun->save())) {
                            $transaction->rollBack();
                            Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => 'Duplicate Entry']);
                            return $this->redirect(['list-template-lpg-kew8']);
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya disimpan!']);
                        return $this->redirect(['list-template-lpg-kew8']);
                    }
                } catch (\yii\base\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('alert', ['title' => 'Perhatian', 'type' => 'warning', 'msg' => 'Problem Occurred While Saving']);
                    return $this->redirect(['list-template-lpg-kew8']);
                }
            }
        }

        return $this->renderAjax('lpg/template_form', [
            'model' => $model,
            'modelsElaun' => (empty($modelsElaun)) ? [new TblGajiTemplateLpg] : $modelsElaun
        ]);
    }

    public function actionDeleteTemplate($id)
    {
        TblGajiTemplateLpg::deleteAll(['jenis_lpg_id' => $id]);

        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Data berjaya dipadam!']);
        return $this->redirect(['list-template-lpg-kew8']);
    }

    public function actionChecklistPelepasanCukai()
    {
        $biodata = Tblprcobiodata::find()->where(['ICNO' => Yii::$app->user->getId()])->one();
        $modelSoalanA = \app\models\hronline\RefPelepasanCukai::find();

        $dataProviderA = new ActiveDataProvider([
            'query' => $modelSoalanA,
            'pagination' => false,
        ]);

        $modelL = new \app\models\hronline\TblPelepasanCukai();
        if ($modelL->load(Yii::$app->request->post())) {

            $modelL->icno = Yii::$app->user->getId();
            $modelL->umsper = $biodata->COOldID;
            $modelL->created_at = date('Y-m-d H:i:s');
            $modelL->status = 1;
            $modelL->save();

            if ($modelL->save()) {
                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Berjaya Disimpan']);
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
            }
        }

        return $this->render('checklist-pelepasan-cukai', [
            'modelL' => $modelL,
            'dataProviderA' => $dataProviderA, 'biodata' => $biodata
        ]);
    }
}
