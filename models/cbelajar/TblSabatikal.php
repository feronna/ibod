<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_sabatikal".
 *
 * @property int $id
 * @property string $icno
 * @property int $CountryCd
 * @property string $InstNm
 * @property string $tarikh_mula
 * @property string $tarikh_tamat
 * @property int $baki_bon
 */
class TblSabatikal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_sabatikal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'baki_bon'], 'integer'],
            [['tarikh_mula', 'tarikh_tamat'], 'safe'],
            [['icno'], 'string', 'max' => 12],
            [['InstNm', 'CountryCd', 'HighestEduLevel'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'CountryCd' => 'Country Cd',
            'InstNm' => 'Inst Nm',
            'tarikh_mula' => 'Tarikh Mula',
            'tarikh_tamat' => 'Tarikh Tamat',
            'baki_bon' => 'Baki Bon',
            'HighestEduLevel' => 'HighestEduLevel',
        ];
    }
    
     public function getNegara() {
        return $this->hasOne(\app\models\hronline\Negara::className(), ['CountryCd'=>'CountryCd']);
    }
}
