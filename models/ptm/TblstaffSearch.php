<?php

namespace app\models\ptm;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ptm\Tblstaff;

/**
 * TblstaffSearch represents the model behind the search form of `app\models\ptm\Tblstaff`.
 */
class TblstaffSearch extends Tblstaff
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'dept_id', 'flag'], 'integer'],
            [['icno', 'lantik_dt'], 'safe'],
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
        $query = Tblstaff::find();

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
            'dept_id' => $this->dept_id,
            'lantik_dt' => $this->lantik_dt,
            'flag' => $this->flag,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno]);

        return $dataProvider;
    }
}
