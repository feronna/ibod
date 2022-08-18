<?php

namespace app\models\hronline;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblprcobiodata;
use app\models\cuti\AksesPengguna;

/**
 * TblprcobiodataSearch represents the model behind the search form of `app\models\hornline\Tblprcobiodata`.
 */
class TblprcobiodataSearch extends Tblprcobiodata
{

    /**
     * {@inheritdoc}
     */

    public $jawatanID; //myidp

    //biodata//
    public $jenis_carian = '0';
    public $carian_data;
    public $carian_kategorijawatan;
    public $carian_programpengajaran;
    public $carian_jenis_lantikan;
    public $carian_sumber_peruntukan;
    public $carian_status_kontrak;
    public $carian_status_warga;
    public $carian_kodprogram;
    public $program_vaksinasi = 0;
    public $klasifikasi_id;

    public function rules()
    {
        return [
            [['ICNO', 'ReligionCd', 'RaceCd', 'EthnicCd', 'ArmyPoliceCd', 'BloodTypeCd', 'MrtlStatusCd', 'TitleCd', 'ConfermentDt', 'GenderCd', 'COBirthPlaceCd', 'COBirthCountryCd', 'NegaraAsalCd', 'NegeriAsalCd', 'NatCd', 'NatStatusCd', 'CONm', 'COEmail', 'COEmail2', 'COOldID', 'COBirthCertNo', 'COBirthDt', 'COHPhoneNo', 'COOffTelNo', 'COOffTelNoExtn', 'COOffTelNoExtn2', 'COOPass', 'COHPhoneStatus', 'startDateLantik', 'endDateLantik', 'startDateStatus', 'startDateSandangan', 'endDateSandangan', 'gredJawatan_2', 'startDateSandangan_2', 'endDateSandangan_2', 'jawatanTadbir', 'last_update', 'last_updater', 'last_login', 'pp', 'bos', 'program_ums', 'kemaskini_terakhir', 'tarikh_sah'], 'safe'],
            [['HighestEduLevelCd', 'COBumiStatus', 'COOIsNew', 'accessLevel', 'accessSecondLevel', 'DeptId', 'campus_id', 'statLantikan', 'Status', 'noWaran', 'gredJawatan', 'statSandangan', 'statSandangan_2', 'ApmtTypeCd', 'DeptId_hakiki', 'campus_id_hakiki', 'KodProgram', 'sah_keluarga', 'sah_alamat', 'sah_notel', 'sah_statuskahwin', 'sah_emel', 'sah_akademik', 'sah_agama', 'sah_passport', 'showposition'], 'integer'],
            [['jawatanID'], 'safe'],
            [[
                'carian_kategorijawatan', 'carian_programpengajaran', 'jenis_carian', 'carian_data', 'carian_kodprogram',
                'carian_jenis_lantikan', 'carian_sumber_peruntukan', 'carian_status_kontrak', 'carian_status_warga', 'klasifikasi_id'
            ], 'safe'],
            [['program_vaksinasi'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Tblprcobiodata::find();
        //        $query->with('department');
        // add conditions that should always apply here
        $this->load($params);
        $deparment = $this->DeptId;

        $icno = Yii::$app->user->getId();

        $akses = AksesPengguna::findOne(['akses_cuti_icno' => $icno]);

        //teda akses
        if (!$akses) {
            $query->where('0=1');
        } else if ($akses->akses_cuti_int == 2) {

            $arr = array();
            $akses_model = AksesPengguna::findAll(['akses_cuti_icno' => $icno]);

            foreach ($akses_model as $r) {
                $arr[] = $r->akses_jspiu_id;
            }

            $deparment = $arr;
        } else if ($akses->akses_cuti_int == 3) {
            $deparment = $this->DeptId;
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);



        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'HighestEduLevelCd' => $this->HighestEduLevelCd,
            'ConfermentDt' => $this->ConfermentDt,
            'COBumiStatus' => $this->COBumiStatus,
            'COBirthDt' => $this->COBirthDt,
            'COOIsNew' => $this->COOIsNew,
            'accessLevel' => $this->accessLevel,
            'accessSecondLevel' => $this->accessSecondLevel,
            'DeptId' => $deparment,
            'campus_id' => $this->campus_id,
            'statLantikan' => $this->statLantikan,
            'startDateLantik' => $this->startDateLantik,
            'endDateLantik' => $this->endDateLantik,
            //            'Status' => $this->Status,
            'Status' => 1,
            'startDateStatus' => $this->startDateStatus,
            'noWaran' => $this->noWaran,
            'gredJawatan' => $this->gredJawatan,
            'statSandangan' => $this->statSandangan,
            'startDateSandangan' => $this->startDateSandangan,
            'endDateSandangan' => $this->endDateSandangan,
            'statSandangan_2' => $this->statSandangan_2,
            'startDateSandangan_2' => $this->startDateSandangan_2,
            'endDateSandangan_2' => $this->endDateSandangan_2,
            'ApmtTypeCd' => $this->ApmtTypeCd,
            'last_update' => $this->last_update,
            'last_login' => $this->last_login,
            'DeptId_hakiki' => $this->DeptId_hakiki,
            'campus_id_hakiki' => $this->campus_id_hakiki,
            'KodProgram' => $this->KodProgram,
            'kemaskini_terakhir' => $this->kemaskini_terakhir,
            'sah_keluarga' => $this->sah_keluarga,
            'sah_alamat' => $this->sah_alamat,
            'sah_notel' => $this->sah_notel,
            'sah_statuskahwin' => $this->sah_statuskahwin,
            'sah_emel' => $this->sah_emel,
            'sah_akademik' => $this->sah_akademik,
            'sah_agama' => $this->sah_agama,
            'sah_passport' => $this->sah_passport,
            'tarikh_sah' => $this->tarikh_sah,
            'showposition' => $this->showposition,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'ReligionCd', $this->ReligionCd])
            ->andFilterWhere(['like', 'RaceCd', $this->RaceCd])
            ->andFilterWhere(['like', 'EthnicCd', $this->EthnicCd])
            ->andFilterWhere(['like', 'ArmyPoliceCd', $this->ArmyPoliceCd])
            ->andFilterWhere(['like', 'BloodTypeCd', $this->BloodTypeCd])
            ->andFilterWhere(['like', 'MrtlStatusCd', $this->MrtlStatusCd])
            ->andFilterWhere(['like', 'TitleCd', $this->TitleCd])
            ->andFilterWhere(['like', 'GenderCd', $this->GenderCd])
            ->andFilterWhere(['like', 'COBirthPlaceCd', $this->COBirthPlaceCd])
            ->andFilterWhere(['like', 'COBirthCountryCd', $this->COBirthCountryCd])
            ->andFilterWhere(['like', 'NegaraAsalCd', $this->NegaraAsalCd])
            ->andFilterWhere(['like', 'NegeriAsalCd', $this->NegeriAsalCd])
            ->andFilterWhere(['like', 'NatCd', $this->NatCd])
            ->andFilterWhere(['like', 'NatStatusCd', $this->NatStatusCd])
            ->andFilterWhere(['like', 'CONm', $this->CONm])
            ->andFilterWhere(['like', 'COEmail', $this->COEmail])
            ->andFilterWhere(['like', 'COEmail2', $this->COEmail2])
            ->andFilterWhere(['like', 'COOldID', $this->COOldID])
            ->andFilterWhere(['like', 'COBirthCertNo', $this->COBirthCertNo])
            ->andFilterWhere(['like', 'COHPhoneNo', $this->COHPhoneNo])
            ->andFilterWhere(['like', 'COOffTelNo', $this->COOffTelNo])
            ->andFilterWhere(['like', 'COOffTelNoExtn', $this->COOffTelNoExtn])
            ->andFilterWhere(['like', 'COOffTelNoExtn2', $this->COOffTelNoExtn2])
            ->andFilterWhere(['like', 'COOPass', $this->COOPass])
            ->andFilterWhere(['like', 'COHPhoneStatus', $this->COHPhoneStatus])
            ->andFilterWhere(['like', 'gredJawatan_2', $this->gredJawatan_2])
            ->andFilterWhere(['like', 'jawatanTadbir', $this->jawatanTadbir])
            ->andFilterWhere(['like', 'last_updater', $this->last_updater])
            ->andFilterWhere(['like', 'pp', $this->pp])
            ->andFilterWhere(['like', 'bos', $this->bos])
            ->andFilterWhere(['like', 'program_ums', $this->program_ums]);

        return $dataProvider;
    }

    public function searchstaff($params) //myidp
    {
        $query = Tblprcobiodata::find()
            ->joinWith('jawatan')
            ->where(['<>', 'Status', '6']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'HighestEduLevelCd' => $this->HighestEduLevelCd,
            'ConfermentDt' => $this->ConfermentDt,
            'COBumiStatus' => $this->COBumiStatus,
            'COBirthDt' => $this->COBirthDt,
            'COOIsNew' => $this->COOIsNew,
            'accessLevel' => $this->accessLevel,
            'accessSecondLevel' => $this->accessSecondLevel,
            'DeptId' => $this->DeptId,
            'campus_id' => $this->campus_id,
            'statLantikan' => $this->statLantikan,
            'startDateLantik' => $this->startDateLantik,
            'endDateLantik' => $this->endDateLantik,
            'Status' => $this->Status,
            'startDateStatus' => $this->startDateStatus,
            'noWaran' => $this->noWaran,
            'gredJawatan' => $this->gredJawatan,
            'statSandangan' => $this->statSandangan,
            'startDateSandangan' => $this->startDateSandangan,
            'endDateSandangan' => $this->endDateSandangan,
            'statSandangan_2' => $this->statSandangan_2,
            'startDateSandangan_2' => $this->startDateSandangan_2,
            'endDateSandangan_2' => $this->endDateSandangan_2,
            'ApmtTypeCd' => $this->ApmtTypeCd,
            'last_update' => $this->last_update,
            'last_login' => $this->last_login,
            'DeptId_hakiki' => $this->DeptId_hakiki,
            'campus_id_hakiki' => $this->campus_id_hakiki,
            'KodProgram' => $this->KodProgram,
            'kemaskini_terakhir' => $this->kemaskini_terakhir,
            'sah_keluarga' => $this->sah_keluarga,
            'sah_alamat' => $this->sah_alamat,
            'sah_notel' => $this->sah_notel,
            'sah_statuskahwin' => $this->sah_statuskahwin,
            'sah_emel' => $this->sah_emel,
            'sah_akademik' => $this->sah_akademik,
            'sah_agama' => $this->sah_agama,
            'sah_passport' => $this->sah_passport,
            'tarikh_sah' => $this->tarikh_sah,
            'showposition' => $this->showposition,
            'id' => $this->jawatanID,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'ReligionCd', $this->ReligionCd])
            ->andFilterWhere(['like', 'RaceCd', $this->RaceCd])
            ->andFilterWhere(['like', 'EthnicCd', $this->EthnicCd])
            ->andFilterWhere(['like', 'ArmyPoliceCd', $this->ArmyPoliceCd])
            ->andFilterWhere(['like', 'BloodTypeCd', $this->BloodTypeCd])
            ->andFilterWhere(['like', 'MrtlStatusCd', $this->MrtlStatusCd])
            ->andFilterWhere(['like', 'TitleCd', $this->TitleCd])
            ->andFilterWhere(['like', 'GenderCd', $this->GenderCd])
            ->andFilterWhere(['like', 'COBirthPlaceCd', $this->COBirthPlaceCd])
            ->andFilterWhere(['like', 'COBirthCountryCd', $this->COBirthCountryCd])
            ->andFilterWhere(['like', 'NegaraAsalCd', $this->NegaraAsalCd])
            ->andFilterWhere(['like', 'NegeriAsalCd', $this->NegeriAsalCd])
            ->andFilterWhere(['like', 'NegeriAsalIbu', $this->NegeriAsalIbu])
            ->andFilterWhere(['like', 'NegeriAsalBapa', $this->NegeriAsalBapa])
            ->andFilterWhere(['like', 'NatCd', $this->NatCd])
            ->andFilterWhere(['like', 'NatStatusCd', $this->NatStatusCd])
            ->andFilterWhere(['like', 'CONm', $this->CONm])
            ->andFilterWhere(['like', 'COEmail', $this->COEmail])
            ->andFilterWhere(['like', 'COEmail2', $this->COEmail2])
            ->andFilterWhere(['like', 'COOldID', $this->COOldID])
            ->andFilterWhere(['like', 'COBirthCertNo', $this->COBirthCertNo])
            ->andFilterWhere(['like', 'COHPhoneNo', $this->COHPhoneNo])
            ->andFilterWhere(['like', 'COHPhoneNo2', $this->COHPhoneNo2])
            ->andFilterWhere(['like', 'COOffTelNo', $this->COOffTelNo])
            ->andFilterWhere(['like', 'COOffTelNoExtn', $this->COOffTelNoExtn])
            ->andFilterWhere(['like', 'COOffTelNoExtn2', $this->COOffTelNoExtn2])
            ->andFilterWhere(['like', 'COOUCTelNo', $this->COOUCTelNo])
            ->andFilterWhere(['like', 'COOPass', $this->COOPass])
            ->andFilterWhere(['like', 'COHPhoneStatus', $this->COHPhoneStatus])
            ->andFilterWhere(['like', 'gredJawatan_2', $this->gredJawatan_2])
            ->andFilterWhere(['like', 'jawatanTadbir', $this->jawatanTadbir])
            ->andFilterWhere(['like', 'last_updater', $this->last_updater])
            ->andFilterWhere(['like', 'pp', $this->pp])
            ->andFilterWhere(['like', 'bos', $this->bos])
            ->andFilterWhere(['like', 'program_ums', $this->program_ums]);

        return $dataProvider;
    }

