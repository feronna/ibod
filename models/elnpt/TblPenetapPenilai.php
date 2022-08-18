<?php

namespace app\models\elnpt;

use Yii;
use app\models\elnpt\Tblprcobiodata;

/**
 * This is the model class for table "hrm.elnpt_tbl_penetap_penilai".
 *
 * @property int $id
 * @property string $tahun
 * @property int $ref_kump_dept
 * @property string $penetap_icno
 */
class TblPenetapPenilai extends \yii\db\ActiveRecord
{
    //public $jabatan;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_tbl_penetap_penilai';
    }
    
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        if($insert == true) {
            $this->tahun = date("Y");
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun'], 'safe'],
            [['ref_kump_dept', 'penetap_jfpiu'], 'integer'],
            [['penetap_icno'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tahun' => 'Tahun',
            'ref_kump_dept' => 'Ref Kump Dept',
            'penetap_icno' => 'Penetap Icno',
        ];
    }
    
    public function getNamaPenetap() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'penetap_icno']);
    }
}
