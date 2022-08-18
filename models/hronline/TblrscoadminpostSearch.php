<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblrscoadminpost;

/**
 * TblrscoadminpostSearch represents the model behind the search form of `app\models\hronline\Tblrscoadminpost`.
 */
class TblrscoadminpostSearch extends Tblrscoadminpost
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'adminpos_id', 'jobStatus', 'paymentStatus', 'dept_id', 'campus_id', 'flag', 'renew', 'status_tugas'], 'integer'],
            [['ICNO', 'description', 'description_sef', 'appoinment_date', 'start_date', 'end_date', 'files'], 'safe'],
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
        $query = Tblrscoadminpost::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => [

                'pageSize' => 50,

            ],
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
            'adminpos_id' => $this->adminpos_id,
            'jobStatus' => $this->jobStatus,
            'paymentStatus' => $this->paymentStatus,
            'dept_id' => $this->dept_id,
            'campus_id' => $this->campus_id,
            'appoinment_date' => $this->appoinment_date,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'flag' => $this->flag,
            'renew' => $this->renew,
            'status_tugas' => $this->status_tugas,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'adminpos_id', $this->adminpos_id])
            ->andFilterWhere(['like', 'jobStatus', $this->jobStatus])
            ->andFilterWhere(['like', 'paymentStatus', $this->paymentStatus])
            ->andFilterWhere(['like', 'dept_id', $this->dept_id])
            ->andFilterWhere(['like', 'campus_id', $this->campus_id])
            ->andFilterWhere(['like', 'appoinment_date', $this->appoinment_date])
            ->andFilterWhere(['like', 'start_date', $this->start_date])
            ->andFilterWhere(['like', 'end_date', $this->end_date])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'renew', $this->renew])
            ->andFilterWhere(['like', 'status_tugas', $this->status_tugas])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'description_sef', $this->description_sef])
            ->andFilterWhere(['like', 'files', $this->files]);
         if($this->dept_id != null)
        {   
            // $query->andFilterWhere( "status IN (".implode(',',$this->status).")" );
            $query->andFilterWhere(['in', 'dept_id', $this->dept_id]);
        }

        return $dataProvider;
    }
}
