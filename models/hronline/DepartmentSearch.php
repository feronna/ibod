<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Department;

/**
 * DepartmentSearch represents the model behind the search form of `app\models\hronline\Department`.
 */
class DepartmentSearch extends Department
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'isActive', 'cluster', 'dept_cat_id', 'sub_of'], 'integer'],
            [['fullname', 'shortname', 'chief', 'mymohesCd', 'pp', 'bos', 'idMM', 'address', 'fax_no', 'tel_no', 'pa_email'], 'safe'],
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
        $query = Department::find()->orderBy([
            'isActive'=>SORT_DESC,

            'fullname' => SORT_ASC
          ]);

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
            'category_id' => $this->category_id,
            'isActive' => $this->isActive,
            'cluster' => $this->cluster,
            'dept_cat_id' => $this->dept_cat_id,
            'sub_of' => $this->sub_of,
        ]);

        $query->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'shortname', $this->shortname])
            ->andFilterWhere(['like', 'chief', $this->chief])
            ->andFilterWhere(['like', 'mymohesCd', $this->mymohesCd])
            ->andFilterWhere(['like', 'pp', $this->pp])
            ->andFilterWhere(['like', 'bos', $this->bos])
            ->andFilterWhere(['like', 'idMM', $this->idMM])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'fax_no', $this->fax_no])
            ->andFilterWhere(['like', 'tel_no', $this->tel_no])
            ->andFilterWhere(['like', 'pa_email', $this->pa_email]);

        return $dataProvider;
    }
}
