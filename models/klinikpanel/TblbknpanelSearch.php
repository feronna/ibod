<?php

namespace app\models\klinikpanel;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\klinikpanel\Tblbknpanel;

/**
 * TblbknpanelSearch represents the model behind the search form of `app\models\klinikpanel\Tblbknpanel`.
 */
class TblbknpanelSearch extends Tblbknpanel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['icno', 'nama_klinik', 'rawatan', 'no_resit', 'tuntutan_date', 'insert_by', 'insert_dt'], 'safe'],
            [['tuntutan'], 'number'],
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
        $query = Tblbknpanel::find();

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
            'tuntutan' => $this->tuntutan,
            'tuntutan_date' => $this->tuntutan_date,
            'insert_dt' => $this->insert_dt,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'nama_klinik', $this->nama_klinik])
            ->andFilterWhere(['like', 'rawatan', $this->rawatan])
            ->andFilterWhere(['like', 'no_resit', $this->no_resit])
            ->andFilterWhere(['like', 'insert_by', $this->insert_by]);

        return $dataProvider;
    }
}
