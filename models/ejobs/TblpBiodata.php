<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.tbl_biodata".
 *
 * @property string $ICNO
 * @property string $ReligionCd
 * @property string $RaceCd
 * @property string $EthnicCd
 * @property string $ArmyPoliceCd
 * @property string $BloodTypeCd
 * @property string $MrtlStatusCd
 * @property string $TitleCd
 * @property int $HighestEduLevelCd
 * @property string $GenderCd
 * @property string $COBirthPlaceCd
 * @property string $COBirthCountryCd
 * @property string $NatCd
 * @property string $NatStatusCd
 * @property string $CONm
 * @property string $COEmail
 * @property int $COBumiStatus
 * @property string $COBirthCertNo
 * @property string $COBirthDt
 * @property int $CoWeight
 * @property string $CoHeight
 * @property string $COBmiIndex
 * @property string $COBmiLvl
 * @property string $COHPhoneNo
 * @property string $COOffTelNo
 * @property int $Status
 * @property string $last_update
 * @property string $last_updater
 */
class TblpBiodata extends \yii\db\ActiveRecord {

    public $COOldID, $COEmail2, $COHPhoneNo2, $COHPhoneStatus, $ConfermentDt;
    public $KodProgram, $statLantikan, $startDateLantik, $endDateLantik, $gredJawatan, $statSandangan, $ApmtTypeCd, $noWaran, $DeptId, $campus_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ejobs.tbl_biodata';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb() {
        return Yii::$app->get('db7');
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['COBirthDt', 'COBmiLvl', 'COBmiIndex', 'ICNO', 'COEmail', 'HighestEduLevelCd', 'COHPhoneNo', 'TitleCd', 'CONm', 'CoWeight', 'ReligionCd', 'EthnicCd', 'RaceCd', 'CoHeight', 'BloodTypeCd', 'MrtlStatusCd', 'GenderCd', 'NatStatusCd', 'COBirthCountryCd', 'NatCd', 'ArmyPoliceCd', 'COBirthCertNo', 'NegaraAsalCd', 'NegeriAsalCd', 'NegeriAsalIbu', 'NegeriAsalBapa', 'isSabahan'], 'required', 'message' => 'Required'],
            [['HighestEduLevelCd', 'COBumiStatus', 'CoWeight', 'Status'], 'integer'],
            [['CoHeight'], 'number'],
            [['COBirthDt', 'last_update'], 'safe'],
            [['ICNO', 'last_updater'], 'string', 'max' => 12],
            [['ReligionCd', 'RaceCd', 'COBirthPlaceCd'], 'string', 'max' => 2],
            [['EthnicCd', 'TitleCd'], 'string', 'max' => 4],
            [['ArmyPoliceCd', 'BloodTypeCd', 'COBirthCountryCd', 'NatCd'], 'string', 'max' => 3],
            [['MrtlStatusCd', 'GenderCd', 'NatStatusCd'], 'string', 'max' => 1],
            [['CONm'], 'string', 'max' => 255],
            [['COEmail'], 'string', 'max' => 100],
            [['COBirthCertNo'], 'string', 'max' => 15],
            [['COHPhoneNo', 'COOffTelNo'], 'string', 'max' => 14],
            [['ICNO'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'ICNO' => 'Icno',
            'ReligionCd' => 'Religion Cd',
            'RaceCd' => 'Race Cd',
            'EthnicCd' => 'Ethnic Cd',
            'ArmyPoliceCd' => 'Army Police Cd',
            'BloodTypeCd' => 'Blood Type Cd',
            'MrtlStatusCd' => 'Mrtl Status Cd',
            'TitleCd' => 'Title Cd',
            'HighestEduLevelCd' => 'Highest Edu Level Cd',
            'GenderCd' => 'Gender Cd',
            'COBirthPlaceCd' => 'Co Birth Place Cd',
            'COBirthCountryCd' => 'Co Birth Country Cd',
            'NatCd' => 'Nat Cd',
            'NatStatusCd' => 'Nat Status Cd',
            'CONm' => 'Co Nm',
            'COEmail' => 'Co Email',
            'COBumiStatus' => 'Co Bumi Status',
            'COBirthCertNo' => 'Co Birth Cert No',
            'COBirthDt' => 'Co Birth Dt',
            'CoWeight' => 'Co Weight',
            'CoHeight' => 'Co Height',
            'COBmiIndex' => 'Co Bmi Index',
            'COBmiLvl' => 'Co Bmi Lvl',
            'COHPhoneNo' => 'Coh Phone No',
            'COOffTelNo' => 'Co Off Tel No',
            'Status' => 'Status',
            'last_update' => 'Last Update',
            'last_updater' => 'Last Updater',
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['icno' => 'ICNO']);
    }

    public function getPendidikanTertinggi($type) {
        $model = TblpEduHighest::find()->where(['tbl_eduhighest.ICNO' => $this->ICNO])->orderBy(['ConfermentDt' => SORT_DESC])->one();

        if ($model) {
            if ($type == 'id') {
                return $model->HighestEduLevelCd;
            } else {//date
                return $model->ConfermentDt;
            }
        } else {
            return '';
        }
    }

}
