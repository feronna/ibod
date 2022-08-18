<?php

namespace app\controllers\patrol;

use app\models\hronline\Tblprcobiodata;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\RefPosKawalanSearch;
use app\models\keselamatan\TblAkses;
use app\models\keselamatan\TblJadualDoPm;
use app\models\keselamatan\TblRekod;
use app\models\keselamatan\TblRollcall;
use app\models\keselamatan\TblShiftKeselamatanSearch;
use app\models\keselamatan\TblStaffKeselamatan;
use app\models\keselamatan\TblStaffKeselamatanSearch;
use app\models\Notification;
use app\models\patrol\BitPictures;
use app\models\patrol\PatrolExchangepos;
use Yii;
use app\models\patrol\PatrolMainTable;
use app\models\patrol\PatrolMainTableSearch;
use app\models\patrol\PatrolReportDo;
use app\models\patrol\PatrolTblReport;
use app\models\patrol\RefBit;
use app\models\patrol\RefBitSearch;
use app\models\patrol\RefRoute;
use app\models\patrol\RefRouteSearch;
use app\models\patrol\Rekod;
use app\models\patrol\RekodSearch;
use app\models\patrol\TblExcused;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Da\QrCode\QrCode;
use kartik\mpdf\Pdf;
use PhpOffice\PhpSpreadsheet\Reader\Xls\MD5;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;
use DateTime;

/**
 * MainController implements the CRUD actions for PatrolMainTable model.
 */
