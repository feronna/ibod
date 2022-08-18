<?php

namespace app\controllers\api;

use app\models\hronline\Country;
use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;
use yii\web\Response;
use Yii;


class StaffController extends \yii\base\Controller
{

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
     * untuk paparan info di hadapan;
     */
    public function actionGetInfo()
    {

        if ($params = $_REQUEST) {

            if (isset($params['public_key']) && isset($params['secret_key'])) {

                $public_key = $params['public_key'];
                $secret_key = $params['secret_key'];

                if ($public_key == 'WwQUWooGPXL19OormLRcDXRR8lOjvN' &&  $secret_key == 'yKrEdoUEMme6LuOOcfTp8sVl1gMwpe') {

                    $data = [];
                    $staff = [];

                    if (isset($params['nama']) || isset($params['icno'])) {

                        $nama = isset($params['nama']) ? $params['nama'] : null;
                        $icno = isset($params['icno']) ? $params['icno'] : null;

                        // $model = Tblprcobiodata::find()->where(['LIKE', 'CONm', $nama])->andWhere(['<>', 'status', 6])->all();
                        $model = Tblprcobiodata::find()->Where(['<>', 'status', 6])->andFilterWhere(['LIKE','ICNO',$icno])->andFilterWhere(['LIKE','CONm',$nama])->all();

                        if ($model) {


                            foreach ($model as $m) {

                                $staff[] = [
                                    'gelaran' => $m->gelaran->Title,
                                    'nama' => $m->CONm,
                                    'no_kp' => $m->ICNO,
                                    'jawatan' => $m->jawatan->fname,
                                    'umsper' => $m->COOldID,
                                    'jfpib' => $m->department->fullname,
                                    'jfpib_shortname' => $m->department->shortname,
                                    'jfpib_hakiki' => $m->departmentHakiki->fullname,
                                    'jfpib_hakiki_shortname' => $m->departmentHakiki->shortname,
                                    'email' => $m->COEmail,
                                    'no_hp' => $m->COHPhoneNo,
                                ];
                            }


                            $this->setHeader(200);

                            $data = [
                                'totalRecord' => count($model),
                                'status' => 'Ok!',
                                'data' => $staff,
                            ];

                            return $data;
                        } else {


                            $data = [
                                'totalRecord' => 0,
                                'status' => 'No Record found!',
                                'data' => null,
                            ];

                            return $data;
                        }
                    }
                }
            }
        }

        $this->setHeader(400);
        return $this->_getStatusCodeMessage(400);
    }

    public function actionDeptList()
    {
        $model = Department::find()->where(['isActive' => 1])->all();

        if ($model) {
            foreach ($model as $m) {

                $dept[] = [
                    'id' => $m->id,
                    'fullname' => $m->fullname,
                    'shortname' => $m->shortname,
                ];
            }

            return $dept;
        }

        $this->setHeader(400);
        return $this->_getStatusCodeMessage(400);
    }

    public function actionCountryList()
    {
        $model = Country::find()->where(['isActive' => 1])->andWhere(['<>', 'CountryCd', 'MYS'])->all();

        if ($model) {
            foreach ($model as $m) {

                $arr[] = [
                    'CountryCd' => $m->CountryCd,
                    'Country' => $m->Country,
                ];
            }

            array_unshift($arr, [
                'CountryCd' => 'MYS',
                'Country' => 'Malaysia'
            ]);

            return $arr;
        }

        $this->setHeader(400);
        return $this->_getStatusCodeMessage(400);
    }

    /**
     * paparan Info staf aktif
     * 
     * parameter 
     * id : icno/no passport staff;
     */
    public function actionGetProfile()
    {
        if ($params = $_REQUEST) {

            if (isset($params['public_key']) && isset($params['secret_key'])) {

                $public_key = $params['public_key'];
                $secret_key = $params['secret_key'];

                if ($public_key == 'WwQUWooGPXL19OormLRcDXRR8lOjvN' &&  $secret_key == 'yKrEdoUEMme6LuOOcfTp8sVl1gMwpe') {

                    $data = [];

                    if (isset($params['id'])) {

                        $icno = $params['id'];
                        $model = Tblprcobiodata::find()->where(['ICNO' => $icno])->andWhere(['<>', 'status', 6])->one();

                        if ($model) {
                            $data = [
                                'status' => 1,
                                'icno' => $model->ICNO,
                                'staff_name' => $model->CONm,
                                'staff_id' => $model->COOldID,
                                'title' => $model->gelaran->Title,
                                'department' => $model->department->fullname,
                                'designation' => $model->jawatan->fname,
                            ];
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


    /**
     * paparan info untuk team SMPB
     * 
     * parameter
     * 
     */

     public function actionGetRecord()
     {
        if ($params = $_REQUEST) {

            if (isset($params['public_key']) && isset($params['secret_key'])) {

                $public_key = $params['public_key'];
                $secret_key = $params['secret_key'];

                if ($public_key == 'WwQUWooGPXL19OormLRcDXRR8lOjvN' &&  $secret_key == 'yKrEdoUEMme6LuOOcfTp8sVl1gMwpe') {

                    $data = [];
                    $staff = [];

                    if (isset($params['nama']) || isset($params['icno'])) {

                        $nama = isset($params['nama']) ? $params['nama'] : null;
                        $icno = isset($params['icno']) ? $params['icno'] : null;

                        $model = Tblprcobiodata::find()->Where([])->andFilterWhere(['LIKE','tblprcobiodata.ICNO',$icno])->andFilterWhere(['LIKE','CONm',$nama])->all();

                        if ($model) {

                            foreach ($model as $m) {

                                $staff[] = [
                                    'umsper' => $m->COOldID,
                                    'nama_staf' => $m->CONm,
                                    'kod_jabatan' => $m->department->shortname,
                                    'kod_jabatan_hakiki' => $m->departmentHakiki->shortname,
                                    'lantikan' => $m->ap,
                                    'lantikan_tarikh_mula' => $m->apStartDate,
                                    'lantikan_tarikh_tamat' => $m->apEndDate,
                                    'is_aktif' => $m->serviceStatus->ServStatusNm,
                                    'emel' => $m->COEmail,
                                ];
                            }


                            $this->setHeader(200);

                            $data = [
                                'totalRecord' => count($model),
                                'status' => 'Ok!',
                                'data' => $staff,
                            ];

                            return $data;
                        } else {


                            $data = [
                                'totalRecord' => 0,
                                'status' => 'No Record found!',
                                'data' => null,
                            ];

                            return $data;
                        }
                    }
                }
            }
        }

        $this->setHeader(400);
        return $this->_getStatusCodeMessage(400);
     }
}
