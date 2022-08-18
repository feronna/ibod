<?php

namespace app\models\hronline;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\TblAdminRP;


class TblAdminRPSearch extends TblAdminRP
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno', 'access_type'], 'required', 'message'=>'Ruang ini adalah mandatori.'],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        
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
        $query = TblAdminRP::find();

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
            'isActive' => $this->isActive,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'access_type', $this->access_type]);

        return $dataProvider;
    }
}
