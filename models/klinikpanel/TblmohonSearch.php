<?php

namespace app\models\klinikpanel;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\klinikpanel\Tblmohon;

/**
 * TblmohonSearch represents the model behind the search form of `app\models\klinikpanel\Tblmohon`.
 */
class TblmohonSearch extends Tblmohon
{
    public $CONm;
    public $dept;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'entry_id', 'status'], 'integer'],
            [['icno', 'entry_dt', 'entry_remarks', 'verify_dt', 'verify_by', 'verify_remarks', 'app_dt', 'app_by', 'app_remarks'], 'safe'],
            [['jumlah_mohon'], 'number'],
            [['CONm','dept'], 'safe'],
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
        $query = Tblmohon::find()
                ->joinWith('biodata')
                 ->joinWith('department')
                // ->where(['NOT IN', 'hrm.myhealth_tblmohon.status', [3,4]])
                ->orderBy(['entry_dt' => SORT_DESC]);

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
            'entry_id' => $this->entry_id,
            'jumlah_mohon' => $this->jumlah_mohon,
            'status' => $this->status,
            'entry_dt' => $this->entry_dt,
            'verify_dt' => $this->verify_dt,
            'app_dt' => $this->app_dt,
        ]);

        $query->andFilterWhere(['like', 'hrm.myhealth_tblmohon.icno', $this->icno])
            ->andFilterWhere(['like', 'entry_remarks', $this->entry_remarks])
            ->andFilterWhere(['like', 'verify_by', $this->verify_by])
            ->andFilterWhere(['like', 'verify_remarks', $this->verify_remarks])
            ->andFilterWhere(['like', 'app_by', $this->app_by])
            ->andFilterWhere(['like', 'hronline.tblprcobiodata.CONm', $this->CONm])
            ->andFilterWhere(['=', 'hronline.department.id', $this->dept])
            ->andFilterWhere(['like', 'app_remarks', $this->app_remarks]);

        return $dataProvider;
    }
}
