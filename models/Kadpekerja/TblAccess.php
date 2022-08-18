<?php

namespace app\models\Kadpekerja;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "facility_keselamatan.utils_tbl_access".
 *
 * @property int $id
 * @property string $icno
 * @property int $access_level
 */
class TblAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.utils_tbl_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['access_level', 'isActive'], 'integer'],
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
            'access_level' => 'Access Level',
            'isActive' => 'isActive',
        ];
    }
      public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    } 
    public function getAccess() {
        
        if($this->access_level == '1'){
            return 'Ketua Seksyen';
            
        }
        
        if($this->access_level == '2'){
            return 'Pegawai Tadbir';
            
        }
        if($this->access_level == '3'){
            return 'Pegawai Keselamatan';            
        }
        if($this->access_level == '99'){
            return 'Pentadbir Sistem';            
        }
    }
    public function getActivestat() {
        if ($this->isActive == '1') {
           return '<span class="label label-success">AKTIF</span>';
        }
        
        if ($this->isActive == '0') {
           return '<span class="label label-danger">TIDAK AKTIF</span>';
        } 
    }
}
