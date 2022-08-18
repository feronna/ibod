<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Notification;
use app\models\system_core\logs;
use yii\helpers\VarDumper;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'index', 'notifikasi', 'archive', 'read_noti', 'send_arc'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index', 'notifikasi', 'archive', 'read_noti', 'send_arc'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    //                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            // 'error' => [
            //     'class' => 'yii\web\ErrorAction',
            // ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->goback();
    }

    public function actionLogin()
    {
        $this->layout = 'login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->login() && $model->validate()) {

                $log = new logs();
                $log->icno = $model->username;
                $log->log_time = date('Y-m-d H:i:s');
                $log->ip_address = $this->getRealUserIp();
                $log->action = "LOGIN";
                $log->detail = "Login using HR Account";
                $log->save();

                return $this->goBack(Yii::$app->user->getReturnUrl());

                //Pakai Ad
            } else {

                $datas = Yii::$app->ActiveDirectory->Login($model->username, $model->password);
                // $s = serialize($datas);
                // VarDumper::dump( $s, $depth = 10, $highlight = true);
                // $w = unserialize($s);
                // VarDumper::dump( $w, $depth = 10, $highlight = true);

                // exit();

                if ($datas->status == "Successful login") {

                    $icno = $datas->login->userid;

                    //ini function utk update directory
                    Yii::$app->ActiveDirectory->Update($model->username, $icno);

                    $model->username = $icno;
                    $model->activeDirectory = true;

                    // validate user input and redirect to the previous page if valid
                    if ($model->login()) {

                        $log = new logs();
                        $log->icno = $icno;
                        $log->log_time = date('Y-m-d H:i:s');
                        $log->ip_address = $this->getRealUserIp();
                        $log->action = "LOGIN";
                        $log->detail = "Login using AD Account";
                        $log->data = serialize($datas);
                        $log->save();

                        return $this->goBack(Yii::$app->user->getReturnUrl());
                    }
                } else {
                    $model->validate();
                }
            }
        }


        return $this->render('login2', [
            'model' => $model,
        ]);
    }


    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->cache->flush();

        return $this->goHome();
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



    public function actionMaintenance()
    {
        return $this->render('maintain');
    }



    public function actionNotifikasi()
    {


        $icno = Yii::$app->user->getId();

        $sql = 'SELECT * FROM system_core.tbl_notifications WHERE icno=:icno AND (status=0 OR status=1)';
        $model = Notification::findBySql($sql, [':icno' => $icno])->all();

        return $this->render('notifikasi', ['model' => $model, 'bil' => 1]);
    }

    public function actionArchive()
    {


        $icno = Yii::$app->user->getId();

        $model = Notification::findAll(['icno' => $icno, 'status' => 2]);

        return $this->render('archive', ['model' => $model, 'bil' => 1]);
    }

    public function actionRead_noti($id)
    {

        $icno = Yii::$app->user->getId();

        $model = Notification::findOne(['id' => $id, 'icno' => $icno]);

        if ($model->status == 0) {
            $model->status = 1;
            $model->update();
        }

        return $this->render('read_noti', ['ntf' => $model]);
    }

    public function actionReadArc($id)
    {

        $icno = Yii::$app->user->getId();

        $model = Notification::findOne(['id' => $id, 'icno' => $icno]);

        if ($model->status == 0) {
            $model->status = 1;
            $model->update();
        }

        return $this->render('read-arc', ['ntf' => $model]);
    }

    public function actionSend_arch($id)
    {

        $icno = Yii::$app->user->getId();

        //        $model = Notification::find(['id' => $id, 'icno' => $icno])->one();
        $model = Notification::findOne($id);

        //update as archived
        $model->status = 2;
        if ($model->update()) {
            Yii::$app->session->setFlash('alert', ['title' => 'Berjaya', 'type' => 'success', 'msg' => 'Notifikasi telah dihantar ke arkib.']);

            return $this->redirect(['site/notifikasi']);
        }
    }

    public function actionSend_archive($id)
    {
        $model = Notification::findOne($id);
        $model->status = 2;
        $model->update();
    }

    public function actionMark_read($id)
    {
        $model = Notification::findOne($id);
        $model->status = 1;
        $model->update();
    }

    public function actionTestUpdateAd($icno)
    {

        $datas = Yii::$app->ActiveDirectory->add($icno);

        VarDumper::dump($datas, $depth = 10, $highlight = true);
    }

    public function actionError()
    {
        if (
            Yii::$app->user->isGuest  &&
            Yii::$app->request->url !== \yii\helpers\Url::to(Yii::$app->user->loginUrl)
        ) {
            return Yii::$app->response->redirect(\yii\helpers\Url::to(Yii::$app->user->loginUrl))->send();
        }

        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }
}
