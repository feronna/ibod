<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hronline.v_latest_bln_gaji".
 *
 * @property string $ICNO
 * @property string $SalMoveMth
 * @property int $SalMoveMthType
 * @property string $SalMoveMthStDt
 * @property string $id
 */
class TblBulanPgt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.v_latest_bln_gaji';
    }
    
//    public static function getDb() {
//        return Yii::$app->get('db2'); // second database
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'SalMoveMth', 'SalMoveMthStDt'], 'required'],
            [['SalMoveMthType', 'id'], 'integer'],
            [['SalMoveMthStDt'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
            [['SalMoveMth'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
            'SalMoveMth' => 'Sal Move Mth',
            'SalMoveMthType' => 'Sal Move Mth Type',
            'SalMoveMthStDt' => 'Sal Move Mth St Dt',
            'id' => 'ID',
        ];
    }
}
