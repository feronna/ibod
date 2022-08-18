<?php

namespace app\models\ejobs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ejobs\TblpBiodata;

/**
 * TblpBiodataSearch represents the model behind the search form of `app\models\ejobs\TblpBiodata`.
 */
class TblpBiodataSearch extends TblpBiodata
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'ReligionCd', 'RaceCd', 'EthnicCd', 'ArmyPoliceCd', 'BloodTypeCd', 'MrtlStatusCd', 'TitleCd', 'GenderCd', 'COBirthPlaceCd', 'COBirthCountryCd', 'NatCd', 'NatStatusCd', 'CONm', 'COEmail', 'COBirthCertNo', 'COBirthDt', 'COBmiLvl', 'COHPhoneNo', 'COOffTelNo', 'last_update', 'last_updater'], 'safe'],
            [['HighestEduLevelCd', 'COBumiStatus', 'CoWeight', 'Status'], 'integer'],
            [['CoHeight', 'COBmiIndex'], 'number'],
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
        if($params){
        $query = TblpBiodata::find();
        }else{
            $query = TblpBiodata::find()->where(['ICNO'=>null]);
        }

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
            'COBumiStatus' => $this->COBumiStatus,
            'COBirthDt' => $this->COBirthDt,
            'CoWeight' => $this->CoWeight,
            'CoHeight' => $this->CoHeight,
            'COBmiIndex' => $this->COBmiIndex,
            'Status' => $this->Status,
            'last_update' => $this->last_update,
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
            ->andFilterWhere(['like', 'NatCd', $this->NatCd])
            ->andFilterWhere(['like', 'NatStatusCd', $this->NatStatusCd])
            ->andFilterWhere(['like', 'CONm', '%'.$this->CONm.'%',false])
            ->andFilterWhere(['like', 'COEmail', $this->COEmail])
            ->andFilterWhere(['like', 'COBirthCertNo', $this->COBirthCertNo])
            ->andFilterWhere(['like', 'COBmiLvl', $this->COBmiLvl])
            ->andFilterWhere(['like', 'COHPhoneNo', $this->COHPhoneNo])
            ->andFilterWhere(['like', 'COOffTelNo', $this->COOffTelNo])
            ->andFilterWhere(['like', 'last_updater', $this->last_updater]);

        return $dataProvider;
    }
}
