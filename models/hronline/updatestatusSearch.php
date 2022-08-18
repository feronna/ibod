<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\updatestatus;

/**
 * updatestatusSearch represents the model behind the search form of `app\models\hronline\updatestatus`.
 */
class updatestatusSearch extends updatestatus
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
            [['usern', 'COTableName', 'COUpadteDate', 'COUpdateIP', 'COUpdateComp', 'COUpdateCompUser', 'COUpdateSQL', 'idval'], 'safe'],
            [['COActivity', 'id'], 'integer'],
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
        $query = updatestatus::find();

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
            'COActivity' => $this->COActivity,
            'COUpadteDate' => $this->COUpadteDate,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'usern', $this->usern])
            ->andFilterWhere(['like', 'COTableName', $this->COTableName])
            ->andFilterWhere(['like', 'COUpdateIP', $this->COUpdateIP])
            ->andFilterWhere(['like', 'COUpdateComp', $this->COUpdateComp])
            ->andFilterWhere(['like', 'COUpdateCompUser', $this->COUpdateCompUser])
            ->andFilterWhere(['like', 'COUpdateSQL', $this->COUpdateSQL])
            ->andFilterWhere(['like', 'idval', $this->idval]);

        return $dataProvider;
    }
}
