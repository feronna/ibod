<?php

namespace app\models\klinikpanel;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\klinikpanel\Tblmaxtuntutan;

/**
 * TblmaxtuntutanSearch represents the model behind the search form of `app\models\klinikpanel\Tblmaxtuntutan`.
 */
class TblmaxtuntutanSearch extends Tblmaxtuntutan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['max_icno', 'last_update', 'last_updater'], 'safe'],
            [['max_tuntutan', 'current_balance', 'topup_max', 'tuntutan_bukan_panel', 'jum_tuntutan'], 'number'],
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
        $query = Tblmaxtuntutan::find();

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
            'max_tuntutan' => $this->max_tuntutan,
            'current_balance' => $this->current_balance,
            'topup_max' => $this->topup_max,
            'tuntutan_bukan_panel' => $this->tuntutan_bukan_panel,
            'jum_tuntutan' => $this->jum_tuntutan,
            'last_update' => $this->last_update,
        ]);

        $query->andFilterWhere(['like', 'max_icno', $this->max_icno])
            ->andFilterWhere(['like', 'last_updater', $this->last_updater]);

        return $dataProvider;
    }
}
