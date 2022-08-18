<?php

namespace app\models\saman;

use Yii;

/**
 * This is the model class for table "e_saman.t_19_eks_bayar".
 *
 * @property string $NOSAMAN
 * @property string $STATUS
 * @property string $INSERTDATE
 * @property string $PAIDDATE
 * @property string $UPDATER
 * @property string $AMOUNT_PENDING
 * @property string $AMNKUNCI
 * @property string $AMOUNT_PAID
 * @property int $ID
 * @property string $AMNKUNCI_PAID
 * @property string $CATATAN
 */
class SamanStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
     public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ekeselamatan.t_19_eks_bayar';
    }
//    
//    public static function tableName()
//    {
//        return 'e_saman.t_19_eks_bayar';
//    }
public $nokenderaan;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NOSAMAN','AMOUNT_PAID','AMNKUNCI_PAID','STATUS'], 'required'],
            [['INSERTDATE', 'PAIDDATE','nokenderaan'], 'safe'],
            [['AMOUNT_PENDING', 'AMNKUNCI', 'AMOUNT_PAID', 'AMNKUNCI_PAID'], 'number'],
            [['ID'], 'integer'],
            [['CATATAN'], 'string'],
            [['NOSAMAN'], 'string', 'max' => 12],
            [['STATUS'], 'string', 'max' => 10],
            [['UPDATER'], 'string', 'max' => 15],
            [['NOSAMAN'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'NOSAMAN' => 'Nosaman',
            'STATUS' => 'Status',
            'INSERTDATE' => 'Insertdate',
            'PAIDDATE' => 'Paiddate',
            'UPDATER' => 'Updater',
            'AMOUNT_PENDING' => 'Amount Pending',
            'AMNKUNCI' => 'Amnkunci',
            'AMOUNT_PAID' => 'Amount Paid',
            'ID' => 'ID',
            'AMNKUNCI_PAID' => 'Amnkunci Paid',
            'CATATAN' => 'Catatan',
        ];
    }
    public function getSaman() {
        return $this->hasOne(SamanOld::className(), ['NOSAMAN' => 'NOSAMAN']);
    }
    public function getRemark() {
        $val = $this->CATATAN;
        if(!$this->CATATAN){
            $val = "";
        }
        return $val;

    }
    public function getPaiddate() {
        $val = $this->PAIDDATE;
        if(!$this->PAIDDATE){
            $val = "";
        }
        return $val;

    }
}
