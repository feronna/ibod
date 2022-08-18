<?php

namespace app\models\portfolio;

use Yii;

/**
 * This is the model class for table "hrm.portfolio_akses_pa".
 *
 * @property int $id
 * @property string $icno
 */
class SenaraiPa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.portfolio_akses_pa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'string', 'max' => 12],
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
        ];
    }
     public function getKakitangan() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
         public function getPekerjaNm2() {
   
        $kon = \app\models\hronline\Tblprcobiodata::findOne(['ICNO'=> $this->icno]); 
        return $kon->CONm . ' ' . '( ' . $kon->department->shortname . ' )';
        }

    
    
    
}
