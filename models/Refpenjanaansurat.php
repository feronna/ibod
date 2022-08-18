<?php

namespace app\models;

use app\models\hronline\Tblprcobiodata;
use app\models\hronline\GredJawatan;
use app\models\mohonjawatan\TblPenetapanGaji;
use app\models\hronline\Department;
use app\models\mohonjawatan\RefItka;
use app\models\mohonjawatan\RefItp;
use app\models\mohonjawatan\RefBiw;
use Yii;

/**
 * This is the model class for table "mohonjawatan.ref_penjanaansurat".
 *
 * @property int $id
 * @property string $no_rujukan
 * @property string $tarikh_m tarikh mesyuarat
 * @property string $tarikh_surat tarikh surat dijana
 * @property string $dijana_oleh
 * @property string $kepada surat kepada siapa
 */
class Refpenjanaansurat extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'mohonjawatan.ref_penjanaansurat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['tarikh_m', 'tarikh_surat'], 'safe'],
            [['no_rujukan', 'dijana_oleh', 'kepada'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'no_rujukan' => 'No Rujukan',
            'tarikh_m' => 'Tarikh M',
            'tarikh_surat' => 'Tarikh Surat',
            'dijana_oleh' => 'Dijana Oleh',
            'kepada' => 'Kepada',
        ];
    }

    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'kepada']);
    }

    public function getGredjawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'jawatan_dipohon']);
    }

    public function getDept() {
        return $this->hasOne(Department::className(), ['id' => 'dept_id']);
        $value = (($model->min) * ($model->biw->kadar)) + ($model->itka->jumlah) + ($model->itp->jumlah) + ($model->min);
    }

    public function getData() {
        return $this->hasOne(TblPermohonan::findAll(['app_by' => '$icno']));
    }

    public function getNamajawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 'gredJawatan']);
    }

    public static function jawatan($id) {
        $value = '';
        $model = Tblprcobiodata::findOne(['ICNO' => $id]);
        if ($model) {
            $value1 = $model->DeptId;
            $value = Department::findOne(['id' => $value1]);
        }
        return $value;
        die;
    }

   
}
