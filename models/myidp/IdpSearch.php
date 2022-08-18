<?php

namespace app\models\myidp;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\myidp\Idp;

/**
 * IdpSearch represents the model behind the search form of `app\models\myidp\Idp`.
 */
class IdpSearch extends Idp
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tahun', 'susunan', 'kumpulan', 'v_co_app_cd', 'campus_id', 'DeptId', 'v_co_tempoh_sandangan_month', 'kategori', 'tahap', 'gredjawatan', 'v_co_cpd_group', 'v_mata_minima', 'v_mata_terkumpul', 'v_cf_umum', 'v_idp_teras', 'v_idp_elektif', 'v_idp_umum', 'isPegawaiUtama', 'bhgn_id', 'ServStatusCd', 'v_matamin_teras_uni', 'v_idp_teras_uni', 'v_cf_teras_skim', 'v_matamin_teras_skim', 'v_idp_teras_skim', 'v_cf_elektif', 'v_matamin_elektif'], 'integer'],
            [['nama_kumpulan', 'v_co_icno', 'v_co_umsper', 'v_co_title', 'v_co_name', 'v_co_gender', 'v_co_sts', 'v_co_app', 'v_co_app_startdate', 'v_co_campus', 'v_co_gred', 'v_co_jwtn', 'v_co_dept_sn', 'v_co_dept_fn', 'v_co_job_grp', 'v_co_cpd_group_name', 'v_co_sand_date', 'gred_skim', 'gred_no', 'pp', 'hod', 'updatedate', 'ServStatusNm', 'ServStatusStDt'], 'safe'],
            [['v_co_tempoh_sandangan_year'], 'number'],
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
        $query = Idp::find();

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
            'tahun' => $this->tahun,
            'susunan' => $this->susunan,
            'kumpulan' => $this->kumpulan,
            'v_co_app_cd' => $this->v_co_app_cd,
            'v_co_app_startdate' => $this->v_co_app_startdate,
            'campus_id' => $this->campus_id,
            'DeptId' => $this->DeptId,
            'v_co_sand_date' => $this->v_co_sand_date,
            'v_co_tempoh_sandangan_month' => $this->v_co_tempoh_sandangan_month,
            'v_co_tempoh_sandangan_year' => $this->v_co_tempoh_sandangan_year,
            'kategori' => $this->kategori,
            'tahap' => $this->tahap,
            'gredjawatan' => $this->gredjawatan,
            'v_co_cpd_group' => $this->v_co_cpd_group,
            'v_mata_minima' => $this->v_mata_minima,
            'v_mata_terkumpul' => $this->v_mata_terkumpul,
            'v_cf_umum' => $this->v_cf_umum,
            'v_idp_teras' => $this->v_idp_teras,
            'v_idp_elektif' => $this->v_idp_elektif,
            'v_idp_umum' => $this->v_idp_umum,
            'isPegawaiUtama' => $this->isPegawaiUtama,
            'updatedate' => $this->updatedate,
            'bhgn_id' => $this->bhgn_id,
            'ServStatusCd' => $this->ServStatusCd,
            'ServStatusStDt' => $this->ServStatusStDt,
            'v_matamin_teras_uni' => $this->v_matamin_teras_uni,
            'v_idp_teras_uni' => $this->v_idp_teras_uni,
            'v_cf_teras_skim' => $this->v_cf_teras_skim,
            'v_matamin_teras_skim' => $this->v_matamin_teras_skim,
            'v_idp_teras_skim' => $this->v_idp_teras_skim,
            'v_cf_elektif' => $this->v_cf_elektif,
            'v_matamin_elektif' => $this->v_matamin_elektif,
        ]);

        $query->andFilterWhere(['like', 'nama_kumpulan', $this->nama_kumpulan])
            ->andFilterWhere(['like', 'v_co_icno', $this->v_co_icno])
            ->andFilterWhere(['like', 'v_co_umsper', $this->v_co_umsper])
            ->andFilterWhere(['like', 'v_co_title', $this->v_co_title])
            ->andFilterWhere(['like', 'v_co_name', $this->v_co_name])
            ->andFilterWhere(['like', 'v_co_gender', $this->v_co_gender])
            ->andFilterWhere(['like', 'v_co_sts', $this->v_co_sts])
            ->andFilterWhere(['like', 'v_co_app', $this->v_co_app])
            ->andFilterWhere(['like', 'v_co_campus', $this->v_co_campus])
            ->andFilterWhere(['like', 'v_co_gred', $this->v_co_gred])
            ->andFilterWhere(['like', 'v_co_jwtn', $this->v_co_jwtn])
            ->andFilterWhere(['like', 'v_co_dept_sn', $this->v_co_dept_sn])
            ->andFilterWhere(['like', 'v_co_dept_fn', $this->v_co_dept_fn])
            ->andFilterWhere(['like', 'v_co_job_grp', $this->v_co_job_grp])
            ->andFilterWhere(['like', 'v_co_cpd_group_name', $this->v_co_cpd_group_name])
            ->andFilterWhere(['like', 'gred_skim', $this->gred_skim])
            ->andFilterWhere(['like', 'gred_no', $this->gred_no])
            ->andFilterWhere(['like', 'pp', $this->pp])
            ->andFilterWhere(['like', 'hod', $this->hod])
            ->andFilterWhere(['like', 'ServStatusNm', $this->ServStatusNm]);

        return $dataProvider;
    }
}
