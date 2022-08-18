<?php

namespace app\models\cbelajar;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "hrd.cb_tbl_pa".
 *
 * @property string $icno
 * @property int $DeptID
 */
class AksesPa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_pa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['DeptID'], 'integer'],
            [['icno'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'icno' => 'Icno',
            'DeptID' => 'Dept ID',
        ];
    }
     public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
     public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
}
