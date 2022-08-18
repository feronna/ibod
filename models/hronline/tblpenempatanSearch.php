<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\tblpenempatan;

/**
 * tblpenempatanSearch represents the model behind the search form of `app\models\hronline\tblpenempatan`.
 */
class tblpenempatanSearch extends tblpenempatan
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
            [['id', 'dept_id', 'campus_id', 'reason_id'], 'integer'],
            [['ICNO', 'date_start', 'date_update', 'remark', 'letter_order_refno', 'date_letter_order', 'letter_refno', 'update_by'], 'safe'],
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
        $query = tblpenempatan::find();

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
            'date_start' => $this->date_start,
            'date_update' => $this->date_update,
            'dept_id' => $this->dept_id,
            'campus_id' => $this->campus_id,
            'reason_id' => $this->reason_id,
            'date_letter_order' => $this->date_letter_order,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'letter_order_refno', $this->letter_order_refno])
            ->andFilterWhere(['like', 'letter_refno', $this->letter_refno])
            ->andFilterWhere(['like', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
