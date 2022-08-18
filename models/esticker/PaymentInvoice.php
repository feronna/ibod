<?php

namespace app\models\esticker;
use app\models\esticker\PayRate;
use Yii;

/**
 * This is the model class for table "keselamatan.stc_pay_invoice".
 *
 * @property int $id
 * @property string $ref1 ICNO
 * @property string $ref1_desc STAFF / PELAJAR
 * @property int $ref2 id_pelekat
 * @property string $ref2_desc BARU/HILANG/ROSAK
 * @property string $customer_name
 * @property string $detail PELEKAT KENDERAAN
 * @property string $contact_no
 * @property string $email
 * @property string $amount
 * @property string $payment_method FPX / CREDIT_CARD
 */
class PaymentInvoice extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.stc_pay_invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment_method'],'required', 'message' => 'Ruang ini adalah mandatori'],
            [['ref1'], 'integer'],
            [['amount'], 'number'],
            [['ref2'], 'string', 'max' => 12],
            [['ref1_desc', 'ref2_desc'], 'string', 'max' => 150],
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
            'ref1' => 'Ref1',
            'ref1_desc' => 'Ref1 Desc',
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
