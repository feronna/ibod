<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\tblrscopsnstatus;

/**
 * tblrscopsnstatusSearch represents the model behind the search form of `app\models\hronline\tblrscopsnstatus`.
 */
class tblrscopsnstatusSearch extends tblrscopsnstatus
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
            [['ICNO', 'PsnStatusCd', 'PsnStatusNo', 'PsnIncomeTaxNo', 'PsnEpfNo', 'PsnStatusStDt'], 'safe'],
            [['id'], 'integer'],
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
        $query = tblrscopsnstatus::find();

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
            'PsnStatusStDt' => $this->PsnStatusStDt,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'PsnStatusCd', $this->PsnStatusCd])
            ->andFilterWhere(['like', 'PsnStatusNo', $this->PsnStatusNo])
            ->andFilterWhere(['like', 'PsnIncomeTaxNo', $this->PsnIncomeTaxNo])
            ->andFilterWhere(['like', 'PsnEpfNo', $this->PsnEpfNo]);

        return $dataProvider;
    }
}
