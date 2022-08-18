<?php

namespace app\models\tatatertib_staf;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\tatatertib_staf\TblRekod;

/**
 * TblRekodSearch represents the model behind the search form of `app\models\tatatertib_staf\TblRekod`.
 */
class TblRekodSearch extends TblRekod
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jabatan'], 'integer'],
            [['icno', 'nama', 'kes', 'icno_kp'], 'safe'],
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
        $query = TblRekod::find();

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
            'jabatan' => $this->jabatan,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'kes', $this->kes])
            ->andFilterWhere(['like', 'icno_kp', $this->icno_kp]);

        return $dataProvider;
    }
}
