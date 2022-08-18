<?php

namespace app\models\dass;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\dass\Tblprcobiodata;
use app\models\dass\TblUserAccess;

/**
 * TblprcobiodataSearch represents the model behind the search form of `app\models\hornline\Tblprcobiodata`.
 */
class TblDassBiodataSearch extends Tblprcobiodata {
    
    public $akses;
    
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['akses', 'ICNO', 'ReligionCd', 'RaceCd', 'EthnicCd', 'ArmyPoliceCd', 'BloodTypeCd', 'MrtlStatusCd', 'TitleCd', 'ConfermentDt', 'GenderCd', 'COBirthPlaceCd', 'COBirthCountryCd', 'NegaraAsalCd', 'NegeriAsalCd', 'NatCd', 'NatStatusCd', 'CONm', 'COEmail', 'COEmail2', 'COOldID', 'COBirthCertNo', 'COBirthDt', 'COHPhoneNo', 'COOffTelNo', 'COOffTelNoExtn', 'COOffTelNoExtn2', 'COOPass', 'COHPhoneStatus', 'startDateLantik', 'endDateLantik', 'startDateStatus', 'startDateSandangan', 'endDateSandangan', 'gredJawatan_2', 'startDateSandangan_2', 'endDateSandangan_2', 'jawatanTadbir', 'last_update', 'last_updater', 'last_login', 'pp', 'bos', 'program_ums', 'kemaskini_terakhir', 'tarikh_sah'], 'safe'],
                [['HighestEduLevelCd', 'COBumiStatus', 'COOIsNew', 'accessLevel', 'accessSecondLevel', 'DeptId', 'campus_id', 'statLantikan', 'Status', 'noWaran', 'gredJawatan', 'statSandangan', 'statSandangan_2', 'ApmtTypeCd', 'DeptId_hakiki', 'campus_id_hakiki', 'KodProgram', 'sah_keluarga', 'sah_alamat', 'sah_notel', 'sah_statuskahwin', 'sah_emel', 'sah_akademik', 'sah_agama', 'sah_passport', 'showposition'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    
    public function search($params) {
        
        $query = Tblprcobiodata::find();
        
        //$query->with('department');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'pageSize' => 20,
                'pageSize' => 10,
                ],
            'sort' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        if(!empty($this->akses)) {
            $query = $query->innerJoinWith('dassAkses', false)->where(['access' => $this->akses]);
        }
        
        if (is_null($params) || empty($params)){
            $query->where('0 = 1');
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
            //'Status' => $this->Status,
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
                ->andFilterWhere(['like', 'program_ums', $this->program_ums])
                ->andFilterWhere(['=', 'DeptId', $this->DeptId]);

        return $dataProvider;
    }
    
}
