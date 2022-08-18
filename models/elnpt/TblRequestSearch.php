<?php

namespace app\models\elnpt;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\elnpt\TblRequest;

/**
 * TblRequestSeach represents the model behind the search form of `app\models\elnpt\TblRequest`.
 */
class TblRequestSearch extends TblRequest
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lpp_id'], 'integer'],
            [['ICNO', 'close_date'], 'safe'],
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
        $query = TblRequest::find();

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
            'lpp_id' => $this->lpp_id,
            'close_date' => $this->close_date,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO]);

        return $dataProvider;
    }
}
