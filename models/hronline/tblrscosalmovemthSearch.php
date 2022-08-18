<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\tblrscosalmovemth;

/**
 * tblrscosalmovemthSearch represents the model behind the search form of `app\models\hronline\tblrscosalmovemth`.
 */
class tblrscosalmovemthSearch extends tblrscosalmovemth
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'SalMoveMth', 'SalMoveMthStDt'], 'safe'],
            [['SalMoveMthType', 'id'], 'integer'],
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
        $query = tblrscosalmovemth::find();

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
            'SalMoveMthType' => $this->SalMoveMthType,
            'SalMoveMthStDt' => $this->SalMoveMthStDt,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'SalMoveMth', $this->SalMoveMth]);

        return $dataProvider;
    }
}