class MainController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['indexs', 'index', 'byname', 'generate', 'bulk-generate', 'qr', 'print-bulk', 'print', 'route-list', 'bit-list', 'add-bit', 'update-bit', 'add-route', 'add-patroller', 'create', 'update', 'delete', 'upload'],
                'rules' => [
                    [
                        'actions' => ['indexs', 'index', 'byname', 'generate', 'bulk-generate', 'qr', 'print-bulk', 'print', 'route-list', 'bit-list', 'add-bit', 'update-bit', 'add-route', 'add-patroller', 'create', 'update', 'delete', 'upload'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $logicno = Yii::$app->user->getId();

                            $check = TblAkses::find()->where(['icno' => $logicno])->andWhere(['isActive' => 1])->exists();
                            $boleh = false;
                            if ($check) {
                                $boleh = true;
                            }

                            return $boleh === true;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [],
            ],
        ];
    }

    /**
     * Lists all PatrolMainTable models.
     * @return mixed
     */
    public function actionIndex($icno, $pos, $date)
    {
        $model = Rekod::find()->where(['icno' => $icno])->andWhere(['LIKE', 'scan_date', $date])->orderBy([
            'scan_date' => SORT_ASC
        ])->all();
        // $model = Rekod::find()->where(['icno' => $icno])->andWhere(['route_id' => $pos])->andWhere(['LIKE', 'scan_date', $date])->orderBy([
        //     'scan_date' => SORT_ASC
        // ])->all();

        $searchModel = new RekodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $today = date('Y-m-d');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProviders' => $dataProvider,
            'today' => $date,
            'model' => $model,
        ]);
    }
    public function actionByname()
    {
        // $model = Rekod::find()->where(['icno' => $icno])->andWhere(['route_id' => $pos])->andWhere(['LIKE', 'scan_date', $date])->orderBy([
        //     'scan_date' => SORT_ASC
        // ])->all();
        $searchModel = new RekodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $id = Yii::$app->user->getId();
        $campus = Tblprcobiodata::findOne(['ICNO' => $id]);
        $akses = TblAkses::findOne(['icno' => $id]);
        if ($akses->akses_level == 2) {
            $data = ArrayHelper::map(Tblprcobiodata::find()->where(['!=', 'Status', '6'])->andWhere(['campus_id' => $campus->campus_id])->all(), 'CONm', 'CONm');
        } else {
            $data = ArrayHelper::map(Tblprcobiodata::find()->where(['!=', 'Status', '6'])->all(), 'ICNO', 'CONm');
        }
        return $this->render('byname', [
            'searchModel' => $searchModel,
            'dataProviders' => $dataProvider,
            'data' => $data,
            // 'model' => $model,
        ]);
    }
    public function actionIndexs($pos = null, $date = null)
    {
        $id = Yii::$app->user->getId();
        $campus = Tblprcobiodata::findOne(['ICNO' => $id]);
        // var_dump($campus->campus_id);die;
        $akses = TblAkses::findOne(['icno' => $id]);
        if ($akses->akses_level == 2) {
            $data = ArrayHelper::map(RefPosKawalan::find()->where(['kampus_id' => $campus->campus_id])->all(), 'id', 'pos_kawalan');
        } else {
            $data = ArrayHelper::map(RefPosKawalan::find()->all(), 'id', 'pos_kawalan');
        }
        if (!$pos) {
            $pos = 1;
        }
        if (!$date) {
            $date = date('Y-m-d');
        }

        $query1 = (new \yii\db\Query())
            ->select(" id,icno,tarikh,YEAR,MONTH,shift_id,
        unit_id,pos_kawalan_id,campus_id")
            ->from('keselamatan.tbl_shift_keselamatan')
            ->where(['tarikh' => $date])
            // ->andWhere(['campus_id' => $campus->campus_id])
            ->andWhere(['pos_kawalan_id' => $pos])
            ->andWhere(['!=', 'shift_id', '1']);

        $query2 = (new \yii\db\Query())
            ->select(" id,icno,tarikh,YEAR,MONTH,shift_id,
        unit_id,pos_kawalan_id,campus_id")
            ->from('keselamatan.tbl_ot')
            ->where(['tarikh' => $date])
            // ->andWhere(['campus_id' => $campus->campus_id])
            ->andWhere(['pos_kawalan_id' => $pos])
            ->andWhere(['!=', 'shift_id', '1']);


        $query3 = (new \yii\db\Query())
            ->select(" id,icno,tarikh,YEAR,MONTH,lmt_id,
        unit_id,pos_kawalan_id,campus_id")
            ->from('keselamatan.tbl_lmt')
            ->where(['tarikh' => $date])
            // ->andWhere(['campus_id' => $campus->campus_id])
            ->andWhere(['pos_kawalan_id' => $pos])
            ->andWhere(['!=', 'lmt_id', '1']);

        // $query = TblShiftKeselamatan::find();
        $query = $query1->union($query2)->union($query3)->all();
        //    VarDumper::dump( $query, $depth = 10, $highlight = true);die;
        $searchModel = new TblShiftKeselamatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('indexs', [
            'searchModel' => $searchModel,
            'dataProviders' => $dataProvider,
            'query' => $query,
            'today' => $date,
            'pos' => $pos,
            'bil' => 1,
            'data' => $data,
        ]);
    }
    //borang semakan DO by syif
    public function actionDoCheckIndex($syif = null, $date = null)
    {
        $id = Yii::$app->user->getId();
        $campus = Tblprcobiodata::findOne(['ICNO' => $id]);
        $akses = TblAkses::findOne(['icno' => $id]);
        $akses->akses_level == 2 ? $data = ArrayHelper::map(RefPosKawalan::find()->where(['kampus_id' => $campus->campus_id])->all(), 'id', 'pos_kawalan')
            : $data = ArrayHelper::map(RefPosKawalan::find()->all(), 'id', 'pos_kawalan');
        if (!$syif) {
            $syif = 3;
        }
        if (!$date) {
            $date = date('Y-m-d');
        }
        $report_do = new PatrolReportDo();
        $ulasan = PatrolReportDo::find()->where(['icno_do' => $id, 'date' => $date])->andWhere(['IN', 'shift_id', $syif])->all();
        if ($report_do->load(Yii::$app->request->post())) {
            // echo 'd';die;
            $report_do->icno_do = $id;
            $report_do->date = $date;
            $report_do->shift_id = $syif;
            $report_do->remark_dt = date('Y-m-d H:i:s');
            $report_do->campus_id = $akses->campus_id;
            if ($report_do->save(false)) {
                // VarDumper::dump($report_do,$depth = 10, $highlight=true);die;
                return $this->redirect(['do-check-index', 'syif' => $syif, 'date' => $date]);
            }
        }

        if ($syif == 3) {
            $syif = ['3', '18'];
        } else
        if ($syif == 4) {
            $syif = ['4', '19', '23', '24'];
        }
        // if ($id == 5) 
        else {
            $syif = ['5', '20'];
        }
        $query1 = (new \yii\db\Query())
            ->select(" id,icno,tarikh,YEAR,MONTH,shift_id,
        unit_id,pos_kawalan_id,campus_id")
            ->from('keselamatan.tbl_shift_keselamatan')
            ->where(['tarikh' => $date])
            ->andWhere(['campus_id' => $campus->campus_id])
            ->andWhere(['IN', 'shift_id', $syif]);

        $query2 = (new \yii\db\Query())
            ->select(" id,icno,tarikh,YEAR,MONTH,shift_id,
        unit_id,pos_kawalan_id,campus_id")
            ->from('keselamatan.tbl_ot')
            ->where(['tarikh' => $date])
            ->andWhere(['campus_id' => $campus->campus_id])
            ->andWhere(['IN', 'shift_id', $syif]);


        $query3 = (new \yii\db\Query())
            ->select(" id,icno,tarikh,YEAR,MONTH,lmt_id,
        unit_id,pos_kawalan_id,campus_id")
            ->from('keselamatan.tbl_lmt')
            ->where(['tarikh' => $date])
            ->andWhere(['campus_id' => $campus->campus_id])
            ->andWhere(['IN', 'lmt_id', $syif]);

        $var = false;
        $query = $query1->union($query2)->union($query3)->all();
        if ($query) {
            $var = true;
        }
        return $this->render('do-check', [

            'query' => $query,
            'today' => $date,
            'syif' => $syif,
            'bil' => 1,
            'data' => $data,
            'var' => $var,
            'do' => $report_do,
            'ulasan' => $ulasan,
            'campus' => $akses->campus_id
        ]);
    }

    //do hantaar laporan
    public function actionSendToVerify($syif, $date)
    {
        $id = Yii::$app->user->getId();
        $model = PatrolReportDo::find()->where(['icno_do' => $id, 'date' => $date])->andWhere(['IN', 'shift_id', $syif])->all();

        $campus = TblAkses::findOne(['icno' => $id]);

        $pm = TblJadualDoPm::find()->where(['tarikh' => $date])->andWhere(['campus_id' => $campus->campus_id])->andWhere(['shift_id' => 16])->one();
        if (!$pm) {
            Yii::$app->session->setFlash('alert', ['title' => 'Tidak Berjaya', 'type' => 'error', 'msg' => 'Pegawai Medan Belum ditetapkan. Sila Berhubung dengan penyelia jadual anda']);
            return $this->redirect(['keselamatan/ringkasan-laporan', 'syif' => $syif, 'tarikh' => $date]);
        }
        foreach ($model as $var) {
            $verify = PatrolReportDo::findOne($var->id);
            $verify->icno_pm = $pm->icno;
            $verify->report_dt = date('Y-m-d H:i:s');
            $verify->status = 'PENDING';

            $verify->update(false);
        }
        $ntf = new Notification();
        $ntf->icno = $pm->icno;
        $ntf->title = 'Pengesahan Laporan Rondaan Harian BKUMS';
        $ntf->content = "Laporan Harian Rondaan Menunggu untuk disahkan oleh anda ";
        $ntf->ntf_dt = date('Y-m-d H:i:s');
        $ntf->save();
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Laporan Telah Dihantar Kepada Pegawai Medan']);
        return $this->redirect(['patrol/main/do-check-index', 'syif' => $syif, 'tarikh' => $date]);
    }
    public function actionUpdateRemarkDo($syif, $date)
    {
        var_dump($syif, $date);
        die;
        $id = Yii::$app->user->getId();

        $model = PatrolReportDo::find()->where(['icno_do' => $id])->andWhere(['syif' => $syif])->andWhere(['date' => $date])->one();
        // var_dump($model->id);die;

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Ulasan telah Berjaya dikemaskini!']);
                return $this->redirect(['do-check-index', 'syif' => $syif, 'date' => $date]);
            }
        }
        return $this->render('update-remark-do', [
            'model' => $model
        ]);
    }

    public function generatestart($id)
    {
        $model = RefPosKawalan::findOne(['id' => $id]);
        $model->start_hashcode = MD5($model->id . '- Start');
        $model->save(false);

        $qrCode = (new QrCode('https://registrar.ums.edu.my/staff/web/patrol/scan/start?id=' . $model->start_hashcode))
            ->setSize(450)
            ->setMargin(5)
            ->useForegroundColor(51, 153, 255);

        // now we can display the qrcode in many ways
        // saving the result to a file:

        $qrCode->writeFile(Yii::getAlias('@webroot/uploads/patrol/' . $model->pos_kawalan . ' - Start' . '.png')); // writer defaults to PNG when none is specified
        $pic = BitPictures::findOne(['route_id' => $id, 'type' => 'pos-start']);
        if (!$pic) {
            $pic = new BitPictures();

            $data['name'] =  $model->pos_kawalan . '.png';
            $data['tempName'] =  Yii::getAlias('@webroot/uploads/patrol/' . $model->pos_kawalan . ' - Start' . '.png');
            $pic->route_id = $id;
            // $pic->bit_id = $model->id;
            $pic->type = 'pos-start';
            // if ($pic->file_hashcode) {
            $datas = Yii::$app->FileManager->UploadFile($data['name'], $data['tempName'], '05', 'POS');

            if ($datas->status == true) {
                $pic->file_hashcode = $datas->file_name_hashcode;
            }
            $pic->save(false);
        }
        //   VarDumper::dump( $datas, $depth = 10, $highlight = true);die;

        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'QrCode Successfully Generated.']);
        return $this->redirect(['patrol/main/route-list']);
    }
    public function generateend($id)
    {
        $model = RefPosKawalan::findOne(['id' => $id]);
        $model->end_hashcode = MD5($model->id . 'end');
        $model->save(false);


        $qrCode1 = (new QrCode('https://registrar.ums.edu.my/staff/web/patrol/scan/end?id=' . $model->end_hashcode))
            ->setSize(450)
            ->setMargin(5)
            ->useForegroundColor(51, 153, 255);

        // now we can display the qrcode in many ways
        // saving the result to a file:

        $qrCode1->writeFile(Yii::getAlias('@webroot/uploads/patrol/' . $model->pos_kawalan . ' - End' . '.png')); // writer defaults to PNG when none is specified
        $pic = BitPictures::findOne(['route_id' => $id, 'type' => 'pos-end']);
        if (!$pic) {
            $pic = new BitPictures();

            $data['name'] =  $model->pos_kawalan . '.png';
            $data['tempName'] =  Yii::getAlias('@webroot/uploads/patrol/' . $model->pos_kawalan . ' - End' . '.png');
            $pic->route_id = $id;
            // $pic->bit_id = $model->id;
            $pic->type = 'pos-end';
            // if ($pic->file_hashcode) {
            $datas = Yii::$app->FileManager->UploadFile($data['name'], $data['tempName'], '05', 'Pos');
            if ($datas->status == true) {
                $pic->file_hashcode = $datas->file_name_hashcode;
            }
            $pic->save(false);
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'QrCode Successfully Generated.']);
        return $this->redirect(['patrol/main/route-list']);
    }

    public function actionGenerate($id)
    {
        $model = RefBit::findOne(['id' => $id]);
        $model->encrypted = MD5($model->id);
        $model->save(false);

        $qrCode = (new QrCode('https://registrar.ums.edu.my/staff/web/patrol/scan/info?id=' . $model->encrypted))
            ->setSize(450)
            ->setMargin(5)
            ->useForegroundColor(51, 153, 255);

        // now we can display the qrcode in many ways
        // saving the result to a file:

        $qrCode->writeFile(Yii::getAlias('@webroot/uploads/patrol/' . $model->bit_name . '.png')); // writer defaults to PNG when none is specified
        // VarDumper::dump( Yii::getAlias('@webroot/patrol/'.'code.png'), $depth = 10, $highlight = true);die;
        // display directly to the browser 
        // header('Content-Type: ' . $qrCode->getContentType());
        // echo $qrCode->writeString();
        return $this->render('generate', [
            'model' => $model,
            'qrCode' => $qrCode,

        ]);
    }
    //to generate all qrcode bit for the route
    public function actionBulkGenerate($id)
    {
        // var_dump($id);die;
        $model = RefBit::findAll(['route_id' => $id]);
        $this->generatestart($id);
        $this->generateend($id);
        foreach ($model as $m) {
            $m->encrypted = MD5($m->id);

            $m->save(false);
            // $path = 'C:/patrol';
            // FileHelper::createDirectory($path, $mode = 0775, $recursive = true);

            $qrCode = (new QrCode('https://registrar.ums.edu.my/staff/web/patrol/scan/info?id=' . $m->encrypted))
                ->setSize(450)
                ->setMargin(5)
                ->useForegroundColor(51, 153, 255);
            $qrCode->writeFile(Yii::getAlias('@webroot/uploads/patrol/' . $m->bit_name . '.png')); // writer defaults to PNG when none is specified
            //   var_dump(Yii::getAlias('@webroot/uploads/patrol/' . $m->bit_name . '.png'));die;
            $pic = BitPictures::findOne(['route_id' => $id, 'bit_id' => $m->id]);
            if (!$pic) {
                $pic = new BitPictures();

                $data['name'] =  $m->bit_name . '.png';
                $data['tempName'] =  Yii::getAlias('@webroot/uploads/patrol/' . $m->bit_name . '.png');
                $pic->route_id = $id;
                $pic->bit_id = $m->id;
                $pic->type = 'bit';
                // if ($pic->file_hashcode) {
                $datas = Yii::$app->FileManager->UploadFile($data['name'], $data['tempName'], '05', 'Medical Certificate');
                if ($datas->status == true) {
                    $pic->file_hashcode = $datas->file_name_hashcode;
                }
                $pic->save(false);
            }
        }
        Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'QrCode Successfully Generated.']);
        return $this->redirect(['patrol/main/bit-list', 'id' => $id]);
    }

    //download qrcode
    public function actionQr($id)
    {

        if ($post = Yii::$app->request->post()) {
            $id = $post['id'];
            $tahun = $post['tahun'];
            $start_mth = $post['start_mth'];
            $end_mth = $post['end_mth'];

            $this->redirect(['gen-yearly-pdf-rpt', 'id' => $id, 'tahun' => $tahun, 'start_mth' => $start_mth, 'end_mth' => $end_mth]);
        }

        $download = RefBit::findAll(['route_id' => $id]);
        foreach ($download as $d) {
            $path = Yii::getAlias('@webroot/uploads/patrol/' . $d->bit_name . '.png');

            if (file_exists($path)) {
                return Yii::$app->response->sendFile($path, 'File name here');
            }
        }
    }
    public function actionDownload($id)
    {
        $model = RefBit::findAll(['route_id' => $id]);

        $content = $this->renderPartial('_printbulk', [
            'id' => $id,
            'model' => $model,
        ]);

        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Penyata Kelayakan Cuti .pdf",
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
            'options' => ['title' => "Maklumat Kelayakan Cuti "],
            // call mPDF methods on the fly
            'methods' => [
                // 'SetHeader' => ["UNIVERSITI MALAYSIA SABAH||Penyata Kelayakan Cuti"],
                // 'SetFooter' => ['INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN||{PAGENO}'],
                //    'SetFooter' => [' {PAGENO}'],
            ]
        ]);
        // $mpdf->SetHeader('Kartik Header'); // call methods or set any properties
        // $mpdf->WriteHtml($content); // call mpdf write html
        return $pdf->render();

        // echo $pdf->Output('filename', 'D');
    }
    public function actionPrintBulk($id)
    {
        $pos = RefPosKawalan::findOne(['id' => $id]);
        $this->view->title = "POS KAWALAN ()";
        $model = BitPictures::findAll(['route_id' => $id]);
        // $models = BitPictures::find()->where(['route_id' => $id])->andWhere(['LIKE','type','pos'])->all();
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_printbulk', [
            'id' => $id,
            'model' => $model,
            // 'models' => $models,
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "QRCODE " . $pos->pos_kawalan . ".pdf",
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
            'options' => ['title' => "Maklumat Pos Kawalan "],
            // call mPDF methods on the fly
            'methods' => [
                // 'SetHeader' => ["UNIVERSITI MALAYSIA SABAH||Penyata Kelayakan Cuti"],
                // 'SetFooter' => ['INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN||{PAGENO}'],
                //    'SetFooter' => [' {PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }
    public function actionPrint($id)
    {

        $this->view->title = "MAKLUMAT KELAYAKAN CUTI ()";
        $model = RefBit::findOne(['id' => $id]);
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_print', [
            'id' => $id,
            'model' => $model,
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            'filename' => "Penyata Kelayakan Cuti .pdf",
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
            'options' => ['title' => "Maklumat Kelayakan Cuti "],
            // call mPDF methods on the fly
            'methods' => [
                // 'SetHeader' => ["UNIVERSITI MALAYSIA SABAH||Penyata Kelayakan Cuti"],
                // 'SetFooter' => ['INI ADALAH CETAKAN KOMPUTER, TANDATANGAN TIDAK DIPERLUKAN||{PAGENO}'],
                //    'SetFooter' => [' {PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionRouteList()
    {
        $searchModel = new RefPosKawalanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('route-list', [
            'searchModel' => $searchModel,
            'dataProviders' => $dataProvider,
        ]);
    }
    public function actionBitList()
    {
        $searchModel = new RefBitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('bit-list', [
            'searchModel' => $searchModel,
            'dataProviders' => $dataProvider,
        ]);
    }
    /**
     * Displays a single PatrolMainTable model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PatrolMainTable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddBit($id)
    {
        $model = new RefBit();

        $model->scenario = 'bit';

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {

                return $this->redirect(['bit-list', 'id' => $id]);
            }
        }

        return $this->render('add-bit', [
            'model' => $model,
        ]);
    }

    public function actionUpdateBit($id)
    {
        $model = RefBit::findOne(['id' => $id]);
        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                return $this->redirect(['bit-list', 'id' => $model->route_id]);
            }
        }
        return $this->render('update-bit', [
            'model' => $model,
        ]);
    }

    public function actionAddRoute()
    {
        $model = new RefPosKawalan();

        $model->scenario = 'bit';

        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->added_by = Yii::$app->user->getId();
            if ($model->save()) {
                return $this->redirect(['route_list']);
            }
        }

        return $this->render('add-route', [
            'model' => $model,
        ]);
    }

    //add anggota to list peronda , not needed for now
    public function actionAddPatroller()
    {
        $model = new PatrolMainTable();

        $model->scenario = 'patrol';
        $staff = TblStaffKeselamatan::find()->where(['isActive' => 1])->joinWith('staff')->all();
        if (Yii::$app->request->isAjax && $model->load($_POST)) {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->added_by = Yii::$app->user->getId();
            if ($model->save()) {
                return $this->redirect(['route_list']);
            }
        }

        return $this->render('add-patroller', [
            'model' => $model,
            'staff' => $staff
        ]);
    }
    //add remark
    public function actionRemark($shift, $pos, $date)
    {
        $model = new TblExcused();

        // $model->scenario = 'patrol';
        $icno = Yii::$app->user->getId();
        $camp = TblStaffKeselamatan::findOne(['staff_icno' => $icno]);
        $do = TblJadualDoPm::find()->where(['shift_id' => $shift])->andWhere(['campus_id' => $camp->campus_id])->andWhere(['tarikh' => $date])->one();

        if ($model->load(Yii::$app->request->post())) {
            $model->icno =  $icno;
            $model->pos_id =  $pos;
            $model->shift_id =  $shift;
            $model->date =  $date;
            $model->remark_dt =  date('Y-m-d H:i:s');
            $model->do_onduty = $do->icno;
            $model->campus_id =  $camp->campus_id;
            if ($model->save()) {
                return $this->redirect(['patrol/main/my-patrol']);
            }
        }

        return $this->render('remark', [
            'model' => $model,
            'icno' => $icno,
            'do' => $do->icno,
            'shift' => $shift,
            'pos' => $pos,
            'date' => $date,
        ]);
    }
    public function actionPatrollerReport($shift, $pos, $date, $count = null)
    {
        $model = new PatrolTblReport();
        if (!$count) {
            $count = 0;
        }
        // var_dump($shift, $pos, $date);die;
        // $model->scenario = 'on';
        $icno = Yii::$app->user->getId();
        $camp = TblStaffKeselamatan::findOne(['staff_icno' => $icno]);
        $do = TblJadualDoPm::find()->where(['shift_id' => $shift])->andWhere(['campus_id' => $camp->campus_id])->andWhere(['tarikh' => $date])->one();

        if ($model->load(Yii::$app->request->post())) {
            $model->icno =  "$icno";

            $model->pos_id = (int) $pos;
            $model->shift_id =  (int)$shift;
            $model->date =  $date;
            $model->count = (int) $count;
            $model->report_dt =  date('Y-m-d H:i:s');
            $model->do_onduty = "$do->icno";
            $model->campus_id = (int) $camp->campus_id;
            // $model->type =  (int) $model->type;

            if ($model->save(false)) {
                // VarDumper::dump($model,$depth = 10, $highlight ='true');die;

                return $this->redirect(['patrol/main/my-patrol']);
            }
        }

        return $this->render('patroller-report', [
            'model' => $model,
            'icno' => $icno,
            'do' => $do->icno,
            'shift' => $shift,
            'pos' => $pos,
            'date' => $date,
        ]);
    }
    public function actionApprovalList()
    {
        $icno = Yii::$app->user->getId();

        $model = TblExcused::find()->where(['do_onduty' => $icno])->andWhere(['IN', 'status', ['ENTRY']])->all();

        return $this->render('approval-list', [
            'model' => $model,

            // 'bal' => $bal,
        ]);
    }
    public function actionPosList()
    {
        $icno = Yii::$app->user->getId();

        $model = RefPosKawalan::find()->where(['active' => 1])->andWhere(['!=', 'file_hashcode', 'NULL'])->all();
        // var_dump($model);die;
        return $this->render('pos-list', [
            'model' => $model,

            // 'bal' => $bal,
        ]);
    }
    public function actionApprove($id)
    {
        $model = TblExcused::findOne(['id' => $id]);
        if ($model->load(Yii::$app->request->post())) {
            $model->approve_dt = date('Y-m-d H:i:s');
            if ($model->save()) {
                return $this->redirect(['patrol/main/approval-list']);
            }
        }
        return $this->render('approve', [
            'model' => $model,

        ]);
    }
    public function actionCreate()
    {
        $model = new PatrolMainTable();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionPatrolReport()
    {
    }
    /**
     * Updates an existing PatrolMainTable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PatrolMainTable model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionDeleteBit($id)
    {
        $model = RefBit::findOne(['id' => $id]);
        if ($model) {
            $model->delete();
        }

        return $this->redirect(['patrol/main/bit-list', 'id' => $model->route_id]);
    }
    //upload
    public function actionUpload($id)
    {

        $model = RefPosKawalan::findOne(['id' => $id]);
        $icno = Yii::$app->user->getId();

        // var_dump($sick_leave_verifier );die;
        // if (Yii::$app->request->isAjax && $model->load($_POST)) {
        //     Yii::$app->response->format = 'json';
        //     return \yii\widgets\ActiveForm::validate($model);
        // }

        if ($model->load(Yii::$app->request->post())) {

            $model->updated_by = $icno;

            // $model->peraku_by = $model_department->chief;
            //file
            $model->file_hashcode = UploadedFile::getInstance($model, 'file_hashcode');
            $datas = Yii::$app->FileManager->UploadFile($model->file_hashcode->name, $model->file_hashcode->tempName, '05', 'Bit Pic');

            if ($datas->status == true) {
                $model->file_hashcode = $datas->file_name_hashcode;
            }

            if ($model->save()) {

                Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Permohonan telah dihantar!']);
                return $this->redirect(['patrol/main/bit-list', 'id' => $id]);
            }
        }

        return $this->render("upload-bit-pic", [
            'model' => $model,

        ]);
    }

    public function actionDoPatrol()
    {
        $searchModel = new RekodSearch();
        $dataProvider = $searchModel->searchs(Yii::$app->request->queryParams);
        $pos = RefPosKawalan::findAll(['active' => 1]);
        $date = Yii::$app->request->queryParams;
        if (Yii::$app->request->queryParams == NULL) {
            $date = date('Y-m-d');
        }
        $id = Yii::$app->user->getId();
        $check = TblJadualDoPm::find()->where(['icno' => $id, 'tarikh' => $date])->one();

        return $this->render('do-patrol', [
            'searchModel' => $searchModel,
            'dataProviders' => $dataProvider,
            'query' => $check,
            'data' => $pos,
            'icno' => $id,
            // 'today' => $date
        ]);
    }
    public function actionMyPatrol()
    {
        $searchModel = new RekodSearch();
        $dataProvider = $searchModel->searchs(Yii::$app->request->queryParams);
        $date = Yii::$app->request->queryParams;
        if (Yii::$app->request->queryParams == NULL) {
            $date = date('Y-m-d');
        }
        $id = Yii::$app->user->getId();
        $check = TblJadualDoPm::find()->where(['icno' => $id, 'tarikh' => $date])->one();
        if ($check) {
            return $this->redirect(['patrol/main/do-patrol']);
        }

        $campus = Tblprcobiodata::findOne(['ICNO' => $id]);
        $akses = TblAkses::findOne(['icno' => $id]);
        if ($akses && $akses->akses_level == 2) {
            $data = ArrayHelper::map(Tblprcobiodata::find()->where(['!=', 'Status', '6'])->andWhere(['campus_id' => $campus->campus_id])->all(), 'CONm', 'CONm');
        } else {
            $data = ArrayHelper::map(Tblprcobiodata::find()->where(['!=', 'Status', '6'])->all(), 'ICNO', 'CONm');
        }

        $query1 = (new \yii\db\Query())
            ->select(" id,icno,tarikh,YEAR,MONTH,shift_id,
        unit_id,pos_kawalan_id,campus_id")
            ->from('keselamatan.tbl_shift_keselamatan')
            ->where(['tarikh' => $date])
            ->andWhere(['campus_id' => $campus->campus_id])
            ->andWhere(['icno' => $id])
            ->andWhere(['!=', 'shift_id', '1']);

        $query2 = (new \yii\db\Query())
            ->select(" id,icno,tarikh,YEAR,MONTH,shift_id,
        unit_id,pos_kawalan_id,campus_id")
            ->from('keselamatan.tbl_ot')
            ->where(['tarikh' => $date])
            ->andWhere(['campus_id' => $campus->campus_id])
            ->andWhere(['icno' => $id])
            ->andWhere(['!=', 'shift_id', '1']);


        $query3 = (new \yii\db\Query())
            ->select(" id,icno,tarikh,YEAR,MONTH,lmt_id,
        unit_id,pos_kawalan_id,campus_id")
            ->from('keselamatan.tbl_lmt')
            ->where(['tarikh' => $date])
            ->andWhere(['campus_id' => $campus->campus_id])
            ->andWhere(['icno' => $id])
            ->andWhere(['!=', 'lmt_id', '1']);

        // $query = TblShiftKeselamatan::find();
        $query = $query1->union($query2)->union($query3)->all();

        return $this->render('my-patrol', [
            'searchModel' => $searchModel,
            'dataProviders' => $dataProvider,
            'query' => $query,
            'data' => $data,
            'id' => $id,
        ]);
    }

    //reporting
    public function actionDoReport($id = null, $shift, $pos, $date)
    {
        $model = new TblExcused();
        $count = 5;

        $icno = Yii::$app->user->getId();
        $camp = TblStaffKeselamatan::findOne(['staff_icno' => $icno]);
        // $do = TblJadualDoPm::find()->where(['shift_id' => $shift])->andWhere(['campus_id' => $camp->campus_id])->andWhere(['tarikh' => $date])->one();

        if ($model->load(Yii::$app->request->post())) {
            $model->icno =  $id;
            $model->pos_id =  $pos;
            $model->shift_id =  $shift;
            $model->date =  $date;
            $model->count = $count;
            $model->report_dt =  date('Y-m-d H:i:s');
            $model->do_onduty = $icno;
            $model->campus_id =  $camp->campus_id;
            $model->status =  "APPROVED";
            if ($model->save()) {
                return $this->redirect(['patrol/main/my-patrol']);
            }
        }
        return $this->render('do-report', [
            'icno' => $id,
            'pos' => $pos,
            'shift' => $shift,
            'date' => $date,
            'model' => $model,
            'do' => $icno


        ]);
    }
    public function actionBitReport($id = null, $shift, $pos, $date)
    {

        $year = date('Y');
        $mth = date('m');

        if (!$id) {
            $id = Yii::$app->user->getId();
        }
        if (!$date) {
            $date = date('Y-m-d');
        }

        $var = null;
        $nbit = [];
        for ($i  = 1; $i < 17; $i++) {
            $nbit[] = $i;
        }
        //    var_dump($nbit);die;
        $data = ['PERTAMA (2 jam)', 'KEDUA (2 jam)', 'KETIGA (2 jam)', 'KEEMPAT (2 jam)'];
        $data2 = ['PERTAMA (2 jam)', 'KEDUA (2 jam)', 'KETIGA (2 jam)', 'KEEMPAT (2 jam)'];
        $bit = RefBit::find()->where(['route_id' => $pos])->all();
        // if ($tahun && $bulan) {
        //     echo 'd';die;
        $var = $this->getDaysInYearMonth($year, $mth, 'Y-m-d');
        // }
        $tukarpos = PatrolExchangepos::findOne(['icno' => $id, 'tarikh' => $date]);

        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);

        // VarDumper::dump( $var, $depth = 10, $highlight = true);die;
        return $this->render('bit-report', [
            'var' => $var, 'icno' => $id, 'tahun' => $year,
            'bulan' => $mth, 'biodata' => $biodata,
            'data' => $data,
            'data2' => $data2,
            'bil' => 1,
            'bit' => $bit,
            'nbit' => $nbit,
            'pos' => $pos,
            'shift' => $shift,
            'date' => $date,
            'tukarpos' => $tukarpos,
        ]);
    }

    //monthly report
    public function actionMonthlyReport($id = null, $tahun = null, $bulan = null)
    {

        $year = date('Y');
        $mth = date('m');

        if (!$id) {
            $id = Yii::$app->user->getId();
        }

        $var = null;
        if ($tahun != null) {
            $year = $tahun;
        }

        if ($bulan != null) {
            $mth = $bulan;
        }
        if ($tahun && $bulan) {
            $var = $this->getDaysInYearMonth($year, $mth, 'Y-m-d');
        }

        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);

        return $this->render('monthly-report', ['var' => $var, 'icno' => $id, 'tahun' => $year, 'bulan' => $mth, 'biodata' => $biodata]);
    }
    public function actionYearlyReport($id = null, $start = null, $end = null)
    {

        $yearstart = date("Y", strtotime($start));
        $monthstart = date("m", strtotime($start));
        $yearend = date("Y", strtotime($end));
        // echo $yearend;die;
        $monthend = date("m", strtotime($end));

        if (!$id) {
            $id = Yii::$app->user->getId();
        }

        $var = null;
        $var1 = null;
        if ($start && $end) {
            $var = $this->getMonthsInYearStart($yearstart, $monthstart, 'm');
            $var1 = $this->getMonthsInYearEnd($yearend, $monthend, 'm');
        }
        $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);

        return $this->render('yearly-report', [
            'var' => $var,
            'var1' => $var1,
            'yearend' => $yearend,
            'yearstart' => $yearstart,
            'monthend' => $monthend,
            'monthstart' => $monthstart,
            'icno' => $id,
            'start' => $start,
            'end' => $end,
            'biodata' => $biodata
        ]);
    }
    //
    function getMonthsInYearStart(int $year, int $month, string $format)
    {
        //        var_dump($format);die;
        $date = DateTime::createFromFormat("Y-n", "$year-$month");

        $datesArray = array();
        for ($i = $month; $i <= 12; $i++) {
            $datesArray[] = TblRekod::viewBulan($i);
        }
        return $datesArray;
    }

    function getMonthsInYearEnd(int $year, int $month, string $format)
    {
        //        var_dump($format);die;
        $date = DateTime::createFromFormat("Y-n", "$year-$month");

        $datesArray = array();
        for ($i = 1; $i <= $month; $i++) {
            $datesArray[] = TblRekod::viewBulan($i);
        }
        return $datesArray;
    }

    //laporan bulanan list
    public function actionStaffList()
    {
        $searchModel = new TblStaffKeselamatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // $pos = RefPosKawalan::findAll(['active' => 1]);
        // $date = Yii::$app->request->queryParams;
        // if (Yii::$app->request->queryParams == NULL) {
        //     $date = date('Y-m-d');
        // }
        // $id = Yii::$app->user->getId();
        // $check = TblJadualDoPm::find()->where(['icno' => $id, 'tarikh' => $date])->one();

        return $this->render('staff-list', [
            'searchModel' => $searchModel,
            'dataProviders' => $dataProvider,
            // 'query' => $check,
            // 'data' => $pos,
            // 'icno' => $id,
            // 'today' => $date
        ]);
    }

    function getDaysInYearMonth(int $year, int $month, string $format)
    {
        $date = DateTime::createFromFormat("Y-n", "$year-$month");
        // var_dump($year);die;
        $datesArray = array();
        for ($i = 1; $i <= $date->format("t"); $i++) {
            $datesArray[] = DateTime::createFromFormat("Y-n-d", "$year-$month-$i")->format($format);
        }

        return $datesArray;
    }

    /**
     * Finds the PatrolMainTable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PatrolMainTable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PatrolMainTable::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
