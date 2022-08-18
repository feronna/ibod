<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\HubunganKeluarga;

class HubunganKeluargaSearch extends HubunganKeluarga
{
   
    public function rules()
    {
        return [
            [['RelCd', 'RelNm'], 'safe'],
            [['isActive'], 'integer'],
        ];
    }

  
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
        $query = HubunganKeluarga::find();

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
            'isActive' => $this->isActive,
        ]);

        $query->andFilterWhere(['like', 'RelCd', $this->RelCd])
            ->andFilterWhere(['like', 'RelNm', $this->RelNm]);

        return $dataProvider;
    }
}
