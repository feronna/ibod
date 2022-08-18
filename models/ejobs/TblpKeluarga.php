<?php

namespace app\models\ejobs;

use Yii;
use app\models\hronline\HubunganKeluarga;
use app\models\hronline\JenisIc;
use app\models\hronline\Gelaran;
use app\models\hronline\Jantina;
use app\models\hronline\StatusPekerjaanAhliKeluarga;
use app\models\hronline\JenisBadanMajikan;
use app\models\hronline\SektorPekerjaan;
use app\models\hronline\Tblkeluarga;

/**
 * This is the model class for table "ejobs.tbl_keluarga".
 *
 * @property int $id
 * @property string $ICNO
 * @property string $FmyDependencyICTypeCd
 * @property string $FamilyId
 * @property string $FmyNm
 * @property string $TitleCd
 * @property string $FmyBirthDt
 * @property string $GenderCd
 * @property int $FmyDisabilityStatus
 * @property string $RelCd
 * @property string $FmyStatusCd
 * @property string $CorpBodyTypeCd
 * @property string $OccSectorCd
 * @property string $FmyEmployerNm
 */
class TblpKeluarga extends \yii\db\ActiveRecord {

    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ejobs.tbl_keluarga';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['ICNO', 'isUms', 'IdTypeCd', 'FmyBirthDt', 'FmyDependencyICTypeCd', 'GenderCd', 'FamilyId', 'FmyNm', 'TitleCd', 'RelCd', 'FmyStatusCd'], 'required', 'message' => 'Required'],
            [['FmyBirthDt', 'FmyEmployerNm', 'FmyStatusCd', 'CorpBodyTypeCd', 'OccSectorCd'], 'safe'],
            [['FmyDisabilityStatus'], 'integer'],
            [['ICNO'], 'string', 'max' => 12],
            [['FmyDependencyICTypeCd', 'GenderCd'], 'string', 'max' => 1],
            [['FamilyId'], 'string', 'max' => 15],
            [['FmyNm'], 'string', 'max' => 80],
            [['TitleCd'], 'string', 'max' => 4],
            [['RelCd', 'FmyStatusCd', 'CorpBodyTypeCd', 'OccSectorCd'], 'string', 'max' => 2],
            [['FmyEmployerNm'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'id',
            'ICNO' => 'Icno',
            'FmyDependencyICTypeCd' => 'Jenis Kad Pengenalan',
            'FamilyId' => 'No. KP',
            'FmyNm' => 'Nama',
            'TitleCd' => 'Gelaran',
            'FmyBirthDt' => 'Tarikh Lahir',
            'GenderCd' => 'Jantina',
            'FmyDisabilityStatus' => 'Status Kecacatan',
            'RelCd' => 'Hubungan Keluarga',
            'FmyStatusCd' => 'Status',
            'CorpBodyTypeCd' => 'Jenis Majikan',
            'OccSectorCd' => 'Sektor Pekerjaan',
            'FmyEmployerNm' => 'Nama Majikan',
        ];
    }

    public function getHubunganKeluarga() {
        return $this->hasOne(HubunganKeluarga::className(), ['RelCd' => 'RelCd']);
    }

    public function getJenisIc() {
        if ($this->TitleCd == NULL) {
            return 0;
        }
        return $this->hasOne(JenisIc::className(), ['ICTypeCd' => 'FmyDependencyICTypeCd']);
    }

    public function getGelaran() {

        if ($this->TitleCd == NULL) {
            return 0;
        }
        return $this->hasOne(Gelaran::className(), ['TitleCd' => 'TitleCd']);
    }

    public function getJantina() {
        return $this->hasOne(Jantina::className(), ['GenderCd' => 'GenderCd']);
    }

    public function getStatusPekerjaan() {
        return $this->hasOne(StatusPekerjaanAhliKeluarga::className(), ['FmyStatusCd' => 'FmyStatusCd']);
    }

    public function getJenisBadanMajikan() {
        return $this->hasOne(JenisBadanMajikan::className(), ['CorpBodyTypeCd' => 'CorpBodyTypeCd']);
    }

    public function getSektorPekerjaan() {
        return $this->hasOne(SektorPekerjaan::className(), ['OccSectorCd' => 'OccSectorCd']);
    }

    public function getDisabilityStatus() {
        if ($this->FmyDisabilityStatus == 1) {
            return 'Yes';
        } else {
            return 'No';
        }
    }

    public function Tarikh($bulan) {

        $m = date_format(date_create($bulan), "m");
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

        return date_format(date_create($bulan), "d") . ' ' . $m . ' ' . date_format(date_create($bulan), "Y");
    }

    public function LaporDiri($ICNO) {
        $model = TblpKeluarga::findAll(['ICNO' => $ICNO]);
        $simpan = new Tblkeluarga();

        if ($model) {
            foreach ($model as $model) {
                if ($model->FamilyId) {
                    $simpan->ICNO = $model->ICNO;
                    $simpan->FamilyId = $model->FamilyId;
                    $simpan->TitleCd = $model->TitleCd;
                    $simpan->FmyStatusCd = $model->FmyStatusCd;
                    $simpan->CorpBodyTypeCd = $model->CorpBodyTypeCd;
                    $simpan->OccSectorCd = $model->OccSectorCd;
                    $simpan->GenderCd = $model->GenderCd;
                    $simpan->RelCd = $model->RelCd;
                    $simpan->FmyNm = $model->FmyNm;
                    $simpan->FmyTelNo = $model->FmyTelNo;
                    $simpan->FmyBirthDt = $model->FmyBirthDt;
                    $simpan->FmyMarriageCertNo = $model->FmyBirthCertNo;
                    $simpan->FmyEmployerNm = $model->FmyEmployerNm;
                    $simpan->FmyDisabilityStatus = $model->FmyDisabilityStatus;
                    $simpan->FmyDependencyICTypeCd = $model->FmyDependencyICTypeCd;
                    $simpan->isUms = $model->isUms;
                    $simpan->IdTypeCd = $model->IdTypeCd;
                    $simpan->save(false);
                }
            }
        }
    }

}
