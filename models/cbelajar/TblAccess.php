<?php

namespace app\models\cbelajar;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_access".
 *
 * @property int $id
 * @property string $icno
 * @property int $level
 * @property string $update_by
 * @property string $update_dt
 */
class TblAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno','level'], 'required', 'message' => 'Ruang ini adalah mandatori'], 
            [['level'], 'integer'],
            [['update_dt'], 'safe'],
            [['icno', 'update_by'], 'string', 'max' => 12],
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
            'level' => 'Level',
            'update_by' => 'Update By',
            'update_dt' => 'Update Dt',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
     public function getPenyelia() {
        return $this->hasOne(LkkTblPenyelia::className(), ['emel' => 'icno']);
    }
}
