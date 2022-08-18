<?php

namespace app\models\cuti;

use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "hrm.cuti_temp_table".
 *
 * @property int $id
 * @property string $icno
 * @property int $allowed
 */
class CutiTempTable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cuti_temp_table';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['allowed'], 'integer'],
            [['added_dt'], 'safe'],
            [['icno','added_by'], 'string', 'max' => 12],
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
            'allowed' => 'Allowed',
        ];
    }
    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getStatus()
    {
        $lang = "";

        
        if ($this->allowed == '1') {
            $lang = 'Allowed';
        }
        if ($this->allowed == '0') {
            $lang = 'Not Allowed';
        }
       

        return $lang;
    }
}
