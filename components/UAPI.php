<?php

namespace app\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use GuzzleHttp\Client;
use yii\web\NotFoundHttpException;
use GuzzleHttp\Exception\RequestException;
use yii\helpers\VarDumper;

class UAPI extends Component
{

    public function UploadFile($namefile, $content, $category, $directory, $icno = null)
    {

        if (empty($namefile) || empty($content) || empty($category) || empty($directory)) {
            return 'Terdapat parameter yang kosong.';
        }
        //**stdClass**
        //"status": true
        //"message": "File successfully uploaded.",
        //"file_name_hashcode": "896f2b7483ebe694ceb8e3db395fa2c5"
        //**
        //"status": false,
        //"message": "No file detected."

        //category type
        //$image = '01';
        //$video = '02';
        //$audio = '03';
        //$document = '04';
        //$archive = '05';


        $user_id = $icno ?? Yii::$app->user->getId();
        $client = new Client();
        try {

            $response = $client->request('POST', 'https://mediahost.ums.edu.my/api/v1/upload', [
                'timeout' => 60.00,
                'header' => [
                    'Content-Type' => 'application/json',
                ],
                'multipart' => [
                    [
                        'name'     => 'secret_key',
                        'contents' => 'nWuRQcGNm1FCDew3VpQK83DVFsLklE'
                    ],
                    [
                        'name'     => 'public_key',
                        'contents' => 'ca2hNOYNhsaLL0OcH1hXsNYfTG6lO2'
                    ],
                    [
                        'name'     => 'uploader_id',
                        'contents' => '0302'
                    ],
                    [
                        'name'     => 'user_id',
                        'contents' => $user_id,
                    ],
                    [
                        'name'     => 'autocreatedirectory',
                        'contents' => '1'
                    ],
                    [
                        'name'     => 'directory',
                        'contents' => $directory,
                    ],

                    [
                        'name'     => 'file_title',
                        'contents' => $namefile,
                    ],
                    [
                        'name'     => 'file',
                        'contents' => file_get_contents($content, $namefile),
                        'filename' => $namefile,

                    ],
                    [
                        'name'     => 'file_description',
                        'contents' => '-'
                    ],
                    [
                        'name'     => 'category',
                        'contents' => $category
                    ],
                    [
                        'name'     => 'tag',
                        'contents' => '-'
                    ],
                    [
                        'name'     => 'accessibility',
                        'contents' => '01'
                    ],
                    [
                        'name'     => 'overwrite',
                        'contents' => '0'
                    ],
                    [
                        'name'     => 'hashcode',
                        'contents' => ''
                    ],
                ]

            ]);

            $datas = json_decode($response->getBody());
            return $datas;

        } catch (RequestException $e) {
            if($e->hasResponse()){
                if ($e->getResponse()->getstatusCode() == '404') {
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }elseif($e->getResponse()->getstatusCode() == '401'){
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }else{
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }
            }else{
                return $x = (object)['status' => false, 'message' => $e->getHandlerContext()['error']];
            }
        }
    }

    public function DeleteFile($hashcode)
    {
        if (empty($hashcode)) {
            return 'Dokumen adalah kosong.';
        }

        $user_id = Yii::$app->user->getId();
        $client = new Client();

        $response = $client->request('POST', 'https://mediahost.ums.edu.my/api/v1/delete-file', [
            'timeout' => 60.00,
            'header' => [
                'Content-Type' => 'application/json',
            ],
            'multipart' => [
                [
                    'name'     => 'secret_key',
                    'contents' => 'nWuRQcGNm1FCDew3VpQK83DVFsLklE'
                ],
                [
                    'name'     => 'public_key',
                    'contents' => 'ca2hNOYNhsaLL0OcH1hXsNYfTG6lO2'
                ],
                [
                    'name'     => 'uploader_id',
                    'contents' => '0302'
                ],
                [
                    'name'     => 'user_id',
                    'contents' => $user_id,
                ],
                [
                    'name'     => 'hashcode',
                    'contents' => $hashcode,
                ],

            ]
        ]);

        $datas = json_decode($response->getBody());
        return $datas;
    }

