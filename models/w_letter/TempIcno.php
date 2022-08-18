<?php

namespace app\models\w_letter; 
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "ejobs.temp_icno".
 *
 * @property string $ICNO
 */
class TempIcno extends \yii\db\ActiveRecord
{ 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.wl_temp_ic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [ 
            [['ICNO'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
        ];
    }
     
}
