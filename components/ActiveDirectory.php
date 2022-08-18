<?php

namespace app\components;

use app\models\hronline\Tblprcobiodata;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use yii\helpers\VarDumper;

class ActiveDirectory extends Component
{
    private $secret_key = 'yKrEdoUEMme6LuOOcfTp8sVl1gMwpe';
    private $public_key = 'WwQUWooGPXL19OormLRcDXRR8lOjvN';

    public function Login($username, $password)
    {
        $url = "https://api.ums.edu.my/api/v2/basic/ad/login";
        $client = new Client();

        try {

            $response = $client->request('POST', $url, [
                'timeout' => 60.00,
                'header' => [
                    'Content-Type' => 'application/json',
                ],
                'multipart' => [
                    [
                        'name'     => 'secret_key',
                        'contents' => $this->secret_key,
                    ],
                    [
                        'name'     => 'public_key',
                        'contents' => $this->public_key,
                    ],
                    [
                        'name'     => 'txtUserId',
                        'contents' => $username,
                    ],
                    [
                        'name'     => 'txtUserPassword',
                        'contents' => $password,
                    ],
                ]

            ]);

            $datas = json_decode($response->getBody());

            return $datas;
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                if ($e->getResponse()->getstatusCode() == '404') {
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }
            }
        }
    }

    public function Update($userId, $icno)
    {

        $url = "https://api.ums.edu.my/api/v1/ad/updateUser/$userId";
        $client = new Client();

        $biodata = Tblprcobiodata::findOne(['ICNO'=>$icno]);
        $data = [
            'ic_no' => $biodata->ICNO,
            'email' => $biodata->COEmail,
            'name' => $biodata->CONm,
            'dept_code' => $biodata->department->shortname,
            'department' => $biodata->department->fullname,
            'staff_no' => $biodata->COOldID,
            'office_phone_no' => $biodata->COOffTelNo,
            'handphone_no' => $biodata->COHPhoneNo,
            'title' => $biodata->gelaran->Title,
            'city' => $biodata->kampus->campus_name,
        ];

        try {

            $response = $client->request('POST', $url, [
                'timeout' => 60.00,
                'header' => [
                    'Content-Type' => 'application/json',
                ],
                'multipart' => [

                    [
                        'name'     => 'secret_key',
                        'contents' => $this->secret_key,
                    ],
                    [
                        'name'     => 'public_key',
                        'contents' => $this->public_key,
                    ],
                    [
                        'name'     => 'ic_no',
                        'contents' => $data['ic_no'],
                    ],
                    [
                        'name'     => 'email',
                        'contents' => $data['email'],
                    ],
                    [
                        'name'     => 'name',
                        'contents' => $data['name'],
                    ],
                    [
                        'name'     => 'dept_code',
                        'contents' => $data['dept_code'],
                    ],
                    [
                        'name'     => 'department',
                        'contents' => $data['department'],
                    ],
                    [
                        'name'     => 'staff_no',
                        'contents' => $data['staff_no'],
                    ],
                    [
                        'name'     => 'office_phone_no',
                        'contents' => $data['office_phone_no'],
                    ],
                    [
                        'name'     => 'handphone_no',
                        'contents' => $data['handphone_no'],
                    ],
                    [
                        'name'     => 'title',
                        'contents' => $data['title'],
                    ],
                    [
                        'name'     => 'city',
                        'contents' => $data['city'],
                    ],
                ]

            ]);
           
            $datas = json_decode($response->getBody());
            return $datas;
        } catch (RequestException $e) {
            
            if ($e->hasResponse()) {
                if ($e->getResponse()->getstatusCode() == '404') {
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }elseif($e->getResponse()->getstatusCode() == '401'){
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }else{
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }
            }
        }
    }

    public function Add($icno)
    {

        $url = "https://api.ums.edu.my/api/v1/ad/createUser";
        $client = new Client();

        $biodata = Tblprcobiodata::findOne(['ICNO'=>$icno]);

        $data = [
            'ic_no' => $biodata->ICNO,
            'email' => $biodata->COEmail,
            'name' => $biodata->CONm,
            'dept_code' => $biodata->department->shortname,
            'department' => $biodata->department->fullname,
            'staff_no' => $biodata->COOldID,
            'office_phone_no' => $biodata->COOffTelNo,
            'handphone_no' => $biodata->COHPhoneNo,
            'title' => $biodata->gelaran->Title,
            // 'ad_userid' => rtrim($biodata->COEmail,"@ums.edu.my"), //tidak bulih pakai ni saitan
            'ad_userid' => substr($biodata->COEmail, 0, strpos($biodata->COEmail, '@')), 
            'city' => $biodata->kampus->campus_name,
        ];

        try {

            $response = $client->request('POST', $url, [
                'timeout' => 60.00,
                'header' => [
                    'Content-Type' => 'application/json',
                ],
                'multipart' => [

                    [
                        'name'     => 'secret_key',
                        'contents' => $this->secret_key,
                    ],
                    [
                        'name'     => 'public_key',
                        'contents' => $this->public_key,
                    ],
                    [
                        'name'     => 'ic_no',
                        'contents' => $data['ic_no'],
                    ],
                    [
                        'name'     => 'email',
                        'contents' => $data['email'],
                    ],
                    [
                        'name'     => 'name',
                        'contents' => $data['name'],
                    ],
                    [
                        'name'     => 'dept_code',
                        'contents' => $data['dept_code'],
                    ],
                    [
                        'name'     => 'department',
                        'contents' => $data['department'],
                    ],
                    [
                        'name'     => 'staff_no',
                        'contents' => $data['staff_no'],
                    ],
                    [
                        'name'     => 'office_phone_no',
                        'contents' => $data['office_phone_no'],
                    ],
                    [
                        'name'     => 'handphone_no',
                        'contents' => $data['handphone_no'],
                    ],
                    [
                        'name'     => 'title',
                        'contents' => $data['title'],
                    ],
                    [
                        'name'     => 'ad_userid',
                        'contents' => $data['ad_userid'],
                    ],
                    [
                        'name'     => 'city',
                        'contents' => $data['city'],
                    ],
                ]

            ]);

            $datas = json_decode($response->getBody());
            return $datas;

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                if ($e->getResponse()->getstatusCode() == '404') {
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }elseif($e->getResponse()->getstatusCode() == '401'){
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }else{
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }
            }
        }
    }

    public function AdEmailExist($param,$type){
        //type = AD or EMAIL

        if(empty($param)){
            return (object)['status' => false, 'message' => 'parameter empty!'];
        }

        $type = strtoupper($type);
        $url = "https://api.ums.edu.my/api/v1/ad/find";
        $client = new Client();

        try {

            $response = $client->request('POST', $url, [
                'timeout' => 60.00,
                'header' => [
                    'Content-Type' => 'application/json',
                ],
                'multipart' => [
                    [
                        'name'     => 'public_key',
                        'contents' => $this->public_key,
                    ],
                    [
                        'name'     => 'secret_key',
                        'contents' => $this->secret_key,
                    ],
                    [
                        'name'     => 'userid',
                        'contents' => $param,
                    ],
                    [
                        'name'     => 'type',
                        'contents' => $type,
                    ],
                ]

            ]);

            $datas = json_decode($response->getBody());
            return $datas;
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                if ($e->getResponse()->getstatusCode() == '404') {
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }
                return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
            }
        }

    }
}
