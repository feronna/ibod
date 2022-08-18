<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\helpers\Json;
use yii\base\Exception;
use app\models\hronline\TblStaffSalary;
use app\models\hronline\Tblprcobiodata;
use app\models\gaji\TblprcobiodataSearch;
use app\models\gaji\TblStaffRoc;
use app\models\gaji\Tblrscolpg;
use app\models\gaji\TblStaffRocBatch;
use app\models\gaji\TblStaffAkses;
use app\models\gaji\TblStaffAksesSearch;
use app\models\gaji\RefJadualGaji;
use app\models\gaji\Tblrscoelaun;
use app\models\gaji\RefRocReason;
use yii\web\NotFoundHttpException;
use yii\base\UserException;
use yii\helpers\VarDumper;

class SaraanController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //               'only' => ['lpg'],
                'rules' => [
                    [
                        'actions' => ['index', 'lpg-report'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => [
                            'dashboard',
                            'carian-kakitangan',
                            //                            'kemaskini-akses', 'padam-akses', 'tambah-akses', 'penetapan-staf-akses',
                            //                            'kemaskini-lpg', 'tambah-lpg', 'padam-lpg', 
                            'rekod-lpg', 'lpg-report-2',
                            'rekod-lpg-v2',
                            'elaun-details',
                            'kumpulan', 'create-elaun'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query = TblStaffAkses::find()
                                ->where(['staf_akses_icno' => Yii::$app->user->identity->ICNO])
                                //                                ->andWhere(['staf_akses_id' => ['99']])
                                ->exists();

                            if ($query) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                            }
                        },
                    ],
                    [
                        'actions' => [
                            //                           'dashboard',
                            //                           'carian-kakitangan', 
                            'kemaskini-akses', 'padam-akses', 'tambah-akses', 'penetapan-staf-akses',
                            //                           'kemaskini-lpg', 'lpg-report-2', 'padam-lpg', 'tambah-lpg', 'rekod-lpg'
                            'generate-report'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query = TblStaffAkses::find()
                                ->where(['staf_akses_icno' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['staf_akses_id' => '99'])
                                ->exists();

                            if ($query) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                            }
                        },
                    ],
                    [
                        'actions' => [
                            //                           'dashboard',
                            //                           'carian-kakitangan', 
                            //                           'kemaskini-akses', 'padam-akses', 'tambah-akses', 'penetapan-staf-akses',
                            'kemaskini-lpg', 'tambah-lpg', 'padam-lpg',
                            'tambah-kew8', 'get-remark',
                            //                           'rekod-lpg', 'lpg-report-2',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $query = TblStaffAkses::find()
                                ->where(['staf_akses_icno' => Yii::$app->user->identity->ICNO])
                                ->andWhere(['!=', 'staf_akses_id', '50'])
                                ->exists();

                            if ($query) {
                                return true;
                            } else {
                                throw new ForbiddenHttpException('You don\'t have permission to view this page.');
                            }
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'lpg-report' => ['get'],
                ],
            ],
        ];
    }

    //    public function actionIndex()
    //    {
    //        return $this->render('index');
    //    }

    public function actionIndex()
    {
        // Yii::$app->user->identity->getAuthKey()

        //        $subQuery = TblStaffRoc::find()
        //                ->select(['MIN(SR_REF_ID) as SR_REF_ID', 'SR_ENTRY_BATCH'])
        //                ->groupBy('SR_ENTRY_BATCH');
        //        
        //        $lpg = TblStaffRoc::find()
        //                ->innerJoin(['m' => $subQuery], '[dbo].[staff_roc].SR_ENTRY_BATCH = m.SR_ENTRY_BATCH'
        //                        . ' AND [dbo].[staff_roc].SR_REF_ID = m.SR_REF_ID')
        //                ->where(['SR_STAFF_ID' => '160315-03227'])
        //                ->andWhere(['IS NOT', 'SR_VERIFY_BY', NULL])
        //                ->orderBy(['SR_ENTER_DATE' => SORT_DESC]);

        $bio = Tblprcobiodata::findOne(['ICNO' => Yii::$app->user->identity->ICNO]);

        $lpg = TblStaffRocBatch::find()
            // ->leftJoin('staffRocSingle', '`order`.`customer_id` = `customer`.`id`')
            ->joinWith([
                'staffRocSingle' => function ($query) {
                    $query->andWhere(['>=', 'YEAR(SR_DATE_FROM)', 2018]);
                },
            ])
            ->where(['srb_staff_id' => $bio->COOldID, 'srb_change_reason' => ['11', '10']])
            ->andWhere(['LIKE', 'srb_status', 'APPROVE'])
            //->andWhere(['in', 'srb_change_reason', ['11']])
            ->andWhere(['IS NOT', 'srb_approve_date', NULL])
            // ->andWhere(['>=', 'YEAR(srb_approve_date)', 2018])
            ->orderBy(['srb_approve_date' => SORT_DESC]);

        $provider = new ActiveDataProvider([
            'query' => $lpg,
            // 'pagination' => [
            //     'pageSize' => 10,
            // ],
            'sort' => [
                'attributes' => ['srb_effective_date', 'srb_approve_date']
            ],
            /*'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'title' => SORT_ASC, 
                ]
            ],*/
        ]);

        return $this->render('kemasukan', [
            'dataProvider' => $provider,
            'bio' => $bio,
        ]);
    }

    public function actionDashboard()
    {

        //        $tahun = TblLppTahun::findOne(['lpp_aktif' => 'Y']);

        //        $lpp = TblMain::find()->where(['tahun' => $tahun->lpp_tahun]);

        return $this->render('dashboard', [
            //            'lpp' => $lpp,
        ]);
    }

    public function actionLpgReport($batch_code)
    {

        $roc = TblStaffRocBatch::findOne(['srb_batch_code' => $batch_code]);

        $biodata = Tblprcobiodata::findOne(['COOldID' => $roc->srb_staff_id]);
        //
        //
        //        $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');
        //
        ////        $month = TblRekod::viewBulan($bulan);
        //
        //        $this->view->title = "Attendance Report";
        //        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_lpg_report', [
            'biodata' => $biodata,
            'roc' => $roc
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            'filename' => "lpgReport.pdf",
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
            'options' => ['title' => "lpgreport"],
            // call mPDF methods on the fly
            'methods' => [
                //                'SetHeader' => ["Attendance Report"],
                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                //'SetFooter' => [' {PAGENO}'],
                //'SetFooter' => [' '],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionLpgReport2($lpg_id)
    {

        $roc = Tblrscolpg::findOne(['t_lpg_id' => $lpg_id]);

        $biodata = Tblprcobiodata::findOne(['ICNO' => $roc->t_lpg_ICNO]);
        //
        //
        //        $var = $this->getDaysInYearMonth($tahun, $bulan, 'Y-m-d');
        //
        ////        $month = TblRekod::viewBulan($bulan);
        //
        //        $this->view->title = "Attendance Report";
        //        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_lpg_report_1', [
            'biodata' => $biodata,
            'roc' => $roc
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            'filename' => "lpgReport.pdf",
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
            'options' => ['title' => "lpgreport"],
            // call mPDF methods on the fly
            'methods' => [
                //                'SetHeader' => ["Attendance Report"],
                'SetFooter' => ['"INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN"'],
                //'SetFooter' => [' {PAGENO}'],
                //'SetFooter' => [' '],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    //    public function actionKew8() {
    //        $searchModel = new TblprcobiodataSearch();
    //
    //        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    //
    //        return $this->render('kew8', [
    //            'searchModel' => $searchModel,
    //            'dataProvider' => $dataProvider,
    //        ]);
    //    }

    public function actionCarianKakitangan()
    {
        \yii\helpers\Url::remember();
        $searchModel = new TblprcobiodataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //        $dataProvider->query->andWhere('elnpt.tbl_main.is_deleted = 0');

        return $this->render('carian_staff', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCarianKakitanganV2()
    {
        \yii\helpers\Url::remember();
        $searchModel = new TblprcobiodataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //        $dataProvider->query->andWhere('elnpt.tbl_main.is_deleted = 0');

        return $this->render('carian_staff', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRekodLpgV2($umsper)
    {
        \yii\helpers\Url::remember();
        //        $lpg = $this->findRekod($icno);
        $bio = Tblprcobiodata::findOne(['COOldID' => $umsper]);

        $max = TblStaffRoc::find()
            ->select(['SR_ROC_TYPE, max(SR_ENTER_DATE) as SR_ENTER_DATE'])
            ->where(['SR_STAFF_ID' => $umsper])
            ->andWhere(['<', 'SR_DATE_FROM',  new \yii\db\Expression('NOW()')])
            ->groupBy('SR_ROC_TYPE');

        $query = TblStaffRoc::find()
            ->innerJoin(['b' => $max], 'b.SR_ROC_TYPE = hrm.gaji_staff_roc.SR_ROC_TYPE AND b.SR_ENTER_DATE = hrm.gaji_staff_roc.SR_ENTER_DATE')
            ->where(['SR_STAFF_ID' => $umsper, 'SR_CHANGE_REASON' => ['11', 'RR20180307113551']])
            ->andWhere(['<>', 'SR_CHANGE_TYPE', 'FIXED'])
            ->orderBy(['SR_ENTER_DATE' => SORT_DESC, 'SR_ROC_TYPE' => SORT_ASC]);

        $query2 = TblStaffRocBatch::find()
            ->where(['srb_staff_id' => $umsper])
            ->orderBy(['srb_effective_date' => SORT_DESC]);

        $query3 = TblStaffRoc::find()
            ->leftJoin(['a' => '`hrm`.`gaji_migbkp_incometype_180226`'], '`a`.`it_income_code` = `SR_ROC_TYPE`')
            ->where(['`a`.`it_trans_type`' => 'ALLOWANCE', 'SR_STAFF_ID' => $umsper])
            ->orderBy(['SR_ENTER_DATE' => SORT_DESC]);

        $query4 = TblStaffRoc::find()
            ->leftJoin(['a' => '`hrm`.`gaji_migbkp_incometype_180226`'], '`a`.`it_income_code` = `SR_ROC_TYPE`')
            ->where(['`a`.`it_trans_type`' => 'DEDUCTION', 'SR_STAFF_ID' => $umsper])
            ->orderBy(['SR_ENTER_DATE' => SORT_DESC]);

        // return VarDumper::dump($query3->asArray()->all(), 10, true);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // 'pagination' => [
            //     //'pageSize' => 20,
            //     'pageSize' => 10,
            //     ],
            'sort' => false,
        ]);

        $dataProvider2 = new ActiveDataProvider([
            'query' => $query2,
            // 'pagination' => [
            //     //'pageSize' => 20,
            //     'pageSize' => 10,
            //     ],
            'sort' => false,
        ]);

        $dataProvider3 = new ActiveDataProvider([
            'query' => $query3,
            // 'pagination' => [
            //     //'pageSize' => 20,
            //     'pageSize' => 10,
            //     ],
            'sort' => false,
        ]);

        $dataProvider4 = new ActiveDataProvider([
            'query' => $query4,
            // 'pagination' => [
            //     //'pageSize' => 20,
            //     'pageSize' => 10,
            //     ],
            'sort' => false,
        ]);

        $model = TblStaffSalary::find()->where(['SS_STAFF_ID' => $umsper])->all();
        $models = Tblprcobiodata::find()->where(['COOldID' => $umsper])->one();
        return $this->render('rekod_lpg_v2', [
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
            'dataProvider3' => $dataProvider3,
            'dataProvider4' => $dataProvider4,
            'bio' => $bio, 'model' => $model, 'models' => $models, 'umsper' => $umsper
        ]);
    }

    public function actionRekodLpg($icno)
    {
        \yii\helpers\Url::remember();
        //        $lpg = $this->findRekod($icno);
        $bio = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $query = Tblrscolpg::find()
            ->where(['t_lpg_ICNO' => $icno])
            ->orderBy(['t_lpg_date_start' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'pageSize' => 20,
                'pageSize' => 5,
            ],
            'sort' => false,
        ]);

        return $this->render('rekod_lpg', [
            'dataProvider' => $dataProvider,
            'bio' => $bio,
        ]);
    }

    public function actionPenetapanStafAkses()
    {
        \yii\helpers\Url::remember();
        $searchModel = new TblStaffAksesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('staf_akses', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTambahAkses()
    {
        //$id = Yii::$app->user->getId(); 
        $model = new TblStaffAkses();

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Akses berjaya disimpan!']);
            //            return $this->redirect('penetapan-staf-akses');
            //$model->akses_oleh = $id;
            return $this->goBack();
        }

        return $this->renderAjax('tambah_akses', ['model' => $model]);
    }

    public function actionKemaskiniAkses($ICNO)
    {
        //$id = Yii::$app->user->getId(); 
        $bio = Tblprcobiodata::findOne(['ICNO' => $ICNO]);

        if (TblStaffAkses::findOne(['staf_akses_icno' => $ICNO]) != null) {
            $model = TblStaffAkses::findOne(['staf_akses_icno' => $ICNO]);
        } else {
            throw new NotFoundHttpException('Staff tidak dijumpai.');
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->staf_akses_icno = $ICNO;
            $model->save();
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Akses berjaya dikemaskini!']);
            //            return $this->redirect('penetapan-staf-akses');
            //$model->akses_oleh = $id;
            return $this->goBack();
        }

        return $this->renderAjax('kemaskini_akses', ['bio' => $bio, 'model' => $model]);
    }

    public function actionPadamAkses($ICNO)
    {
        //        $bio = Tblprcobiodata::findOne(['ICNO' => $icno]);
        if (TblStaffAkses::findOne(['staf_akses_icno' => $ICNO]) != null) {
            $model = TblStaffAkses::findOne(['staf_akses_icno' => $ICNO]);
        } else {
            throw new NotFoundHttpException('Staff tidak dijumpai.');
        }

        $model->delete();

        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Akses berjaya dipadam!']);
        //                return $this->redirect(['saraan/rekod-lpg', 'icno' => $bio->ICNO]);
        return $this->goBack();
    }

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
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'LPG berjaya ditambah!']);
                //                return $this->redirect(['saraan/rekod-lpg', 'icno' => $bio->ICNO]);
                return $this->goBack();
            }
        }

        return $this->renderAjax('tambah_lpg', [
            'model' => $model,
            'bio' => $bio,
        ]);
    }

    public function actionKemaskiniLpg($icno, $lpg_id)
    {
        \yii\helpers\Url::remember();
        $bio = Tblprcobiodata::findOne(['ICNO' => $icno]);

        $model = $this->findLpg($lpg_id);

        $lpg = Tblrscoelaun::find()
            ->where(['el_lpg_id' => $model->t_lpg_id])
            ->indexBy('el_id');
        //                ->andWhere(['LIKE', 'srb_status', 'APPROVE'])
        //                //->andWhere(['in', 'srb_change_reason', ['11']])
        //                ->andWhere(['IS NOT', 'srb_approve_date', NULL])
        //                ->orderBy(['srb_approve_date' => SORT_DESC]);

        $provider = new ActiveDataProvider([
            'query' => $lpg,
            'pagination' => [
                'pageSize' => 10,
            ],
            /*'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'title' => SORT_ASC, 
                ]
            ],*/
        ]);

        if ($model->load(Yii::$app->request->post())) {
            //            $model->t_lpg_ICNO = $bio->ICNO;
            //            
            //            $model->created_by = Yii::$app->user->identity->ICNO;
            //            $model->created_datetime = new \yii\db\Expression('NOW()');

            if ($model->save(false)) {
                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'LPG berjaya dikemaskini!']);
                //                return $this->redirect(['saraan/rekod-lpg', 'icno' => $bio->ICNO]);
                return $this->goBack();
            }
        }

        if (Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $bookId = Yii::$app->request->post('editableKey');
            $model = Tblrscoelaun::findOne($bookId);

            // store a default json response as desired by editable
            $out = Json::encode(['output' => '', 'message' => '']);

            // fetch the first entry in posted data (there should only be one entry 
            // anyway in this array for an editable submission)
            // - $posted is the posted data for Book without any indexes
            // - $post is the converted array for single model validation
            $posted = current($_POST['Tblrscoelaun']);
            $post = ['Tblrscoelaun' => $posted];

            // load model like any single model validation
            if ($model->load($post)) {
                // can save model or do something before saving model
                $model->save();

                // custom output to return to be displayed as the editable grid cell
                // data. Normally this is empty - whereby whatever value is edited by
                // in the input by user is updated automatically.
                $output = '';

                // specific use case where you need to validate a specific
                // editable column posted when you have more than one
                // EditableColumn in the grid view. We evaluate here a
                // check to see if buy_amount was posted for the Book model
                if (isset($posted['el_amount'])) {
                    $output = Yii::$app->formatter->asDecimal($model->el_amount, 2);
                }

                // similarly you can check if the name attribute was posted as well
                // if (isset($posted['name'])) {
                // $output = ''; // process as you need
                // }
                $out = Json::encode(['output' => $output, 'message' => '']);
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
        }

        return $this->renderAjax('kemaskini_lpg', [
            'model' => $model,
            'bio' => $bio,
            'dataProvider' => $provider,
        ]);
    }

    public function actionPadamLpg($lpg_id)
    {
        //        $bio = Tblprcobiodata::findOne(['ICNO' => $icno]);
        $model = $this->findLpg($lpg_id);
        if ($model->elaun) {
            foreach ($model->elaun as $el) {
                $el->delete();
            }
        }
        $model->delete();

        \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'LPG berjaya dipadam!']);
        //                return $this->redirect(['saraan/rekod-lpg', 'icno' => $bio->ICNO]);
        return $this->goBack();
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
            //->andWhere(['OR', ['t_lpg_ver_status' => NULL], ['!=', 't_lpg_ver_status', 'disprove']])
            //->andWhere(['>', 't_lpg_amount', 0])
            ->asArray()
            ->one();

        $cnt = TblStaffRocBatch::find()
            ->where(['srb_staff_id' => $bio->COOldID])
            ->andWhere(['>=', 'srb_verify_date', '2012-01-01'])
            //->andWhere(['OR', ['t_lpg_ver_status' => NULL], ['!=', 't_lpg_ver_status', 'disprove']])
            ->andWhere(['srb_status' => 'APPROVE'])
            ->andWhere(['srb_verify_date' => $max_date])
            ->andWhere(['srb_change_reason' => $lpgCd])
            //->andWhere(['>', 't_lpg_amount', 0])
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
                //->leftJoin('[dbo].[mig_Income_code_mapping]', '[dbo].[mig_Income_code_mapping].[income_code] = [dbo].[staff_roc].[SR_ROC_TYPE]')
                ->where(['SR_STAFF_ID' => $bio->COOldID])
                //->andWhere(['OR', ['srb_batch_code' => $old_lpg], ['srb_change_reason' => '7']])
                ->andWhere(['SR_ENTRY_BATCH' => $old_lpg])
                //->groupBy(['[dbo].[staff_roc].SR_CHANGE_REASON'])
                //->orderby(['[dbo].[staff_roc_batch].srb_change_reason' => SORT_ASC, 'srb_enter_date' => SORT_ASC])
                ->asArray()
                ->all();

            //$ell = ArrayHelper::getColumn($elaun, '0','');
            $arryy = array();

            $arryy1 = array();

            foreach ($elaun as $aaa) {
                array_push($arryy, $aaa['hronline_id']);
            }

            foreach ($elaun as $aaa) {
                array_push($arryy1, $aaa['SR_NEW_VALUE']);
            }

            //echo \yii\helpers\VarDumper::dump($arryy, 10, true);

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

    public function JumlahElaun($lpg_id, $elaun_cd)
    {

        $ret_jum_el = null;

        $lpg_info = Tblrscolpg::find()
            ->select([
                't_lpg_cd', 't_lpg_ICNO', 't_lpg_dept_id', 't_lpg_jawatan_id', 't_lpg_amount', 'hronline.gredjawatan.nama as nama',
                'hronline.gredjawatan.job_group as job_group'
            ])
            ->joinWith('jawatan')
            ->where(['t_lpg_id' => $lpg_id])
            ->asArray()
            ->one();

        $bio = Tblprcobiodata::findOne(['ICNO' => $lpg_info['t_lpg_ICNO']]);

        $gred_chr = Tblrscolpg::find()
            ->select(['IF ( gred NOT LIKE "V%" AND (LENGTH(gred) <= 3 OR LENGTH(gred) >= 6), LEFT(gred,1),
                    IF ( LENGTH(gred) <= 4, LEFT(gred,2), NULL)) as chr'])
            ->joinWith('jawatan', false)
            ->where(['t_lpg_id' => $lpg_id])
            ->asArray()
            ->one();

        $gred_no = Tblrscolpg::find()
            ->select(['IF (gred LIKE \'V%\', (100 - RIGHT(gred,1)), 
                    (IF (LENGTH(gred) >= 3, IF( gred != \'DU51P\', RIGHT(gred,2), 51 ) , RIGHT(gred,1)

            ))) as gred'])
            ->joinWith('jawatan', false)
            ->where(['t_lpg_id' => $lpg_id])
            ->asArray()
            ->one();

        //echo \yii\helpers\VarDumper::dump($gred_no, 10, true);

        $elaun_dekan = Tblrscoelaun::find()
            ->where(['el_elaun_cd' => [13, 50]])
            ->andWhere(['el_lpg_id' => $lpg_id])
            ->asArray()
            ->one();

        $expression = new Expression('IF(COUNT(el_id) >= 1, 1, 0)');

        $elaun_timb_dekan = Tblrscoelaun::find()
            ->select($expression)
            ->where(['el_elaun_cd' => [14, 51]])
            ->andWhere(['el_lpg_id' => $lpg_id])
            ->asArray()
            ->one();

        if ($elaun_cd == 1 or $elaun_cd == 3) {
            switch ($gred_no['gred']) {
                case 95:
                    $ret_jum_el = 2500;
                    break;
                case 94:
                    $ret_jum_el = 1500;
                    break;
                case 93:
                    $ret_jum_el = 1000;
                    break;
            }
        }

        if ($elaun_cd == 2 or $elaun_cd == 4) {
            switch ($gred_no['gred']) {
                case 95:
                    $ret_jum_el = 4000;
                    break;
                case 94:
                    $ret_jum_el = 3050;
                    break;
                case 93:
                    $ret_jum_el = 2500;
                    break;
            }
        }

        if ($elaun_cd == 5) {
            //            if($lpg_info['job_group'] == 2 OR $lpg_info['job_group'] == 3 OR $lpg_info['job_group'] == 4) {
            //               
            //                if(preg_match("/(perubatan|farmasi|pergigian)/i", $lpg_info['nama'])) {
            //                    $ret_jum_el = 750;
            //                }else {
            //                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
            //                }
            //            }
            //
            //            if($lpg_info['job_group'] == 5 OR $lpg_info['job_group'] == 6) {
            //                if(preg_match("/(jururawat)/i", $lpg_info['nama'])) {
            //                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.15);
            //                }else {
            //                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.1);
            //                }
            //            }
            //
            //            if($lpg_info['job_group'] == 4) {
            //                if(preg_match("/(jururawat)/i", $lpg_info['nama'])) {
            //                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.1);
            //                }
            //            }

            switch ($bio->jawatan->gred) {
                case 'DU51P':
                    $ret_jum_el = 750;
                    break;
                case 'UG43':
                    $ret_jum_el = 750;
                    break;
                case 'UG48':
                    $ret_jum_el = 750;
                    break;
                case 'UF43':
                    $ret_jum_el = 750;
                    break;
                case 'UD43':
                    $ret_jum_el = 750;
                    break;
                case 'UD47':
                    $ret_jum_el = 750;
                    break;
                case 'UD53':
                    $ret_jum_el = 750;
                    break;
                case 'U29':
                    if (($bio->jawatan->nama == 'Jururawat') or ($bio->jawatan->nama == 'Jururawat Kanan')) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.15);
                    }
                    break;
                case 'U32':
                    if (($bio->jawatan->nama == 'Jururawat') or ($bio->jawatan->nama == 'Jururawat Kanan')) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.15);
                    }
                    break;
                case 'DS45':
                    //if(($bio->jawatan->nama == 'Jururawat') or ($bio->jawatan->nama == 'Jururawat Kanan')){
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    //}
                    break;
                case 'DS48':
                    //if(($bio->jawatan->nama == 'Jururawat') or ($bio->jawatan->nama == 'Jururawat Kanan')){
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    //}
                    break;
                case 'DS51':
                    //if(($bio->jawatan->nama == 'Jururawat') or ($bio->jawatan->nama == 'Jururawat Kanan')){
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    //}
                    break;
                case 'DS52':
                    //if(($bio->jawatan->nama == 'Jururawat') or ($bio->jawatan->nama == 'Jururawat Kanan')){
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    //}
                    break;
                case 'DS53':
                    //if(($bio->jawatan->nama == 'Jururawat') or ($bio->jawatan->nama == 'Jururawat Kanan')){
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    //}
                    break;
                case 'DS54':
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    break;
                case 'J41':
                    //strpos($a, 'are') !== false
                    if (strpos($bio->jawatan->nama, 'Arkitek') !== false) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    }
                    if (strpos($bio->jawatan->nama, 'Jurutera') !== false) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    }
                    break;
                case 'J44':
                    if (strpos($bio->jawatan->nama, 'Arkitek') !== false) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    }
                    if (strpos($bio->jawatan->nama, 'Juruukur') !== false) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    }
                    break;
                case 'B19':
                    if (($bio->jawatan->nama == 'Penerbit Rancangan')) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    }
                    break;
                case 'B29':
                    if (($bio->jawatan->nama == 'Penerbit Rancangan')) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    }
                    break;
                case 'Q41':
                    if (($bio->jawatan->nama == 'Pegawai Penyelidik')) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    }
                    break;
                case 'G41':
                    if (($bio->jawatan->nama == 'Pegawai Pertanian')) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    }
                    break;
                case 'L48':
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    break;
                case 'L44':
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    break;
                case 'N44':
                    if (($bio->jawatan->nama == 'Penolong Pendaftar Kanan')) {
                        $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.05);
                    }
                    break;
            }
        }

        if ($elaun_cd == 6) {
            if ($gred_chr['chr'] == 'VU' or $gred_chr['chr'] == 'VK') {
                $ret_jum_el = 3100;
            }

            if ($gred_chr['chr'] == 'U' or $gred_chr['chr'] == 'UD' or $gred_chr['chr'] == 'DU' or $gred_chr['chr'] == 'DUG') {
                if ($gred_no['gred'] >= 55) {
                    $ret_jum_el = 3100;
                } else if ($gred_no['gred'] >= 53 and $gred_no['gred'] <= 54) {
                    $ret_jum_el = 2800;
                } else if ($gred_no['gred'] >= 51 and $gred_no['gred'] <= 52) {
                    $ret_jum_el = 2500;
                } else if ($gred_no['gred'] >= 47 and $gred_no['gred'] <= 48) {
                    $ret_jum_el = 2200;
                } else if ($gred_no['gred'] == 45) {
                    $ret_jum_el = 2000;
                } else if ($gred_no['gred'] >= 43 and $gred_no['gred'] <= 44) {
                    $ret_jum_el = 1900;
                } else if ($gred_no['gred'] == 41) {
                    $ret_jum_el = 1600;
                }
            }
        }

        if ($elaun_cd == 7) {
            if ($gred_chr['chr'] == 'VK' or $gred_chr['chr'] == 'DU') {
                if ($gred_no['gred'] >= 55) {
                    $ret_jum_el = 1200;
                } else if ($gred_no['gred'] >= 53 and $gred_no['gred'] <= 54) {
                    $ret_jum_el = 1000;
                } else if ($gred_no['gred'] >= 51 and $gred_no['gred'] <= 52) {
                    $ret_jum_el = 800;
                } else if ($gred_no['gred'] == 45) {
                    $ret_jum_el = 600;
                }
            }
        }

        if ($elaun_cd == 40) {
            if ($gred_chr['chr'] == 'VK' or $gred_chr['chr'] == 'DU') {
                if ($gred_no['gred'] >= 55) {
                    $ret_jum_el = 1000;
                } else if ($gred_no['gred'] >= 53 and $gred_no['gred'] <= 54) {
                    $ret_jum_el = 800;
                } else if ($gred_no['gred'] >= 51 and $gred_no['gred'] <= 52) {
                    $ret_jum_el = 600;
                } else if ($gred_no['gred'] == 45) {
                    $ret_jum_el = 400;
                }
            }
        }

        if ($elaun_cd == 8) {
            if ($lpg_info['job_group'] == 3) {
                if ($gred_no['gred'] >= 53 and $gred_no['gred'] <= 54) {
                    $ret_jum_el = 800;
                } else if ($gred_no['gred'] >= 51 and $gred_no['gred'] <= 52) {
                    $ret_jum_el = 600;
                } else if ($gred_no['gred'] == 46) {
                    $ret_jum_el = 550;
                } else if ($gred_no['gred'] == 45) {
                    $ret_jum_el = 500;
                } else if ($gred_no['gred'] == 44) {
                    $ret_jum_el = 400;
                }
            } else {
                if ($gred_no['gred'] >= 53 and $gred_no['gred'] <= 54) {
                    $ret_jum_el = 800;
                } else if ($gred_no['gred'] >= 51 and $gred_no['gred'] <= 52) {
                    $ret_jum_el = 600;
                } else if ($gred_no['gred'] >= 47 and $gred_no['gred'] <= 50) {
                    $ret_jum_el = 550;
                } else if ($gred_no['gred'] >= 43 and $gred_no['gred'] <= 44) {
                    $ret_jum_el = 400;
                }
            }
        }

        if ($elaun_cd == 9) {
            if ($lpg_info['job_group'] == 3) {
                if ($gred_no['gred'] <= 45) {
                    $ret_jum_el = 300;
                }
            } else {
                if ($gred_no['gred'] >= 41 and $gred_no['gred'] <= 42) {
                    $ret_jum_el = 300;
                } else if ($gred_no['gred'] >= 35 and $gred_no['gred'] <= 40) {
                    $ret_jum_el = 220;
                } else if ($gred_no['gred'] >= 27 and $gred_no['gred'] <= 34) {
                    $ret_jum_el = 160;
                } else if ($gred_no['gred'] >= 25 and $gred_no['gred'] <= 26) {
                    $ret_jum_el = 140;
                } else if ($gred_no['gred'] >= 17 and $gred_no['gred'] <= 24) {
                    $ret_jum_el = 115;
                } else if ($gred_no['gred'] >= 1 and $gred_no['gred'] <= 16) {
                    $ret_jum_el = 95;
                }
            }
        }

        if ($elaun_cd == 10) {
            if ($gred_no['gred'] == 95) {
                $ret_jum_el = 2000;
            } else if ($gred_no['gred'] == 94) {
                $ret_jum_el = 1600;
            } else if ($gred_no['gred'] >= 93) {
                $ret_jum_el = 1300;
            } else if ($gred_no['gred'] >= 53 and $gred_no['gred'] <= 54) {
                $ret_jum_el = 900;
            } else if ($gred_no['gred'] >= 51 and $gred_no['gred'] <= 52) {
                $ret_jum_el = 700;
            } else if ($gred_no['gred'] >= 45 and $gred_no['gred'] <= 50) {
                $ret_jum_el = 700;
            } else if ($gred_no['gred'] >= 43 and $gred_no['gred'] <= 44) {
                $ret_jum_el = 400;
            } else if ($gred_no['gred'] >= 41 and $gred_no['gred'] <= 42) {
                $ret_jum_el = 300;
            } else if ($gred_no['gred'] >= 1 and $gred_no['gred'] <= 40) {
                $ret_jum_el = 300;
            }
        }

        if ($elaun_cd == 11 and $lpg_info['t_lpg_cd'] == 29) {
            if ($bio->NatStatusCd == '1') {
                if ($lpg_info['t_lpg_amount'] >= 5565.61) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (12.5 / 100));
                } else if ($lpg_info['t_lpg_amount'] >= 3566.05 and $lpg_info['t_lpg_amount'] <= 5565.60) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (15 / 100));
                } else if ($lpg_info['t_lpg_amount'] >= 1783.84 and $lpg_info['t_lpg_amount'] <= 3566.04) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (17.5 / 100));
                } else if ($lpg_info['t_lpg_amount'] >= 1176.76 and $lpg_info['t_lpg_amount'] <= 1783.83) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (20 / 100));
                } else if ($lpg_info['t_lpg_amount'] >= 841.90 and $lpg_info['t_lpg_amount'] <= 1176.75) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (22.5 / 100));
                } else if ($lpg_info['t_lpg_amount'] <= 841.89) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (25 / 100));
                }
            }
        }

        if ($elaun_cd == 11 and $lpg_info['t_lpg_cd'] != 29) {
            if ($bio->NatStatusCd == '1' || $bio->NatStatusCd == '3') {
                if ($lpg_info['t_lpg_amount'] >= 6289.13) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.125);
                } else if ($lpg_info['t_lpg_amount'] >= 4029.64 and $lpg_info['t_lpg_amount'] <= 6289.13) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.15);
                } else if ($lpg_info['t_lpg_amount'] >= 2015.74 and $lpg_info['t_lpg_amount'] <= 4029.63) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.175);
                } else if ($lpg_info['t_lpg_amount'] >= 1329.74 and $lpg_info['t_lpg_amount'] <= 2015.13) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.2);
                } else if ($lpg_info['t_lpg_amount'] >= 951.35 and $lpg_info['t_lpg_amount'] <= 1329.73) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.225);
                } else if ($lpg_info['t_lpg_amount'] <= 951.34) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.25);
                }
            }
        }

        if ($elaun_cd == 12 and $lpg_info['t_lpg_cd'] == 29) {
            if ($bio->NatStatusCd == '2' or $bio->NatStatusCd == '2' or $bio->NatStatusCd == '9') {
                if ($lpg_info['t_lpg_amount'] >= 5565.61) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (12.5 / 100));
                } else if ($lpg_info['t_lpg_amount'] >= 3566.05 and $lpg_info['t_lpg_amount'] <= 5565.60) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (15 / 100));
                } else if ($lpg_info['t_lpg_amount'] >= 1783.84 and $lpg_info['t_lpg_amount'] <= 3566.04) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (17.5 / 100));
                } else if ($lpg_info['t_lpg_amount'] >= 1176.76 and $lpg_info['t_lpg_amount'] <= 1783.83) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (20 / 100));
                } else if ($lpg_info['t_lpg_amount'] >= 841.90 and $lpg_info['t_lpg_amount'] <= 1176.75) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (22.5 / 100));
                } else if ($lpg_info['t_lpg_amount'] <= 841.89) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * (25 / 100));
                }
            }
        }

        if ($elaun_cd == 11 and $lpg_info['t_lpg_cd'] != 29) {
            if ($bio->NatStatusCd == '2' or $bio->NatStatusCd == '2' or $bio->NatStatusCd == '9') {
                if ($lpg_info['t_lpg_amount'] >= 6289.13) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.125);
                } else if ($lpg_info['t_lpg_amount'] >= 4029.64 and $lpg_info['t_lpg_amount'] <= 6289.13) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.15);
                } else if ($lpg_info['t_lpg_amount'] >= 2015.74 and $lpg_info['t_lpg_amount'] <= 4029.63) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.175);
                } else if ($lpg_info['t_lpg_amount'] >= 1329.74 and $lpg_info['t_lpg_amount'] <= 2015.13) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.2);
                } else if ($lpg_info['t_lpg_amount'] >= 951.35 and $lpg_info['t_lpg_amount'] <= 1329.73) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.225);
                } else if ($lpg_info['t_lpg_amount'] <= 951.34) {
                    $ret_jum_el = ($lpg_info['t_lpg_amount'] * 0.25);
                }
            }
        }

        if ($elaun_cd == 13) {
            $ret_jum_el = 800;
        }

        if ($elaun_cd == 14) {
            $ret_jum_el = 700;
        }

        if ($elaun_cd == 15) {
            $ret_jum_el = 300;
        }

        if ($elaun_cd == 77) {
            $ret_jum_el = 300;
        }

        if ($elaun_cd == 22) {
            if ($gred_no['gred'] == 94) {
                $ret_jum_el = 1600;
            } else if ($gred_no['gred'] == 93) {
                $ret_jum_el = 1500;
            } else if ($gred_no['gred'] >= 53 and $gred_no['gred'] <= 54) {
                $ret_jum_el = 1300;
            } else if ($gred_no['gred'] >= 45 and $gred_no['gred'] <= 52) {
                $ret_jum_el = 1130;
            } else if ($gred_no['gred'] >= 41 and $gred_no['gred'] <= 44) {
                $ret_jum_el = 930;
            } else if ($gred_no['gred'] >= 27 and $gred_no['gred'] <= 40) {
                $ret_jum_el = 830;
            } else if ($gred_no['gred'] >= 1 and $gred_no['gred'] <= 26) {
                $ret_jum_el = 730;
            }
        }

        if ($elaun_cd == 44) {
            if ($gred_no['gred'] == 95) {
                $ret_jum_el = 2000;
            } else if ($gred_no['gred'] == 94) {
                $ret_jum_el = 1600;
            } else if ($gred_no['gred'] == 93) {
                $ret_jum_el = 1500;
            } else if ($gred_no['gred'] >= 53 and $gred_no['gred'] <= 54) {
                $ret_jum_el = 1250;
            } else if ($gred_no['gred'] >= 45 and $gred_no['gred'] <= 52) {
                $ret_jum_el = 1080;
            } else if ($gred_no['gred'] >= 41 and $gred_no['gred'] <= 44) {
                $ret_jum_el = 880;
            } else if ($gred_no['gred'] >= 27 and $gred_no['gred'] <= 40) {
                $ret_jum_el = 780;
            } else if ($gred_no['gred'] >= 1 and $gred_no['gred'] <= 26) {
                $ret_jum_el = 680;
            }
        }

        if ($elaun_cd == 45) {
            if ($gred_no['gred'] == 95) {
                $ret_jum_el = 2000;
            } else if ($gred_no['gred'] == 94) {
                $ret_jum_el = 1600;
            } else if ($gred_no['gred'] == 93) {
                $ret_jum_el = 1500;
            } else if ($gred_no['gred'] >= 53 and $gred_no['gred'] <= 54) {
                $ret_jum_el = 1200;
            } else if ($gred_no['gred'] >= 45 and $gred_no['gred'] <= 52) {
                $ret_jum_el = 1030;
            } else if ($gred_no['gred'] >= 41 and $gred_no['gred'] <= 44) {
                $ret_jum_el = 830;
            } else if ($gred_no['gred'] >= 27 and $gred_no['gred'] <= 40) {
                $ret_jum_el = 730;
            } else if ($gred_no['gred'] >= 1 and $gred_no['gred'] <= 26) {
                $ret_jum_el = 630;
            }
        }

        if ($elaun_cd == 42) {
            $ret_jum_el = 80;
        }

        if ($elaun_cd == 18) {
            $ret_jum_el = 40;
        }

        if ($elaun_cd == 42) {
            $ret_jum_el = 80;
        }

        if ($elaun_cd == 16) {
            if ($gred_chr['chr'] == 'N') {
                if ($gred_no['gred'] == 36) {
                    $ret_jum_el = 250;
                } else if ($gred_no['gred'] == 32) {
                    $ret_jum_el = 192;
                } else if ($gred_no['gred'] >= 27 and $gred_no['gred'] <= 28) {
                    $ret_jum_el = 150;
                } else if ($gred_no['gred'] >= 17 and $gred_no['gred'] <= 22) {
                    $ret_jum_el = 120;
                }

                if ($gred_no['gred'] == 28 and $lpg_id['t_lpg_dept_id'] == 9) {
                    $ret_jum_el = 190;
                }
            }
        }

        if ($elaun_cd == 17) {
            if ($gred_chr['chr'] == 'N' and ($gred_no['gred'] >= 17 and $gred_no['gred'] <= 36)) {
                $ret_jum_el = 85;
            }
        }

        if ($elaun_cd == 41) {
            if ($gred_chr['chr'] == 'N' and ($gred_no['gred'] >= 17 and $gred_no['gred'] <= 36)) {
                $ret_jum_el = 100;
            }
        }

        if ($elaun_cd == 19) {
            $ret_jum_el = 40;
        }

        if ($elaun_cd == 43) {
            $ret_jum_el = 80;
        }

        if ($elaun_cd == 61) {
            $ret_jum_el = 500;
        }

        if ($elaun_cd == 47) {
            $ret_jum_el = 100;

            if ($elaun_dekan == 1) {
                $ret_jum_el = 200;
            }

            if ($elaun_timb_dekan == 1) {
                $ret_jum_el = 100;
            }

            if ($gred_chr['chr'] == 'V') {
                $ret_jum_el = 350;
            }

            if (($gred_chr['chr'] == 'S' or $gred_chr['chr'] == 'W') and ($gred_no['gred'] == 54)) {
                $ret_jum_el = 350;
            }

            if (($gred_chr['chr'] == 'R' or $gred_chr['chr'] == 'H') and ($gred_no['gred'] == 3 or $gred_no['gred'] == 6 or $gred_no['gred'] == 11)) {
                $ret_jum_el = 50;
            }
        }

        if ($elaun_cd == 50) {
            $ret_jum_el = 800;
        }

        if ($elaun_cd == 51) {
            $ret_jum_el = 700;
        }

        if ($elaun_cd == 52) {
            $ret_jum_el = 300;
        }

        if ($elaun_cd == 53) {
            $ret_jum_el = 600;
        }

        if ($elaun_cd == 55) {
            $ret_jum_el = 150;
        }

        if ($elaun_cd == 56) {
            $ret_jum_el = 800;
        }

        if ($elaun_cd == 57) {
            $ret_jum_el = 400;
        }

        if ($elaun_cd == 58) {
            $ret_jum_el = 500;
        }

        if ($elaun_cd == 60) {
            $ret_jum_el = 500;
        }

        if ($elaun_cd == 65) {
            $ret_jum_el = 3;
        }

        if ($elaun_cd == 66) {
            $ret_jum_el = 5;
        }

        if ($elaun_cd == 72) {
            $jum_lpg_prev = TblStaffRocBatch::find()
                ->select(['TOP 1 *'])
                ->joinWith('staffRoc')
                ->where(['srb_staff_id' => $bio->COOldID, 'srb_change_reason' => 11, 'srb_effective_date'])
                ->sum('SR_NEW_VALUE');

            $ret_jum_el = $jum_lpg_prev;
        }

        return $ret_jum_el;
    }

    protected function findLpg($lpg_id)
    {
        if (($model = Tblrscolpg::findOne($lpg_id)) !== null) {
            return $model;
        }

        throw new UserException('ID does not exist.');
    }

    public function actionGenerateReport()
    {
        \yii\helpers\Url::remember();

        $model = new \yii\base\DynamicModel([
            'month', 'year', 'icno'
        ]);

        $model->addRule(['month', 'year'], 'required')
            ->addRule(['icno'], 'safe');

        if ($model->load(Yii::$app->request->post())) {
            $model->icno = Yii::$app->user->identity->ICNO;
            Yii::$app->queue->push(new \app\components\LpgReport([
                'month' => $model->month,
                'year' => $model->year,
                'icnooo' => $model->icno
            ]));
            \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan sedang dijana dan akan dihantar ke pusat notifikasi anda.']);
            return $this->goBack();
        }

        return $this->render('jana_laporan', [
            'model' => $model,
        ]);
    }

    public function actionTambahKew8($umsper)
    {
        $model = new TblStaffRocBatch();
        $model1 = new TblStaffRoc();

        $post = Yii::$app->request->post();
        $enter_by = Tblprcobiodata::find()->where(['ICNO' => Yii::$app->user->getId()])->one();
        // return VarDumper::dump($post['keylist'], 10, true);

        if ($model->load(Yii::$app->request->post()) && $model1->load(Yii::$app->request->post())) {
            $bio = Tblprcobiodata::find()->where(['COOldID' => $umsper])->one();
            $uuid = \thamtech\uuid\helpers\UuidHelper::uuid();
            $model->srb_batch_code = $uuid;
            $model->srb_cmpy_code = 'UMS';
            $model->srb_staff_id = $umsper;
            $model->srb_status = "ENTRY";
            $model->srb_enter_by =  $enter_by->COOldID;
            $model->srb_enter_date = new \yii\db\Expression('NOW()');
            // $model->srb_effective_date = \Yii::$app->formatter->asDate($model->srb_effective_date, 'yyyy-MM-dd');
            // $model->SRB_SOURCE = null;
            $model->srb_job_code = strval($bio->gredJawatan);

            $isValid = $model->validate();
            if ($isValid) {
                $model->save(false);
                $myElauns = TblStaffRoc::find()->where(['SR_REF_ID' => explode(',', $model->elaun_potongan)])->all();

                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    foreach ($myElauns as $p) {
                        $roc = new TblStaffRoc();
                        $roc->SR_REF_ID = \thamtech\uuid\helpers\UuidHelper::uuid();
                        $roc->SR_CMPY_CODE = 'UMS';
                        $roc->SR_STAFF_ID = $umsper;
                        $roc->SR_ROC_TYPE = $p->elaunnn->it_income_code;
                        $roc->SR_ENTRY_BATCH = $uuid;
                        $roc->SR_DATE_FROM = $model->srb_effective_date;
                        $roc->SR_DATE_TO = $model1->SR_DATE_TO;
                        $roc->SR_CHANGE_REASON = 11;
                        $roc->SR_OLD_VALUE = $p->SR_NEW_VALUE;
                        $roc->SR_NEW_VALUE = $p->SR_NEW_VALUE;
                        $roc->SR_CALC_TYPE = 'PRORATE';
                        $roc->SR_CHANGE_TYPE = 'NOCHANGE';

                        if (!($flag = $roc->save(false))) {
                            $transaction->rollBack();
                            break;
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }


                \Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Entry saved!']);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->renderAjax('tambah_kew8', [
            'model' => $model,
            'model1' => $model1,
            // 'keylist' => implode(", ", $keylist),
            'keylist' => $post['keylist'] ?? [],
            'status' => 'success'
        ]);
    }

    public function actionGetRemark($code)
    {
        $remark = '1';
        if (!empty($code)) {
            // echo 'console.log("asdasd")';
            $reason = RefRocReason::find()->where(['RR_REASON_CODE' => $code])->asArray()->one();
            $remark = $reason['rr_remarks_template'];
            // $remark = $code;
        }
        return $remark;
    }

    public function actionElaunDetails()
    {
        if (isset($_POST['expandRowKey'])) {
            $model = TblStaffRoc::find()->where(['SR_ENTRY_BATCH' => $_POST['expandRowKey']]);
            $dataProvider = new ActiveDataProvider([
                'query' => $model,
                'pagination' => [
                    //'pageSize' => 20,
                    'pageSize' => 5,
                ],
                'sort' => false,
            ]);
            return $this->renderPartial('_elaun2', ['dataProvider' => $dataProvider]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionKumpulan($roc_batch)
    {
        $batch = TblStaffRocBatch::findOne(['srb_batch_code' => $roc_batch]);

        $model = TblStaffRoc::find()->where(['SR_ENTRY_BATCH' => $batch->srb_batch_code]);
        $dataProvider = new ActiveDataProvider([
            'query' => $model,
            // 'pagination' => [
            //     //'pageSize' => 20,
            //     'pageSize' => 5,
            // ],
            'sort' => false,
        ]);

        return $this->renderAjax('kumpulan', ['batch' => $batch, 'dataProvider' => $dataProvider]);
    }

    public function actionCreateElaun($batch_code)
    {
        $model = new TblStaffRoc();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                if (Yii::$app->request->isAjax) {
                    // JSON response is expected in case of successful save
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    return ['success' => true];
                }
                return $this->redirect(['kumpulan', 'roc_batch' => $batch_code]);
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create_elaun', [
                'model' => $model,
            ]);
        } else {
            return $this->render('create_elaun', [
                'model' => $model,
            ]);
        }
    }
}
