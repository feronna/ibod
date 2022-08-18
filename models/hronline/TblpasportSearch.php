<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblpasport;

/**
 * TblpasportSearch represents the model behind the search form of `app\models\hronline\Tblpasport`.
 */
class TblpasportSearch extends Tblpasport
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'PassportNo', 'PassportTypeCd', 'CountryCd', 'StateCd', 'IssuedDt', 'PassportExpiryDt'], 'safe'],
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
        $query = Tblpasport::find();

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
            'IssuedDt' => $this->IssuedDt,
            'PassportExpiryDt' => $this->PassportExpiryDt,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'PassportNo', $this->PassportNo])
            ->andFilterWhere(['like', 'PassportTypeCd', $this->PassportTypeCd])
            ->andFilterWhere(['like', 'CountryCd', $this->CountryCd])
            ->andFilterWhere(['like', 'StateCd', $this->StateCd]);

        return $dataProvider;
    }
}
