<?php

namespace app\models\lnpk;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\lnpk\TblMain;

/**
 * TblMainSearch represents the model behind the search form of `app\models\lnpk\TblMain`.
 */
class TblMainSearch extends TblMain
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lnpk_id', 'lnpk_jenis', 'PYD_sts_lantikan', 'gred_jawatan_id', 'jspiu', 'gred_jawatan_id_PPP', 'jspiu_PPP', 'PPP_sah', 'is_deleted'], 'integer'],
            [['lnpk_datetime', 'PYD', 'tahun', 'PPP', 'PPP_sah_datetime', 'catatan', 'deleted_by', 'deleted_datetime'], 'safe'],
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
        $query = TblMain::find();

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

        // if (is_null($params) || empty($params)) {
        //     $query->where('0 = 1');
        //     return $dataProvider;
        // }

        // grid filtering conditions
        $query->andFilterWhere([
            'lnpk_id' => $this->lnpk_id,
            'lnpk_datetime' => $this->lnpk_datetime,
            'lnpk_jenis' => $this->lnpk_jenis,
            'PYD_sts_lantikan' => $this->PYD_sts_lantikan,
            'gred_jawatan_id' => $this->gred_jawatan_id,
            'tahun' => $this->tahun,
            'jspiu' => $this->jspiu,
            'gred_jawatan_id_PPP' => $this->gred_jawatan_id_PPP,
            'jspiu_PPP' => $this->jspiu_PPP,
            'PPP_sah' => $this->PPP_sah,
            'PPP_sah_datetime' => $this->PPP_sah_datetime,
            'is_deleted' => $this->is_deleted,
            'deleted_datetime' => $this->deleted_datetime,
        ]);

        $query
            ->andFilterWhere(['PYD' => $this->PYD])
            ->andFilterWhere(['PPP' => $this->PPP])
            ->andFilterWhere(['like', 'catatan', $this->catatan])
            ->andFilterWhere(['like', 'deleted_by', $this->deleted_by]);

        return $dataProvider;
    }

    public function formName()
    {
        return '';
    }
}
