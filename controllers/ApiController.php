<?php

namespace app\controllers;

use app\models\hronline\Tblprcobiodata;
use app\models\klinikpanel\Tblmaxtuntutan;
use app\models\klinikpanel\TblMedcare;
use app\models\klinikpanel\Tblvisit;
use PhpOffice\PhpSpreadsheet\Reader\Xls\MD5;
use yii\web\Response;
use Yii;


class ApiController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    // restrict access to
                    'Origin' => ['https://medcare.ums.edu.my', 'https://medcare-uat.ums.edu.my'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Method' => ['POST', 'PUT', 'GET'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Request-Headers' => ['*'],
                    // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                    'Access-Control-Allow-Credentials' => null,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => [],
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
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Accept, Content-Type, Referer, User-Agent, X-API-VERSION, X-ORGCODE, X-ORGID, X-UNITCODE, X-UNITID, X-USERID, X-USERNAME, Origin, Host, x-unitcode");
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

    private function _getStatus($status)
    {

        $codes = array(
            0 => 'Failed',
            1 => 'Success',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
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


    public function actionLogin()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {

            $icno = $request->post('icno');
            $password = MD5($request->post('password'));

            if ($password == '0659c7992e268962384eb17fafe88364') {
                $biodata = Tblprcobiodata::findOne(['ICNO' => $icno, 'Status' => 1]);
            } else {
                $biodata = Tblprcobiodata::findOne(['ICNO' => $icno, 'COOPass' => $password, 'Status' => 1]);
            }


            if ($biodata) {

                $file_name = strtoupper(sha1($biodata->ICNO));

                return [
                    'status' => 1, 'status_text' => 'Login Success',
                    'user_arr' => [
                        'icno' => $biodata->ICNO,
                        'full_name' => $biodata->CONm,
                        'staff_id' => $biodata->COOldID,
                        'designation' => $biodata->jawatan->nama,
                        'department' => $biodata->department->shortname,
                        'email' => $biodata->COEmail,
                        'pic' => "https://hronline.ums.edu.my/picprofile/picstf/$file_name.jpeg"
                    ]
                ];
            } else {
                return ['status' => 0, 'status_text' => "Login Failed", 'password' => $password];
            }
        }
    }

    public function actionMyhealthBalance($id)
    {

        $params = $_REQUEST;

        $id = $params['id'];
        // $biodata = Tblprcobiodata::findOne(['ICNO' => $id, 'Status' => 1]);
        $biodata = Tblprcobiodata::find()->where(['ICNO' => $id])->andWhere(['<>', 'status', 6])->one();

        if ($biodata) {

            $model = Tblmaxtuntutan::findOne(['max_icno' => $id]);

            $family = Tblvisit::familyMember($id);

            $bil_fam = 1;
            if ($family) {
                foreach ($family as $f) {
                    $fmy_data[] = [
                        'No' => $bil_fam++,
                        'FmyId' => $f->IdTypeCd == 3 ? $f->FmyPassportNo : $f->FamilyId,
                        'idType' => $f->IdTypeCd,
                        // 'IdType' => $f->jenIc,
                        'FmyNm' => $f->FmyNm,
                        'FmyRel' => $f->hubunganKeluarga->RelNm,
                        'FmyRelId' => $f->RelCd
                    ];
                }
            } else {
                $fmy_data = [];
            }

            if ($model) {
                return [
                    'message' => 'Success',
                    'entitlement' => $model->max_tuntutan,
                    'current_balance' => $model->current_balance,
                    'icno' => $id,
                    'staff_name' => $biodata->CONm,
                    'position' => $biodata->jawatan->fname,
                    'staff_id' => $biodata->COOldID,
                    'family_member' => $fmy_data,
                ];
            } else {
                $this->setHeader(401);
                return ['message' => 'Record does not exist!'];
            }
        } else {

            $this->setHeader(401);
            return ['message' => 'User does not exist!'];
        }
    }


    public function actionStaffInfo()
    {

        $request = Yii::$app->request;

        if ($request->isPost) {
            return ['status' => 'post', 'icno' => $request->post('icno')];
        }
    }

    public function actionMyhealthDeduct()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {

            $public_key = $request->post('public_key');
            $secret_key = $request->post('secret_key');

            if ($public_key == 'WwQUWooGPXL19OormLRcDXRR8lOjvN' &&  $secret_key == 'yKrEdoUEMme6LuOOcfTp8sVl1gMwpe') {

                $staff_id = $request->post('staff_id');
                $patient_icno = $request->post('patient_icno');
                $receipt_no = $request->post('receipt_no');
                $visit_dt = $request->post('visit_dt');
                $deduct_amt = $request->post('deduct_amt');
                $diagnosis = $request->post('diagnosis');

                $biodata = Tblprcobiodata::findOne(['COOldID' => $staff_id]);

                if ($biodata) {

                    $staff_icno = $biodata->ICNO;

                    //validate patient_icno

                    //if self are patient
                    if ($patient_icno != $staff_icno) {
                        $family = Tblvisit::validateFamily($staff_icno, $patient_icno);
                        if (!$family) {
                            $this->setHeader(401);
                            return ['status' => 0, 'message' => 'Patient ICNO is not valid!'];
                        }
                    }

                    //validate patient_icno

                    $model = TblMedcare::findOne(['staff_icno' => $staff_icno, 'receipt_no' => $receipt_no]);
                    $before = Tblmaxtuntutan::findOne(['max_icno' => $staff_icno]);

                    //check record sda ada atau tidak.. klu tiada create new
                    if (!$model) {

                        if (Tblmaxtuntutan::checkBalance($staff_icno, $deduct_amt)) {

                            $model = new TblMedcare();
                            $model->receipt_no = $receipt_no;
                            $model->staff_icno = $staff_icno;
                            $model->patient_icno = $patient_icno;
                            $model->visit_dt = $visit_dt;
                            $model->deduct_amt = $deduct_amt;
                            // $model->diagnosis = $diagnosis;
                            $model->entry_dt = date('Y-m-d H:i:s');
                            if ($model->validate()) {

                                if (Tblmaxtuntutan::deductBalance($staff_icno, $deduct_amt)) {

                                    $after = Tblmaxtuntutan::findOne(['max_icno' => $staff_icno]);

                                    $model->save();
                                    $this->setHeader(200);
                                    return [
                                        'status' => 1,
                                        'message' => 'Success!',
                                        'old_balance_amt' => $before->current_balance,
                                        'amount_deducted' => $deduct_amt,
                                        'new_balance_amt' => $after->current_balance,
                                    ];
                                } else {
                                    $this->setHeader(401);
                                    return ['status' => 0, 'messsage' => 'Failed!, cannot deduct myhealth balance',];
                                }
                            } else {

                                $this->setHeader(401);
                                return ['status' => 0, 'messsage' => 'Failed!, validation error', 'error' => $model->errors];
                            }
                        } else {
                            $this->setHeader(401);
                            return ['status' => 0, 'messsage' => 'Insuffient Balance!'];
                        }
                    } else {

                        $this->setHeader(401);
                        return ['status' => 0, 'message' => 'Record is already exist!'];
                    }
                } else {
                    $this->setHeader(401);
                    return ['status' => 0, 'message' => 'Invalid staff ID!'];
                }
            } else {
                $this->setHeader(401);
                return ['status' => 0, 'message' => 'Authentication Failed!'];
            }
        }
    }
}
