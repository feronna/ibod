<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "keselamatan.stc_pay_transaction".
 *
 * @property int $id
 * @property string $ORDER_NO
 * @property string $TRANSACTION_ID
 * @property string $REF1
 * @property string $TRANSACTION_DATE
 * @property string $AMOUNT
 * @property string $TRANSACTION_STATUS
 * @property string $PAYMENT_STATUS
 * @property string $RESPONSE_DESC
 */
class PaymentTransaction extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.stc_pay_transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['AMOUNT'], 'number'],
            [['ORDER_NO', 'TRANSACTION_ID', 'TRANSACTION_DATE', 'TRANSACTION_STATUS', 'PAYMENT_STATUS', 'RESPONSE_DESC'], 'string', 'max' => 150],
            [['REF1'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ORDER_NO' => 'Order No',
            'TRANSACTION_ID' => 'Transaction ID',
            'REF1' => 'Ref1',
            'TRANSACTION_DATE' => 'Transaction Date',
            'AMOUNT' => 'Amount',
            'TRANSACTION_STATUS' => 'Transaction Status',
            'PAYMENT_STATUS' => 'Payment Status',
            'RESPONSE_DESC' => 'Response Desc',
        ];
    }
}
