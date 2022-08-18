<?php

namespace app\models\Kontraktor;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kontraktor\SyarikatKontraktor;

/**
 * SyarikatKontraktorSearch represents the model behind the search form of `app\models\Kontraktor\SyarikatKontraktor`.
 */
class SyarikatKontraktorSearch extends SyarikatKontraktor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'apsu_status', 'isActive'], 'integer'],
            [['apsu_suppid', 'name', 'jenis_kontrak', 'apsu_address1', 'apsu_address2', 'apsu_address3', 'apsu_phone', 'apsu_email', 'tarikhmula_sah', 'tarikhtamat_sah', 'no_pendaftaran', 'updated_by', 'updated_at'], 'safe'],
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
        $query = SyarikatKontraktor::find();

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
            'name' => $this->name,
            'apsu_status' => $this->apsu_status,
            'tarikhmula_sah' => $this->tarikhmula_sah,
            'tarikhtamat_sah' => $this->tarikhtamat_sah,
            'updated_at' => $this->updated_at,
            'isActive' => $this->isActive,
        ]);

        $query->andFilterWhere(['like', 'apsu_suppid', $this->apsu_suppid])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'jenis_kontrak', $this->jenis_kontrak])
            ->andFilterWhere(['like', 'apsu_address1', $this->apsu_address1])
            ->andFilterWhere(['like', 'apsu_address2', $this->apsu_address2])
            ->andFilterWhere(['like', 'apsu_address3', $this->apsu_address3])
            ->andFilterWhere(['like', 'apsu_phone', $this->apsu_phone])
            ->andFilterWhere(['like', 'apsu_email', $this->apsu_email])
            ->andFilterWhere(['like', 'no_pendaftaran', $this->no_pendaftaran])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by]);

        return $dataProvider;
    }
}
