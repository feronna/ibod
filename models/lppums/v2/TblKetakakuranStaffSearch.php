<?php

namespace app\models\lppums\v2;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\lppums\v2\TblKetakakuranStaff;

/**
 * TblKetakakuranStaffSearch represents the model behind the search form of `app\models\lppums\v2\TblKetakakuranStaff`.
 */
class TblKetakakuranStaffSearch extends TblKetakakuranStaff
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'icno', 'created_by'], 'integer'],
            [['content', 'file_name', 'filehash', 'created_dt'], 'safe'],
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
        $query = TblKetakakuranStaff::find();

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
            'icno' => $this->icno,
            'created_dt' => $this->created_dt,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'filehash', $this->filehash]);

        return $dataProvider;
    }
}