    public function carian($params) //biodata
    {
        $this->load($params);
        $query = Tblprcobiodata::find();
        if (!empty($this->carian_kategorijawatan)) {
            $query = Tblprcobiodata::find()->joinWith('jawatan');
            $query->andFilterWhere([
                'job_category' => $this->carian_kategorijawatan,
            ]);
        }
        $access = Yii::$app->user->identity->accessLevel;
        switch ($access) {
            case '3':
                $secondaccess = Yii::$app->user->identity->accessSecondLevel;
                if (['IN', $secondaccess, ['7', '8', '9']]) {
                    $query->andFilterWhere(['DeptId' => Yii::$app->user->identity->DeptId]);
                }
                break;
            case '5':

                if (Yii::$app->MP->isKetuaProgram()) {
                    $query->andFilterWhere(['KodProgram' => Yii::$app->user->identity->KodProgram]);
                }
                break;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        if ($this->carian_kodprogram) {
            $array = ProgramPengajaran::find()->select('id')->where(['KodProgram' => $this->carian_kodprogram])->asArray()->all();
            $a = [];
            for ($i = 0; $i < count($array); $i++) {
                array_push($a, $array[$i]['id']);
            }
            $query->andFilterWhere(['IN', 'KodProgram', $a]);
        }
        $query->andFilterWhere([
            'HighestEduLevelCd' => $this->HighestEduLevelCd,
            'DeptId' => $this->DeptId,
            'campus_id' => $this->campus_id,
            'statLantikan' => $this->statLantikan,
            'Status' => $this->Status,
            'KodProgram' => $this->carian_programpengajaran,
        ]);

        switch ($this->jenis_carian) {
            case '1':
                $query->andFilterWhere(['like', 'ICNO', $this->carian_data]);
                break;
            case '2':
                $query->andFilterWhere(['like', 'COOldID', $this->carian_data]);
                break;
            default:
                $query->andFilterWhere(['like', 'CONm', $this->carian_data]);
                break;
        }
        return $dataProvider;
    }

    public function carianLantikan($params) //biodata
    {
        $this->load($params);
        $query = Tblprcobiodata::find();
        $access = Yii::$app->user->identity->accessLevel;
        switch ($access) {
            case '3':
                $secondaccess = Yii::$app->user->identity->accessSecondLevel;
                if (['IN', $secondaccess, ['8', '9']]) {
                    $query->andFilterWhere(['DeptId' => Yii::$app->user->identity->DeptId]);
                }
                break;
        }
        if (!empty($this->carian_kategorijawatan)) {
            $query = Tblprcobiodata::find()->joinWith('jawatan');
            $query->andFilterWhere([
                'job_category' => $this->carian_kategorijawatan,
            ]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'HighestEduLevelCd' => $this->HighestEduLevelCd,
            'DeptId' => $this->DeptId,
            'campus_id' => $this->campus_id,
            'statLantikan' => $this->statLantikan,
            'Status' => $this->Status,
        ]);

        switch ($this->jenis_carian) {
            case '1':
                $query->andFilterWhere(['like', 'CONm', $this->carian_data]);
                break;
            case '2':
                $query->andFilterWhere(['like', 'COOldID', $this->carian_data]);
                break;
            default:
                $query->andFilterWhere(['like', 'ICNO', $this->carian_data]);
                break;
        }


        return $dataProvider;
    }

    public function carianVaksinasi($params) //vaksinasi
    {
        $this->load($params);


        switch ($this->program_vaksinasi) {
            case '1':
                $query = Tblprcobiodata::find()->joinWith('vaksinasi', true, 'RIGHT JOIN')->where(['!=', 'Status', '06']);
                break;
            case '2':
                $query = Tblprcobiodata::find()->joinWith('vaksinasi', true, 'LEFT JOIN')->where(['!=', 'Status', '06'])->andWhere([
                    'IS', '`tblvaksinasi`.`icno`', NULL
                ]);
                break;

            default:

                $query = Tblprcobiodata::find()->joinWith('vaksinasi')->where(['!=', 'Status', '06']);

                break;
        }

        $access = Yii::$app->user->identity->accessLevel;
        switch ($access) {
            case '3':
                $secondaccess = Yii::$app->user->identity->accessSecondLevel;
                if (['IN', $secondaccess, ['8', '9']]) {
                    $query->andFilterWhere(['DeptId' => Yii::$app->user->identity->DeptId]);
                }
                break;
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'DeptId' => $this->DeptId,
            'campus_id' => $this->campus_id,
        ]);

        switch ($this->jenis_carian) {
            case '1':
                $query->andFilterWhere(['like', 'CONm', $this->carian_data]);
                break;
            case '2':
                $query->andFilterWhere(['like', 'COOldID', $this->carian_data]);
                break;
            default:
                $query->andFilterWhere(['like', 'ICNO', $this->carian_data]);
                break;
        }


        return $dataProvider;
    }

