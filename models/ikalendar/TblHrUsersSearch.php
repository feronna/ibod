<?php

namespace app\models\ikalendar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ikalendar\TblHrUsers;

/**
 * TblHrUsersSearch represents the model behind the search form of `app\models\ikalendar\TblHrUsers`.
 */
class TblHrUsersSearch extends TblHrUsers
{
    public $CONm;
    public $DeptId;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CONm', 'DeptId'], 'safe'],
            [['user_id', 'view', 'post', 'add_users', 'add_categories', 'add_groups', 'isadmin'], 'integer'],
            [['password', 'temp_password', 'email'], 'safe'],
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
        $query = TblHrUsers::find();

        $query->joinWith(['staf']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['user_id' => SORT_DESC, 'CONm' => SORT_ASC]],
        ]);

        $dataProvider->sort->attributes['CONm'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['hronline.tblprcobiodata.CONm' => SORT_ASC],
            'desc' => ['hronline.tblprcobiodata.CONm' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'view' => $this->view,
            'post' => $this->post,
            'add_users' => $this->add_users,
            'add_categories' => $this->add_categories,
            'add_groups' => $this->add_groups,
            'isadmin' => $this->isadmin,
        ]);

        $query->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'temp_password', $this->temp_password])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'hronline.tblprcobiodata.CONm', $this->CONm])
            ->andFilterWhere(['hronline.tblprcobiodata.DeptId' => $this->DeptId]);

        return $dataProvider;
    }
}
