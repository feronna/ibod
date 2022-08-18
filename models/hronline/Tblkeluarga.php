<?php

namespace app\models\hronline;

use Yii;
use app\models\hronline\HubunganKeluarga;
use app\models\hronline\JenisIc;
use app\models\hronline\Gelaran;
use app\models\hronline\TempatLahir;
use app\models\hronline\Jantina;
use app\models\hronline\Agama;
use app\models\hronline\Bangsa;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\Warganegara;
use app\models\hronline\TarafPerkahwinan;
use app\models\hronline\StatusWarganegara;
use app\models\hronline\JenisTanggungan;
use app\models\hronline\StatusPekerjaanAhliKeluarga;
use app\models\hronline\JenisBadanMajikan;
use app\models\hronline\SektorPekerjaan;
use app\models\hronline\Negara;
use app\models\hronline\Negeri;
use app\models\hronline\Bandar;
use app\models\hronline\Tblfmydisability;
use app\models\hronline\IdType;
use app\models\hronline\Tblprfmydisease;
use DateTime;

//audit trail
use app\models\hronline\Updatestatus;
use app\models\hronline\Tblstat;
use phpDocumentor\Reflection\Types\This;
use PhpOffice\PhpSpreadsheet\Shared\Date;

/**
 * This is the model class for table "hronline.tblprfmy".
 *
 * @property string $ICNO
 * @property string $FamilyId
 * @property string $StaffUms
 * @property string $TitleCd
 * @property string $ReligionCd
 * @property string $MrtlStatusCd
 * @property string $RaceCd
 * @property string $FmyStatusCd
 * @property string $CorpBodyTypeCd
 * @property string $OccSectorCd
 * @property string $HighestEduLevelCd
 * @property string $GenderCd
 * @property string $CountryCd
 * @property string $NatCd
 * @property string $StateCd
 * @property string $FmyBirthPlaceCd
 * @property string $CityCd
 * @property string $RelCd
 * @property string $NatStatusCd
 * @property string $FmyNm
 * @property string $FmyMomNm
 * @property string $FmyTelNo
 * @property string $FmyBirthDt
 * @property int $FmyTwinStatus
 * @property string $FmyMarriageDt
 * @property string $FmyMarriageCertNo
 * @property string $FmyDeceaseDt
 * @property int $FmyBumiStatus
 * @property string $FmyDivorceDt
 * @property string $FmyEmployerNm
 * @property int $FmyDisabilityStatus
 * @property int $FmyDependencyStatus
 * @property string $FmyAddr1
 * @property string $FmyAddr2
 * @property string $FmyAddr3
 * @property string $FmyPostcode
 * @property int $FmyNextOfKinStatus
 * @property int $FmyEmerContactStatus
 * @property int $FmyPensionRecipient
 * @property int $ChildReliefInd
 * @property string $FmyEmailAddr
 * @property string $FmyDependencyCd
 * @property string $FmyDependencyICTypeCd
 * @property string $FmyBirthCertNo
 * @property string $FmyPassportNo
 * @property int $id
 */
class Tblkeluarga extends \yii\db\ActiveRecord {

    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public static function tableName() {
        return 'hronline.tblprfmy';
    }

