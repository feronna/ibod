<?php

namespace app\models\cv;

use Yii;

/**
 * This is the model class for table "hrm.cv_tbl_aduan".
 *
 * @property int $id
 * @property int $kriteria_id
 * @property string $justifikasi
 * @property string $tarikh_mohon
 * @property int $status_id
 * @property string $tarikh_tindakan
 * @property string $tindakan_by
 * @property string $tarikh_selesai
 * @property string $selesai_by
 * @property string $cacatan
 */
class TblAduan extends \yii\db\ActiveRecord {

    public $name;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'hrm.cv_tbl_aduan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['kriteria_id', 'justifikasi'], 'required'],
            [['kriteria_id', 'status_id'], 'integer'],
            [['justifikasi', 'catatan'], 'string'],
            [['tarikh_mohon', 'tarikh_tindakan', 'tarikh_selesai', 'name', 'assign_at'], 'safe'],
            [['tindakan_by', 'selesai_by', 'ICNO', 'assign_to', 'assign_by'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'kriteria_id' => 'Kriteria ID',
            'justifikasi' => 'Justifikasi',
            'tarikh_mohon' => 'Tarikh Mohon',
            'status_id' => 'Status ID',
            'tarikh_tindakan' => 'Tarikh Tindakan',
            'tindakan_by' => 'Tindakan By',
            'tarikh_selesai' => 'Tarikh Selesai',
            'selesai_by' => 'Selesai By',
            'cacatan' => 'Cacatan',
        ];
    }

    public function getKriteria() {

        return $this->hasOne(RefKriteria::className(), ['id' => 'kriteria_id']);
    }

    public function getStatus() {

        return $this->hasOne(RefStatusAduan::className(), ['id' => 'status_id']);
    }

    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }

    public function getOwner() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'assign_to']);
    }

    public function getCompletedby() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'selesai_by']);
    }

    public function getAdminAkademik() {
        return \app\models\cv\TblAccess::findOne(['ICNO' => Yii::$app->user->getId()]);
    }

    public static function TotalbyStatus($id) {
        return count(TblAduan::findAll(['status_id'=>$id]));
    }

}
