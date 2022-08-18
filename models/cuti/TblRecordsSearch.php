<?php

namespace app\models\cuti;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\cuti\TblRecords;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * TblAnnouncementsSearch represents the model behind the search form of `app\models\system_core\TblAnnouncements`.
 */
class TblRecordsSearch extends TblRecords
{
    public $carian_department;
    public $carian_bulan;
    public $carian_nama;
    public $carian_status;
    public $start_date;
    public $stat;
    public $carian_jenis_cuti;
    public $carian_data;
    public $jenis_carian = '0';
    public $carian_tahun;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jenis_cuti_id', 'tempoh'], 'integer'],
            [['carian_tahun', 'carian_department', 'carian_nama', 'carian_bulan', 'carian_jenis_cuti', 'carian_status', 'carian_data', 'jenis_carian'], 'safe'],
            [['icno', 'full_date', 'start_date', 'end_date', 'tempoh', 'remark', 'type', 'semakan_by', 'semakan_remark', 'peraku_by', 'peraku_remark', 'lulus_by', 'lulus_remark', 'status', 'file_hashcode'], 'safe'],
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


    public function search($params, $status = null, $peraku = null, $pelulus = null)
    {
        $query = TblRecords::find();
        $query->joinWith(['kakitangan']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // var_dump($dataProvider);die;
        $this->load($params);
        // var_dump($params);die;

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // echo $this->jenis_cuti_id;die;
        // if (empty($this->jenis_cuti_id)) {

        $query->andFilterWhere(['like', 'cuti_tbl_records.icno', $this->icno])
            ->andFilterWhere(['like', 'start_date', $this->start_date])
            ->andFilterWhere(['like', 'end_date', $this->end_date])
            ->andFilterWhere(['like', 'full_date', $this->full_date])
            ->andFilterWhere(['like', 'type', $this->type])
            // ->andFilterWhere(['like', 'tblprcobiodata.DeptId', $this->icno])
            ->orFilterWhere(['like', 'tblprcobiodata.CONm', $this->icno]);

        if (!empty($this->carian_status)) {
            $query->andFilterWhere([
                'cuti_tbl_records.status' => $this->carian_status,
            ]);
        } else {
            $query->andFilterWhere([
                '!=', 'cuti_tbl_records.status', 'APPROVED',
            ]);
        }
        if (!empty($this->carian_department)) {
            $query->andFilterWhere([
                'DeptId' => $this->carian_department,
            ]);
        }
        if (!empty($this->carian_nama)) {
            $query->andFilterWhere([
                'CONm' => $this->carian_nama,
            ]);
        }


        if ($peraku) {
            $query->andFilterWhere(['=', 'cuti_tbl_records.peraku_by', $peraku]);
        }

        if ($pelulus) {
            $query->andFilterWhere(['=', 'cuti_tbl_records.lulus_by', $pelulus]);
        }



        return $dataProvider;
    }

    public function searchPeraku($params, $icno)
    {
        $query = TblRecords::find();
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

        $query->andFilterWhere(['like', 'cuti_tbl_records.icno', $this->icno])
            ->andFilterWhere(['like', 'start_date', $this->start_date])
            ->andFilterWhere(['like', 'end_date', $this->end_date])
            ->andFilterWhere(['like', 'full_date', $this->full_date])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['=', 'peraku_by', $icno])
            ->andFilterWhere(['=', 'cuti_tbl_records.status', 'AGREED'])
            ->orFilterWhere(['like', 'tblprcobiodata.CONm', $this->icno]);



        return $dataProvider;
    }


