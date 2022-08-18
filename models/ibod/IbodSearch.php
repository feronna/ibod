<?php

namespace app\models\ibod;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ibod\Ibod;

/**
 * IbodSearch represents the model behind the search form of `app\models\ibod\Ibod`.
 */
class IbodSearch extends Ibod
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'isActive'], 'integer'],
            [['icno', 'lpu_name', 'lpu_position', 'lpu_start_date', 'lpu_end_date', 'lpu_entry_date', 'updated_date', 'updated_by', 'attachment', 'catatan'], 'safe'],
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
        $query = Ibod::find();

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
            'lpu_start_date' => $this->lpu_start_date,
            'lpu_end_date' => $this->lpu_end_date,
            'lpu_entry_date' => $this->lpu_entry_date,
            'updated_date' => $this->updated_date,
            'isActive' => $this->isActive,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'lpu_name', $this->lpu_name])
            ->andFilterWhere(['like', 'lpu_position', $this->lpu_position])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by])
            ->andFilterWhere(['like', 'attachment', $this->attachment])
            ->andFilterWhere(['like', 'catatan', $this->catatan]);

        return $dataProvider;
    }
}
