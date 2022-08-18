<?php

namespace app\models\klinikpanel;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\klinikpanel\TblMedcare;

/**
 * TblMedcareSearch represents the model behind the search form of `app\models\myhealth\TblMedcare`.
 */
class TblMedcareSearch extends TblMedcare
{
    
    public $name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['receipt_no', 'staff_icno', 'patient_icno', 'visit_dt', 'diagnosis', 'entry_dt'], 'safe'],
            [['deduct_amt'], 'number'],
            [['name'], 'safe'],
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
        $query = TblMedcare::find()
                ->joinWith('biodata')
                ->orderBy(['visit_dt' => SORT_DESC]);
        
//        $query->joinWith('tblprcobiodata');
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
            'visit_dt' => $this->visit_dt,
            'deduct_amt' => $this->deduct_amt,
            'entry_dt' => $this->entry_dt,
        ]);

        $query->andFilterWhere(['like', 'receipt_no', $this->receipt_no])
            ->andFilterWhere(['like', 'staff_icno', $this->staff_icno])
            ->andFilterWhere(['like', 'patient_icno', $this->patient_icno])
            ->andFilterWhere(['like', 'diagnosis', $this->diagnosis])
            ->andFilterWhere(['like', 'hronline.tblprcobiodata.CONm',$this->name]);

        return $dataProvider;
    }
}
