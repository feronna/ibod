<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "{{%keselamatan.stc_pelekat_kenderaan_jabatan}}".
 *
 * @property int $id
 * @property int $id_kenderaan
 * @property string $status_mohon
 * @property string $mohon_date
 * @property string $apply_type
 * @property string $no_siri
 * @property string $kod_siri
 * @property string $siri
 * @property string $updater
 * @property string $app_datetime
 * @property int $deleted
 * @property string $catatan
 * @property string $expired_date_1
 * @property string $expired_date_2
 * @property string $wakil_ICNO
 * @property string $wakil_nama
 * @property string $wakil_masa_ambil
 * @property int $batal
 * @property string $no_resit
 */
class TblPelekatKenderaanJabatan extends \yii\db\ActiveRecord {

    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%keselamatan.stc_pelekat_kenderaan_jabatan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['wakil_masa_ambil'], 'required', 'message' => 'Ruang ini adalah mandatori.'],
            [['id_kenderaan', 'deleted', 'batal'], 'integer'],
            [['mohon_date', 'app_datetime', 'expired_date_1', 'expired_date_2', 'wakil_masa_ambil'], 'safe'],
            [['catatan'], 'string'],
            [['status_mohon'], 'string', 'max' => 30],
            [['apply_type'], 'string', 'max' => 10],
            [['no_siri', 'siri', 'updater'], 'string', 'max' => 15],
            [['kod_siri'], 'string', 'max' => 5],
            [['wakil_ICNO'], 'string', 'max' => 12],
            [['wakil_nama'], 'string', 'max' => 150],
            [['no_resit'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'id_kenderaan' => 'Id Kenderaan',
            'status_mohon' => 'Status Mohon',
            'mohon_date' => 'Mohon Date',
            'apply_type' => 'Apply Type',
            'no_siri' => 'No Siri',
            'kod_siri' => 'Kod Siri',
            'siri' => 'Siri',
            'updater' => 'Updater',
            'app_datetime' => 'App Datetime',
            'deleted' => 'Deleted',
            'catatan' => 'Catatan',
            'expired_date_1' => 'Expired Date 1',
            'expired_date_2' => 'Expired Date 2',
            'wakil_ICNO' => 'Wakil Icno',
            'wakil_nama' => 'Wakil Nama',
            'wakil_masa_ambil' => 'Wakil Masa Ambil',
            'batal' => 'Batal',
            'no_resit' => 'No Resit',
        ];
    }

    public function getKenderaan() {
        return $this->hasOne(\app\models\esticker\TblStickerJabatan::className(), ['id' => 'id_kenderaan']);
    }

    public static function findPelekatDiterima($id) {
        return TblPelekatKenderaan::find()->where(['id_kenderaan' => $id])->andWhere(['status_mohon' => 'MENUNGGU KUTIPAN'])->one();
    }

    public function getUser() {
        return $this->hasOne(\app\models\esticker\TblStickerJabatan::className(), ['id' => 'id_kenderaan']);
    }

    public function getPengemaskini() {
        return $this->hasOne(\app\models\hronline\tblprcobiodata::className(), ['ICNO' => 'updater']);
    }

}
