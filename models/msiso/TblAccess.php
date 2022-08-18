<?php

namespace app\models\msiso;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "utilities.iso_tbl_access".
 *
 * @property int $id
 * @property string $icno
 * @property int $access_level
 * @property int $isActive
 */
class TblAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.iso_tbl_access';
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
            'isActive' => 'Is Active',
        ];
    }
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public function getAccessRole() {
        if ($this->access_level == '1') {
            return 'Pegawai BPQ';
        } 
       
        if ($this->access_level == '2') {
            return 'Penyelia BPQ';
        }
  
        if ($this->access_level == '3') {
          return 'Auditor';
        }
        if ($this->access_level == '99') {
        return 'Pentadbir Sistem';
        } 
    }

    public function getActive() { //status label permohonan buka /tutup
        if ($this->isActive == '1') {
            return '<span class="label label-success">Aktif</span>';
        }
         if ($this->isActive == '0') {
           return '<span class="label label-danger">Tidak Aktif</span>'; 
        }
       
    }
}
