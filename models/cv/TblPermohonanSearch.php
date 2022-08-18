<?php

namespace app\models\cv;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cv\TblPermohonan;

/**
 * TblPermohonanSearch represents the model behind the search form of `app\models\cv\TblPermohonan`.
 */
class TblPermohonanSearch extends TblPermohonan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ads_id', 'current_gred', 'gred_hakiki', 'current_dept', 'dept_hakiki', 'status_id', 'kj_status', 'admin_status', 'isActive'], 'integer'],
            [['ICNO', 'submit_datetime', 'kj_ICNO', 'kj_datetime', 'kj_ulasan', 'admin_ICNO', 'admin_datetime', 'admin_ulasan'], 'safe'],
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
        $model = \app\models\hronline\Tblprcobiodata::find()->joinWith('jawatan')->where(['gredjawatan.job_category'=>1])->andWhere(['!=','tblprcobiodata.Status',6])->all();
        $icno = array();
        foreach($model as $m){
            $icno[] = $m->ICNO;
        }
        
        $query = TblPermohonan::find()->where(['in', 'status_id', [4,5]])->andWhere(['in','ICNO',$icno]);

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
            'submit_datetime' => $this->submit_datetime,
            'ads_id' => $this->ads_id,
            'current_gred' => $this->current_gred,
            'gred_hakiki' => $this->gred_hakiki,
            'current_dept' => $this->current_dept,
            'dept_hakiki' => $this->dept_hakiki,
            'status_id' => $this->status_id,
            'kj_datetime' => $this->kj_datetime,
            'kj_status' => $this->kj_status,
            'admin_datetime' => $this->admin_datetime,
            'admin_status' => $this->admin_status,
            'isActive' => $this->isActive,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'kj_ICNO', $this->kj_ICNO])
            ->andFilterWhere(['like', 'kj_ulasan', $this->kj_ulasan])
            ->andFilterWhere(['like', 'admin_ICNO', $this->admin_ICNO])
            ->andFilterWhere(['like', 'admin_ulasan', $this->admin_ulasan]);

        return $dataProvider;
    }
}
