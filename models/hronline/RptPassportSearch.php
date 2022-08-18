<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\RptPassport;


class RptPassportSearch extends RptPassport
{
    public function rules()
    {
        return [
            [['ICNO', 'pasport_status','ps_noty_status','isSabahan', 'tblpassport_id', 'permit_status','pr_noty_status', 'tblpermit_id','lock'], 'safe'],
        ];
    }

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
        $query = RptPassport::find();

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
        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'isSabahan', $this->isSabahan])
            ->andFilterWhere(['like', 'ps_noty_status', $this->ps_noty_status])
            ->andFilterWhere(['like', 'pasport_status', $this->pasport_status])
            ->andFilterWhere(['like', 'tblpassport_id', $this->tblpassport_id])
            ->andFilterWhere(['like', 'pr_noty_status', $this->pr_noty_status])
            ->andFilterWhere(['like', 'permit_status', $this->permit_status])
            ->andFilterWhere(['like', 'tblpassport_id', $this->tblpassport_id])
            ->andFilterWhere(['like', 'lock', $this->lock]);

        return $dataProvider;
    }
}
