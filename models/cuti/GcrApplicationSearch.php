<?php

namespace app\models\cuti;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cuti\GcrApplication;

/**
 * GcrApplicationSearch represents the model behind the search form of `app\models\cuti\GcrApplication`.
 */
class GcrApplicationSearch extends GcrApplication
{
    /**
     * {@inheritdoc}
     */
    public $year;
    public $jenis_carian;
    public $carian_data;
    public function rules()
    {
        return [
            [['year','jenis_carian','carian_data'], 'safe'],
            [['id', 'leave_balance', 'gcr_applied', 'cbth_applied', 'dept_id', 'agreement', 'isActive'], 'integer'],
            [['pemohon_icno', 'mohon_dt', 'semakan_remark', 'semakan_by', 'semakan_dt', 'peraku_by', 'peraku_dt', 'lulus_by', 'lulus_dt', 'bsm_semak', 'bsm_semak_dt', 'status'], 'safe'],
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
        $query = GcrApplication::find();
        $query->joinWith(['kakitangan']);

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
            // 'id' => $this->id,
            // 'mohon_dt' => $this->mohon_dt,
            // 'leave_balance' => $this->leave_balance,
            // 'gcr_applied' => $this->gcr_applied,
            // 'cbth_applied' => $this->cbth_applied,
            // 'semakan_dt' => $this->semakan_dt,
            // 'peraku_dt' => $this->peraku_dt,
            // 'lulus_dt' => $this->lulus_dt,
            // 'bsm_semak_dt' => $this->bsm_semak_dt,
            // 'dept_id' => $this->dept_id,
            // 'agreement' => $this->agreement,
            // 'isActive' => $this->isActive,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);

        if (!empty($this->year)) {
            $query->andFilterWhere([
                'LIKE', 'YEAR(mohon_dt)', $this->year
            ]);
        }
            if (!empty($this->isActive)) {
                $query->andFilterWhere([
                    '=', 'isActive', $this->isActive
                ]);
            }
        return $dataProvider;
    }
}
