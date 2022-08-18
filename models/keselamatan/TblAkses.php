<?php

namespace app\models\keselamatan;

use app\models\hronline\Department;
use app\models\hronline\GredJawatan;
use app\models\hronline\Tblprcobiodata;
use app\models\keselamatan\RefUnit;
use Yii;

/**
 * This is the model class for table "keselamatan.tbl_akses".
 *
 * @property int $id
 * @property string $icno
 * @property int $akses_level
 * @property int $isActive
 */
class TblAkses extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.tbl_akses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['campus_id','akses_level', 'isActive', 'unit_id','import-access','isAccess'], 'integer'],
            [['icno'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'akses_level' => 'Akses Level',
            'isActive' => 'Is Active',
        ];
    }

    public function getCampus() {
        return $this->hasOne(\app\models\hronline\Campus::className(), ['campus_id' => 'campus_id']);
    }
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getStaff() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getDisplayDepartment() {
        $model = GredJawatan::find()->where(['id' => $this->staff->gredJawatan])->one();

        return $model->gred;
    }
    public function getAccessLevel() {

        if ($this->akses_level == 1) {
            return '&nbsp;<span class="badge bg-red">Administrator</span>';
        }
        if ($this->akses_level == 2) {
            return '&nbsp;<span>Penyelia Unit</span>';
        }
        if ($this->akses_level == 3) {
            return '&nbsp;<span >Pegawai</span>';
        }
        if ($this->akses_level == 4) {
            return '&nbsp;<span >Penyelia Cuti</span>';
        }
        if ($this->akses_level == 5) {
            //nester
            return '&nbsp;<span >Penyelia Jadual</span>';
        }
    }

    public function getStatus() {
        if ($this->isActive == 1) {
            return '&nbsp;<span >Aktif</span>';
        } else {
            return '&nbsp;<span >Tidak Aktif</span>';
        }
    }

    public function getUnit() {

//            $val = false;
        if ($this->unit_id == NULL) {
            return '&nbsp;<span class="badge bg-red">-</span>';
        } else {
            $unit_id = $this->hasOne(RefUnit::className(), ['id' => 'unit_id']);
//            $id = RefUnit::find()->where(['id'=>$unit_id]);
            var_dump($unit_id);
            die;
        }
//        if ($this->unit_id == 1) {
//            return '&nbsp;<span class="badge bg-red">ALPHA</span>';
//        }
//        if ($this->unit_id == 2) {
//            return '&nbsp;<span class="badge bg-red">ALPHA</span>';
//        }
//        if ($this->unit_id == 3) {
//            return '&nbsp;<span class="badge bg-red">ALPHA</span>';
//        }
    }

}
