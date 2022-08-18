<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblkeluarga;

/**
 * TblkeluargaSearch represents the model behind the search form of `app\models\hronline\Tblkeluarga`.
 */
class TblkeluargaSearch extends Tblkeluarga
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'FamilyId', 'TitleCd', 'ReligionCd', 'MrtlStatusCd', 'RaceCd', 'FmyStatusCd', 'CorpBodyTypeCd', 'OccSectorCd', 'HighestEduLevelCd', 'GenderCd', 'CountryCd', 'NatCd', 'StateCd', 'FmyBirthPlaceCd', 'CityCd', 'RelCd', 'NatStatusCd', 'FmyNm', 'FmyMomNm', 'FmyTelNo', 'FmyBirthDt', 'FmyMarriageDt', 'FmyMarriageCertNo', 'FmyDeceaseDt', 'FmyDivorceDt', 'FmyEmployerNm', 'FmyAddr1', 'FmyAddr2', 'FmyAddr3', 'FmyPostcode', 'FmyEmailAddr', 'FmyDependencyCd', 'FmyDependencyICTypeCd', 'FmyBirthCertNo', 'FmyPassportNo'], 'safe'],
            [['FmyTwinStatus', 'FmyBumiStatus', 'FmyDisabilityStatus', 'FmyDependencyStatus', 'FmyNextOfKinStatus', 'FmyEmerContactStatus', 'FmyPensionRecipient', 'ChildReliefInd', 'id'], 'integer'],
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
        $query = Tblkeluarga::find();

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
            'FmyBirthDt' => $this->FmyBirthDt,
            'FmyTwinStatus' => $this->FmyTwinStatus,
            'FmyMarriageDt' => $this->FmyMarriageDt,
            'FmyDeceaseDt' => $this->FmyDeceaseDt,
            'FmyBumiStatus' => $this->FmyBumiStatus,
            'FmyDivorceDt' => $this->FmyDivorceDt,
            'FmyDisabilityStatus' => $this->FmyDisabilityStatus,
            'FmyDependencyStatus' => $this->FmyDependencyStatus,
            'FmyNextOfKinStatus' => $this->FmyNextOfKinStatus,
            'FmyEmerContactStatus' => $this->FmyEmerContactStatus,
            'FmyPensionRecipient' => $this->FmyPensionRecipient,
            'ChildReliefInd' => $this->ChildReliefInd,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'FamilyId', $this->FamilyId])
            ->andFilterWhere(['like', 'TitleCd', $this->TitleCd])
            ->andFilterWhere(['like', 'ReligionCd', $this->ReligionCd])
            ->andFilterWhere(['like', 'MrtlStatusCd', $this->MrtlStatusCd])
            ->andFilterWhere(['like', 'RaceCd', $this->RaceCd])
            ->andFilterWhere(['like', 'FmyStatusCd', $this->FmyStatusCd])
            ->andFilterWhere(['like', 'CorpBodyTypeCd', $this->CorpBodyTypeCd])
            ->andFilterWhere(['like', 'OccSectorCd', $this->OccSectorCd])
            ->andFilterWhere(['like', 'HighestEduLevelCd', $this->HighestEduLevelCd])
            ->andFilterWhere(['like', 'GenderCd', $this->GenderCd])
            ->andFilterWhere(['like', 'CountryCd', $this->CountryCd])
            ->andFilterWhere(['like', 'NatCd', $this->NatCd])
            ->andFilterWhere(['like', 'StateCd', $this->StateCd])
            ->andFilterWhere(['like', 'FmyBirthPlaceCd', $this->FmyBirthPlaceCd])
            ->andFilterWhere(['like', 'CityCd', $this->CityCd])
            ->andFilterWhere(['like', 'RelCd', $this->RelCd])
            ->andFilterWhere(['like', 'NatStatusCd', $this->NatStatusCd])
            ->andFilterWhere(['like', 'FmyNm', $this->FmyNm])
            ->andFilterWhere(['like', 'FmyMomNm', $this->FmyMomNm])
            ->andFilterWhere(['like', 'FmyTelNo', $this->FmyTelNo])
            ->andFilterWhere(['like', 'FmyMarriageCertNo', $this->FmyMarriageCertNo])
            ->andFilterWhere(['like', 'FmyEmployerNm', $this->FmyEmployerNm])
            ->andFilterWhere(['like', 'FmyAddr1', $this->FmyAddr1])
            ->andFilterWhere(['like', 'FmyAddr2', $this->FmyAddr2])
            ->andFilterWhere(['like', 'FmyAddr3', $this->FmyAddr3])
            ->andFilterWhere(['like', 'FmyPostcode', $this->FmyPostcode])
            ->andFilterWhere(['like', 'FmyEmailAddr', $this->FmyEmailAddr])
            ->andFilterWhere(['like', 'FmyDependencyCd', $this->FmyDependencyCd])
            ->andFilterWhere(['like', 'FmyDependencyICTypeCd', $this->FmyDependencyICTypeCd])
            ->andFilterWhere(['like', 'FmyBirthCertNo', $this->FmyBirthCertNo])
            ->andFilterWhere(['like', 'FmyPassportNo', $this->FmyPassportNo]);

        return $dataProvider;
    }
}
