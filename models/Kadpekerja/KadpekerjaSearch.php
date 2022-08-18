<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kadpekerja\Kadpekerja;

/**
 * KadpekerjaSearch represents the model behind the search form of `app\models\Kadpekerja\Kadpekerja`.
 */
class KadpekerjaSearch extends Kadpekerja
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'isActive', 'status_semasa'], 'integer'],
            [['icno', 'card_owner', 'card_id','entry_date', 'card_type', 'ver_by', 'ver_date', 'ver_catatan', 'app_by', 'app_date', 'app_catatan', 'dokumen'], 'safe'],
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
        $query = Kadpekerja::find();

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
            'entry_date' => $this->entry_date,
            'ver_date' => $this->ver_date,
            'app_date' => $this->app_date,
            'isActive' => $this->isActive,
            'status_semasa' => $this->status_semasa,
            'card_owner' => $this->card_owner,
            'card_id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'card_type', $this->card_type])
            ->andFilterWhere(['like', 'ver_by', $this->ver_by])
            ->andFilterWhere(['like', 'ver_catatan', $this->ver_catatan])
            ->andFilterWhere(['like', 'app_by', $this->app_by])
            ->andFilterWhere(['like', 'app_catatan', $this->app_catatan])
            ->andFilterWhere(['like', 'dokumen', $this->dokumen])
            ->andFilterWhere(['like', 'card_owner', $this->card_owner])
            ->andFilterWhere(['like', 'card_id', $this->card_id]); 
                    
        return $dataProvider;
    }
}
