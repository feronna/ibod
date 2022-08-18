<?php

namespace app\models\elnpt\support;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\elnpt\support\TblTicket;

/**
 * TblTicketSearch represents the model behind the search form of `app\models\elnpt\support\TblTicket`.
 */
class TblTicketSearch extends TblTicket
{
    public $ICNO;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lpp_id', 'category_id', 'status', 'priority'], 'integer'],
            [['title', 'created_at', 'ICNO'], 'safe'],
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
        $query = TblTicket::find()->leftJoin('hrm.elnpt_tbl_main', 'hrm.elnpt_tbl_main.lpp_id = hrm.elnpt_tbl_ticket.lpp_id');

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
            'lpp_id' => $this->lpp_id,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'priority' => $this->priority,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        $query->andFilterWhere(['hrm.elnpt_tbl_main.PYD' => $this->ICNO]);

        return $dataProvider;
    }
}