    public function searchs($params)
    {
        $query = TblRecords::find();
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

        // grid filtering conditions
        // var_dump($this->akses_cuti_int,$this->akses_cuti_icno);die;
        $query->andFilterWhere([
            // 'akses_cuti_id' => $this->akses_cuti_id,
            'jenis_cuti_id' => $this->jenis_cuti_id,
            'status' => $this->status,
            // 'akses_kampus_id' => $this->akses_kampus_id,
        ]);

        if (!empty($this->carian_status)) {
            $query->andFilterWhere([
                'cuti_tbl_records.status' => $this->carian_status,
            ]);
        } else {
            $query->andFilterWhere([
                '=', 'cuti_tbl_records.status', 'APPROVED',
            ]);
        }
        if (!empty($this->carian_department)) {
            $query->andFilterWhere([
                'DeptId' => $this->carian_department,
            ]);
        } else {
            $id = Yii::$app->user->getId();
            $biodata = Tblprcobiodata::findOne(['ICNO' => $id]);
            $query->andFilterWhere([
                'DeptId' => $biodata->DeptId,
            ]);
        }
        if (!empty($this->icno)) {
            $query->andFilterWhere([
                'LIKE', 'cuti_tbl_records.icno', $this->icno,
            ]);
        }

        if (!empty($this->full_date)) {

            $arr = explode(" ", $this->full_date);

            $start_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[0]))));
            $end_date = date('Y-m-d', strtotime(str_replace("/", "-", date($arr[2]))));
            // var_dump($end_date);die;
            $query->andFilterWhere([
                //         'or',
                //    ['=', 'MONTH(start_date)', $start_date],
                //    ['=', 'MONTH(end_date)', $end_date]
                // '=', 'MONTH(start_date)', $start_date
                'between', 'start_date', $start_date, $end_date
            ]);
        }
        if (!empty($this->carian_nama)) {
            $query->andFilterWhere([
                'LIKE', 'tblprcobiodata.CONm', $this->carian_nama,
            ]);
        }
        // var_dump($dataProvider);die;
        return $dataProvider;
    }
    public function searchleave($params)
    {
        $query = TblRecords::find();
        // $query->joinWith(['kakitangan']);

        // add conditions that should always apply here

        // var_dump($params['id']);die;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 35,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        // var_dump($this->akses_cuti_int,$this->akses_cuti_icno);die;
        $query->andFilterWhere([
            'icno' => $params['id'],
            // 'jenis_cuti_id' => $this->jenis_cuti_id,
            'status' => $this->status,
            // 'YEAR(cuti_tbl_records.start_date)' => $this->carian_tahun
            // 'akses_kampus_id' => $this->akses_kampus_id,
        ]);

        if (!empty($this->jenis_cuti_id)) {
            $query->andFilterWhere([
                'cuti_tbl_records.jenis_cuti_id' => $this->jenis_cuti_id,
            ]);
        }
        if (!empty($this->carian_status)) {
            $query->andFilterWhere([
                'cuti_tbl_records.status' => $this->carian_status,
            ]);
        }

        if (!empty($this->carian_tahun)) {

            $query->andFilterWhere([
                'or',
                ['YEAR(cuti_tbl_records.start_date)' => $this->carian_tahun],
                ['YEAR(cuti_tbl_records.end_date)' => $this->carian_tahun]
            ]);
        }

        return $dataProvider;
    }
    public function searchss($params)
    {
        $query = TblRecords::find();
        $query->joinWith(['kakitangan']);
        $id = Yii::$app->user->getId();
        $bp = Tindakan::findOne(['icno_tindakan' => $id]);
        if ($bp) {
            $id = $bp->icno_pemberi_kuasa;
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'start_date' => SORT_DESC,
                    // 'title' => SORT_ASC, 
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            // 'lulus_by' => $id,
            // 'peraku_by'=>$id,
            'jenis_cuti_id' => $this->jenis_cuti_id,
            'status' => $this->status,
            // 'akses_kampus_id' => $this->akses_kampus_id,
        ]);

        if (!empty($id)) {
            $query->andFilterWhere([
                'or', ['cuti_tbl_records.peraku_by' => $id],
                ['cuti_tbl_records.lulus_by' => $id]
            ]);
        }
        if (!empty($this->carian_status)) {
            $query->andFilterWhere([
                'cuti_tbl_records.status' => $this->carian_status,
            ]);
        } else {
            $query->andFilterWhere([
                '=', 'cuti_tbl_records.status', 'APPROVED',
            ]);
        }

        if (!empty($this->icno)) {
            $query->andFilterWhere([
                'LIKE', 'cuti_tbl_records.icno', $this->icno,
            ]);
        }
        if (!empty($this->carian_nama)) {
            $query->andFilterWhere([
                'LIKE', 'tblprcobiodata.CONm', $this->carian_nama,
            ]);
        }

        // var_dump($this->carian_bulan);die;
        if (!empty($this->carian_tahun)) {
            $query->andFilterWhere([

                'YEAR(cuti_tbl_records.start_date)' => $this->carian_tahun
            ]);
        } else {
            // echo 'd';die;
            $query->andFilterWhere([

                'YEAR(cuti_tbl_records.start_date)' => date('Y')
            ]);
        }
        if (!empty($this->carian_bulan)) {

            $query->andFilterWhere([

                'MONTH(cuti_tbl_records.start_date)' => $this->carian_bulan
            ]);
        }

        if (!empty($this->carian_nama)) {
            $query->andFilterWhere([
                'LIKE', 'tblprcobiodata.CONm', $this->carian_nama,
            ]);
        }
        // var_dump($dataProvider);die;
        return $dataProvider;
    }
    public function cbsearch($params)
    {
        $query = TblRecords::find();
        $query->joinWith(['kakitangan']);
        $id = Yii::$app->user->getId();
        $bp = Tindakan::findOne(['icno_tindakan' => $id]);
        if ($bp) {
            $id = $bp->icno_pemberi_kuasa;
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'start_date' => SORT_DESC,
                    // 'title' => SORT_ASC, 
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            // 'lulus_by' => $id,
            // 'peraku_by'=>$id,
            'jenis_cuti_id' => 28,
            'status' => $this->status,
            // 'akses_kampus_id' => $this->akses_kampus_id,
        ]);


        if (!empty($this->carian_status)) {
            $query->andFilterWhere([
                'cuti_tbl_records.status' => $this->carian_status,
            ]);
        }

        if (!empty($this->icno)) {
            $query->andFilterWhere([
                'LIKE', 'cuti_tbl_records.icno', $this->icno,
            ]);
        }
        if (!empty($this->carian_nama)) {
            $query->andFilterWhere([
                'LIKE', 'tblprcobiodata.CONm', $this->carian_nama,
            ]);
        }

        // var_dump($this->carian_bulan);die;
        if (!empty($this->carian_tahun)) {
            $query->andFilterWhere([

                'or',
                [
                    'YEAR(cuti_tbl_records.start_date)' => $this->carian_tahun
                ],
                [
                    'YEAR(cuti_tbl_records.end_date)' => $this->carian_tahun
                ]
            ]);
        } else {
            // echo 'd';die;
            $query->andFilterWhere([

                'or',
                [
                    'YEAR(cuti_tbl_records.start_date)' => date('Y')
                ],
                [
                    'YEAR(cuti_tbl_records.end_date)' => date('Y')
                ]
            ]);
        }
        if (!empty($this->carian_bulan)) {

            $query->andFilterWhere([

                'MONTH(cuti_tbl_records.start_date)' => $this->carian_bulan
            ]);
        }

        if (!empty($this->carian_nama)) {
            $query->andFilterWhere([
                'LIKE', 'tblprcobiodata.CONm', $this->carian_nama,
            ]);
        }
        // var_dump($dataProvider);die;
        return $dataProvider;
    }
}
