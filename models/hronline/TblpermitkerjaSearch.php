<?php

namespace app\models\hronline;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\hronline\Tblpermitkerja;

/**
 * TblpermitkerjaSearch represents the model behind the search form of `app\models\hronline\Tblpermitkerja`.
 */
class TblpermitkerjaSearch extends Tblpermitkerja
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO', 'WrkPermitNo', 'WrkPermitIssueDt', 'WrkPermitExpiryDt', 'ImigRefNo'], 'safe'],
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
        $query = Tblpermitkerja::find();

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
            'WrkPermitIssueDt' => $this->WrkPermitIssueDt,
            'WrkPermitExpiryDt' => $this->WrkPermitExpiryDt,
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'ICNO', $this->ICNO])
            ->andFilterWhere(['like', 'WrkPermitNo', $this->WrkPermitNo])
            ->andFilterWhere(['like', 'ImigRefNo', $this->ImigRefNo]);

        return $dataProvider;
    }
}
