<?php

namespace app\models\mohonjawatan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mohonjawatan\TblPermohonan;

/**
 * TblPermohonanSearch represents the model behind the search form of `app\models\mohonjawatan\TblPermohonan`.
 */
class TblPermohonanSearch extends TblPermohonan {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'bilangan'], 'integer'],
            [['icno', 'tujuan', 'doc_sokongan', 'latarbelakang', 'ori_org', 'fungsi_ori', 'new_org', 'fungsi_new', 'ringkasan', 'jawatan_dipohon', 'implikasi_kewangan', 'justifikasi'], 'safe'],
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
        $query = TblPermohonan::find();

        // add conditions that should always apply here
            $query->joinWith(['dept']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
          $dataProvider->sort->attributes['dept.shortname'] = [
        'asc' => ['dept.shortname' => SORT_ASC],
        'desc' => ['dept.shortname' => SORT_DESC],
    ];
          $dataProvider->sort->attributes['jawatan_dipohon'] = [
        'asc' => ['jawatan_dipohon.shortname' => SORT_ASC],
        'desc' => ['jawatan_dipohon.shortname' => SORT_DESC],
    ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'bilangan' => $this->bilangan,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno])
                ->andFilterWhere(['like', 'tujuan', $this->tujuan])
                ->andFilterWhere(['like', 'doc_sokongan', $this->doc_sokongan])
                ->andFilterWhere(['like', 'latarbelakang', $this->latarbelakang])
                ->andFilterWhere(['like', 'ori_org', $this->ori_org])
                ->andFilterWhere(['like', 'fungsi_ori', $this->fungsi_ori])
                ->andFilterWhere(['like', 'new_org', $this->new_org])
                ->andFilterWhere(['like', 'fungsi_new', $this->fungsi_new])
                ->andFilterWhere(['like', 'ringkasan', $this->ringkasan])
                ->andFilterWhere(['like', 'jawatan_dipohon', $this->jawatan_dipohon])
                ->andFilterWhere(['like', 'implikasi_kewangan', $this->implikasi_kewangan])
                ->andFilterWhere(['like', 'justifikasi', $this->justifikasi]);

        return $dataProvider;
    }

}
