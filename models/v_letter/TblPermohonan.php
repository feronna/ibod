<?php

namespace app\models\v_letter;

use Yii;  
use app\models\hronline\Tblprcobiodata; 

class TblPermohonan extends \yii\db\ActiveRecord { 

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hrm.vl_tbl_permohonan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [

            [['tarikh_mohon','ICNO','apply_type','tujuan'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['tarikh_notifikasi', 'isActive', 'approved_at', 'approved_by','approved_text','apply_type'], 'safe'],
            [['status_semasa', 'status_notifikasi'], 'integer'],
            [['ICNO', 'approved_by'], 'string', 'max' => 12], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'tarikh_mohon' => 'Tarikh Mohon',
            'status_semasa' => 'Status Semasa', 
            'tarikh_notifikasi' => 'Tarikh Notifikasi',
            'approved_by' => 'Disahkan Oleh',
            'approved_at' => 'Disahkan Pada',
        ];
    }

    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }  
     public static function totalPending() { 
                $count = TblPermohonan::find()->where(['status_semasa' => 1])->count();
           if ($count) {
                return '&nbsp;<span class="badge bg-red">' . $count . '</span>';
            } else {
                return '';
            }  
    }

    public function isChiefBsm() {
        $model = \app\models\hronline\Department::find()->where(['shortname'=>'BSM'])->one();
        
        return $model ? $model->chief: "";
    }
    
    public function Bsm() {
        return Tblprcobiodata::find()->joinWith('chiefDepartment')->andWhere(['department.shortname'=>'BSM'])->one();
    }
    
    public function Pendaftar() {
        return Tblprcobiodata::find()->joinWith('chiefDepartment')->andWhere(['department.shortname'=>'PN'])->one();
    }
}
