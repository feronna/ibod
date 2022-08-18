<?php

namespace app\models\esticker;

use GuzzleHttp\Client;
use Yii;

/**
 * This is the model class for table "keselamatan.stc_pay_url".
 *
 * @property int $id
 * @property string $buyer_name
 * @property string $buyer_id
 * @property string $amount
 * @property string $order_no
 * @property string $contact
 * @property string $detail
 * @property string $status
 * @property string $payment_url
 */
class PaymentUrl extends \yii\db\ActiveRecord {

    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.stc_pay_url';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['amount'], 'number'],
            [['buyer_name'], 'string', 'max' => 250],
            [['buyer_id', 'order_no', 'detail'], 'string', 'max' => 150],
            [['payment_url'], 'string', 'max' => 600],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'buyer_name' => 'Buyer Name',
            'buyer_id' => 'Buyer ID',
            'amount' => 'Amount',
            'order_no' => 'Order No',
            'contact' => 'Contact',
            'detail' => 'Detail',
            'status' => 'Status',
            'payment_url' => 'Payment Url',
        ];
    }

    public function getPaymentDetails() {
        $url = "https://epayment.ums.edu.my/api/epayment/getPaymentDetail";

        $client = new Client();
        $data = $client->request('POST', $url, [
            'auth' => ['044', '655a11e834dfcf21c14cf4ad37b0b758e3df5ea5'],
            'header' => [
                "Accept: application/json",
                'Content-Type' => 'application/json',
            ],
            'form_params' => [
                'order_no' => $this->order_no,
            ],
        ]);

        $details = json_decode($data->getBody(), true);

        if ($details) {
            if ($details['status'] == "true") {

                $arr = array();
                foreach ($details['details'] as $array) {
                    foreach ($array as $key => $value) {
                        $arr[] = $value;
                    }
                }

                if (empty(PaymentDetails::findOne(['ref_no' => $arr[3]]))) {
                    $payDetails = new PaymentDetails();
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
                }
                return "True";
            } else {
                return "false";
            }
        } else {
            return "Tiada Maklumat";
        }
    }

}
