<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "{{%keselamatan.stc_pekerja_kontraktor}}".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $CONm
 * @property string $COBirthDt
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
 * @property int $id_kontraktor
 * @property string $no_permit
 * @property string $filename_vaksin_pm
 * @property string $filename_sijil_pm
 * @property string $filename_kad_cidb
 */
class TblPekerjaKontraktor extends \yii\db\ActiveRecord {

    public $kt_vaksin_pm;
    public $kt_sijil_pm;
    public $kt_kad_cidb;

    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%keselamatan.stc_pekerja_kontraktor}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['no_permit', 'id_kontraktor', 'ICNO', 'CONm', 'GenderCd', 'COOffTelNo', 'Postcode', 'ReligionCd', 'CountryCd', 'CityCd', 'StateCd', 'Addr1', 'COBirthDt'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['id', 'COBirthDt', 'created_at', 'updated_at'], 'safe'],
            [['id_kontraktor'], 'string', 'max' => 11],
            [['ICNO', 'created_by', 'updated_by'], 'string', 'max' => 12],
            [['CONm'], 'string', 'max' => 150],
            [['GenderCd'], 'string', 'max' => 1],
            [['COOffTelNo', 'Postcode'], 'string', 'max' => 14],
            [['ReligionCd', 'CountryCd', 'CityCd', 'StateCd'], 'string', 'max' => 6],
            [['Addr1', 'Addr2', 'Addr3'], 'string', 'max' => 80],
            [['no_permit'], 'string', 'max' => 12],
            [['kt_vaksin_pm', 'kt_sijil_pm', 'kt_kad_cidb'], 'file', 'extensions' => 'pdf', 'maxSize' => 1024 * 1024 * 2],
            [['filename_vaksin_pm', 'filename_sijil_pm', 'filename_kad_cidb'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ICNO' => 'Icno',
            'CONm' => 'Co Nm',
            'COBirthDt' => 'Co Birth Dt',
            'GenderCd' => 'Gender Cd',
            'COOffTelNo' => 'Co Off Tel No',
            'ReligionCd' => 'Religion Cd',
            'CountryCd' => 'Country Cd',
            'Addr1' => 'Addr1',
            'Addr2' => 'Addr2',
            'Addr3' => 'Addr3',
            'Postcode' => 'Postcode',
            'CityCd' => 'City Cd',
            'StateCd' => 'State Cd',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'id_kontraktor' => 'Id Kontraktor',
            'no_permit' => 'No Permit',
            'filename_vaksin_pm' => 'Filename Vaksin Pm',
            'filename_sijil_pm' => 'Filename Sijil Pm',
            'filename_kad_cidb' => 'Filename Kad Cidb',
        ];
    }

    public function getPegawaiDaftar() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'created_by']);
    }

    public function getPegawaiKemaskini() {
        return $this->hasOne(\app\models\hronline\Tblprcobiodata::className(), ['ICNO' => 'updated_by']);
    }

    public function getAktifSyarikat() {
        $pekerja = TblPekerjaKontraktor::find()->all();
        $arr = array();
        foreach ($pekerja as $pekerja) {
            $aktif = TblKontraktor::find()->where(['is not', 'vw_pelekat_hr.tarikhtamatsah', NULL])->andWhere(['>', 'DATE(vw_pelekat_hr.tarikhtamatsah)', date('Y-m-d')])->andWhere(['apsu_suppid' => $pekerja->id_kontraktor])->one();
            if ($aktif) {
                $arr[] = $pekerja->id;
            }
        }

        return TblPekerjaKontraktor::find()->where(['in', 'id', $arr])->all(); 
    }

    public function getPerkerjaSykNm() {
        $kon = TblKontraktor::findOne(['apsu_suppid'=>$this->id_kontraktor]);
        
        return $this->CONm . ' ( ' . $kon->apsu_lname . ' )';
    }
}
