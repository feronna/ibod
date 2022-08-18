<?php

namespace app\models\Kadpekerja;

use Yii;

/**
 * This is the model class for table "keselamatan.utils_tbl_pay_url".
 *
 * @property int $id
 * @property string $buyer_name
 * @property string $buyer_id
 * @property string $amount
 * @property string $order_no
 * @property string $detail
 * @property string $payment_url
 */
class TblPayUrl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.utils_tbl_pay_url';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'buyer_name' => 'Buyer Name',
            'buyer_id' => 'Buyer ID',
            'amount' => 'Amount',
            'order_no' => 'Order No',
            'detail' => 'Detail',
            'payment_url' => 'Payment Url',
        ];
    }
}
