<?php

namespace app\models\keselamatan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\keselamatan\TblShiftKeselamatan;

/**
 * TblShiftKeselamatanSearch represents the model behind the search form of `app\models\keselamatan\TblShiftKeselamatan`.
 */
class TblShiftKeselamatanSearch extends TblShiftKeselamatan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'shift_id'], 'integer'],
            [['icno', 'tarikh', 'year', 'month'], 'safe'],
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
        // $query = (new \yii\db\Query())
        // ->select(" id,icno,tarikh,YEAR,MONTH,shift_id,
        // unit_id,pos_kawalan_id,campus_id")
        // ->from('keselamatan.tbl_shift_keselamatan');
        // $query2 = (new \yii\db\Query())
        // ->select(" id,icno,tarikh,YEAR,MONTH,shift_id,
        // unit_id,pos_kawalan_id,campus_id")
        // ->from('keselamatan.tbl_ot');
        // $query3 = (new \yii\db\Query())
        // ->select(" id,icno,tarikh,YEAR,MONTH,lmt_id,
        // unit_id,pos_kawalan_id,campus_id")
        // ->from('keselamatan.tbl_lmt');
        $query = TblShiftKeselamatan::find();
    //    $query = $query1->union($query2)->union($query3);

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
        // $query->andFilterWhere([
            // 'id' => $this->id,
            // 'tarikh' => $this->tarikh,
            // 'year' => $this->year,
            // 'shift_id' => $this->shift_id,
        // ]);

        if (empty($this->tarikh)) {
            // var_dump('dds');die;

            $query->andFilterWhere(['=', 'tarikh', date('Y-m-d')]);
        }

        return $dataProvider;
    }
}
