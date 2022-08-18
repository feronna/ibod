<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\MajorMinor;

/**
 * MajorMinorSearch represents the model behind the search form of `app\models\hronline\MajorMinor`.
 */
class MajorMinorSearch extends MajorMinor
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
            [['MajorMinorCd', 'MajorMinor', 'MajorMinorStDt', 'MajorMinorEndDt'], 'safe'],
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
        $query = MajorMinor::find();

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
        $query->andFilterWhere(['like', 'MajorMinorCd', $this->MajorMinorCd])
            ->andFilterWhere(['like', 'MajorMinor', $this->MajorMinor])
            ->andFilterWhere(['like', 'MajorMinorStDt', $this->MajorMinorStDt])
            ->andFilterWhere(['like', 'MajorMinorEndDt', $this->MajorMinorEndDt]);

        return $dataProvider;
    }
}
