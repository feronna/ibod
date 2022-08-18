<?php

namespace app\models\Kadpekerja;

use Yii;

/**
 * This is the model class for table "keselamatan.utils_tbl_pay_invoice".
 *
 * @property int $id
 * @property int $refl id kad
 * @property string $ref2 icno
 * @property string $ref2_desc STAFF / PELAJAR
 * @property string $customer_name
 * @property string $detail
 * @property string $contact_no
 * @property string $email
 * @property string $amount
 * @property string $payment_method FPX / CREDIT CARD
 */
class TblPayInvoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.utils_tbl_pay_invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['refl'], 'integer'],
            [['amount'], 'number'],
            [['ref2'], 'string', 'max' => 12],
            [['ref2_desc'], 'string', 'max' => 150],
            [['customer_name'], 'string', 'max' => 250],
            [['detail', 'contact_no', 'email'], 'string', 'max' => 60],
            [['payment_method'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'refl' => 'Refl',
            'ref2' => 'Ref2',
            'ref2_desc' => 'Ref2 Desc',
            'customer_name' => 'Customer Name',
            'detail' => 'Detail',
            'contact_no' => 'Contact No',
            'email' => 'Email',
            'amount' => 'Amount',
            'payment_method' => 'Payment Method',
        ];
    }
}
