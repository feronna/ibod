<?php

namespace app\models\gaji;

use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "hrm.gaji_staf_akses".
 *
 * @property string $staf_akses_icno
 * @property int $staf_akses_id akses_level
 */
class TblStaffAkses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.gaji_staf_akses_copy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staf_akses_icno'], 'required'],
            [['staf_akses_id'], 'integer'],
            [['staf_akses_icno'], 'string', 'max' => 14],
            [['staf_akses_icno'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'staf_akses_icno' => 'Staf Akses Icno',
            'staf_akses_id' => 'Staf Akses ID',
        ];
    }
    
    public function getBiodata(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'staf_akses_icno']);
    }
    
    public function getAkses() {
        switch($this->staf_akses_id){
            case '99':
                return 'ALL';
                case '88':
                return 'INSERT, UPDATE, DELETE, VER_STATUS';
                    case '77':
                return 'INSERT, UPDATE, DELETE, APP_STATUS';
                        case '60':
                return 'INSERT, UPDATE, DELETE';
                            case '50':
                return 'VIEW ONLY';
        }
    }
    
}
