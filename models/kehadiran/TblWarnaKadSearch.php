<?php

namespace app\models\kehadiran;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\kehadiran\TblWarnaKad;

/**
 * TblWarnaKadSearch represents the model behind the search form of `app\models\kehadiran\TblWarnaKad`.
 */
class TblWarnaKadSearch extends TblWarnaKad
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ketidakpatuhan', 'approved', 'disapproved'], 'integer'],
            [['month_date', 'icno', 'color'], 'safe'],
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
        $query = TblWarnaKad::find();

        // add conditions that should always apply here
        $query->joinWith(['kakitangan']);

        
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
            'month_date' => $this->month_date,
            'ketidakpatuhan' => $this->ketidakpatuhan,
            'approved' => $this->approved,
            'disapproved' => $this->disapproved,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'Tblprcobiodata.CONm', $this->nama]);

        return $dataProvider;
    }
}
