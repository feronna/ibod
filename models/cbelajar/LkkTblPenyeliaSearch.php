<?php

namespace app\models\cbelajar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cbelajar\LkkTblPenyelia;

/**
 * LkkTblPenyeliaSearch represents the model behind the search form of `app\models\cbelajar\LkkTblPenyelia`.
 */
class LkkTblPenyeliaSearch extends LkkTblPenyelia
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'access_level'], 'integer'],
            [['icno', 'nama', 'emel', 'jawatan', 'jabatan', 'password', 'last_login', 'last_ipaccess', 'staff_icno', 'HighestEduLevelCd'], 'safe'],
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
        $query = LkkTblPenyelia::find();

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
            'access_level' => $this->access_level,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'emel', $this->emel])
            ->andFilterWhere(['like', 'jawatan', $this->jawatan])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'last_login', $this->last_login])
            ->andFilterWhere(['like', 'last_ipaccess', $this->last_ipaccess])
            ->andFilterWhere(['like', 'staff_icno', $this->staff_icno])
            ->andFilterWhere(['like', 'HighestEduLevelCd', $this->HighestEduLevelCd]);

        return $dataProvider;
    }
}
