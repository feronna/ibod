<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "keselamatan.stc_pelekat_kenderaan_kontraktor".
 *
 * @property int $id
 * @property int $id_kenderaan
 * @property string $status_mohon
 * @property string $mohon_date
 * @property string $apply_type
 * @property string $no_siri
 * @property string $expired_date
 * @property string $total
 * @property string $updater
 * @property string $app_date
 * @property int $deleted
 * @property string $lesen_no
 * @property string $lesen_exp
 */
class TblPelekatKenderaanKontraktor extends \yii\db\ActiveRecord {

    public $booked;

    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.stc_pelekat_kenderaan_kontraktor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['apply_type','siri','no_resit'], 'required', 'message' => 'Ruang ini adalah mandatori.'],
            [['id_kenderaan', 'deleted'], 'integer'],
            [['booked', 'kod_siri', 'mohon_date', 'expired_date', 'app_date', 'expired_date_2'], 'safe'],
            [['siri'], 'number'],
            [['siri'], 'string', 'min' => 6, 'max' => 6],
            [['total'], 'number'],
            [['status_mohon'], 'string', 'max' => 30],
            [['apply_type','no_resit'], 'string', 'max' => 10],
            [['no_siri', 'updater'], 'string', 'max' => 15],
            [['id_kontraktor'], 'string', 'max' => 11],
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
            'expired_date' => 'Expired Date',
            'total' => 'Total',
            'updater' => 'Updater',
            'app_date' => 'App Date',
            'deleted' => 'Deleted',
        ];
    } 

    public function getKenderaan() {
        return $this->hasOne(\app\models\esticker\TblStickerKontraktor::className(), ['id' => 'id_kenderaan']);
    }

    public static function findAllPelekat($id) {
        $kontraktor = TblStickerKontraktor::findOne(['id' => $id]);
        return TblPelekatKenderaanKontraktor::find()->joinWith('kenderaan')->where(['stc_sticker_kontraktor.id_kontraktor' => $kontraktor->id_kontraktor])->andWhere(['stc_sticker_kontraktor.status_kenderaan' => 'AKTIF'])->all();
    }

    public function getYangBertugas() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'updater']);
    }

    public function getKontraktor() {
        return $this->hasOne(\app\models\esticker\TblKontraktor::className(), ['apsu_suppid' => 'id_kontraktor']);
    }

}