    public function rules() {
        return [
            //[['FamilyId', 'RelCd', 'FmyNm', 'TitleCd', 'FmyDependencyICTypeCd', 'GenderCd', 'ReligionCd', 'RaceCd', 'NatStatusCd', 'MrtlStatusCd', 'NatCd', 'FmyAddr1', 'CountryCd', 'StateCd', 'CityCd', 'FmyPostcode', 'FmyStatusCd'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['FamilyId', 'RelCd', 'FmyNm', 'TitleCd','IdTypeCd', 'GenderCd', 'ReligionCd', 'RaceCd', 'NatStatusCd', 'MrtlStatusCd', 'NatCd', 'FmyAddr1', 'CountryCd', 'StateCd', 'CityCd', 'FmyPostcode', 'FmyStatusCd'], 'required', 'message' => 'Ruang ini adalah mandatori'],

            [['FmyBirthDt', 'FmyMarriageDt', 'FmyDeceaseDt', 'FmyDivorceDt'], 'safe'],
            [['FmyTwinStatus', 'FmyBumiStatus', 'FmyDisabilityStatus', 'FmyDependencyStatus', 'FmyNextOfKinStatus', 'FmyEmerContactStatus', 'FmyPensionRecipient', 'ChildReliefInd', 'StaffUms'], 'integer'],
            [['ICNO', 'FmyPostcode'], 'string', 'max' => 12],
            [['FamilyId', 'FmyBirthCertNo', 'FmyPassportNo'], 'string', 'max' => 15],
            [['TitleCd', 'FmyDependencyCd'], 'string', 'max' => 4],
            [['ReligionCd', 'RaceCd', 'FmyStatusCd', 'CorpBodyTypeCd', 'OccSectorCd', 'StateCd', 'FmyBirthPlaceCd', 'RelCd'], 'string', 'max' => 2],
            [['MrtlStatusCd', 'GenderCd', 'NatStatusCd', 'FmyDependencyICTypeCd'], 'string', 'max' => 1],
            [['HighestEduLevelCd', 'CountryCd', 'NatCd'], 'string', 'max' => 3],
            [['CityCd'], 'string', 'max' => 6],
            [['FmyNm', 'FmyMomNm'], 'string', 'max' => 80],
            [['FmyTelNo'], 'string', 'max' => 14],
            [['FmyMarriageCertNo'], 'string', 'max' => 20],
            [['FmyEmployerNm'], 'string', 'max' => 150],
            [['FmyAddr1', 'FmyAddr2', 'FmyAddr3'], 'string', 'max' => 50],
            [['FmyEmailAddr'], 'string', 'max' => 30],
            //[['FamilyId'], 'unique','targetAttribute'=>['ICNO'], 'message' => 'Nombor IC sudah wujud!'],
            [['isUms'], 'integer'],
            [['ICNO', 'RelCd'], 'unique', 'targetAttribute'=>['ICNO', 'RelCd'], 'message'=>'Tidak boleh lebih dari satu(1) Ibu/Bapa','when' => function($model) {
                return $model->RelCd == '03' || $model->RelCd == '04';
            }],
            [['IdTypeCd'], 'integer'],
            [['chronic_disease', 'allergic'], 'integer'],
            // [['chronic_disease', 'allergic', 'MySJ_ID'], 'required','message' => 'Ruang ini adalah mandatori', 'when' => function($model){
            //     return  $model->NatStatusCd == 1;
            // } ,'enableClientValidation' => false],
            // [['chronic_disease', 'allergic', 'MySJ_ID'], 'custom_function_validation', 'on' => 'baru'],
            [['MySJ_ID'], 'string', 'max'=> 50],
            ['FamilyId', 'match','pattern'=>'/^[a-zA-Z0-9]+$/', 'message'=>'Only alphabets & numbers are allowed. White space & special characters are not allowed.'],
        ];
    }

