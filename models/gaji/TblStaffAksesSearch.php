<?php

namespace app\models\gaji;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\gaji\TblStaffAkses;

/**
 * TblStaffAksesSearch represents the model behind the search form of `app\models\gaji\TblStaffAkses`.
 */
class TblStaffAksesSearch extends TblStaffAkses
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staf_akses_icno'], 'safe'],
            [['staf_akses_id'], 'integer'],
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
        $query = TblStaffAkses::find();

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
            'staf_akses_id' => $this->staf_akses_id,
        ]);

        $query->andFilterWhere(['like', 'staf_akses_icno', $this->staf_akses_icno]);

        return $dataProvider;
    }
}
