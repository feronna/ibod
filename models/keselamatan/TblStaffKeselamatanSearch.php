<?php

namespace app\models\keselamatan;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\keselamatan\TblStaffKeselamatan;
//use app\models\hronline\Tblprcobiodata;

/**
 * TblStaffKeselamatanSearch represents the model behind the search form of `app\models\keselamatan\TblStaffKeselamatan`.
 */
class TblStaffKeselamatanSearch extends TblStaffKeselamatan
{
    /**
     * {@inheritdoc}
     */
    public $carian_data;
    public $jenis_carian;
    public $carian_statuslantikan;
    public function rules()
    {
        return [
            [['id', 'unit_id'], 'integer'],
            [['carian_data', 'jenis_carian', 'carian_statuslantikan'], 'safe'],
            [['staff_icno', 'pos_kawalan_id', 'ketua_pos', 'penolong_ketua_pos', 'month', 'year', 'added_by', 'created_at'], 'safe'],
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
        $query = TblStaffKeselamatan::find()->joinWith('staff');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'pos_kawalan_id' => SORT_ASC,
                    // 'id' => SORT_DESC,
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        switch ($this->jenis_carian) {
            case '1':
                $query->andFilterWhere(['like', 'CONm', $this->carian_data]);
                break;
            case '2':
                $query->andFilterWhere(['like', 'COOldID', $this->carian_data]);
                break;
            default:
                $query->andFilterWhere(['like', 'ICNO', $this->carian_data]);
                break;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'unit_id' => $this->unit_id,
            'year' => $this->year,
            'created_at' => $this->created_at,
        ]);

        // $query->andFilterWhere(['like', 'staff_icno', $this->staff_icno])
        //     ->andFilterWhere(['=', 'pos_kawalan_id', $this->pos_kawalan_id])
        //     ->andFilterWhere(['like', 'ketua_pos', $this->ketua_pos])
        //     ->andFilterWhere(['like', 'penolong_ketua_pos', $this->penolong_ketua_pos])
        //     ->andFilterWhere(['like', 'month', $this->month])
        //     ->andFilterWhere(['like', 'added_by', $this->added_by])
        //     ->andFilterWhere(['like', 'CONm', $this->carian_data]);

        if (!empty($this->pos_kawalan_id)) {
            $query->andFilterWhere([
                '=', 'pos_kawalan_id', $this->pos_kawalan_id
            ]);
        }
        if (!empty($this->carian_statuslantikan)) {
            $query->andFilterWhere([
                'statLantikan' => $this->carian_statuslantikan,
            ]);
        }
        return $dataProvider;
    }
}