    public function attributeLabels() {
        return [
            'ICNO' => 'Icno',
            'FamilyId' => 'Family ID',
            'TitleCd' => 'Title Cd',
            'ReligionCd' => 'Religion Cd',
            'MrtlStatusCd' => 'Mrtl Status Cd',
            'RaceCd' => 'Race Cd',
            'FmyStatusCd' => 'Fmy Status Cd',
            'CorpBodyTypeCd' => 'Corp Body Type Cd',
            'OccSectorCd' => 'Occ Sector Cd',
            'HighestEduLevelCd' => 'Highest Edu Level Cd',
            'GenderCd' => 'Gender Cd',
            'CountryCd' => 'Country Cd',
            'NatCd' => 'Nat Cd',
            'StateCd' => 'State Cd',
            'FmyBirthPlaceCd' => 'Fmy Birth Place Cd',
            'CityCd' => 'City Cd',
            'RelCd' => 'Rel Cd',
            'NatStatusCd' => 'Nat Status Cd',
            'FmyNm' => 'Fmy Nm',
            'FmyMomNm' => 'Fmy Mom Nm',
            'FmyTelNo' => 'Fmy Tel No',
            'FmyBirthDt' => 'Fmy Birth Dt',
            'FmyTwinStatus' => 'Fmy Twin Status',
            'FmyMarriageDt' => 'Fmy Marriage Dt',
            'FmyMarriageCertNo' => 'Fmy Marriage Cert No',
            'FmyDeceaseDt' => 'Fmy Decease Dt',
            'FmyBumiStatus' => 'Fmy Bumi Status',
            'FmyDivorceDt' => 'Fmy Divorce Dt',
            'FmyEmployerNm' => 'Fmy Employer Nm',
            'FmyDisabilityStatus' => 'Fmy Disability Status',
            'FmyDependencyStatus' => 'Fmy Dependency Status',
            'FmyAddr1' => 'Fmy Addr1',
            'FmyAddr2' => 'Fmy Addr2',
            'FmyAddr3' => 'Fmy Addr3',
            'FmyPostcode' => 'Fmy Postcode',
            'FmyNextOfKinStatus' => 'Fmy Next Of Kin Status',
            'FmyEmerContactStatus' => 'Fmy Emer Contact Status',
            'FmyPensionRecipient' => 'Fmy Pension Recipient',
            'ChildReliefInd' => 'Child Relief Ind',
            'FmyEmailAddr' => 'Fmy Email Addr',
            'FmyDependencyCd' => 'Fmy Dependency Cd',
            'FmyDependencyICTypeCd' => 'Fmy Dependency Ictype Cd',
            'FmyBirthCertNo' => 'Fmy Birth Cert No',
            'FmyPassportNo' => 'Fmy Passport No',
            'id' => 'ID',
        ];
    }

