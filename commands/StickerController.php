<?php

namespace app\commands;
 
use yii\console\Controller;
use yii\console\ExitCode; 
use app\models\hronline\Tblprcobiodata;
use GuzzleHttp\Client; 

class StickerController extends Controller {

    public function actionKemaskiniStatusPembayaran() {

        $pelekat = \app\models\esticker\TblPelekatKenderaan::find()->joinWith(['kenderaan'])->where(['stc_pelekat_kenderaan.status_mohon' => 'PENDING PAYMENT'])->all();

        if ($pelekat) {
            foreach ($pelekat as $pelekat) {
                $record = \app\models\esticker\PaymentUrl::findOne(['buyer_id' => $pelekat->id]);
                $details = array();
                if ($record) {
                    $details = $this->getPaymentDetails($record->order_no);
                }
                if ($details) {
                    if ($details['status'] == "true") {
                        $pelekat->status_mohon = 'MENUNGGU KUTIPAN';
                        $pelekat->save(false);

                        $arr = array();
                        foreach ($details['details'] as $array) {
                            foreach ($array as $key => $value) {
                                $arr[] = $value;
                            }
                        }

                        $payDetails = new \app\models\esticker\PaymentDetails();
                        $payDetails->payer_name = $arr[0];
                        $payDetails->amount = $arr[1];
                        $payDetails->item_code = $arr[2];
                        $payDetails->ref_no = $arr[3];
                        $payDetails->txn_status = $arr[4];
                        $payDetails->contact_no = $arr[5];
                        $payDetails->payment_method = $arr[6];
                        $payDetails->email = $arr[7];
                        $payDetails->payment_date = $arr[8];
                        $payDetails->payment_detail = $arr[9];
                        $payDetails->save(false);

                        //simpan paymentDetails (Selesai Bayar)
                        //notifikasi
//                        $this->EmailStaf($pelekat->user->biodata->ICNO, $arr[3]);
                    }
                }
            }
        }

        return ExitCode::OK;
    }

    public function EmailStaf($ICNO, $ref) {
        $payment = \app\models\esticker\PaymentDetails::findOne(['ref_no' => $ref]);
        $biodata = Tblprcobiodata::findOne(['ICNO' => $ICNO]);

        try {
            Yii::$app->mailer2->compose('pelekat_kenderaan_staf', ['biodata' => $biodata, 'payment' => $payment])
                    ->setFrom('esticker_noreply@ums.edu.my')
                    ->setSubject('PELEKAT KENDERAAN UNIVERSITI MALAYSIA SABAH')
                    ->setTo($biodata->COEmail)
                    ->send();

            $mail_status = 1;
        } catch (Exception $e) {
            $mail_status = 0;
        }

        $model = new \app\models\esticker\TblEmail();
        $model->from_name = 'E-STICKER';
        $model->from_email = 'esticker_noreply@ums.edu.my';
        $model->to_name = $biodata->CONm;
        $model->to_email = $biodata->COEmail;
        $model->subject = 'PELEKAT KENDERAAN UNIVERSITI MALAYSIA SABAH';
        $model->message = 'DEFAULT MESSAGE STAFF';
        $model->success = $mail_status;
        $model->date_published = date('Y-m-d H:i:s');
        $model->save();
    }
    
    public function getPaymentDetails($id) {
        $url = "https://epayment.ums.edu.my/api/epayment/getPaymentDetail";

        $client = new Client();
        $data = $client->request('POST', $url, [
            'auth' => ['044', '655a11e834dfcf21c14cf4ad37b0b758e3df5ea5'],
            'header' => [
                "Accept: application/json",
                'Content-Type' => 'application/json',
            ],
            'form_params' => [
                'order_no' => $id,
            ],
        ]);

        return json_decode($data->getBody(), true);
    }

}
