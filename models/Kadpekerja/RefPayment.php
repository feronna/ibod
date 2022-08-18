<?php

namespace app\models\Kadpekerja;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "keselamatan.utils_ref_payment".
 *
 * @property int $id
 * @property string $payment payment type
 * @property string $pay_status
 * @property string $pay_receipt
 * @property string $pay_recv received by / updated by
 * @property string $pay_recvDt
 * @property string $catatan
 * @property int $parent_id
 */
class RefPayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.utils_ref_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pay_recvDt'], 'safe'],
            [['catatan'], 'string'],
            [['parent_id'], 'integer'],
            [['payment', 'pay_status'], 'string', 'max' => 50],
            [['pay_receipt'], 'string', 'max' => 200],
            [['pay_recv', 'ref_icno'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payment' => 'Payment',
            'pay_status' => 'Pay Status',
            'pay_receipt' => 'Pay Receipt',
            'pay_recv' => 'Pay Recv',
            'pay_recvDt' => 'Pay Recv Dt',
            'catatan' => 'Catatan',
            'parent_id' => 'Parent ID',
            'ref_icno' => 'ICNO',

        ];
    }
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ref_icno']);
    }  
}
