<?php

namespace app\models\myintegriti;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myintegriti\TblPenilaian;
use yii\db\Expression;

/**
 * TblPenilaianSearch represents the model behind the search form of `app\models\myintegriti\TblPenilaian`.
 */
class TblPenilaianSearch extends TblPenilaian
{
    /**
     * {@inheritdoc}
     */
    public $CONm;
    public function rules()
    {
        return [
            [['id', 'tahun', 'status', 'dept_id'], 'integer'],
            [['icno', 'created_dt', 'CONm'], 'safe'],
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
        $query = TblPenilaian::find()->where(['itg_tbl_penilaian.status' => 2]);

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
        
        
            $query = $query->innerJoinWith('biodata', false)->andFilterWhere(['like', 'CONm', $this->CONm]);
     
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tahun' => $this->tahun,
            'status' => $this->status,
            'dept_id' => $this->dept_id,
            'gred_id' => $this->gred_id,
        ]);

        $query->andFilterWhere(['like', 'icno', $this->icno]);
        $query->andFilterWhere(['=', new Expression('CAST(`created_dt` as DATE)'), $this->created_dt]);

        return $dataProvider;
    }
}
