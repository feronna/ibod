<?php

namespace app\controllers;

use app\models\system_core\AccessToken;
use app\models\hronline\Tblprcobiodata;
use app\models\User;
use app\models\LoginForm;
use yii\web\Response;
use app\models\system_core\logs;
use Yii;
use DateTime;
use DateInterval;

use yii\helpers\VarDumper;

class ExternalAuthController extends \yii\web\Controller
{

    // public $layout = 'plain';

    public $enableCsrfValidation = false;


    private function setHeader($status)
    {

        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        $content_type = "application/json; charset=utf-8";

        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "ums.edu.my");
    }
    private function _getStatusCodeMessage($status)
    {
        $codes = array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    private function checkToken($icno)
    {
        $now = date("Y-m-d H:i:s", strtotime("now"));

        $model = AccessToken::findOne(['icno' => $icno]);

        if ($model) {
            if ($model->end_dt > $now) {
                return false;
            } else {
                return $model->token;
            }
        }
    }

    private function getRealUserIp()
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


    public function actionInit()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($params = $_REQUEST) {

            $icno = $params['icno'];
            $now = date("Y-m-d H:i:s", strtotime("now"));
            $after_30 = date("Y-m-d H:i:s", strtotime("+30 minutes"));

            $date = new DateTime('1989-04-26');
            $date->add(new DateInterval('P60Y'));
            // $date->format('Y-m-d');

            $biodata = Tblprcobiodata::findOne(['ICNO' => $icno]);

            // check icno dlu samaada dlm table biodata 
            if ($biodata) {

                $model = AccessToken::findOne(['icno' => $icno]);
                $token = sha1($icno . $now);

                // check icno dlu samaada dlm table access_token 
                if ($model) {
                    $this->setHeader(200);

                    //klu ada check expired klu x update token, start_dt dan end_dt
                    if (strtotime($model->end_dt) > strtotime($now)) {

                        return ['token' => $model->token, 'start' => $model->start_dt, 'end' => $model->end_dt, 'test' => $date->format('Y-m-d')];

                        //update token, start_dt dan end_dt    
                    } else {

                        $model->token = $token;
                        $model->start_dt = $now;
                        $model->end_dt = $after_30;

                        if ($model->save()) {
                            return ['token' => $token, 'start' => $now, 'end' => $after_30];
                        }
                    }

                    // klu tiada create baru icno dlm table access_token
                } else {

                    $model = new AccessToken();
                    $model->icno = $icno;
                    $model->token = $token;
                    $model->start_dt = $now;
                    $model->end_dt = $after_30;
                    if ($model->save()) {
                        return ['token' => $token, 'start' => $now, 'end' => $after_30];
                    }
                }

                // klu tiada icno dlm biodata.. trus kasi not exist
            } else {
                $this->setHeader(401);
                return ['message' => 'User does not exist in HR.Please contact admin'];
            }
        }
    }

    public function actionRedirect($token)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $now = date("Y-m-d H:i:s", strtotime("now"));

        if ($token) {
            $model = AccessToken::find()->where(['token' => $token])->one();

            if ($model) {


                if (strtotime($now) < strtotime($model->end_dt)) {
                    // $this->setHeader(200);
                    // return ['message' => 'ngam!.. atur dia'];

                    $login = new LoginForm();
                    $login->username = $model->icno;
                    $login->activeDirectory = true; 

                    if ($login->login()) {

                        $log = new logs();
                        $log->icno = $model->icno;
                        $log->log_time = date('Y-m-d H:i:s');
                        $log->ip_address = $this->getRealUserIp();
                        $log->action = "LOGIN";
                        $log->detail = "Login from IICS";
                        $log->save();

                        return $this->redirect(['kehadiran/index']);
                    }
                } else {
                    $this->setHeader(401);
                    return ['message' => 'expired'];
                }
            } else {
                $this->setHeader(401);
                return ['message' => 'Token invalid/expired'];
            }
        } else {
            $this->setHeader(400);
            return ['message' => 'Required Token!'];
        }
    }

    public function actionClearSession(){
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($params = $_REQUEST) {

            $icno = $params['icno'];

            $model = AccessToken::findOne(['icno'=>$icno]);

            if($model){

                $model->delete();

                $this->setHeader(200);
                return ['message' => 'Session clear'];

            } else {

                $this->setHeader(401);
                return ['message' => 'UserID not defined'];
            
            }
        }
    }
}
