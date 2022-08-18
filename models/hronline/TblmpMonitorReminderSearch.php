<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\TblmpMonitorReminder;


class TblmpMonitorReminderSearch extends TblmpMonitorReminder
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno', 'name','mp_type'], 'safe'],
            [['id'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = TblmpMonitorReminder::find();

       
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }
        if(!empty($this->icno)){
            $query->andFilterWhere(['icno'=>$this->icno]);
        }
        if(!empty($this->mp_type)){
            $query->andFilterWhere(['mp_type'=>$this->mp_type]);
        }
        return $dataProvider;
    }
}
