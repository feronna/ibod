<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblrscoapmtstatus;

/**
 * TblrscoapmtstatusSearch represents the model behind the search form of `app\models\hronline\Tblrscoapmtstatus`.
 */
class TblrscoapmtstatusSearch extends Tblrscoapmtstatus
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
            [['ICNO', 'ApmtStatusStDt', 'ApmtStatusEndDt'], 'safe'],
            [['ApmtStatusCd', 'id'], 'integer'],
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
        $query = Tblrscoapmtstatus::find();

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
            'ApmtStatusCd' => $this->ApmtStatusCd,
            'ApmtStatusStDt' => $this->ApmtStatusStDt,
            'ApmtStatusEndDt' => $this->ApmtStatusEndDt,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO]);

        return $dataProvider;
    }
}
