<?php

namespace app\controllers\api;

use app\models\hronline\Tblprcobiodata;
use app\models\kehadiran\TblRekod;
use yii\web\Response;


class PbxController extends \yii\base\Controller
{

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    // restrict access to
                    'Origin' => ['*.ums.edu.my'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Method' => ['POST', 'PUT', 'GET'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Request-Headers' => ['X-Wsse'],
                    // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ],

            ],
        ];
    }

    public $enableCsrfValidation = false;

    public function beforeAction($action)
    {

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

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

    /**
     * paparan kehadiran staff
     * 
     * parameter 
     * id : icno/no passport staff;
     */
    public function actionAttendanceInfo()
    {
        if ($params = $_REQUEST) {

            if (isset($params['public_key']) && isset($params['secret_key'])) {

                $public_key = $params['public_key'];
                $secret_key = $params['secret_key'];

                if ($public_key == 'WwQUWooGPXL19OormLRcDXRR8lOjvN' &&  $secret_key == 'yKrEdoUEMme6LuOOcfTp8sVl1gMwpe') {

                    $data = [];
                    $today = date('Y-m-d');

                    if (isset($params['id'])) {

                        $icno = $params['id'];

                        $model = Tblprcobiodata::find()->where(['ICNO' => $icno])->andWhere(['<>', 'status', 6])->one();

                        if ($model) {
                            $att = TblRekod::find()->where(['icno' => $model->ICNO, 'tarikh' => $today])->one();

                            if ($att) {
                                $data = [
                                    'id' => $model->ICNO,
                                    'staff_name' => $model->CONm,
                                    'staff_id' => $model->COOldID,
                                    'day' => $att->day,
                                    'date' => $att->tarikh,
                                    'time_in' => $att->formatTimeIn,
                                    'time_out' => $att->formatTimeOut,
                                    'status' => (!$att->time_out) ? 1 : 0, // klu suda clock out tukar balik status ke 0
                                ];
                            } else {
                                $data = [
                                    'id' => $model->ICNO,
                                    'staff_name' => $model->CONm,
                                    'staff_id' => $model->COOldID,
                                    'status' => 0,
                                    'message' => 'No attendance record found!',
                                ];
                            }
                        } else {
                            $data = [
                                'status' => 0,
                                'message' => 'No record found!'
                            ];
                        }

                        return $data;
                    }
                }
            } else {
                $this->setHeader(401);
                return ['status' => 0, 'message' => 'Authentication Failed!'];
            }
        }

        $this->setHeader(400);
        return $this->_getStatusCodeMessage(400);
    }
}
