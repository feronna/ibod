<?php

namespace app\models\saman;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\saman\SamanStatus;

/**
 * SamanStatusSearch represents the model behind the search form of `app\models\saman\SamanStatus`.
 */
class SamanStatusSearch extends SamanStatus
{
    /**
     * {@inheritdoc}
     */
    public $nokenderaan;
    public $icno;
    public function rules()
    {
        return [
            [['NOSAMAN', 'STATUS', 'INSERTDATE', 'PAIDDATE', 'UPDATER', 'CATATAN','nokenderaan','icno'], 'safe'],
            [['AMOUNT_PENDING', 'AMNKUNCI', 'AMOUNT_PAID', 'AMNKUNCI_PAID'], 'number'],
            [['ID'], 'integer'],
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
        $query = SamanStatus::find()->joinWith('saman')->orderBy(['ekeselamatan.t_19_eks_bayar.STATUS' => SORT_DESC]);

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
            'INSERTDATE' => $this->INSERTDATE,
            'PAIDDATE' => $this->PAIDDATE,
            'AMOUNT_PENDING' => $this->AMOUNT_PENDING,
            'AMNKUNCI' => $this->AMNKUNCI,
            'AMOUNT_PAID' => $this->AMOUNT_PAID,
            'ID' => $this->ID,
            'AMNKUNCI_PAID' => $this->AMNKUNCI_PAID,
        ]);

        $query->andFilterWhere(['like', 'ekeselamatan.t_19_eks_bayar.NOSAMAN', $this->NOSAMAN])
            ->andFilterWhere(['like', 'ekeselamatan.t_19_eks_bayar.STATUS', $this->STATUS])
            ->andFilterWhere(['like', 'UPDATER', $this->UPDATER])
            ->andFilterWhere(['like', 'CATATAN', $this->CATATAN]);

            if (!empty($this->nokenderaan)) {
                $query->andFilterWhere([
                    'NO_KENDERAAN' => $this->nokenderaan,
                ]);
            }
            if (!empty($this->icno)) {
                $query->andFilterWhere([
                    'ICNO' => $this->icno,
                ]);
            }
        return $dataProvider;
    }
}
