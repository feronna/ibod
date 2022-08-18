<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "e_sticker.pelekat_kenderaan".
 *
 * @property int $id
 * @property string $status_mohon
 * @property string $mohon_date
 * @property string $app_date
 * @property string $no_siri
 * @property string $apply_type
 * @property string $updater
 * @property string $expired_date_1
 * @property int $id_kenderaan
 * @property string $total
 */
class TblPelekatKenderaan extends \yii\db\ActiveRecord {

    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.stc_pelekat_kenderaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['apply_type', 'wakil_masa_ambil', 'siri', 'no_resit'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['free', 'kod_siri', 'batal', 'mohon_date', 'app_datetime', 'expired_date_1', 'expired_date_2', 'deleted', 'catatan', 'wakil_ICNO', 'wakil_nama', 'wakil_masa_ambil', 'jenis_bayaran'], 'safe'],
            [['siri'], 'number'],
            [['wakil_ICNO'], 'string', 'max' => 12],
            [['siri'], 'string', 'min' => 6, 'max' => 6],
            [['id_kenderaan'], 'integer'],
            [['total'], 'number'],
            [['status_mohon'], 'string', 'max' => 30],
            [['no_siri', 'updater'], 'string', 'max' => 15],
            [['apply_type', 'no_resit'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'status_mohon' => 'Status Permohonan',
            'mohon_date' => 'Tarikh Mohon',
            'app_date' => 'Tarikh Diluluskan',
            'no_siri' => 'No. Siri',
            'no_resit' => 'No. Resit',
            'free' => 'Status Percuma',
            'apply_type' => 'Jenis Permohonan',
            'updater' => 'Pengemaskini',
            'expired_date_1' => 'Tarikh Luput Pelekat',
            'id_kenderaan' => 'Id Kenderaan',
            'total' => 'Harga Pelekat (RM)',
        ];
    }

    public function findPelekat($id) {
        return TblPelekatKenderaan::findOne(['id_kenderaan' => $id]);
    }

    public static function findOwnPelekat($id) {
        return TblPelekatKenderaan::findOne(['id' => $id]);
    }

    public static function findPaymentRate($type) {
        return PayRate::find()->where(['type' => $type])->one();
    }

    public static function findAllPelekat() {
        return TblPelekatKenderaan::find()->joinWith('kenderaan')->where(['stc_sticker_staf.v_co_icno' => Yii::$app->user->getId()])->andWhere(['stc_sticker_staf.status_kenderaan' => 'AKTIF'])->all();
    }

    public function findPelekatDiterima($id) {
        return TblPelekatKenderaan::find()->where(['id_kenderaan' => $id])->andWhere(['status_mohon' => 'DIHANTAR'])->one();
    }

    public function findPelekatMenungguKutipan($id) {
        return TblPelekatKenderaan::find()->where(['id_kenderaan' => $id])->andWhere(['status_mohon' => 'MENUNGGU KUTIPAN'])->one();
    }

    public function getBiodata() {
        return $this->hasOne(\app\models\hronline\tblprcobiodata::className(), ['ICNO' => 'updater']);
    }

    public function getKenderaan() {
        return $this->hasOne(\app\models\esticker\TblStickerStaf::className(), ['id' => 'id_kenderaan']);
    }

    public function getUser() {
        return $this->hasOne(\app\models\esticker\TblStickerStaf::className(), ['id' => 'id_kenderaan']);
    }

    public function getTarikh($date) {
        $record = explode("-", $date);
        $year = $record[1];
        $m = $record[0];
        if ($m == 01) {
            $m = "Januari";
        } elseif ($m == 02) {
            $m = "Februari";
        } elseif ($m == 03) {
            $m = "Mac";
        } elseif ($m == 04) {
            $m = "April";
        } elseif ($m == 05) {
            $m = "Mei";
        } elseif ($m == 06) {
            $m = "Jun";
        } elseif ($m == 07) {
            $m = "Julai";
        } elseif ($m == '08') {
            $m = "Ogos";
        } elseif ($m == '09') {
            $m = "September";
        } elseif ($m == '10') {
            $m = "Oktober";
        } elseif ($m == '11') {
            $m = "November";
        } elseif ($m == '12') {
            $m = "Disember";
        }

        return $m . ' ' . $year;
    }

}
