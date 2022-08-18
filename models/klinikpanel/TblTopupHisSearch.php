<?php

namespace app\models\klinikpanel;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\klinikpanel\TblTopupHis;

/**
 * TblTopupHisSearch represents the model behind the search form of `app\models\klinikpanel\TblTopupHis`.
 */
class TblTopupHisSearch extends TblTopupHis
{
    public $name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['icno', 'topup_by', 'topup_dt','name'], 'safe'],
            [['topup_amount'], 'number'],
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
        $query = TblTopupHis::find()
                ->joinWith('kakitangan');

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
            'topup_amount' => $this->topup_amount,
            'topup_dt' => $this->topup_dt,
        ]);

        $query->andFilterWhere(['like', 'hrm.myhealth_tbl_topup_his.icno', $this->icno])
            ->andFilterWhere(['like', 'hronline.tblprcobiodata.CONm',$this->name])
            ->andFilterWhere(['like', 'topup_by', $this->topup_by]);

        return $dataProvider;
    }
}
