<?php

namespace app\models\ejobs;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ejobs\TblpPermohonan;

/**
 * TblpPermohonanSearch represents the model behind the search form of `app\models\ejobs\TblpPermohonan`.
 */
class TblpPermohonanSearch extends TblpPermohonan {

    public $jawatan_id;
    public $nama;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'iklan_id', 'jenis_user_id', 'status_id', 'status_saringan_id', 'dustBstatus'], 'integer'],
            [['ICNO', 'tarikh_mohon', 'tarikh_tutup', 'pengakuanTxt', 'jawatan_id', 'nama'], 'safe'],
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
        if ($params) {
            $query = TblpPermohonan::find()->where(['jenis_user_id' => 2])->orderBy(['tarikh_mohon' => SORT_ASC]);

            $query->joinWith(['biodataOrgAwam']);
            $query->joinWith(['iklan']);
        } else {
            $query = TblpPermohonan::find()->where(['ICNO' => null]);
        }

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
            'iklan_id' => $this->iklan_id,
            'jenis_user_id' => $this->jenis_user_id,
            'tarikh_mohon' => $this->tarikh_mohon,
            'tarikh_tutup' => $this->tarikh_tutup,
            'status_id' => $this->status_id,
            'status_saringan_id' => $this->status_saringan_id,
            'dustBstatus' => $this->dustBstatus,
            'jawatan_id' => $this->jawatan_id,
        ]);

        $query->andFilterWhere(['like', 'tbl_permohonan.ICNO', $this->ICNO])
                ->andFilterWhere(['like', 'pengakuanTxt', $this->pengakuanTxt])
//            ->andFilterWhere(['like', 'tblprcobiodata.CONm', $this->nama])
                ->andFilterWhere(['like', 'tbl_biodata.CONm', $this->nama]);

        return $dataProvider;
    }

}
