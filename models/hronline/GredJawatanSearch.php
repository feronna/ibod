<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\GredJawatan;
use Yii;

class GredJawatanSearch extends GredJawatan
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    } 

    public function rules() {
        return [
                [['id','nama', 'fname', 'short_desc','gred_skim', 'job_category', 'job_group', 'cpd_group', 'gred_status', 
                    'gred','gred_no',
                    'isActive', 'isKhas'], 'safe'],        
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
        $query = GredJawatan::find();

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
            'gred_no' => $this->gred_no,
            'isActive' => $this->isActive,
            'job_category' => $this->job_category,
        ]);

        $query->andFilterWhere(['like', 'gred', $this->gred])
        ->andFilterWhere(['like', 'nama', $this->nama]);

        return $dataProvider;
    }
}
