<?php

namespace app\models\Kemudahan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kemudahan\Kemudahan;

/**
 * TbltuntutanSearch represents the model behind the search form of `app\models\Tblbuka\Tbltuntutan`.
 */
class KemudahanSearch extends Kemudahan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['icno', 'jeniskemudahan', 'kodAkaun',  'reason', 'updated_date'], 'safe'],
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
        $query = Kemudahan::find();

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
            'status' => $this->status,
            'entry_created' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'updated_by', $this->updated_by])
            ->andFilterWhere(['like', 'jeniskemudahan', $this->jeniskemudahan])
            ->andFilterWhere(['like', 'kodAkaun', $this->kodAkaun])
//            ->andFilterWhere(['like', 'amount', $this->amount])
            ->andFilterWhere(['like', 'reason', $this->reason]);
//            ->andFilterWhere(['like', 'total', $this->total]);

        return $dataProvider;
    }
}
