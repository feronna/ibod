<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\badanprofesional_skim;


class badanprofesional_skimSearch extends badanprofesional_skim
{
    public function rules()
    {
        return [
            [['id','skim_id','ProfBodyCd', '_profbodyid'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = badanprofesional_skim::find();

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
        $query->andFilterWhere([
            'id' => $this->id,
            'skim_id' => $this->skim_id,
        ]);

        // grid filtering conditions
        $query->andFilterWhere(['like', 'ProfBodyCd', $this->ProfBodyCd])
            ->andFilterWhere(['like', '_profbodyid', $this->_profbodyid]);

        return $dataProvider;
    }
}