    public function DisplayFile($hashcode, $object = null)
    {
        if (empty($hashcode)) {
            return 'Dokumen adalah kosong.';
        }

        //**stdClass**
        //"status": false,
        //"message": "Hashcode doesnt exist."

        $client = new Client();
        try {
            $url_ = 'https://mediahost.ums.edu.my/api/v1/viewFile/';
            $response = $client->request('GET', $url_ . $hashcode, [
                'timeout' => 60.00,
                'header' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            $response = json_decode($response->getBody());
            // if (property_exists($response, 'status')) {
            //     return 'Fail / Hashcode Tidak Wujud.';
            // }
            if (!empty($response) && $response->status != false) {
                return 'Fail / Hashcode Tidak Wujud.';
            }

            return $url_ . $hashcode;

        } catch (RequestException $e) {
            
            if ($e->hasResponse()) {
                if ($e->getResponse()->getstatusCode() == '404') {
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }elseif($e->getResponse()->getstatusCode() == '401'){
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }else{
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }
            }else{
                return $x = (object)['status' => false, 'message' => $e->getHandlerContext()['error']];
            }
        }
    }

    public function NameFile($hashcode,$object = null)
    {
        if (empty($hashcode)) {
            return 'Dokumen adalah kosong.';
        }

        $client = new Client();
        try {
            $response = $client->request('GET', 'https://mediahost.ums.edu.my/api/v1/getFileInfo/' . $hashcode, [
                'timeout' => 60.00,
                'header' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            $response = json_decode($response->getBody());
             
            if (property_exists($response, 'status')) {
                return  'Fail / Hashcode Tidak Wujud';//$response->status;
            }
          
            return $response->file_name;

        } catch (RequestException $e) {
            if($object == null){
                return '-';
            }
            if($e->hasResponse()){
                if ($e->getResponse()->getstatusCode() == '404') {
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }elseif($e->getResponse()->getstatusCode() == '401'){
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }else{
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }
            }else{
                return $x = (object)['status' => false, 'message' => $e->getHandlerContext()['error']];
            }
        }
    }

    public function DownloadFile($hashcode)
    {

        if (empty($hashcode)) {
            return 'Dokumen adalah kosong.';
        }

        //**stdClass**
        //"status": false,
        //"message": "Hashcode doesnt exist."
        $client = new Client();
        try {
            $url_ = 'https://mediahost.ums.edu.my/api/v1/downloadFiled/';
            $response = $client->request('GET', $url_ . $hashcode, [
                'timeout' => 60.00,
                'header' => [
                    'Content-Type' => 'application/json',
                ],
            ]);
            $response = json_decode($response->getBody());
            if (property_exists($response, 'status')) {
                return $response->status;
            }
            return $url_ . $hashcode;
        } catch (RequestException $e) {
            if($e->hasResponse()){
                if ($e->getResponse()->getstatusCode() == '404') {
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }elseif($e->getResponse()->getstatusCode() == '401'){
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }else{
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }
            }else{
                return $x = (object)['status' => false, 'message' => $e->getHandlerContext()['error']];
            }
        }
    }

    public function InfoFile($hashcode)
    {
        if (empty($hashcode)) {
            return 'Dokumen adalah kosong.';
        }
        //**stdClass**
        // "file_id": "12011807000029",
        // "file_name_hashcode": "896f2b7483ebe694ceb8e3db395fa2c25",
        // "file_title": "Test Upload Picture",
        // "user_id": "active_directory_id",
        // "file_name": "picture_name.png",
        // "file_description": "asd",
        // "file_type": "image\/png",
        // "tag": "t",
        // "file_size": "135973 bytes",
        // "file_path": "\/path\/to\/storage",
        // "file_extension": "png",
        // "category": "02",
        // "accessibility": "00",
        // "uploader_id": "1201",
        //"file_status": 1,
        //"file_details": "null",
        //"created_at": "2018-07-19 23:02:27",
        //"updated_at": "2018-07-19 23:02:27"
        // "status": false,
        // "message": "Hashcode doesnt exist."

        $client = new Client();
        try {
            $response = $client->request('GET', 'https://mediahost.ums.edu.my/api/v1/getFileInfo/' . $hashcode, [
                'timeout' => 60.00,
                'header' => [
                    'Content-Type' => 'application/json',
                ],
            ]);
            $response = json_decode($response->getBody());
            if (property_exists($response, 'status')) {
                return $response->status;
            }

            return 'https://mediahost.ums.edu.my/api/v1/getFileInfo/' . $hashcode;
        } catch (RequestException $e) {
           
            if ($e->hasResponse()) {
                if ($e->getResponse()->getstatusCode() == '404') {
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }elseif($e->getResponse()->getstatusCode() == '401'){
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }else{
                    return $x = (object)['status' => false, 'message' => $e->getResponse()->getReasonPhrase()];
                }
            }else{
                return $x = (object)['status' => false, 'message' => $e->getHandlerContext()['error']];
            }
        }
    }
}
