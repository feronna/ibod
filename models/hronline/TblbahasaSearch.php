<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblbahasa;

/**
 * TblbahasaSearch represents the model behind the search form of `app\models\hronline\Tblbahasa`.
 */
class TblbahasaSearch extends Tblbahasa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'LangSkillOral', 'LangCd', 'LangSkillWritten'], 'safe'],
            [['LangSkillCert', 'id'], 'integer'],
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
        $query = Tblbahasa::find();

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
            'LangSkillCert' => $this->LangSkillCert,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'LangSkillOral', $this->LangSkillOral])
            ->andFilterWhere(['like', 'LangCd', $this->LangCd])
            ->andFilterWhere(['like', 'LangSkillWritten', $this->LangSkillWritten]);

        return $dataProvider;
    }
}
