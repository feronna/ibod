<?php

namespace app\models\esticker;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\esticker\TblKontraktor;

/**
 * SenaraiKontraktorSearch represents the model behind the search form of `app\models\esticker\TblKontraktor`.
 */
class SenaraiKontraktorSearch extends TblKontraktor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apsu_suppid', 'apsu_lname', 'apsu_status', 'apsu_address1', 'apsu_address2', 'apsu_address3', 'apsu_phone', 'apsu_email', 'tarikhmulasah', 'tarikhtamatsah'], 'safe'],
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
        $query = TblKontraktor::find();

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
        $query->andFilterWhere(['like', 'apsu_suppid', $this->apsu_suppid])
            ->andFilterWhere(['like', 'apsu_lname', $this->apsu_lname])
            ->andFilterWhere(['like', 'apsu_status', $this->apsu_status])
            ->andFilterWhere(['like', 'apsu_address1', $this->apsu_address1])
            ->andFilterWhere(['like', 'apsu_address2', $this->apsu_address2])
            ->andFilterWhere(['like', 'apsu_address3', $this->apsu_address3])
            ->andFilterWhere(['like', 'apsu_phone', $this->apsu_phone])
            ->andFilterWhere(['like', 'apsu_email', $this->apsu_email])
            ->andFilterWhere(['like', 'tarikhmulasah', $this->tarikhmulasah])
            ->andFilterWhere(['like', 'tarikhtamatsah', $this->tarikhtamatsah]);

        return $dataProvider;
    }
}
