<?php

namespace app\models\kontrak;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\kontrak\Kontrak;

/**
 * KontrakSearch represents the model behind the search form of `app\models\kontrak\Kontrak`.
 */
class KontrakSearch extends Kontrak
{
    /**
     * {@inheritdoc}
     */
     public $DeptId, $end_filter, $start_filter, $sesi;
     
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['icno','tempoh_l_jfpiu', 'reason', 'tarikh_m', 'status_bsm','sesi', 'DeptId', 'end_filter', 'start_filter'], 'safe'],
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
        $query = Kontrak::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 30 ],
        ]);
        $query->joinWith('kakitangan');

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);
       
        $query->andFilterWhere(['like', 'tblprcobiodata.CONm', $this->icno])    
            ->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'tarikh_m', $this->tarikh_m]); 
         if($this->status_bsm != null)
        {   
            $query->andFilterWhere(['in', 'status_bsm', $this->status_bsm]);
        }

        return $dataProvider;
    }
}
