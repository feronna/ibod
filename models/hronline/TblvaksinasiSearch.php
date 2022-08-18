<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblvaksinasi;

/**
 * TblvaksinasiSearch represents the model behind the search form of `app\models\hronline\Tblvaksinasi`.
 */
class TblvaksinasiSearch extends Tblvaksinasi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno', 'sebab_1', 'sebab_2', 'kemaskini_dt'], 'safe'],
            [['mysj_id', 'daftar_st', 'setuju_st'], 'integer'],
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
        $query = Tblvaksinasi::find();

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
            'mysj_id' => $this->mysj_id,
            'daftar_st' => $this->daftar_st,
            'setuju_st' => $this->setuju_st,
            'kemaskini_dt' => $this->kemaskini_dt,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'sebab_1', $this->sebab_1])
            ->andFilterWhere(['like', 'sebab_2', $this->sebab_2]);

        return $dataProvider;
    }
}
