<?php

namespace app\models\esticker;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\esticker\TblRekodKontraktor;

/**
 * LaporanKontraktorHarianSearch represents the model behind the search form of `app\models\esticker\TblRekodKontraktor`.
 */
class LaporanKontraktorHarianSearch extends TblRekodKontraktor {

    public $bulanan,$syarikat_id;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'campus_id'], 'integer'],
            [['syarikat_id','bulanan', 'ICNO', 'reg_number', 'veh_color', 'veh_type', 'place', 'check_in', 'check_out', 'created_by', 'flag', 'flag_open_reason', 'flag_created_at', 'flag_created_by', 'flag_closed_reason', 'flag_updated_at', 'flag_updated_by'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params) {
        $query = TblRekodKontraktor::find()->joinWith('pekerja');

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
            'stc_kontraktor_in_out.ICNO' => $this->ICNO,
            'id' => $this->id,
            'campus_id' => $this->campus_id,
            'DATE(check_in)' => $this->check_in,
            'DATE_FORMAT(check_in, "%m-%Y")' => $this->bulanan,
            'check_out' => $this->check_out,
            'flag_created_at' => $this->flag_created_at,
            'flag_updated_at' => $this->flag_updated_at,
            'utils_pekerja_kontraktor.id_kontraktor' => $this->syarikat_id,
        ]);

        $query->andFilterWhere(['like', 'reg_number', $this->reg_number])
                ->andFilterWhere(['like', 'veh_color', $this->veh_color])
                ->andFilterWhere(['like', 'veh_type', $this->veh_type])
                ->andFilterWhere(['like', 'place', $this->place])
                ->andFilterWhere(['like', 'created_by', $this->created_by])
                ->andFilterWhere(['like', 'flag', $this->flag])
                ->andFilterWhere(['like', 'flag_open_reason', $this->flag_open_reason])
                ->andFilterWhere(['like', 'flag_created_by', $this->flag_created_by])
                ->andFilterWhere(['like', 'flag_closed_reason', $this->flag_closed_reason])
                ->andFilterWhere(['like', 'flag_updated_by', $this->flag_updated_by]); 
        return $dataProvider;
    }

}
