<?php

namespace app\models\msiso;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\msiso\TblOfi;

/**
 * TblOfiSearch represents the model behind the search form of `app\models\msiso\TblOfi`.
 */
class TblOfiSearch extends TblOfi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['status_tindakan','rujukan_fail', 'dept', 'clause', 'butiran', 'auditor_name','penambahbaikan', 'tindakan_bengkel', 'catatan_bengkel', 'tarikh_bengkel', 'tarikh_audit', 'updated_by', 'updated_at', 'attachment'], 'safe'],
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
        $query = TblOfi::find();

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
            'tarikh_audit' => $this->tarikh_audit,
            'created_at' => $this->updated_at,
            'status' => $this->status,
            'dept'=> $this->dept,
            'auditor_name' => $this->auditor_name,
            'clause' => $this->clause,
            'status_tindakan' => $this->status_tindakan,
        ]);

        $query->andFilterWhere(['like', 'rujukan_fail', $this->rujukan_fail])
            ->andFilterWhere(['like', 'dept', $this->dept])
            ->andFilterWhere(['like', 'clause', $this->clause])
            ->andFilterWhere(['like', 'butiran', $this->butiran])
            ->andFilterWhere(['like', 'auditor_name', $this->auditor_name]) 
            ->andFilterWhere(['like', 'tindakan', $this->tindakan_bengkel])
            ->andFilterWhere(['like', 'tindakan', $this->penambahbaikan])   
            ->andFilterWhere(['like', 'created_by', $this->updated_by])
            ->andFilterWhere(['like', 'clause', $this->clause])
            ->andFilterWhere(['like', 'status_tindakan', $this->status_tindakan])
            ->andFilterWhere(['like', 'attachment', $this->attachment]);

        return $dataProvider;
    }
}
