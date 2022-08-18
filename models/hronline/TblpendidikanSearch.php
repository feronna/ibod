<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblpendidikan;

/**
 * TblpendidikanSearch represents the model behind the search form of `app\models\hronline\Tblpendidikan`.
 */
class TblpendidikanSearch extends Tblpendidikan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'InstCd', 'SponsorshipCd', 'Sponsorship', 'MajorCd', 'MinorCd', 'EduCertTitle', 'EduCertTitleBI', 'ConfermentDt', 'OverallGrade'], 'safe'],
            [['HighestEduLevelCd', 'AcrtdEduAch', 'id'], 'integer'],
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
        $query = Tblpendidikan::find();

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
            'AcrtdEduAch' => $this->AcrtdEduAch,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'InstCd', $this->InstCd])
            ->andFilterWhere(['like', 'SponsorshipCd', $this->SponsorshipCd])
            ->andFilterWhere(['like', 'Sponsorship', $this->Sponsorship])
            ->andFilterWhere(['like', 'MajorCd', $this->MajorCd])
            ->andFilterWhere(['like', 'MinorCd', $this->MinorCd])
            ->andFilterWhere(['like', 'EduCertTitle', $this->EduCertTitle])
            ->andFilterWhere(['like', 'EduCertTitleBI', $this->EduCertTitleBI])
            ->andFilterWhere(['like', 'OverallGrade', $this->OverallGrade]);

        return $dataProvider;
    }
}
