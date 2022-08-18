<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_bonkhidmat".
 *
 * @property int $id
 * @property string $icno
 * @property string $t_phd
 * @property string $t_sabatikal
 * @property string $j_bon
 * @property string $baki_bon
 */
class Tblbonkhidmat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_bonkhidmat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'string', 'max' => 20],
            [['t_phd', 't_sabatikal', 'j_bon', 'baki_bon', 'j_lapor'], 'string', 'max' => 255],
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
            't_phd' => 'T Phd',
            't_sabatikal' => 'T Sabatikal',
            'j_bon' => 'J Bon',
            'baki_bon' => 'Baki Bon',
            'j_lapor' => ' J Lapor',        ];
    }
    
     public function getLapor() {
       
        return $this->hasMany(TblLapordiri::className(), ['laporID' => 'icno', 'HighestEduLevelCd'=>'HighestEduLevelCd']);
       
   }
}
