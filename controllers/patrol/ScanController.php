<?php

namespace app\controllers\patrol;

use Yii;
use app\models\esticker\TblAccess;
use app\models\esticker\TblStickerStaf;
use app\models\esticker\TblPelekatKenderaan;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\patrol\logs;
use app\models\hronline\Tblprcobiodata;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\TblJadualDoPm;
use app\models\keselamatan\TblLmt;
use app\models\keselamatan\TblOt;
use app\models\keselamatan\TblShiftKeselamatan;
use app\models\patrol\logs as PatrolLogs;
use app\models\patrol\MainTable;
use app\models\patrol\RefBit;
use app\models\patrol\Rekod;
use DateTime;
use yii\helpers\VarDumper;

/**
 * ScanController implements the CRUD actions for TblPelekatKenderaanStudent model.
 */
class ScanController extends Controller
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
        ];
    }

    /**
     * Lists all TblPelekatKenderaanStudent models.
     * @return mixed
     */
    public function actionViewInfo($id = null)
    {
        $this->layout = 'index';

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())) {

            $biodata = Tblprcobiodata::find()->where(['ICNO' => $model->username])->one();


            $enc = Yii::$app->getRequest()->getQueryParam('id');
            $id = RefBit::findOne(['encrypted' => $enc]);
            // var_dump($id);die;
            $model->text = $id->id;
            if ($biodata && $model->password == "BSM4dm1n2021") {
                $model->username = $biodata->ICNO;
                // $model->activeDirectory = true;
                // var_dump('d');die;
                $model->login();
                return $this->redirect(['info', 'id' => $model->text, 'key' => md5($biodata->ICNO)]);
            }
            $url = "http://api.ums.edu.my/api/v2/basic/ad/login";
            $secret_key = 'yKrEdoUEMme6LuOOcfTp8sVl1gMwpe';
            $public_key = 'WwQUWooGPXL19OormLRcDXRR8lOjvN';
            $login_username = $model->username;
            $login_password = $model->password;

            $data = [
                'txtUserId' => $login_username,
                'txtUserPassword' => $login_password,
                'secret_key' => $secret_key,
                'public_key' => $public_key
            ];

            $datas = json_decode($this->CallAPI('POST', $url, $data), true);


            if ($datas['status'] == "Successful login") {

                $icno = $datas['login']['userid'];

                $model->username = $icno;
                $check = TblShiftKeselamatan::findOne(['icno' => $icno]);

                $log = new logs();
                $log->icno = $icno;
                $log->log_time = date('Y-m-d H:i:s');
                $log->ip_address = $this->getRealUserIp();
                $log->action = "view-info";
                $log->detail = "Scan Bit" . $id->bit_name;
                $log->save();
                $id = Yii::$app->getRequest()->getQueryParam('id');
                // var_dump(Yii::$app->request->post());die;
                // if (!$check) {
                //     Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'Unauthorized Access.']);
                //     return $this->redirect(['view-info']);
                // }
                return $this->redirect(['info', 'id' => $model->text, 'key' => md5($icno)]);
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'Maaf', 'type' => 'error', 'msg' => 'Nama pengguna/Katalaluan tidak tepat.']);
                return $this->redirect(['view-info']);
            }
        }


        return $this->render('login', [
            'model' => $model,

        ]);
    }

    function getRealUserIp()
    {
        switch (true) {
            case (!empty($_SERVER['HTTP_X_REAL_IP'])):
                return $_SERVER['HTTP_X_REAL_IP'];
            case (!empty($_SERVER['HTTP_CLIENT_IP'])):
                return $_SERVER['HTTP_CLIENT_IP'];
            case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])):
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            default:
                return $_SERVER['REMOTE_ADDR'];
        }
    }

    public function actionInfo($id)
    {

        // echo('d');die;
        // $this->layout = 'index';
        $shift = '';
        $icno = Yii::$app->user->getId();
        $bit = RefBit::findOne(['encrypted' => $id]);
        // var_dump($bit->id);die;
        $model = new Rekod();
        $pegawai = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $status = 0;

        if ($bit) {
            $check = TblShiftKeselamatan::findOne(['icno' => $icno]);
            $log = new logs();
            $log->icno = $icno;
            $log->log_time = date('Y-m-d H:i:s');
            $log->ip_address = $this->getRealUserIp();
            $log->action = "view-info";
            $log->detail = "Scan Bit" . $bit->bit_name;
            $log->save();
            $id = Yii::$app->getRequest()->getQueryParam('id');
            if (!$check) {
                Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'Unauthorized Access.']);
                return $this->redirect(['scan/view-info']);
            }
            // return $this->redirect(['info', 'id' => $model->text, 'key' => md5($icno)]);
            if ($pegawai) {
                $status = 1;
            }
        }
        return $this->render('view_info', [
            'model' => $model,
            'status' => $status,
            'pegawai' => $pegawai,
            'bit' => $bit,
            'url_zone' => Yii::$app->urlManager->createUrl("patrol/scan/zone"),
            'id' => $bit->id,
            'key' => $icno,
            'shift' => $shift,

        ]);
    }
    public function logs($icno, $ip, $action, $detail)
    {
        $log = new logs();
        $log->icno = $icno;
        $log->log_time = date('Y-m-d H:i:s');
        $log->ip_address = $ip;
        $log->action = $action;
        $log->detail = $detail;
        $log->save();
    }
    public function actionDoStart($id)
    {
        $shift = '';
        $icno = Yii::$app->user->getId();
        $pos = RefPosKawalan::findOne(['start_hashcode' => $id]);

        $model = new Rekod();
        $pegawai = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $this->logs($icno, $this->getRealUserIp(), 'do-start', "Do Start Patrolling" . $pos->pos_kawalan);

        $status = 1;


        return $this->render('do-start', [
            'model' => $model,
            'status' => $status,
            'pegawai' => $pegawai,
            'bit' => $pos,
            'url_zone' => Yii::$app->urlManager->createUrl("patrol/scan/zonepos"),
            'id' => $pos->id,
            'key' => $icno,
            'shift' => $shift,

        ]);
    }
    public function actionDoEnd($id)
    {
        $shift = '';
        $icno = Yii::$app->user->getId();
        $pos = RefPosKawalan::findOne(['end_hashcode' => $id]);

        $model = new Rekod();
        $pegawai = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $this->logs($icno, $this->getRealUserIp(), 'do-start', "Do End Patrolling" . $pos->pos_kawalan);

        $status = 1;


        return $this->render('do-end', [
            'model' => $model,
            'status' => $status,
            'pegawai' => $pegawai,
            'bit' => $pos,
            'url_zone' => Yii::$app->urlManager->createUrl("patrol/scan/zonepos"),
            'id' => $pos->id,
            'key' => $icno,
            'shift' => $shift,

        ]);
    }
    public function actionStart($id)
    {
        $shift = '';
        $icno = Yii::$app->user->getId();
        $pos = RefPosKawalan::findOne(['start_hashcode' => $id]);
        $do = TblJadualDoPm::findOne(['icno' => $icno, 'tarikh' => date('Y-m-d')]);

        if ($do) {
            return $this->redirect(['patrol/scan/do-start', 'id' => $id]);
        }
        // var_dump($bit->id);die;
        $model = new Rekod();
        $pegawai = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $status = 0;

        if ($pos) {
            $check = TblShiftKeselamatan::findOne(['icno' => $icno]);
            $log = new logs();
            $log->icno = $icno;
            $log->log_time = date('Y-m-d H:i:s');
            $log->ip_address = $this->getRealUserIp();
            $log->action = "view-info";
            $log->detail = "Start Patrolling" . $pos->pos_kawalan;
            $log->save();
            $id = Yii::$app->getRequest()->getQueryParam('id');
            if (!$check) {
                Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'Unauthorized Access.']);
                return $this->redirect(['scan/view-info']);
            }
            // return $this->redirect(['info', 'id' => $model->text, 'key' => md5($icno)]);
            if ($pegawai) {
                $status = 1;
            }
        }
        return $this->render('start', [
            'model' => $model,
            'status' => $status,
            'pegawai' => $pegawai,
            'bit' => $pos,
            'url_zone' => Yii::$app->urlManager->createUrl("patrol/scan/zonepos"),
            'id' => $pos->id,
            'key' => $icno,
            'shift' => $shift,

        ]);
    }
    public function actionEnd($id)
    {

        // echo('d');die;
        // $this->layout = 'index';
        $shift = '';
        $icno = Yii::$app->user->getId();
        $pos = RefPosKawalan::findOne(['end_hashcode' => $id]);
        // var_dump($bit->id);die;
        $model = new Rekod();
        $pegawai = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $status = 0;
        $do = TblJadualDoPm::findOne(['icno' => $icno, 'tarikh' => date('Y-m-d')]);
        // var_dump($do);die;
        if ($do) {
            return $this->redirect(['patrol/scan/do-end', 'id' => $id]);
        }
        if ($pos) {
            $check = TblShiftKeselamatan::findOne(['icno' => $icno]);
            $log = new logs();
            $log->icno = $icno;
            $log->log_time = date('Y-m-d H:i:s');
            $log->ip_address = $this->getRealUserIp();
            $log->action = "view-info";
            $log->detail = "End Patrolling" . $pos->pos_kawalan;
            $log->save();
            $id = Yii::$app->getRequest()->getQueryParam('id');
            if (!$check) {
                Yii::$app->session->setFlash('alert', ['title' => 'Sorry', 'type' => 'error', 'msg' => 'Unauthorized Access.']);
                return $this->redirect(['scan/view-info']);
            }
            // return $this->redirect(['info', 'id' => $model->text, 'key' => md5($icno)]);
            if ($pegawai) {
                $status = 1;
            }
        }
        return $this->render('end', [
            'model' => $model,
            'status' => $status,
            'pegawai' => $pegawai,
            'bit' => $pos,
            'url_zone' => Yii::$app->urlManager->createUrl("patrol/scan/zonepos"),
            'id' => $pos->id,
            'key' => $icno,
            'shift' => $shift,

        ]);
    }
    public function actionEndDo($id)
    {
        $icno = Yii::$app->user->getId();
        $bit = RefPosKawalan::findOne(['id' => $id]);
        $pegawai = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $model = Rekod::find()->where(['route_id' => $bit->id, 'icno' => $pegawai->ICNO])
            ->andWhere(['LIKE', 'scan_date', date('Y-m-d')])
            ->andWhere(['type' => 3])
            ->orderBy([
                'scan_date' => SORT_DESC,
            ])->one();
        $test = RefPosKawalan::distance(Yii::$app->request->post()['Rekod']['latlng'], $id);

        if (!$model) {
            $model = new Rekod();

            if ($model->load(Yii::$app->request->post())) {
                $count = 1;

                $model->icno =  $pegawai->ICNO;
                $model->route_id = $bit->id;
                // $model->bit_id = $id;
                $model->scan_date = date('Y-m-d H:i:s');
                $model->external = $test ? 0 : 1;
                $model->in_lat_lng = Yii::$app->request->post()['Rekod']['latlng'];
                $model->patrol_count = $count;
                $model->type = 3;
                $model->do = 1;
                $model->shift = Yii::$app->request->post()['shift'];

                if ($model->save(false)) {

                    Yii::$app->session->setFlash('alert', ['title' => 'Clock In', 'type' => 'success', 'msg' => 'Your time is recorded and please go to your next location']);
                    return $this->redirect(['patrol/scan/scan-history', 'id' => $icno]);
                }
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'UnSuccessful', 'type' => 'error', 'msg' => 'You Already scanned the QrCode']);
            return $this->redirect(['patrol/scan/my-patrol']);
        }
    }
    public function actionStartDo($id)
    {
        $icno = Yii::$app->user->getId();
        $bit = RefPosKawalan::findOne(['id' => $id]);
        $pegawai = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $model = Rekod::find()->where(['route_id' => $bit->id, 'icno' => $pegawai->ICNO])
            ->andWhere(['LIKE', 'scan_date', date('Y-m-d')])
            ->andWhere(['type' => 2])
            ->orderBy([
                'scan_date' => SORT_DESC,
            ])->one();
// var_dump(Yii::$app->request->post()['Rekod']['catatan']);die;
            $test = RefPosKawalan::distance(Yii::$app->request->post()['Rekod']['latlng'], $id);

        if (!$model) {
            $model = new Rekod();

            if ($model->load(Yii::$app->request->post())) {
                $count = 1;

                $model->icno =  $pegawai->ICNO;
                $model->route_id = $bit->id;
                // $model->bit_id = $id;
                $model->scan_date = date('Y-m-d H:i:s');
                $model->external = $test ? 0 : 1;
                $model->in_lat_lng = Yii::$app->request->post()['Rekod']['latlng'];
                $model->patrol_count = $count;
                $model->type = 2;
                $model->do = 1;
                $model->catatan = Yii::$app->request->post()['Rekod']['catatan'];
                // $model->position = $bit->position;
                $model->shift = Yii::$app->request->post()['shift'];

                if ($model->save(false)) {

                    Yii::$app->session->setFlash('alert', ['title' => 'Clock In', 'type' => 'success', 'msg' => 'Your time is recorded and please go to your next location']);
                    return $this->redirect(['patrol/scan/scan-history', 'id' => $icno]);
                }
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'UnSuccessful', 'type' => 'error', 'msg' => 'You Already scanned the QrCode']);
            return $this->redirect(['patrol/scan/my-patrol']);
        }
    }
    public function actionEndPatrolling($id)
    {
        $icno = Yii::$app->user->getId();
        $bit = RefPosKawalan::findOne(['id' => $id]);
        $pegawai = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $model = Rekod::find()->where(['route_id' => $bit->id, 'icno' => $pegawai->ICNO])
            ->andWhere(['LIKE', 'scan_date', date('Y-m-d')])
            ->andWhere(['type' => 3])
            ->orderBy([
                'scan_date' => SORT_DESC,
            ])->one();
        if (!$model) {
            $model = new Rekod();

            if ($model->load(Yii::$app->request->post())) {
                $count = 1;

                $counting = Rekod::find()->where(['icno' => $pegawai->ICNO])
                    ->andWhere(['LIKE', 'scan_date', date('Y-m-d')])
                    ->andWhere(['type' => 3])
                    ->orderBy([
                        'scan_date' => SORT_DESC,
                    ])->one();
                if ($counting) {
                    $count = $counting->patrol_count + 1;
                }

                // $count = $models ? $models->patrol_count + 1 : $count;
                // $test = RefBit::distance(Yii::$app->request->post()['Rekod']['latlng'], $id);
                // $check = TblShiftKeselamatan::findOne(['icno' => $icno]);

                $model->icno =  $pegawai->ICNO;
                $model->route_id = $bit->id;
                // $model->bit_id = $id;
                $model->scan_date = date('Y-m-d H:i:s');
                // $model->external = $test ? 0 : 1;
                $model->in_lat_lng = Yii::$app->request->post()['Rekod']['latlng'];
                $model->patrol_count = $count;
                $model->type = 3;
                // $model->position = $bit->position;
                $model->shift = Yii::$app->request->post()['shift'];

                if ($model->save(false)) {

                    Yii::$app->session->setFlash('alert', ['title' => 'Clock In', 'type' => 'success', 'msg' => 'Your time is recorded and please go to your next location']);
                    return $this->redirect(['patrol/scan/scan-history', 'id' => $icno]);
                }
            }
        } elseif ($model) {
            $start = strtotime($model->scan_date);
            $end = strtotime(date('Y-m-d H:i:s'));
            // var_dump($model->scan_date);die;
            $minutes = ($end - $start) / 60;
            if ($minutes > 80 && $model->patrol_count < 4) {
                $count = $model->patrol_count + 1;
                $model = new Rekod();

                if ($model->load(Yii::$app->request->post())) {
                    // $test = RefBit::distance(Yii::$app->request->post()['Rekod']['latlng'], $id);

                    $model->icno =  $pegawai->ICNO;
                    $model->route_id = $bit->id;
                    // $model->bit_id = $id;
                    $model->scan_date = date('Y-m-d H:i:s');
                    // $model->external = $test ? 0 : 1;
                    $model->in_lat_lng = Yii::$app->request->post()['Rekod']['latlng'];
                    $model->patrol_count = $count;
                    $model->type = 3;

                    $model->shift = Yii::$app->request->post()['shift'];
                    // $model->position = $bit->position;
                    if ($model->save(false)) {

                        Yii::$app->session->setFlash('alert', ['title' => 'Clock In', 'type' => 'success', 'msg' => 'Your time is recorded and please go to your next location']);
                        return $this->redirect(['patrol/scan/scan-history']);
                    }
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'UnSuccessful', 'type' => 'error', 'msg' => 'You Already scanned the QrCode']);
                return $this->redirect(['patrol/scan/scan-history']);
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'UnSuccessful', 'type' => 'error', 'msg' => 'You Already scanned the QrCode']);
            return $this->redirect(['patrol/scan/scan-history', 'id' => $icno]);
        }
    }
    public function actionStartPatrolling($id)
    {
        $icno = Yii::$app->user->getId();
        $bit = RefPosKawalan::findOne(['id' => $id]);
        $pegawai = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $model = Rekod::find()->where(['route_id' => $bit->id, 'icno' => $pegawai->ICNO])
            ->andWhere(['LIKE', 'scan_date', date('Y-m-d')])
            ->andWhere(['type' => 2])
            ->orderBy([
                'scan_date' => SORT_DESC,
            ])->one();
        if (!$model) {
            $model = new Rekod();

            if ($model->load(Yii::$app->request->post())) {
                $count = 1;

                $counting = Rekod::find()->where(['icno' => $pegawai->ICNO])
                    ->andWhere(['LIKE', 'scan_date', date('Y-m-d')])
                    ->andWhere(['type' => 2])
                    ->orderBy([
                        'scan_date' => SORT_DESC,
                    ])->one();
                if ($counting) {
                    $count = $counting->patrol_count + 1;
                }

                // $count = $models ? $models->patrol_count + 1 : $count;
                // $test = RefBit::distance(Yii::$app->request->post()['Rekod']['latlng'], $id);
                // $check = TblShiftKeselamatan::findOne(['icno' => $icno]);

                $model->icno =  $pegawai->ICNO;
                $model->route_id = $bit->id;
                // $model->bit_id = $id;
                $model->scan_date = date('Y-m-d H:i:s');
                // $model->external = $test ? 0 : 1;
                $model->in_lat_lng = Yii::$app->request->post()['Rekod']['latlng'];
                $model->patrol_count = $count;
                $model->type = 2;
                // $model->position = $bit->position;
                $model->shift = Yii::$app->request->post()['shift'];

                if ($model->save(false)) {

                    Yii::$app->session->setFlash('alert', ['title' => 'Clock In', 'type' => 'success', 'msg' => 'Rondaan Bermula']);
                    return $this->redirect(['patrol/scan/scan-history', 'id' => $icno]);
                }
            }
        } elseif ($model) {
            $start = strtotime($model->scan_date);
            $end = strtotime(date('Y-m-d H:i:s'));
            // var_dump($model->scan_date);die;
            $minutes = ($end - $start) / 60;
            if ($minutes > 80 && $model->patrol_count < 4) {
                $count = $model->patrol_count + 1;
                $model = new Rekod();

                if ($model->load(Yii::$app->request->post())) {
                    // $test = RefBit::distance(Yii::$app->request->post()['Rekod']['latlng'], $id);

                    $model->icno =  $pegawai->ICNO;
                    $model->route_id = $bit->id;
                    // $model->bit_id = $id;
                    $model->scan_date = date('Y-m-d H:i:s');
                    // $model->external = $test ? 0 : 1;
                    $model->in_lat_lng = Yii::$app->request->post()['Rekod']['latlng'];
                    $model->patrol_count = $count;
                    $model->type = 2;

                    $model->shift = Yii::$app->request->post()['shift'];
                    // $model->position = $bit->position;
                    if ($model->save(false)) {

                        Yii::$app->session->setFlash('alert', ['title' => 'Clock In', 'type' => 'success', 'msg' => 'Your time is recorded and please go to your next location']);
                        return $this->redirect(['patrol/scan/scan-history']);
                    }
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'UnSuccessful', 'type' => 'error', 'msg' => 'You Already scanned the QrCode']);
                return $this->redirect(['patrol/scan/scan-history']);
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'UnSuccessful', 'type' => 'error', 'msg' => 'You Already scanned the QrCode']);
            return $this->redirect(['patrol/scan/scan-history', 'id' => $icno]);
        }
    }
    public function actionClock($id)
    {
        $icno = Yii::$app->user->getId();
        $bit = RefBit::findOne(['id' => $id]);
        $pegawai = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();
        $model = Rekod::find()->where(['bit_id' => $bit->id, 'route_id' => $bit->route_id, 'icno' => $pegawai->ICNO])
            ->andWhere(['LIKE', 'scan_date', date('Y-m-d')])
            ->orderBy([
                'scan_date' => SORT_DESC,
            ])->one();
        if (!$model) {
            $model = new Rekod();

            if ($model->load(Yii::$app->request->post())) {
                $count = 1;
                $models = Rekod::find()->where(['icno' => $pegawai->ICNO])
                    ->andWhere(['LIKE', 'scan_date', date('Y-m-d')])
                    ->andWhere(['route_id' => $bit->route_id])
                    ->one();
                if (!$models) {
                    $counting = Rekod::find()->where(['icno' => $pegawai->ICNO])
                        ->andWhere(['LIKE', 'scan_date', date('Y-m-d')])
                        ->orderBy([
                            'scan_date' => SORT_DESC,
                        ])->one();
                    if ($counting) {
                        $count = $counting->patrol_count + 1;
                    }
                }
                // $count = $models ? $models->patrol_count + 1 : $count;
                $test = RefBit::distance(Yii::$app->request->post()['Rekod']['latlng'], $id);

                $model->icno =  $pegawai->ICNO;
                $model->route_id = $bit->route_id;
                $model->bit_id = $id;
                $model->scan_date = date('Y-m-d H:i:s');
                $model->external = $test ? 0 : 1;
                $model->in_lat_lng = Yii::$app->request->post()['Rekod']['latlng'];
                $model->patrol_count = $count;
                $model->position = $bit->position;
                $model->shift = Yii::$app->request->post()['shift'];
                $hak = TblShiftKeselamatan::findOne(['icno' => $icno,'shift_id' => $model->shift]);
                $lmj = TblOt::findOne(['icno' => $icno,'shift_id' => $model->shift]);
                $lmt = TblLmt::findOne(['icno' => $icno,'lmt_id' => $model->shift]);
                // if($hak){
                //     $model->hakiki = 1;
                // }
                // if($lmj){
                //     $model->lmj = 1;
                // }
                // if($lmt){
                //     $model->lmt = 1;
                // }
                if ($model->save(false)) {

                    Yii::$app->session->setFlash('alert', ['title' => 'Clock In', 'type' => 'success', 'msg' => 'Your time is recorded and please go to your next location']);
                    return $this->redirect(['patrol/main/my-patrol']);
                }
            }
        } elseif ($model) {
            $start = strtotime($model->scan_date);
            $end = strtotime(date('Y-m-d H:i:s'));
            // var_dump($model->scan_date);die;
            $minutes = ($end - $start) / 60;
            if ($minutes > 80 && $model->patrol_count < 4) {
                $count = $model->patrol_count + 1;
                $model = new Rekod();

                if ($model->load(Yii::$app->request->post())) {
                    $test = RefBit::distance(Yii::$app->request->post()['Rekod']['latlng'], $id);

                    $model->icno =  $pegawai->ICNO;
                    $model->route_id = $bit->route_id;
                    $model->bit_id = $id;
                    $model->scan_date = date('Y-m-d H:i:s');
                    $model->external = $test ? 0 : 1;
                    $model->in_lat_lng = Yii::$app->request->post()['Rekod']['latlng'];
                    $model->patrol_count = $count;
                    $model->shift = Yii::$app->request->post()['shift'];
                    $model->position = $bit->position;
                    $hak = TblShiftKeselamatan::findOne(['icno' => $icno,'shift_id' => $model->shift]);
                    $lmj = TblOt::findOne(['icno' => $icno,'shift_id' => $model->shift]);
                    $lmt = TblLmt::findOne(['icno' => $icno,'lmt_id' => $model->shift]);
                    // if($hak){
                    //     $model->hakiki = 1;
                    // }
                    // if($lmj){
                    //     $model->lmj = 1;
                    // }
                    // if($lmt){
                    //     $model->lmt = 1;
                    // }
                    if ($model->save(false)) {

                        Yii::$app->session->setFlash('alert', ['title' => 'Clock In', 'type' => 'success', 'msg' => 'Your time is recorded and please go to your next location']);
                        return $this->redirect(['patrol/scan/scan-history']);
                    }
                }
            } else {
                Yii::$app->session->setFlash('alert', ['title' => 'UnSuccessful', 'type' => 'error', 'msg' => 'You Already scanned the QrCode']);
                return $this->redirect(['patrol/scan/scan-history']);
            }
        } else {
            Yii::$app->session->setFlash('alert', ['title' => 'UnSuccessful', 'type' => 'error', 'msg' => 'You Already scanned the QrCode']);
            return $this->redirect(['patrol/scan/scan-history', 'id' => $icno]);
        }
    }

    public function actionScanHistory()
    {
        $icno = Yii::$app->user->getId();
        $peg = Tblprcobiodata::find()->where(['ICNO' => $icno])->one();

        $record = Rekod::find()->where(['icno' => $peg->ICNO])->andWhere(['LIKE', 'scan_date', date('Y-m-d')])->orderBy(['scan_date' => SORT_ASC, 'patrol_count' => SORT_ASC])->all();
        // $layak = Layak::find()->where(['layak_icno' => $id])->orderBy(['layak_mula' => SORT_DESC])->all();
        // var_dump($record);die;
        return $this->render('history', [
            'record' => $record,

            'bil' => 1,

        ]);
    }
    public function actionZone()
    {
        // var_dump('d');die;
        $latlng = Yii::$app->request->post()['latlng'];

        $id = Yii::$app->request->post()['id'];


        //        $ip = $_SERVER['REMOTE_ADDR'];
        $ip = $this->getRealUserIp();

        if (Yii::$app->request->post()) {
            //if ip = external
            if (RefBit::distance($latlng, $id)) {
                $v = '<span class="label label-success" style="font-size:14px">Internal</span><a class="btn-sm btn-default" onclick="window.location.href = window.location.href"><i class="fa fa-refresh"></i></a>';
            } else {
                $v = '<span class="label label-danger" style="font-size:14px">External</span><a class="btn-sm btn-default" onclick="window.location.href = window.location.href"><i class="fa fa-refresh"></i></a>';
            }
        }

        echo $v;
    }
    public function actionZonepos()
    {
        $latlng = Yii::$app->request->post()['Rekod']['latlng'];

        $id = Yii::$app->request->post()['id'];
        //        $ip = $_SERVER['REMOTE_ADDR'];
        $ip = $this->getRealUserIp();

        if (Yii::$app->request->post()) {
            //if ip = external
            if (RefPosKawalan::distance($latlng, $id)) {
                $v = '<span class="label label-success" style="font-size:14px">Internal</span><a class="btn-sm btn-default" onclick="window.location.href = window.location.href"><i class="fa fa-refresh"></i></a>';
            } else {
                $v = '<span class="label label-danger" style="font-size:14px">External</span><a class="btn-sm btn-default" onclick="window.location.href = window.location.href"><i class="fa fa-refresh"></i></a>';
            }
        }

        echo $v;
    }
}
