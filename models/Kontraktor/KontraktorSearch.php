<?php

namespace app\models\Kontraktor;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kontraktor\Kontraktor;

/**
 * KontraktorSearch represents the model behind the search form of `app\models\Kontraktor\Kontraktor`.
 */
class KontraktorSearch extends Kontraktor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'Status'], 'integer'],
            [['ICNO', 'CONm', 'id_kontraktor', 'ReligionCd', 'RaceCd', 'Addr1', 'Addr2', 'Addr3', 'Postcode', 'CityCd', 'StateCd', 'EthnicCd', 'BloodTypeCd', 'MrtlStatusCd', 'TitleCd', 'GenderCd', 'COBirthPlaceCd', 'COBirthCountryCd', 'NegaraAsalCd', 'NegeriAsalCd', 'NegeriAsalIbu', 'NegeriAsalBapa', 'NatCd', 'NatStatusCd', 'COEmail', 'COBirthCertNo', 'COBirthDt', 'COHPhoneNo', 'COOffTelNo', 'last_update', 'last_updater', 'created_at', 'created_by', 'updated_at', 'updated_by', 'kemaskini_terakhir', 'ref_apsu_suppid', 'no_permit', 'mySejahteraId', 'filename_vaksin_pm', 'filename_sijil_pm', 'filename_kad_cidb'], 'safe'],
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
        $query = Kontraktor::find();

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
            'id' => $this->id,
            'COBirthDt' => $this->COBirthDt,
            'last_update' => $this->last_update,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'kemaskini_terakhir' => $this->kemaskini_terakhir,
            'Status' => $this->Status,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'CONm', $this->CONm])
            ->andFilterWhere(['like', 'id_kontraktor', $this->id_kontraktor])
            ->andFilterWhere(['like', 'ReligionCd', $this->ReligionCd])
            ->andFilterWhere(['like', 'RaceCd', $this->RaceCd])
            ->andFilterWhere(['like', 'Addr1', $this->Addr1])
            ->andFilterWhere(['like', 'Addr2', $this->Addr2])
            ->andFilterWhere(['like', 'Addr3', $this->Addr3])
            ->andFilterWhere(['like', 'Postcode', $this->Postcode])
            ->andFilterWhere(['like', 'CityCd', $this->CityCd])
            ->andFilterWhere(['like', 'StateCd', $this->StateCd])
            ->andFilterWhere(['like', 'EthnicCd', $this->EthnicCd])
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
            ->andFilterWhere(['like', 'COEmail', $this->COEmail])
            ->andFilterWhere(['like', 'COBirthCertNo', $this->COBirthCertNo])
            ->andFilterWhere(['like', 'COHPhoneNo', $this->COHPhoneNo])
            ->andFilterWhere(['like', 'COOffTelNo', $this->COOffTelNo])
            ->andFilterWhere(['like', 'last_updater', $this->last_updater])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by])
            ->andFilterWhere(['like', 'ref_apsu_suppid', $this->ref_apsu_suppid])
            ->andFilterWhere(['like', 'no_permit', $this->no_permit])
            ->andFilterWhere(['like', 'mySejahteraId', $this->mySejahteraId])
            ->andFilterWhere(['like', 'filename_vaksin_pm', $this->filename_vaksin_pm])
            ->andFilterWhere(['like', 'filename_sijil_pm', $this->filename_sijil_pm])
            ->andFilterWhere(['like', 'filename_kad_cidb', $this->filename_kad_cidb]);

        return $dataProvider;
    }
}
