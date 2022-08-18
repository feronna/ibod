<?php

namespace app\models\elnpt\elnpt2;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\elnpt\elnpt2\TblKumpDept;

/**
 * TblKumpDeptSearch represents the model behind the search form of `app\models\elnpt\elnpt2\TblKumpDept`.
 */
class TblKumpDeptSearchV2 extends TblKumpDept
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ref_kump_dept_id', 'dept_id'], 'integer'],
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
        $query = TblKumpDept::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
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
            'ref_kump_dept_id' => $this->ref_kump_dept_id,
            'dept_id' => $this->dept_id,
        ]);

        return $dataProvider;
    }
}
