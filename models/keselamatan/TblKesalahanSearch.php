<?php

namespace app\models\keselamatan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\keselamatan\TblKesalahan;

/**
 * TblKesalahanSearch represents the model behind the search form of `app\models\keselamatan\TblKesalahan`.
 */
class TblKesalahanSearch extends TblKesalahan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'thtc', 'thlm', 'thtm', 'lhb', 'mpktk', 'mlasm', 'thb', 'thp', 'gmk', 'syifA', 'syifB', 'syifC'], 'integer'],
            [['icno', 'month', 'year', 'lain_lain', 'tarikh', 'entry_by', 'entry_dt', 'updated_by', 'update_dt', 'no_rujukan', 'remark', 'remark_status'], 'safe'],
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
        $query = TblKesalahan::find();

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
            'year' => $this->year,
            'thtc' => $this->thtc,
            'thlm' => $this->thlm,
            'thtm' => $this->thtm,
            'lhb' => $this->lhb,
            'mpktk' => $this->mpktk,
            'mlasm' => $this->mlasm,
            'thb' => $this->thb,
            'thp' => $this->thp,
            'gmk' => $this->gmk,
            'syifA' => $this->syifA,
            'syifB' => $this->syifB,
            'syifC' => $this->syifC,
            'tarikh' => $this->tarikh,
            'entry_dt' => $this->entry_dt,
            'update_dt' => $this->update_dt,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
            ->andFilterWhere(['like', 'month', $this->month])
            ->andFilterWhere(['like', 'lain_lain', $this->lain_lain])
            ->andFilterWhere(['like', 'entry_by', $this->entry_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by])
            ->andFilterWhere(['like', 'no_rujukan', $this->no_rujukan])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'remark_status', $this->remark_status]);

        return $dataProvider;
    }
}
