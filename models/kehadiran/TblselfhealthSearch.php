<?php

namespace app\models\kehadiran;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\kehadiran\Tblselfhealth;

/**
 * TblselfhealthSearch represents the model behind the search form of `app\models\kehadiran\Tblselfhealth`.
 */
class TblselfhealthSearch extends Tblselfhealth
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'health_status'], 'integer'],
            [['icno', 'date', 'temperature', 'status', 'comment'], 'safe'],
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
        $query = Tblselfhealth::find();

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
            'date' => $this->date,
            'health_status' => $this->health_status,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'temperature', $this->temperature])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
