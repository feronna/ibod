<?php

namespace app\models\klinikpanel;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\klinikpanel\Tblbatchclaim;

/**
 * TblbatchclaimSearch represents the model behind the search form of `app\models\myhealth\Tblbatchclaim`.
 */
class TblbatchclaimSearch extends Tblbatchclaim
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['batch_id', 'batch_status_id', 'batch_process_id', 'batch_klinik_id'], 'integer'],
            [['batch_date_issued', 'process_created'], 'safe'],
            [['total_batch_claim', 'total_batch_claim_paid'], 'number'],
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

        $query = Tblbatchclaim::find()->where(['batch_process_id'=>1])->andWhere(['!=','total_batch_claim',0.00])->orderBy(['batch_date_issued' => SORT_DESC]);

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
            'batch_id' => $this->batch_id,
            'YEAR(batch_date_issued)' => $this->batch_date_issued,
            'total_batch_claim' => $this->total_batch_claim,
            'batch_status_id' => $this->batch_status_id,
            'batch_process_id' => $this->batch_process_id,
            'process_created' => $this->process_created,
            'batch_klinik_id' => $this->batch_klinik_id,
            'total_batch_claim_paid' => $this->total_batch_claim_paid,
        ]);

        return $dataProvider;
    }
}
