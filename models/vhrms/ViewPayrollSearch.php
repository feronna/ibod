<?php

namespace app\models\vhrms;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * tblrscosaltypeSearch represents the model behind the search form of `app\models\hronline\tblrscosaltype`.
 */
class viewPayrollSearch extends viewPayroll
{
    /**
     * {@inheritdoc}
     */
   
      public function rules()
    {
        return [
            [['MPH_STAFF_ID'], 'required'],
            //[['StaffID', 'ActivityID', 'Status'], 'integer'],
            [['it_income_desc','MPH_BANK_ACC_NO', 'MPH_PAY_MONTH'], 'string'],
            [['MPDH_PAID_AMT, MPH_BASIC_PAY'], 'decimal'],
            //[['ApprovedDate', 'OutstationDateTimeStart', 'OutstationDateTimeEnd'], 'safe'],
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
        $query = ViewPayroll::find();

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
            'MPH_STAFF_ID' => $this->MPH_STAFF_ID,
            'id' => $this->id,
    
        ]);
           $query->andFilterWhere(['like', 'MPH_PAY_MONTH', $this->MPH_PAY_MONTH]);
         
       

        return $dataProvider;
    }
}
