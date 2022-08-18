<?php

namespace app\models\msiso;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\msiso\RefAuditorDept;

/**
 * RefAuditorDeptSearch represents the model behind the search form of `app\models\msiso\RefAuditorDept`.
 */
class RefAuditorDeptSearch extends RefAuditorDept
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'deptId', 'isActive'], 'integer'],
            [['icno', 'dept', 'year', 'updated_by', 'updated_dt', 'catatan'], 'safe'],
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
        $query = RefAuditorDept::find();

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
            'deptId' => $this->deptId,
            'updated_dt' => $this->updated_dt,
            'isActive' => $this->isActive,
            'icno' => $this->icno,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'dept', $this->dept])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by])
            ->andFilterWhere(['like', 'catatan', $this->catatan]);

        return $dataProvider;
    }
}
