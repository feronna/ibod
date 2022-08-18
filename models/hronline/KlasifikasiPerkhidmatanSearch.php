<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\KlasifikasiPerkhidmatan;


class KlasifikasiPerkhidmatanSearch extends KlasifikasiPerkhidmatan
{
    public $bp_id = null;
    public function rules()
    {
        return [
            [['id','nama', 'gred_skim','status','bp_id'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = KlasifikasiPerkhidmatan::find()->orderBy(['gred_skim'=>SORT_ASC]);

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
            'status' => $this->status,
        ]);

        // grid filtering conditions
        $query->andFilterWhere(['like', 'gred_skim', $this->gred_skim])
            ->andFilterWhere(['like', 'nama', $this->nama]);

        return $dataProvider;
    }
}
