<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "keselamatan.stc_pelawat".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $CONm
 * @property string $GenderCd
 * @property string $COOffTelNo
 * @property string $ReligionCd
 * @property string $CountryCd
 * @property string $Addr1
 * @property string $Addr2
 * @property string $Addr3
 * @property string $Postcode
 * @property string $CityCd
 * @property string $StateCd 
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class TblPelawat extends \yii\db\ActiveRecord {

    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.stc_pelawat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['CatCd','ICNO', 'CONm', 'GenderCd', 'COOffTelNo', 'Postcode', 'ReligionCd', 'CountryCd', 'CityCd', 'StateCd', 'Addr1', 'COBirthDt'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['ICNO'], 'unique', 'message' => 'No. K/P telah didaftarkan'],
            [['id', 'created_at', 'updated_at'], 'safe'],
            [['ICNO', 'created_by', 'updated_by'], 'string', 'max' => 12],
            [['CONm'], 'string', 'max' => 150],
            [['GenderCd'], 'string', 'max' => 1],
            [['COOffTelNo', 'Postcode'], 'number'],
            [['COOffTelNo', 'Postcode'], 'string', 'max' => 14],
            [['ReligionCd', 'CountryCd', 'CityCd', 'StateCd'], 'string', 'max' => 6],
            [['Addr1', 'Addr2', 'Addr3'], 'string', 'max' => 80],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ICNO' => 'No. K/P',
            'CONm' => 'Nama',
            'COBirthDt' => 'Tarikh Lahir',
            'GenderCd' => 'Jantina',
            'COOffTelNo' => 'No. Telefon Bimbit',
            'ReligionCd' => 'Agama',
            'CountryCd' => 'Warganegara',
            'Addr1' => 'Alamat 1',
            'Addr2' => 'Alamat 2',
            'Addr3' => 'Alamat 3',
            'Postcode' => 'Poskod',
            'CityCd' => 'Bandar',
            'StateCd' => 'Daerah',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public static function findPelawat($id) {
        return TblPelawat::find()->where(['id' => $id])->one();
    }

    public function getPegawaiDaftar() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'created_by']);
    }

    public function getPegawaiKemaskini() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'updated_by']);
    }

    public function getKenderaan() {
        return $this->hasMany(\app\models\esticker\TblStickerPelawat::className(), ['v_co_icno' => 'ICNO']);
    }

    public function checkhasApplied($id) {
        return TblPelekatKenderaanPelawat::find()->where(['id_kenderaan' => $id])->one();
    }

    public function findStickerRate() {
        $max_veh = TblPelekatKenderaan::findPaymentRate('PELAWAT');
        return $max_veh->amount;
    }

}
