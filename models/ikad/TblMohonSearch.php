<?php

namespace app\models\Ikad;

use app\models\hronline\GredJawatan;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ikad\TblMohon;

/**
 * TblMohonSearch represents the model behind the search form of `app\models\Ikad\TblMohon`.
 */
class TblMohonSearch extends TblMohon
{
    public $year;
    public $month;
    public $type;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'language_id', 'd_pieces', 'hantar_status', 'status_kad', 'd_peraku_peg','gred_jawatan'], 'integer'],
            [['applier_id', 'title_bm', 'title_bi', 'd_nama', 'd_edu_bi_1', 'd_edu_bi_2', 'd_edu_bm_1', 'd_edu_bm_2', 'd_jawatan_bi', 'd_jawatan_bm', 'd_jbtn_bi', 'd_jbtn_bm', 'd_kampus_bi', 'd_kampus_bm', 'd_kampus2_bi', 'd_kampus2_bm', 'd_office_telno', 'd_office_extno', 'd_faxno', 'd_hpno', 'd_email', 'd_tarikh_mohon', 'd_tarikh_hantar', 'd_status_tarikh', 'd_update_id', 'd_peraku_peg_id', 'd_peraku_peg_dt', 'dept_address_bi_1', 'dept_address_bi_2', 'dept_address_bm_1', 'dept_address_bm_2', 'remark'], 'safe'],
            [['year','month','type'],'safe']
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
        $query = TblMohon::find()->where(['!=','status_kad','3']);

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
            'language_id' => $this->language_id,
            'd_pieces' => $this->d_pieces,
            'd_tarikh_mohon' => $this->d_tarikh_mohon,
            'hantar_status' => $this->hantar_status,
            'd_tarikh_hantar' => $this->d_tarikh_hantar,
            'status_kad' => $this->status_kad,
            'd_status_tarikh' => $this->d_status_tarikh,
            'd_peraku_peg' => $this->d_peraku_peg,
            'd_peraku_peg_dt' => $this->d_peraku_peg_dt,
        ]);

        $query->andFilterWhere(['like', 'applier_id', $this->applier_id])
            ->andFilterWhere(['like', 'title_bm', $this->title_bm])
            ->andFilterWhere(['like', 'title_bi', $this->title_bi])
            ->andFilterWhere(['like', 'd_nama', $this->d_nama])
            ->andFilterWhere(['like', 'd_edu_bi_1', $this->d_edu_bi_1])
            ->andFilterWhere(['like', 'd_edu_bi_2', $this->d_edu_bi_2])
            ->andFilterWhere(['like', 'd_edu_bm_1', $this->d_edu_bm_1])
            ->andFilterWhere(['like', 'd_edu_bm_2', $this->d_edu_bm_2])
            ->andFilterWhere(['like', 'd_jawatan_bi', $this->d_jawatan_bi])
            ->andFilterWhere(['like', 'd_jawatan_bm', $this->d_jawatan_bm])
            ->andFilterWhere(['like', 'd_jbtn_bi', $this->d_jbtn_bi])
            ->andFilterWhere(['like', 'd_jbtn_bm', $this->d_jbtn_bm])
            ->andFilterWhere(['like', 'd_kampus_bi', $this->d_kampus_bi])
            ->andFilterWhere(['like', 'd_kampus_bm', $this->d_kampus_bm])
            ->andFilterWhere(['like', 'd_kampus2_bi', $this->d_kampus2_bi])
            ->andFilterWhere(['like', 'd_kampus2_bm', $this->d_kampus2_bm])
            ->andFilterWhere(['like', 'd_office_telno', $this->d_office_telno])
            ->andFilterWhere(['like', 'd_office_extno', $this->d_office_extno])
            ->andFilterWhere(['like', 'd_faxno', $this->d_faxno])
            ->andFilterWhere(['like', 'd_hpno', $this->d_hpno])
            ->andFilterWhere(['like', 'd_email', $this->d_email])
            ->andFilterWhere(['like', 'd_update_id', $this->d_update_id])
            ->andFilterWhere(['like', 'd_peraku_peg_id', $this->d_peraku_peg_id])
            ->andFilterWhere(['like', 'dept_address_bi_1', $this->dept_address_bi_1])
            ->andFilterWhere(['like', 'dept_address_bi_2', $this->dept_address_bi_2])
            ->andFilterWhere(['like', 'dept_address_bm_1', $this->dept_address_bm_1])
            ->andFilterWhere(['like', 'dept_address_bm_2', $this->dept_address_bm_2])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
    public function searchs($params)
    {
        $query = TblMohon::find()->where(['IN','status_kad',['7','8']]);

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
            'language_id' => $this->language_id,
            'd_pieces' => $this->d_pieces,
            'd_tarikh_mohon' => $this->d_tarikh_mohon,
            'hantar_status' => $this->hantar_status,
            'd_tarikh_hantar' => $this->d_tarikh_hantar,
            'status_kad' => $this->status_kad,
            'd_status_tarikh' => $this->d_status_tarikh,
            'd_peraku_peg' => $this->d_peraku_peg,
            'd_peraku_peg_dt' => $this->d_peraku_peg_dt,
        ]);

        $query->andFilterWhere(['like', 'applier_id', $this->applier_id])
            ->andFilterWhere(['like', 'title_bm', $this->title_bm])
            ->andFilterWhere(['like', 'title_bi', $this->title_bi])
            ->andFilterWhere(['like', 'd_nama', $this->d_nama])
            ->andFilterWhere(['like', 'd_edu_bi_1', $this->d_edu_bi_1])
            ->andFilterWhere(['like', 'd_edu_bi_2', $this->d_edu_bi_2])
            ->andFilterWhere(['like', 'd_edu_bm_1', $this->d_edu_bm_1])
            ->andFilterWhere(['like', 'd_edu_bm_2', $this->d_edu_bm_2])
            ->andFilterWhere(['like', 'd_jawatan_bi', $this->d_jawatan_bi])
            ->andFilterWhere(['like', 'd_jawatan_bm', $this->d_jawatan_bm])
            ->andFilterWhere(['like', 'd_jbtn_bi', $this->d_jbtn_bi])
            ->andFilterWhere(['like', 'd_jbtn_bm', $this->d_jbtn_bm])
            ->andFilterWhere(['like', 'd_kampus_bi', $this->d_kampus_bi])
            ->andFilterWhere(['like', 'd_kampus_bm', $this->d_kampus_bm])
            ->andFilterWhere(['like', 'd_kampus2_bi', $this->d_kampus2_bi])
            ->andFilterWhere(['like', 'd_kampus2_bm', $this->d_kampus2_bm])
            ->andFilterWhere(['like', 'd_office_telno', $this->d_office_telno])
            ->andFilterWhere(['like', 'd_office_extno', $this->d_office_extno])
            ->andFilterWhere(['like', 'd_faxno', $this->d_faxno])
            ->andFilterWhere(['like', 'd_hpno', $this->d_hpno])
            ->andFilterWhere(['like', 'd_email', $this->d_email])
            ->andFilterWhere(['like', 'd_update_id', $this->d_update_id])
            ->andFilterWhere(['like', 'd_peraku_peg_id', $this->d_peraku_peg_id])
            ->andFilterWhere(['like', 'dept_address_bi_1', $this->dept_address_bi_1])
            ->andFilterWhere(['like', 'dept_address_bi_2', $this->dept_address_bi_2])
            ->andFilterWhere(['like', 'dept_address_bm_1', $this->dept_address_bm_1])
            ->andFilterWhere(['like', 'dept_address_bm_2', $this->dept_address_bm_2])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }

    public function statistic($params)
    {
        $query = TblMohon::find()->joinWith(['kakitangan','gred']);
   
// var_dump('g');die;
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
        //     'id' => $this->id,
        //     'accesstype' => $this->accesstype,
        //     'isActive' => $this->isActive,
        // ]);

        if (!empty($this->year)) {
            // var_dump('dds');die;

            $query->andFilterWhere(['=', 'YEAR(d_tarikh_mohon)', $this->year]);
        }else{

            $query->andFilterWhere(['=', 'YEAR(d_tarikh_mohon)', date('Y')]);
        }
        if (!empty($this->month)) {
            // var_dump('dd');die;

            $query->andFilterWhere(['=', 'MONTH(d_tarikh_mohon)', $this->month]);
        }
        if (!empty($this->name)) {
            // var_dump($this->name);die;

            $query->andFilterWhere(['like', 'CONm', $this->d_nama]);

        }
        if (!empty($this->type)) {
            if($this->type == 1){
                $query->andFilterWhere(['=', 'job_group', $this->type]);

            }else{
                $query->andFilterWhere(['=', 'job_category', '1']);

            }
            // echo 'd';die;

        }
        return $dataProvider;
    }
}
