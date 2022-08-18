<?php

namespace app\models\Kemudahan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kemudahan\Refpegawai2;

/**
 * Refpegawai2Search represents the model behind the search form of `app\models\Kemudahan\Refpegawai2`.
 */
class Refpegawai2Search extends Refpegawai2
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'isActive'], 'integer'],
            [['icno', 'admin_post'], 'safe'],
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
        $query = Refpegawai2::find();

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
            'isActive' => $this->isActive,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'admin_post', $this->admin_post])
         ->andFilterWhere(['like', 'id', $this->id]);

        return $dataProvider;
    }
}
