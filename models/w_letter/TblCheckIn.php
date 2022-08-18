<?php

namespace app\models\w_letter;

use Yii;  

class TblCheckIn extends \yii\db\ActiveRecord
{
    public $tarikh;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.wl_tbl_check_in';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO','datetime'], 'required'], 
            [['datetime','chief'], 'safe'], 
            [['ICNO','chief'], 'string', 'max' => 12], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno', 
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    } 
    
    public function getBiodataKeselamatan() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'chief']);
    }
}