    public function payroll_carian($params) //biodata
    {
        $this->load($params);
        $query = Tblprcobiodata::find();
        $access = Yii::$app->user->identity->accessLevel;
        switch ($access) {
            case '3':
                $secondaccess = Yii::$app->user->identity->accessSecondLevel;
                if (['IN', $secondaccess, ['8', '9']]) {
                    $query->andFilterWhere(['DeptId' => Yii::$app->user->identity->DeptId]);
                }
                break;
        }
        if (!empty($this->carian_kategorijawatan)) {
            $query = Tblprcobiodata::find()->joinWith('jawatan');
            $query->andFilterWhere([
                'job_category' => $this->carian_kategorijawatan,
            ]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->carian_kodprogram) {
            $array = ProgramPengajaran::find()->select('id')->where(['KodProgram' => $this->carian_kodprogram])->asArray()->all();
            $a = [];
            for ($i = 0; $i < count($array); $i++) {
                array_push($a, $array[$i]['id']);
            }
            $query->andFilterWhere(['IN', 'KodProgram', $a]);
        }
        $query->andFilterWhere([
            'HighestEduLevelCd' => $this->HighestEduLevelCd,
            'DeptId' => $this->DeptId,
            'campus_id' => $this->campus_id,
            'statLantikan' => $this->statLantikan,
            'Status' => $this->Status,
            'KodProgram' => $this->carian_programpengajaran,
        ]);
        $query->andFilterWhere(['or', ['like', 'ICNO', $this->carian_data], ['like', 'CONm', $this->carian_data]]);

        return $dataProvider;
    }


    /**
     * Function ni pakai utk raw data survey 
     * Miji 1/7/2021
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchRaw($params)
    {
        $query = Tblprcobiodata::find();
        $this->load($params);

        if (!empty($this->carian_kategorijawatan)) {
            $query = Tblprcobiodata::find()->joinWith('jawatan');
            $query->andFilterWhere([
                'job_category' => $this->carian_kategorijawatan,
            ]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);



        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'HighestEduLevelCd' => $this->HighestEduLevelCd,
            'ConfermentDt' => $this->ConfermentDt,
            'COBumiStatus' => $this->COBumiStatus,
            'COBirthDt' => $this->COBirthDt,
            'COOIsNew' => $this->COOIsNew,
            'accessLevel' => $this->accessLevel,
            'accessSecondLevel' => $this->accessSecondLevel,
            'DeptId' => $this->DeptId,
            'campus_id' => $this->campus_id,
            'statLantikan' => $this->statLantikan,
            'startDateLantik' => $this->startDateLantik,
            'endDateLantik' => $this->endDateLantik,
            'Status' => $this->Status,
            'startDateStatus' => $this->startDateStatus,
            'noWaran' => $this->noWaran,
            'gredJawatan' => $this->gredJawatan,
            'statSandangan' => $this->statSandangan,
            'startDateSandangan' => $this->startDateSandangan,
            'endDateSandangan' => $this->endDateSandangan,
            'statSandangan_2' => $this->statSandangan_2,
            'startDateSandangan_2' => $this->startDateSandangan_2,
            'endDateSandangan_2' => $this->endDateSandangan_2,
            'ApmtTypeCd' => $this->ApmtTypeCd,
            'last_update' => $this->last_update,
            'last_login' => $this->last_login,
            'DeptId_hakiki' => $this->DeptId_hakiki,
            'campus_id_hakiki' => $this->campus_id_hakiki,
            'KodProgram' => $this->KodProgram,
            'kemaskini_terakhir' => $this->kemaskini_terakhir,
            'sah_keluarga' => $this->sah_keluarga,
            'sah_alamat' => $this->sah_alamat,
            'sah_notel' => $this->sah_notel,
            'sah_statuskahwin' => $this->sah_statuskahwin,
            'sah_emel' => $this->sah_emel,
            'sah_akademik' => $this->sah_akademik,
            'sah_agama' => $this->sah_agama,
            'sah_passport' => $this->sah_passport,
            'tarikh_sah' => $this->tarikh_sah,
            'showposition' => $this->showposition,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'ReligionCd', $this->ReligionCd])
            ->andFilterWhere(['like', 'RaceCd', $this->RaceCd])
            ->andFilterWhere(['like', 'EthnicCd', $this->EthnicCd])
            ->andFilterWhere(['like', 'ArmyPoliceCd', $this->ArmyPoliceCd])
            ->andFilterWhere(['like', 'BloodTypeCd', $this->BloodTypeCd])
            ->andFilterWhere(['like', 'MrtlStatusCd', $this->MrtlStatusCd])
            ->andFilterWhere(['like', 'TitleCd', $this->TitleCd])
            ->andFilterWhere(['like', 'GenderCd', $this->GenderCd])
            ->andFilterWhere(['like', 'COBirthPlaceCd', $this->COBirthPlaceCd])
            ->andFilterWhere(['like', 'COBirthCountryCd', $this->COBirthCountryCd])
            ->andFilterWhere(['like', 'NegaraAsalCd', $this->NegaraAsalCd])
            ->andFilterWhere(['like', 'NegeriAsalCd', $this->NegeriAsalCd])
            ->andFilterWhere(['like', 'NatCd', $this->NatCd])
            ->andFilterWhere(['like', 'NatStatusCd', $this->NatStatusCd])
            ->andFilterWhere(['like', 'CONm', $this->CONm])
            ->andFilterWhere(['like', 'COEmail', $this->COEmail])
            ->andFilterWhere(['like', 'COEmail2', $this->COEmail2])
            ->andFilterWhere(['like', 'COOldID', $this->COOldID])
            ->andFilterWhere(['like', 'COBirthCertNo', $this->COBirthCertNo])
            ->andFilterWhere(['like', 'COHPhoneNo', $this->COHPhoneNo])
            ->andFilterWhere(['like', 'COOffTelNo', $this->COOffTelNo])
            ->andFilterWhere(['like', 'COOffTelNoExtn', $this->COOffTelNoExtn])
            ->andFilterWhere(['like', 'COOffTelNoExtn2', $this->COOffTelNoExtn2])
            ->andFilterWhere(['like', 'COOPass', $this->COOPass])
            ->andFilterWhere(['like', 'COHPhoneStatus', $this->COHPhoneStatus])
            ->andFilterWhere(['like', 'gredJawatan_2', $this->gredJawatan_2])
            ->andFilterWhere(['like', 'jawatanTadbir', $this->jawatanTadbir])
            ->andFilterWhere(['like', 'last_updater', $this->last_updater])
            ->andFilterWhere(['like', 'pp', $this->pp])
            ->andFilterWhere(['like', 'bos', $this->bos])
            ->andFilterWhere(['like', 'program_ums', $this->program_ums]);

        return $dataProvider;
    }

    /**
     * Function ni pakai utk Allocation Profile
     * Miji 26/8/2021
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchAllocProfile($params)
    {
        $query = Tblprcobiodata::find()->joinWith(['jawatan', 'allocation'], true, 'LEFT JOIN');
        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'HighestEduLevelCd' => $this->HighestEduLevelCd,
            'ConfermentDt' => $this->ConfermentDt,
            'COBumiStatus' => $this->COBumiStatus,
            'COBirthDt' => $this->COBirthDt,
            'COOIsNew' => $this->COOIsNew,
            'accessLevel' => $this->accessLevel,
            'accessSecondLevel' => $this->accessSecondLevel,
            'DeptId' => $this->DeptId,
            'campus_id' => $this->campus_id,
            'statLantikan' => $this->statLantikan,
            'startDateLantik' => $this->startDateLantik,
            'endDateLantik' => $this->endDateLantik,
            'Status' => $this->Status,
            'startDateStatus' => $this->startDateStatus,
            'noWaran' => $this->noWaran,
            'gredJawatan' => $this->gredJawatan,
            'statSandangan' => $this->statSandangan,
            'startDateSandangan' => $this->startDateSandangan,
            'endDateSandangan' => $this->endDateSandangan,
            'statSandangan_2' => $this->statSandangan_2,
            'startDateSandangan_2' => $this->startDateSandangan_2,
            'endDateSandangan_2' => $this->endDateSandangan_2,
            'ApmtTypeCd' => $this->ApmtTypeCd,
            'last_update' => $this->last_update,
            'last_login' => $this->last_login,
            'DeptId_hakiki' => $this->DeptId_hakiki,
            'campus_id_hakiki' => $this->campus_id_hakiki,
            'KodProgram' => $this->KodProgram,
            'kemaskini_terakhir' => $this->kemaskini_terakhir,
            'sah_keluarga' => $this->sah_keluarga,
            'sah_alamat' => $this->sah_alamat,
            'sah_notel' => $this->sah_notel,
            'sah_statuskahwin' => $this->sah_statuskahwin,
            'sah_emel' => $this->sah_emel,
            'sah_akademik' => $this->sah_akademik,
            'sah_agama' => $this->sah_agama,
            'sah_passport' => $this->sah_passport,
            'tarikh_sah' => $this->tarikh_sah,
            'showposition' => $this->showposition,
            'job_category' => $this->carian_kategorijawatan,
            'jenis_lantikan' => $this->carian_jenis_lantikan,
            'sumber_peruntukan' => $this->carian_sumber_peruntukan,
            'status_kontrak' => $this->carian_status_kontrak,
            'NatStatusCd' => $this->carian_status_warga,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'ReligionCd', $this->ReligionCd])
            ->andFilterWhere(['like', 'RaceCd', $this->RaceCd])
            ->andFilterWhere(['like', 'EthnicCd', $this->EthnicCd])
            ->andFilterWhere(['like', 'ArmyPoliceCd', $this->ArmyPoliceCd])
            ->andFilterWhere(['like', 'BloodTypeCd', $this->BloodTypeCd])
            ->andFilterWhere(['like', 'MrtlStatusCd', $this->MrtlStatusCd])
            ->andFilterWhere(['like', 'TitleCd', $this->TitleCd])
            ->andFilterWhere(['like', 'GenderCd', $this->GenderCd])
            ->andFilterWhere(['like', 'COBirthPlaceCd', $this->COBirthPlaceCd])
            ->andFilterWhere(['like', 'COBirthCountryCd', $this->COBirthCountryCd])
            ->andFilterWhere(['like', 'NegaraAsalCd', $this->NegaraAsalCd])
            ->andFilterWhere(['like', 'NegeriAsalCd', $this->NegeriAsalCd])
            ->andFilterWhere(['like', 'NatCd', $this->NatCd])
            ->andFilterWhere(['like', 'NatStatusCd', $this->NatStatusCd])
            ->andFilterWhere(['like', 'CONm', $this->CONm])
            ->andFilterWhere(['like', 'COEmail', $this->COEmail])
            ->andFilterWhere(['like', 'COEmail2', $this->COEmail2])
            ->andFilterWhere(['like', 'COOldID', $this->COOldID])
            ->andFilterWhere(['like', 'COBirthCertNo', $this->COBirthCertNo])
            ->andFilterWhere(['like', 'COHPhoneNo', $this->COHPhoneNo])
            ->andFilterWhere(['like', 'COOffTelNo', $this->COOffTelNo])
            ->andFilterWhere(['like', 'COOffTelNoExtn', $this->COOffTelNoExtn])
            ->andFilterWhere(['like', 'COOffTelNoExtn2', $this->COOffTelNoExtn2])
            ->andFilterWhere(['like', 'COOPass', $this->COOPass])
            ->andFilterWhere(['like', 'COHPhoneStatus', $this->COHPhoneStatus])
            ->andFilterWhere(['like', 'gredJawatan_2', $this->gredJawatan_2])
            ->andFilterWhere(['like', 'jawatanTadbir', $this->jawatanTadbir])
            ->andFilterWhere(['like', 'last_updater', $this->last_updater])
            ->andFilterWhere(['like', 'pp', $this->pp])
            ->andFilterWhere(['like', 'bos', $this->bos])
            ->andFilterWhere(['!=', 'Status', 6])
            ->andFilterWhere(['like', 'program_ums', $this->program_ums]);

        return $dataProvider;
    }

    public function searchProfil($params, $cat)
    {

        $query = Tblprcobiodata::find()

            ->joinWith('jawatan')
            ->joinWith('statusLantikan')
            ->With('adminpos')
            // ->joinWith(['adminpos' => function (\yii\db\ActiveQuery $query) {
            //     return $query
            //         ->andOnCondition(['tblrscoadminpost.flag'=> 1]);
            // }])
            ->where(['!=', 'tblprcobiodata.Status', 6])
            ->andWhere(['IN', 'gredjawatan.job_category', $cat])
            ->andWhere(['or', ['in', 'gredjawatan.gred_skim', ['VU', 'VK']], ['between', 'gredjawatan.gred_no', '48', '54']])
            // ->andWhere(['in', 'gredjawatan.gred_skim', ['VK']])
            ->orderBy('tblprcobiodata.CONm');


        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'HighestEduLevelCd' => $this->HighestEduLevelCd,
            'DeptId' => $this->DeptId,
            'campus_id' => $this->campus_id,
            'statLantikan' => $this->statLantikan,
            'gredJawatan' => $this->gredJawatan,

        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'CONm', $this->CONm])
            ->andFilterWhere(['like', 'COOldID', $this->COOldID])
            ->andFilterWhere(['like', 'gredjawatan.job_category', $this->carian_kategorijawatan])
            ->andFilterWhere(['=', 'gredjawatan.klasifikasi_id', $this->klasifikasi_id]);
            

        return $dataProvider;
    }
    
    public function searchProfilAll($params, $cat)
    {

        $query = Tblprcobiodata::find()

            ->joinWith('jawatan')
            ->joinWith('statusLantikan')
            ->With('adminpos')
            // ->joinWith(['adminpos' => function (\yii\db\ActiveQuery $query) {
            //     return $query
            //         ->andOnCondition(['tblrscoadminpost.flag'=> 1]);
            // }])
            ->where(['!=', 'tblprcobiodata.Status', 6])
            ->andWhere(['IN', 'gredjawatan.job_category', $cat])
//            ->andWhere(['or', ['in', 'gredjawatan.gred_skim', ['VU', 'VK']]])
            // ->andWhere(['in', 'gredjawatan.gred_skim', ['VK']])
            ->orderBy('tblprcobiodata.CONm');


        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'HighestEduLevelCd' => $this->HighestEduLevelCd,
            'DeptId' => $this->DeptId,
            'campus_id' => $this->campus_id,
            'statLantikan' => $this->statLantikan,
            'gredJawatan' => $this->gredJawatan,

        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'CONm', $this->CONm])
            ->andFilterWhere(['like', 'COOldID', $this->COOldID])
            ->andFilterWhere(['like', 'gredjawatan.job_category', $this->carian_kategorijawatan])
            ->andFilterWhere(['=', 'gredjawatan.klasifikasi_id', $this->klasifikasi_id]);
            

        return $dataProvider;
    }
}
