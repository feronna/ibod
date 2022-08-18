<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "{{%keselamatan.stc_pay_details}}".
 *
 * @property int $id
 * @property string $payer_name
 * @property string $amount
 * @property string $item_code
 * @property string $ref_no
 * @property string $txn_status
 * @property string $contact_no
 * @property string $payment_method
 * @property string $email
 * @property string $payment_date
 * @property string $payment_detail
 */
class PaymentDetails extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%keselamatan.stc_pay_details}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount'], 'number'],
            [['payer_name', 'item_code', 'ref_no', 'txn_status', 'contact_no', 'payment_method', 'email', 'payment_date', 'payment_detail'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payer_name' => 'Payer Name',
            'amount' => 'Amount',
            'item_code' => 'Item Code',
            'ref_no' => 'Ref No',
            'txn_status' => 'Txn Status',
            'contact_no' => 'Contact No',
            'payment_method' => 'Payment Method',
            'email' => 'Email',
            'payment_date' => 'Payment Date',
            'payment_detail' => 'Payment Detail',
        ];
    }
}
