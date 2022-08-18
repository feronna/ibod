<?php

namespace app\models\Kontraktor;
use app\models\esticker\TblKontraktor;
use Yii;

/**
 * This is the model class for table "keselamatan.utils_syarikat_kontraktor".
 *
 * @property int $id
 * @property string $apsu_suppid
 * @property string $name
 * @property int $apsu_status
 * @property string $apsu_address1
 * @property string $apsu_address2
 * @property string $apsu_address3
 * @property string $apsu_phone
 * @property string $apsu_email
 * @property string $tarikhmula_sah
 * @property string $tarikhtamat_sah
 * @property string $no_pendaftaran
 * @property string $updated_by
 * @property string $updated_at
 * @property int $isActive
 */
class SyarikatKontraktor extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.utils_syarikat_kontraktor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['apsu_status', 'isActive'], 'integer'],
            [['apsu_address1', 'apsu_address2', 'apsu_address3'], 'string'],
            [['tarikhmula_sah', 'tarikhtamat_sah', 'updated_at'], 'safe'],
            [['apsu_suppid', 'apsu_phone', 'jenis_kontrak'], 'string', 'max' => 15],
            [['name'], 'string', 'max' => 150],
            [['apsu_email'], 'string', 'max' => 50],
            [['no_pendaftaran', 'updated_by'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'apsu_suppid' => 'Apsu Suppid',
            'name' => 'Name',
            'apsu_status' => 'Apsu Status',
            'apsu_address1' => 'Apsu Address 1',
            'apsu_address2' => 'Apsu Address 2',
            'apsu_address3' => 'Apsu Address 3',
            'apsu_phone' => 'Apsu Phone',
            'apsu_email' => 'Apsu Email',
            'tarikhmula_sah' => 'Tarikhmula Sah',
            'tarikhtamat_sah' => 'Tarikhtamat Sah',
            'no_pendaftaran' => 'No Pendaftaran',
            'updated_by' => 'Updated By',
            'updated_at' => 'Updated At',
            'isActive' => 'Is Active',
            'jenis_kontrak' => 'Jenis Kontrak',
        ];
    }

    public function getSyarikat() {
        if ($this->jenis_kontrak == '1') {
            return 'Pembinaan';
        }
        if ($this->jenis_kontrak == '2') {
            return 'Kawalan Swasta';
        }

        if ($this->jenis_kontrak == '3') {
            return 'Kafeteria';
        }

        if ($this->jenis_kontrak == '4') {
            return 'Pembekal Lain-lain';
        }

        if ($this->jenis_kontrak == '5') {
            return 'Penyelenggaraan';
        }

        if ($this->jenis_kontrak == '6') {
            return 'Pembersihan';
        }

        if ($this->jenis_kontrak == '7') {
            return 'Landskap';
        }
    }

    public function getJenis() {
        return $this->hasOne(RefKontrakType::className(), ['id' => 'jenis_kontrak']);
    }

    public function getKontraktor() {
        return $this->hasOne(TblKontraktor::className(), ['apsu_suppid' => 'apsu_suppid']);
    }

}
