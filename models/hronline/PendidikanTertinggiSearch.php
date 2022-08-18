<?php

namespace app\models\hronline;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\PendidikanTertinggi;

/**
 * PendidikanTertinggiSearch represents the model behind the search form of `app\models\hronline\PendidikanTertinggi`.
 */
class PendidikanTertinggiSearch extends PendidikanTertinggi
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
            [['HighestEduLevelCd', 'HighestEduLevelRank', 'status'], 'integer'],
            [['HighestEduLevel', 'HighestEduLevelBI', 'HighestEduLevelInd', 'EduLevelNm', 'EduLevelNmBI', 'HighestEduLevelCdMM'], 'safe'],
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
        $query = PendidikanTertinggi::find();

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
            'HighestEduLevelCd' => $this->HighestEduLevelCd,
            'HighestEduLevelRank' => $this->HighestEduLevelRank,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'HighestEduLevel', $this->HighestEduLevel])
            ->andFilterWhere(['like', 'HighestEduLevelBI', $this->HighestEduLevelBI])
            ->andFilterWhere(['like', 'HighestEduLevelInd', $this->HighestEduLevelInd])
            ->andFilterWhere(['like', 'EduLevelNm', $this->EduLevelNm])
            ->andFilterWhere(['like', 'EduLevelNmBI', $this->EduLevelNmBI])
            ->andFilterWhere(['like', 'HighestEduLevelCdMM', $this->HighestEduLevelCdMM]);

        return $dataProvider;
    }
}
