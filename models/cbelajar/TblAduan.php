<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "hrd.cb_tbl_Aduan".
 *
 * @property int $id
 * @property string $ICNO
 * @property int $kriteria_id
 * @property string $justifikasi
 * @property string $tarikh_mohon
 * @property int $status_id
 * @property string $tarikh_tindakan
 * @property string $tindakan_by
 * @property string $tarikh_selesai
 * @property string $selesai_by
 * @property string $catatan
 * @property string $assign_to
 * @property string $assign_by
 * @property string $assign_at
 */
class TblAduan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_Aduan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kriteria_id', 'status_id'], 'integer'],
            [['justifikasi', 'catatan'], 'string'],
            [['tarikh_mohon', 'tarikh_tindakan', 'tarikh_selesai', 'assign_at'], 'safe'],
            [['ICNO', 'tindakan_by', 'selesai_by', 'assign_to', 'assign_by'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'kriteria_id' => 'Kriteria ID',
            'justifikasi' => 'Justifikasi',
            'tarikh_mohon' => 'Tarikh Mohon',
            'status_id' => 'Status ID',
            'tarikh_tindakan' => 'Tarikh Tindakan',
            'tindakan_by' => 'Tindakan By',
            'tarikh_selesai' => 'Tarikh Selesai',
            'selesai_by' => 'Selesai By',
            'catatan' => 'Catatan',
            'assign_to' => 'Assign To',
            'assign_by' => 'Assign By',
            'assign_at' => 'Assign At',
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
        public static function TotalbyStatus($id) {
        return count(TblAduan::findAll(['status_id'=>$id]));
    }
}
