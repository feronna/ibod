<?php

namespace app\models\cbelajar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cbelajar\RekodCb;

/**
 * RekodCbSearch represents the model behind the search form of `app\models\cbelajar\RekodCb`.
 */
class RekodCbSearch extends RekodCb
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tahun', 'HighestEduLevelCd'], 'integer'],
            [['CONm', 'umur', 'icno', 'umsper', 'gredJawatan', 'COEmail', 'HighestEduLevel', 'InstNm', 'Country', 'major', 'nama_tajaan', 'tarikh_mula', 'tarikh_tamat'], 'safe'],
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
        $query = RekodCb::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
//        $icno = app\models\hronline\Tblprcobiodata::find()->
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tahun' => $this->tahun,
            'HighestEduLevelCd' => $this->HighestEduLevelCd,
        ]);

        $query->andFilterWhere(['like', 'CONm', $this->CONm])
//            ->andFilterWhere(['like', 'umur', $this->umur])
            ->orFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'umsper', $this->umsper])
            ->andFilterWhere(['like', 'gredJawatan', $this->gredJawatan])
            ->andFilterWhere(['like', 'COEmail', $this->COEmail])
            ->andFilterWhere(['like', 'HighestEduLevel', $this->HighestEduLevel])
            ->andFilterWhere(['like', 'InstNm', $this->InstNm])
            ->andFilterWhere(['like', 'Country', $this->Country])
            ->andFilterWhere(['like', 'major', $this->major])
            ->andFilterWhere(['like', 'nama_tajaan', $this->nama_tajaan])
            ->andFilterWhere(['like', 'tarikh_mula', $this->tarikh_mula])
            ->andFilterWhere(['like', 'tarikh_tamat', $this->tarikh_tamat]);

        return $dataProvider;
    }
}
