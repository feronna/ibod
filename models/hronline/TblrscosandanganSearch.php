<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblrscosandangan;

/**
 * TblrscosandanganSearch represents the model behind the search form of `app\models\hronline\Tblrscosandangan`.
 */
class TblrscosandanganSearch extends Tblrscosandangan
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
            [['id', 'gredjawatan', 'sandangan_id'], 'integer'],
            [['ICNO', 'ApmtTypeCd', 'start_date'], 'safe'],
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
        $query = Tblrscosandangan::find();

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
            'gredjawatan' => $this->gredjawatan,
            'sandangan_id' => $this->sandangan_id,
            'start_date' => $this->start_date,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'ApmtTypeCd', $this->ApmtTypeCd]);

        return $dataProvider;
    }
}