    public function custom_function_validation($attributes){
        
        if($this->NatStatusCd == 1){
            $this->addError($attributes,'wajib isi penyakit');
        }        
    }

    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'ICNO']);
    }
    public function getDisabilities() {
        return $this->hasMany(Tblfmydisability::className(), ['tblfmy_id' => 'id']);
    }

    public function getHubunganKeluarga() {
        return $this->hasOne(HubunganKeluarga::className(), ['RelCd' => 'RelCd']);
    }

    public function getJenisIc() {
        return $this->hasOne(JenisIc::className(), ['ICTypeCd' => 'FmyDependencyICTypeCd']);
    }

    public function getGelaran() {
        return $this->hasOne(Gelaran::className(), ['TitleCd' => 'TitleCd']);
    }

    public function getTempatLahir() {
        return $this->hasOne(TempatLahir::className(), ['StateCd' => 'StateCd']);
    }

    public function getJantina() {
        return $this->hasOne(Jantina::className(), ['GenderCd' => 'GenderCd']);
    }

    public function getAgama() {
        return $this->hasOne(Agama::className(), ['ReligionCd' => 'ReligionCd']);
    }

    public function getBangsa() {
        return $this->hasOne(Bangsa::className(), ['RaceCd' => 'RaceCd']);
    }

    public function getPendidikanTertinggi() {
        return $this->hasOne(PendidikanTertinggi::className(), ['HighestEduLevelCd' => 'HighestEduLevelCd']);
    }

    public function getWarganegara() {
        return $this->hasOne(Warganegara::className(), ['CountryCd' => 'NatCd']);
    }

    public function getTarafPerkahwinan() {
        return $this->hasOne(TarafPerkahwinan::className(), ['MrtlStatusCd' => 'MrtlStatusCd']);
    }

    public function getStatusWarganegara() {
        return $this->hasOne(StatusWarganegara::className(), ['NatStatusCd' => 'NatStatusCd']);
    }

    public function getJenisTanggungan() {
        return $this->hasOne(JenisTanggungan::className(), ['DependencyCd' => 'FmyDependencyCd']);
    }

    public function getStatusPekerjaanAhliKeluarga() {
        return $this->hasOne(StatusPekerjaanAhliKeluarga::className(), ['FmyStatusCd' => 'FmyStatusCd']);
    }

    public function getJenisBadanMajikan() {
        return $this->hasOne(JenisBadanMajikan::className(), ['CorpBodyTypeCd' => 'CorpBodyTypeCd']);
    }

    public function getSektorPekerjaan() {
        return $this->hasOne(SektorPekerjaan::className(), ['OccSectorCd' => 'OccSectorCd']);
    }

    public function getNegara() {
        return $this->hasOne(Negara::className(), ['CountryCd' => 'CountryCd']);
    }

    public function getNegeri() {
        return $this->hasOne(Negeri::className(), ['StateCd' => 'StateCd']);
    }

    public function getBandar() {
        return $this->hasOne(Bandar::className(), ['CityCd' => 'CityCd']);
    }
    public function getIdType() {
        return $this->hasOne(IdType::className(), ['IdTypeCd' => 'IdTypeCd']);
    }
    public function getFamilyDisease() {
        return $this->hasMany(Tblprfmydisease::className(), ['FamilyId' => 'FamilyId']);
    }



    ////display function
    public function getHubkeluarga() {
        if ($this->hubunganKeluarga) {
            return $this->hubunganKeluarga->RelNm;
        }
        return '-';
    }

    public function getJenIc() {
        if ($this->jenisIc) {
            return $this->jenisIc->ICType;
        }
        return 'Tidak Berkaitan';
    }

    public function getGel() {
        if ($this->gelaran) {
            return $this->gelaran->Title;
        }
        return '-';
    }

    public function getFmyPassportNo() {
        if ($this->FmyPassportNo) {
            return $this->FmyPassportNo;
        }
        return '-';
    }

    public function getFmyBirthCertNo() {
        if ($this->FmyBirthCertNo) {
            return $this->FmyBirthCertNo;
        }
        return '-';
    }

    public function getTemlahir() {
        if ($this->tempatLahir) {
            return $this->tempatLahir->State;
        }
        return '-';
    }

    public function getJan() {
        if ($this->jantina) {
            return $this->jantina->Gender;
        }
        return '-';
    }

    public function getAga() {
        if ($this->agama) {
            return $this->agama->Religion;
        }
        return '-';
    }

    public function getBang() {
        if ($this->bangsa) {
            return $this->bangsa->Race;
        }
        return '-';
    }

    public function getPentertinggi() {
        if ($this->pendidikanTertinggi) {
            return $this->pendidikanTertinggi->HighestEduLevel;
        }
        return '-';
    }

    public function getWarneg() {
        if ($this->warganegara) {
            return $this->warganegara->Country;
        }
        return '-';
    }

    public function getFmyMomNm() {
        if ($this->FmyMomNm) {
            return $this->FmyMomNm;
        }
        return '-';
    }

    public function getStaperkahwinan() {
        if ($this->tarafPerkahwinan) {
            return $this->tarafPerkahwinan->MrtlStatus;
        }
        return '-';
    }

    public function getTwinsta() {
        if ($this->FmyTwinStatus) {
            return 'Ada';
        }
        return 'Tidak ada';
    }

    public function getStawarneg() {
        if ($this->statusWarganegara) {
            return $this->statusWarganegara->NatStatus;
        }
        return '-';
    }

    public function getFmybumista() {
        if ($this->FmyBumiStatus) {
            return 'Bumiputera';
        }
        return 'Bukan Bumiputera';
    }

    public function getfmydissta() {
        if ($this->FmyDisabilityStatus) {
            return 'Ada kecacatan';
        }
        return 'Tidak Cacat';
    }

    public function getFmydepsta() {
        if ($this->FmyDependencyStatus) {
            return 'Tanggungan';
        }
        return 'Bukan tanggungan';
    }

    public function getJentang() {
        if ($this->jenisTanggungan) {
            return $this->jenisTanggungan->DependencyNm;
        }
        return 'Tidak Berkaitan';
    }

    public function getPelcukai() {
        if ($this->ChildReliefInd) {
            return 'Ya';
        }
        return 'Tidak';
    }

    public function getTarkematian() {
        if ($this->getFilTarikh($this->FmyDeceaseDt)) {
            return Yii::$app->MP->Tarikh($this->FmyDeceaseDt);
        }
        return 'Tidak Berkaitan';
    }

    public function getStapekahlkel() {
        if ($this->statusPekerjaanAhliKeluarga) {
            return $this->statusPekerjaanAhliKeluarga->FmyStatus;
        }
        return '-';
    }

    public function getTarperkahwinan() {
        if ($this->getFilTarikh($this->FmyMarriageDt)) {
            return Yii::$app->MP->Tarikh($this->FmyMarriageDt);
        }
        return 'Tidak Berkaitan';
    }

    public function getFmyDivorceDt() {
        if ($this->getFilTarikh($this->FmyDivorceDt)) {
            return Yii::$app->MP->Tarikh($this->FmyDivorceDt);
        }
        return 'Tidak Berkaitan';
    }

    public function getFmyBirthDt() {
        if ($this->FmyBirthDt) {
            return Yii::$app->MP->Tarikh($this->FmyBirthDt);
        }
        return 'Tidak Berkaitan';
    }

    public function getFmyEmployerNm() {
        if ($this->FmyEmployerNm) {
            return $this->FmyEmployerNm;
        }
        return '-';
    }

    public function getJenmajikan() {
        if ($this->jenisBadanMajikan) {
            return $this->jenisBadanMajikan->CorpBodyType;
        }
        return 'Tidak Berkaitan';
    }

    public function getSekpekerjaan() {
        if ($this->sektorPekerjaan) {
            return $this->sektorPekerjaan->OccSector;
        }
        return '-';
    }

    public function getNega() {
        if ($this->negara) {
            return $this->negara->Country;
        }
        return '-';
    }

    public function getNege() {
        if ($this->negeri) {
            return $this->negeri->State;
        }
        return '-';
    }

    public function getBand() {
        if ($this->bandar) {
            return $this->bandar->City;
        }
        return '-';
    }

    public function getFmyTelNo() {
        if ($this->FmyTelNo) {
            return $this->FmyTelNo;
        }
        return '-';
    }

    public function getFmyEmerContactStatus() {
        if ($this->FmyEmerContactStatus) {
            return 'Ya';
        }
        return 'Tidak';
    }

    public function getFmyEmailAddr() {
        if ($this->FmyEmailAddr) {
            return $this->FmyEmailAddr;
        }
        return '-';
    }

    public function getFmyNextOfKinStatus() {
        if ($this->FmyNextOfKinStatus) {
            return 'Pewaris';
        }
        return 'Bukan pewaris';
    }

    public function getFmyPensionRecipient() {
        if ($this->FmyPensionRecipient) {
            return 'Penerima Pencen';
        }
        return 'Bukan penerima';
    }

    public function getFilTarikh($d) {
        if ($d == 0000 - 00 - 00) {
            return null;
        }
        return $d;
    }

    //log for Create, update or delete data.
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $changes = [];
        $tempObj = self::findOne(['id' => $this->id]);
        $attrib = $this->activeAttributes();

        switch ($insert) {
            case (false):
                $activity = 1;
                for ($i = 0; $i < count($attrib); $i++) {

                    if ($tempObj->{$attrib[$i]} != $this->{$attrib[$i]}) {
                        array_push($changes, [$attrib[$i], $tempObj->{$attrib[$i]}, $this->{$attrib[$i]}]);
                    }
                }

                break;

            default:
                //aftersave will handle it
                break;
        }
        if (count($changes) > 0) {
            //log activity to updatestatus table
            $log = new Updatestatus();
            $log->usern = $tempObj->ICNO;//Yii::$app->user->getId();
            $log->COTableName = $this->tableName();
            $log->COActivity = $activity;
            $log->COUpadteDate = date('Y-m-d H:i:s');
            $log->COUpdateIP = Yii::$app->request->getRemoteIP();
            $log->COUpdateComp = Yii::$app->request->getUserHost() ? Yii::$app->request->getUserHost() : Yii::$app->request->getRemoteIP();
            $log->COUpdateCompUser = Yii::$app->user->getId();
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);
            
                //save to tbl_stat
                $stat = Tblstat::find()->where(['ICNO' => $this->ICNO, 'table' => $this->tableName(), 'idval' => $this->id])->one();
                if ($stat == null) {
                    $stat = new Tblstat();
                    $stat->ICNO = $this->ICNO;
                    $stat->table = $this->tableName();
                    $stat->idval = $this->id;
                }
                $stat->status = 1;
                $stat->date_submit = date('Y-m-d H:i:s');
                $stat->save(false);

                Yii::$app->MP->BiodataLastUpdate($this->ICNO);
        }

        return true;
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            //save to tbl_stat
            $stat = new Tblstat();
            $stat->ICNO = $this->ICNO;
            $stat->table = $this->tableName();
            $stat->idval = $this->id;
            $stat->status = 0;
            $stat->date_submit = date('Y-m-d H:i:s');
            $stat->save(false);

            $changes = [];
            //$tempObj = self::findOne(['id' => $this->id]);
            $attrib = $this->activeAttributes();
            $activity = 0;

            for ($i = 0; $i < count($attrib); $i++) {
                array_push($changes, [$attrib[$i], $this->{$attrib[$i]}]);
            }

            $log = new Updatestatus();
            $log->usern = $this->ICNO; //Yii::$app->user->getId();
            $log->COTableName = $this->tableName();
            $log->COActivity = $activity;
            $log->COUpadteDate = date('Y-m-d H:i:s');
            $log->COUpdateIP = Yii::$app->request->getRemoteIP();
            $log->COUpdateComp = Yii::$app->request->getRemoteIP();
            $log->COUpdateCompUser = Yii::$app->user->getId();
            $log->COUpdateSQL = serialize($changes);
            $log->idval = $this->id;
            $log->save(false);

            Yii::$app->MP->BiodataLastUpdate($this->ICNO);
        }

        return true;
    }

    public function beforeDelete() {
        if (!parent::beforeDelete()) {
            return false;
        }

        $changes = [];

        //get list of attributes
        $attrib = $this->activeAttributes();

        for ($i = 0; $i < count($attrib); $i++) {
            array_push($changes, array($attrib[$i], $this->{$attrib[$i]}));
        }
        //log activity to updatestatus table
        $log = new Updatestatus();
        $log->usern = $this->ICNO;
        $log->COTableName = $this->tableName();
        $log->COActivity = 2;
        $log->COUpadteDate = date('Y-m-d H:i:s');
        $log->COUpdateIP = Yii::$app->request->getRemoteIP();
        $log->COUpdateComp = Yii::$app->request->getRemoteIP();
        $log->COUpdateCompUser = Yii::$app->user->getId();
        $log->COUpdateSQL = serialize($changes);
        $log->save(false);
        $stat = Tblstat::find()->where(['ICNO' => $this->ICNO, 'table' => $this->tableName(), 'idval' => $this->id])->one();
        if ($stat == null)
            return true;

        $stat->delete();

        return true;
    }

    public function afterDelete(){
        
        //--biodata last update--//
        Yii::$app->MP->BiodataLastUpdate($this->ICNO);

        parent::afterDelete();
    }

    public function getUppercase() {
        return strtoupper($this->FmyNm);
    }
    //count jumlah keluarga 
     public static function jumlahkeluarga($icno){
        return Tblkeluarga::find()->where(['ICNO' => $icno])->count();
    }

    public function isDecease(){
        if($this->FmyDeceaseDt != null && $this->FmyDeceaseDt != '0000-00-00' && $this->FmyDeceaseDt < date('Y-m-d')){
            return true;
        }
        return false;
    }

}
