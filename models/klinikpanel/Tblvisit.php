<?php

namespace app\models\klinikpanel;
use app\models\hronline\Tblkeluarga;
use app\models\hronline\HubunganKeluarga;
use app\models\Klinikpanel\RefDiagnosis;
use Yii;

/**
 * This is the model class for table "klinikpanel2.tblvisit".
 *
 * @property int $rawatan_id
 * @property int $visit_klinik_id
 * @property string $rawatan_date
 * @property string $visit_icno
 * @property string $pesakit_icno
 * @property string $pesakit_name
 * @property int $mc_status
 * @property int $id_max_tuntutan
 * @property string $jum_tuntutan
 * @property string $rawatan
 * @property int $id_visit_status
 * @property string $date_created
 * @property string $id_konsultasi
 * @property int $id_kehadiran
 * @property int $tblvisit_batch_id
 * @property string $tblvisit_catatan
 * @property int $visit_diagnosis_id
 * @property string $bil_log
 */
class Tblvisit extends \yii\db\ActiveRecord
{
    // add the function below:
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myhealth_tblvisit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['visit_klinik_id', 'rawatan_date', 'visit_icno', 'pesakit_icno', 'pesakit_name', 'mc_status', 'rawatan', 'id_visit_status'], 'required'],
            [['visit_klinik_id', 'mc_status', 'id_max_tuntutan', 'id_visit_status', 'id_kehadiran', 'tblvisit_batch_id', 'visit_diagnosis_id'], 'integer'],
            [['rawatan_date', 'date_created'], 'safe'],
            [['jum_tuntutan', 'id_konsultasi'], 'number'],
            [['rawatan', 'tblvisit_catatan'], 'string'],
            [['visit_icno', 'pesakit_icno'], 'string', 'max' => 12],
            [['pesakit_name'], 'string', 'max' => 765],
            [['bil_log'], 'string', 'max' => 7],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rawatan_id' => 'Rawatan ID',
            'visit_klinik_id' => 'Visit Klinik ID',
            'rawatan_date' => 'Tarikh Rawatan',
            'visit_icno' => 'Visit Icno',
            'pesakit_icno' => 'Pesakit Icno',
            'pesakit_name' => 'Nama Pesakit',
            'mc_status' => 'Mc Status',
            'id_max_tuntutan' => 'Id Max Tuntutan',
            'jum_tuntutan' => 'Jumlah Tuntutan (RM)',
            'rawatan' => 'Rawatan',
            'id_visit_status' => 'Id Visit Status',
            'date_created' => 'Date Created',
            'id_konsultasi' => 'Id Konsultasi',
            'id_kehadiran' => 'Id Kehadiran',
            'tblvisit_batch_id' => 'Tblvisit Batch ID',
            'tblvisit_catatan' => 'Tblvisit Catatan',
            'visit_diagnosis_id' => 'Visit Diagnosis ID',
            'bil_log' => 'Bil Log',
        ];
    }
    
    public function getKlinik() {
        return $this->hasOne(RefKlinikpanel::className(), ['klinik_id' => 'visit_klinik_id']);
    }
    
    public function getBaki() {
        return $this->hasOne(Tblmaxtuntutan::className(), ['max_icno' => 'visit_icno']);
    }
    
    public function getKakitangan() {
        return $this->hasOne(Tblmaxtuntutan::className(), ['max_icno' => 'visit_icno']);
    }
    
    public function getKeluarga() {
        return $this->hasOne(Tblkeluarga::className(), ['ICNO' => 'visit_icno'])
                    ->via(HubunganKeluarga::className(),['RelCd' => 'RelCd']);
    }

    public function getAhlikeluarga() {
        return $this->hasOne(Tblkeluarga::className(), ['FamilyId' => 'pesakit_icno']);
    }
    
    public function getUbat(){       
        return $this->hasMany(Tblmedicine::className(), ['med_visit_id' => 'rawatan_id']);        
    } 
    
        public function getDiagnosis()
    {
        return $this->hasOne(RefDiagnosis::className(), ['id_diagonsis' => 'visit_diagnosis_id']);
    }

    public static function familyMember($icno){
        $fmember = [01, 02, 03, 04];
        $keluarga = Tblkeluarga::find()->where(['RelCd' => $fmember,'ICNO' => $icno])->orWhere(['RelCd' => [05,07], 'FmyDisabilityStatus' => 1,'ICNO' => $icno])->orWhere('RelCd in (05,07) and ((DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(FmyBirthDt)), "%Y")+0) < 21) and ICNO = "'.$icno.'"')->andWhere(['IS','FmyDeceaseDt', NULL])->orderBy(['RelCd' => SORT_ASC])->all();

        if($keluarga){
            return $keluarga;
        } else {
            return null;
        }

        
    }
  
    public static function validateFamily($staff_icno, $fmy_icno){
        $fmember = [01, 02, 03, 04, 05, 07];       
        $keluarga = Tblkeluarga::find()->where(['ICNO' => $staff_icno, 'FamilyId'=> $fmy_icno])->andWhere(['RelCd' => $fmember])->one();

        if($keluarga){
            return true;
        }

        return false;
    }
    
    public function getMonth()
    {
        return date('F', strtotime($this->rawatan_date));
    }

    public function getYear()
    {
        return date('Y', strtotime($this->rawatan_date));
    }
}

    
