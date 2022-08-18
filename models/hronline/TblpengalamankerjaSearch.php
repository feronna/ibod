<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblpengalamankerja;

/**
 * TblpengalamankerjaSearch represents the model behind the search form of `app\models\hronline\Tblpengalamankerja`.
 */
class TblpengalamankerjaSearch extends Tblpengalamankerja
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'OrgNm', 'OccSectorCd', 'CorpBodyTypeCd', 'PrevEmpRemarks', 'PrevEmpStartDt', 'PrevEmpEndDt'], 'safe'],
            [['id'], 'integer'],
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
        $query = Tblpengalamankerja::find();

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
            'PrevEmpStartDt' => $this->PrevEmpStartDt,
            'PrevEmpEndDt' => $this->PrevEmpEndDt,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'OrgNm', $this->OrgNm])
            ->andFilterWhere(['like', 'OccSectorCd', $this->OccSectorCd])
            ->andFilterWhere(['like', 'CorpBodyTypeCd', $this->CorpBodyTypeCd])
            ->andFilterWhere(['like', 'PrevEmpRemarks', $this->PrevEmpRemarks]);

        return $dataProvider;
    }
}
