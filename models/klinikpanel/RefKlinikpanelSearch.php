<?php

namespace app\models\klinikpanel;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\klinikpanel\RefKlinikpanel;

/**
 * RefKlinikpanelSearch represents the model behind the search form of `app\models\klinikpanel\RefKlinikpanel`.
 */
class RefKlinikpanelSearch extends RefKlinikpanel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['klinik_id', 'isActive'], 'integer'],
            [['nama', 'alamat', 'fax', 'telefon', 'created_by', 'tarikhproses', 'updateoleh', 'tarikhupdate', 'saga_id', 'klinik_ref', 'klinik_email'], 'safe'],
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
        $query = RefKlinikpanel::find()->where(['isActive'=>1])->orderBy(['nama'=>SORT_ASC]);

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
            'klinik_id' => $this->klinik_id,
            'tarikhproses' => $this->tarikhproses,
            'tarikhupdate' => $this->tarikhupdate,
            'isActive' => $this->isActive,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'telefon', $this->telefon])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updateoleh', $this->updateoleh])
            ->andFilterWhere(['like', 'saga_id', $this->saga_id])
            ->andFilterWhere(['like', 'klinik_ref', $this->klinik_ref])
            ->andFilterWhere(['like', 'klinik_email', $this->klinik_email]);

        return $dataProvider;
    }
}
