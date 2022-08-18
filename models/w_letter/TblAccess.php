<?php

namespace app\models\w_letter;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "guarantee_letter.tbl_access".
 *
 * @property int $id
 * @property string $ICNO
 * @property int $level
 * @property string $update_by
 * @property string $update_at
 */
class TblAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.wl_tbl_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO','level'], 'required', 'message' => 'Ruang ini adalah mandatori'], 
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
            'level' => 'Level', 
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
}
