<?php

namespace app\models\dkums;

use app\models\dkums\YearSettings;
use app\models\hronline\Tblprcobiodata;
use app\models\dkums\Results;
use app\models\hronline\GredJawatan;
use app\models\UtilitiesFunc;
use kartik\popover\PopoverX;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Averages;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "utilities.dkums_tbl_main".
 *
 * @property int $id
 * @property string $icno
 * @property int $gred_id
 * @property int $dept_id
 * @property int $statlantikan
 * @property int $tahun
 * @property int $fasa
 * @property string $create_dt
 * @property string $komen
 * @property string $cadangan
 * @property int $submit
 * @property string $end_dt
 */
class TblMain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.dkums_tbl_main';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gred_id', 'dept_id', 'statlantikan', 'tahun', 'fasa', 'submit'], 'integer'],
            [['create_dt', 'end_dt'], 'safe'],
            [['komen', 'cadangan'], 'string'],
            [['icno'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'gred_id' => 'Gred ID',
            'dept_id' => 'Dept ID',
            'statlantikan' => 'Statlantikan',
            'tahun' => 'Tahun',
            'fasa' => 'Fasa',
            'create_dt' => 'Create Dt',
            'komen' => 'Komen',
            'cadangan' => 'Cadangan',
            'submit' => 'Submit',
            'end_dt' => 'End Dt',
            'dkums' => 'Darjah Kegembiraan',
        ];
    }



    /**
     * /**
     * @return \yii\db\ActiveQuery
     */
    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::class, ['ICNO' => 'icno']);
    }

    public function getJawatan()
    {
        return $this->hasOne(GredJawatan::class, ['id' => 'gred_id']);
    }

    public function getResults()
    {
        return $this->hasOne(Results::class, ['main_id' => 'id']);
    }

    //------------------Relation to item table ---------------------------------//

    public function getRelLifeEval()
    {
        return $this->hasOne(LifeEvaluation::class, ['main_id' => 'id']);
    }
    public function getRelAffectMeasure()
    {
        return $this->hasOne(AffectMeasures::class, ['main_id' => 'id']);
    }
    public function getRelJobSatisfaction()
    {
        return $this->hasOne(JobSatisfaction::class, ['main_id' => 'id']);
    }
    public function getRelJobEngagement()
    {
        return $this->hasOne(JobEngagement::class, ['main_id' => 'id']);
    }
    public function getRelSyukur()
    {
        return $this->hasOne(Syukur::class, ['main_id' => 'id']);
    }

    //------------------Relation to item table ---------------------------------//

    public function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    public function getRandomColor()
    {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }

    public static function purataAll($tahun, $fasa)
    {
        $model = self::find()->with('results')->where(['tahun' => $tahun, 'fasa' => $fasa, 'submit' => 1])->all();

        $totalCount = count($model);
        $totalDkums = 0;
        $totalHidup = 0;
        $totalEmosi = 0;
        $totalKepuasan = 0;
        $totalKeterlibatan = 0;
        $totalSyukur = 0;

        foreach ($model as $m) {
            $totalDkums += $m->results->dkums;
            $totalHidup += $m->results->penilaian_hidup;
            $totalEmosi += $m->results->emosi_positif;
            $totalKepuasan += $m->results->kepuasan_kerja;
            $totalKeterlibatan += $m->results->keterlibatan_kerja;
            $totalSyukur += $m->results->syukur;
        }

        $dkums = round($totalDkums / $totalCount, 2);
        $penilaian_hidup =  round($totalHidup / $totalCount, 2);
        $emosi_positif =  round($totalEmosi / $totalCount, 2);
        $keterlibatan_kerja =  round($totalKepuasan / $totalCount, 2);
        $kepuasan_kerja =  round($totalKeterlibatan / $totalCount, 2);
        $syukur =  round($totalSyukur / $totalCount, 2);

        $main = new TblMain();

        $arr = [
            'dkums' => $dkums,
            'tahap_dkums' => $main->kategori($dkums),
            'penilaian_hidup' => $penilaian_hidup,
            'tahap_penilaian_hidup' => $main->kategori($penilaian_hidup),
            'emosi_positif' =>  $emosi_positif,
            'tahap_emosi_positif' =>  $main->kategori($emosi_positif),
            'keterlibatan_kerja' =>  $keterlibatan_kerja,
            'tahap_keterlibatan_kerja' =>  $main->kategori($keterlibatan_kerja),
            'kepuasan_kerja' => $kepuasan_kerja,
            'tahap_kepuasan_kerja' => $main->kategori($kepuasan_kerja),
            'syukur' => $syukur,
            'tahap_syukur' => $main->kategori($syukur),
        ];

        return $arr;
    }

    public static function getDimensiArr($icno, $limit = null)
    {

        if ($limit) {
            $model = self::find()->with('results')->where(['icno' => $icno, 'submit' => 1])->limit($limit)->orderBy(['id' => SORT_DESC])->all();
        } else {
            $model = self::find()->with('results')->where(['icno' => $icno, 'submit' => 1])->orderBy(['id' => SORT_DESC])->all();
        }

        $arr = [];

        if ($model) {
            foreach ($model as $m) {
                $arr[] = [
                    'label' => 'Tahun ' . $m->tahun . '(Fasa ' . $m->fasa . ')',
                    'backgroundColor' => "#$m->randomColor",
                    'borderColor' => "black",
                    'pointBackgroundColor' => "#$m->randomColor",
                    'data' => [
                        $m->results->penilaian_hidup,
                        $m->results->emosi_positif,
                        $m->results->kepuasan_kerja,
                        $m->results->keterlibatan_kerja,
                        $m->results->syukur
                    ],
                ];
            }
        }

        return $arr;
    }


    public static function getStaffYearArr($icno, $limit = null)
    {

        if ($limit) {
            $model = self::find()->where(['icno' => $icno, 'submit' => 1])->limit($limit)->orderBy(['id' => SORT_DESC])->all();
        } else {
            $model = self::find()->where(['icno' => $icno, 'submit' => 1])->orderBy(['id' => SORT_DESC])->all();
        }

        $arr = [];

        if ($model) {
            foreach ($model as $m) {
                $arr[] = $m->tahun . '(' . $m->fasa . ')';
            }
        }

        return $arr;
    }

    public static function getStaffDkArr($icno, $limit = null)
    {


        if ($limit) {
            $model = self::find()->with('results')->where(['icno' => $icno, 'submit' => 1])->orderBy(['id' => SORT_DESC])->limit($limit)->all();
        } else {
            $model = self::find()->with('results')->where(['icno' => $icno, 'submit' => 1])->orderBy(['id' => SORT_DESC])->all();
        }

        $arr = [];

        if ($model) {
            foreach ($model as $m) {
                $arr[] = $m->results->dkums;
            }
        }

        return $arr;
    }



    public function getDkums()
    {
        return $this->dk_ums($this->id);
    }

    //----------------------------------------- Dimensi Utama ---------------------------------------------------//
    public function getPenilaianHidup()
    {
        return $this->std_hidup($this->id);
    }

    public function getEmosiPositif()
    {
        return $this->std_affect($this->id);
    }

    public function getKepuasanKerja()
    {
        return $this->kepuasan_kerja($this->id);
    }

    public function getKeterlibatanKerja()
    {
        return $this->keterlibatan_kerja($this->id);
    }

    public function getSyukur()
    {
        return $this->syukur($this->id);
    }

    //----------------------------------------- Dimensi Utama ---------------------------------------------------//

    public function getTahapDkums()
    {
        return $this->kategori($this->dk_ums($this->id));
    }

    public static function individualDk($icno, $tahun, $fasa)
    {

        $model = self::findOne(['icno' => $icno, 'tahun' => $tahun, 'fasa' => $fasa, 'submit' => 1]);

        if ($model) {
            return $model;
        }
        return null;
    }

    /**
     * This function is to return main_id in the current year settings
     * 
     * $icno = staf icno
     * 
     * return int 
     */
    public static function currentMainId($icno)
    {

        $model_year = YearSettings::findOne(['status' => 1]);

        $tahun = $model_year->tahun;
        $fasa = $model_year->fasa;

        $model_main = self::findOne(['icno' => $icno, 'tahun' => $tahun, 'fasa' => $fasa]);

        if ($model_main) {
            return $model_main->id;
        }

        return null;
    }

    public function getMasajawab()
    {
        $to_time = strtotime($this->end_dt);
        $from_time = strtotime($this->create_dt);
        return round(abs($to_time - $from_time) / 60, 2) . " minute";
    }

    public function formula_b($val)
    {

        $new_val = 0;

        if ($val == 1) {
            $new_val = 5;
        }

        if ($val == 5) {
            $new_val = 1;
        }

        if ($val == 2) {
            $new_val = 4;
        }

        if ($val == 4) {
            $new_val = 2;
        }

        if ($val == 3) {
            $new_val = 3;
        }

        return $new_val;
    }

    public function formula_c($val)
    {

        $new_val = 0;

        if ($val == 1) {
            $new_val = 6;
        }

        if ($val == 6) {
            $new_val = 1;
        }

        if ($val == 5) {
            $new_val = 2;
        }

        if ($val == 2) {
            $new_val = 5;
        }

        if ($val == 3) {
            $new_val = 4;
        }

        if ($val == 4) {
            $new_val = 3;
        }

        return $new_val;
    }

    public function formula_affect($id)
    {

        $model_affect = AffectMeasures::findOne(['main_id' => $id]);

        $formula = $model_affect->b1 + $model_affect->b5 + $model_affect->b7 + $model_affect->b8 + $model_affect->b10 + $this->formula_b($model_affect->b2) + $this->formula_b($model_affect->b3) + $this->formula_b($model_affect->b4) + $this->formula_b($model_affect->b6) + $this->formula_b($model_affect->b9);


        return $formula;
    }

    public function formula_affect_positif($id)
    {

        $model_affect = AffectMeasures::findOne(['main_id' => $id]);

        $formula = $model_affect->b1 + $model_affect->b5 + $model_affect->b7 + $model_affect->b8 + $model_affect->b10;


        return $formula;
    }

    public function formula_affect_negatif($id)
    {

        $model_affect = AffectMeasures::findOne(['main_id' => $id]);

        $formula = $model_affect->b2 + $model_affect->b3 + $model_affect->b4 + $model_affect->b6 + $model_affect->b9;


        return $formula;
    }

    /*
     * c1+c21+c15(new)
     */

    public function formula_gaji($id)
    {

        $satisfaction = JobSatisfaction::findOne(['main_id' => $id]);

        $formula = $satisfaction->c1 + $satisfaction->c21 + $this->formula_c($satisfaction->c15);

        return $formula;
    }

    /*
     * c9+c24+c2(new)
     */

    public function formula_pangkat($id)
    {

        $satisfaction = JobSatisfaction::findOne(['main_id' => $id]);
        $formula = $satisfaction->c9 + $satisfaction->c24 + $this->formula_c($satisfaction->c2);

        return $formula;
    }

    /*
     * c3+c23+c16(new)
     */

    public function formula_ketua($id)
    {

        $satisfaction = JobSatisfaction::findOne(['main_id' => $id]);
        $formula = $satisfaction->c3 + $satisfaction->c23 + $this->formula_c($satisfaction->c16);

        return $formula;
    }

    /*
     * c10+c4(new)+c22(new)
     */

    public function formula_faedah($id)
    {
        $satisfaction = JobSatisfaction::findOne(['main_id' => $id]);
        $formula = $satisfaction->c10 + $this->formula_c($satisfaction->c4) + $this->formula_c($satisfaction->c22);

        return $formula;
    }

    /*
     * c5+c11(new)+c17(new)
     */

    public function formula_ganjaran($id)
    {

        $satisfaction = JobSatisfaction::findOne(['main_id' => $id]);
        $formula = $satisfaction->c5 + $this->formula_c($satisfaction->c11) + $this->formula_c($satisfaction->c17);

        return $formula;
    }

    /*
     * c12+c6(new)+c18(new)
     */

    public function formula_prosedur($id)
    {

        $satisfaction = JobSatisfaction::findOne(['main_id' => $id]);
        $formula = $satisfaction->c12 + $this->formula_c($satisfaction->c6) + $this->formula_c($satisfaction->c18);

        return $formula;
    }

    /*
     * c19+c13(new)+c25(new)
     */

    public function formula_rakan($id)
    {
        $satisfaction = JobSatisfaction::findOne(['main_id' => $id]);
        $formula = $satisfaction->c19 + $this->formula_c($satisfaction->c13) + $this->formula_c($satisfaction->c25);

        return $formula;
    }

    /*
     * c20+c26+c7(new)
     */

    public function formula_sifat_kerja($id)
    {
        $satisfaction = JobSatisfaction::findOne(['main_id' => $id]);
        $formula = $satisfaction->c20 + $satisfaction->c26 + $this->formula_c($satisfaction->c7);

        return $formula;
    }

    /*
     * c8+c14(new)+c27(new)
     */

    public function formula_komunikasi($id)
    {
        $satisfaction = JobSatisfaction::findOne(['main_id' => $id]);
        $formula = $satisfaction->c8 + $this->formula_c($satisfaction->c14) + $this->formula_c($satisfaction->c27);

        return $formula;
    }

    /*
     * d1+d2+d5
     */

    public function formula_semangat($id)
    {

        $engagement = JobEngagement::findOne(['main_id' => $id]);
        $formula = $engagement->d1 + $engagement->d2 + $engagement->d5;

        return $formula;
    }



    /*
     * d3+d4+d7
     */

    public function formula_dedikasi($id)
    {
        $engagement = JobEngagement::findOne(['main_id' => $id]);
        $formula = $engagement->d3 + $engagement->d4 + $engagement->d7;

        return $formula;
    }



    /*
     * d6+d8+d9
     */

    public function formula_kesungguhan($id)
    {
        $engagement = JobEngagement::findOne(['main_id' => $id]);
        $engagement = JobEngagement::findOne(['main_id' => $id]);
        $formula = $engagement->d6 + $engagement->d8 + $engagement->d9;

        return $formula;
    }

    public function std_satisfaction($val)
    {

        $result = round(($val - 3) / (18 - 3) * 100, 2);
        return $result;
    }

    public function std_engagement($val)
    {

        $result = round(($val - 0) / (18 - 0) * 100, 2);
        return $result;
    }

    //std
    public function std_hidup($id)
    {

        $life = LifeEvaluation::findOne(['main_id' => $id]);
        $val = ($life->a1 - 0) / (10 - 0) * 100;
        return $val;
    }

    //std_affect
    public function std_affect($id)
    {

        return ($this->formula_affect($id) - 10) / (50 - 10) * 100;
    }

    //std_affect negatif
    public function std_affect_negatif($id)
    {

        return ($this->formula_affect_negatif($id) - 5) / (25 - 5) * 100;
    }

    //std_affect positif
    public function std_affect_positif($id)
    {

        return ($this->formula_affect_positif($id) - 5) / (25 - 5) * 100;
    }

    //std_gaji
    public function std_gaji($id)
    {

        return $this->std_satisfaction($this->formula_gaji($id));
    }

    //std_pangkat
    public function std_pangkat($id)
    {

        return $this->std_satisfaction($this->formula_pangkat($id));
    }

    //std_ketua
    public function std_ketua($id)
    {

        return $this->std_satisfaction($this->formula_ketua($id));
    }

    //std_ganjaran
    public function std_ganjaran($id)
    {

        return $this->std_satisfaction($this->formula_ganjaran($id));
    }

    //std_prosedur
    public function std_prosedur($id)
    {

        return $this->std_satisfaction($this->formula_prosedur($id));
    }

    //std_rakan
    public function std_rakan($id)
    {

        return $this->std_satisfaction($this->formula_rakan($id));
    }

    //std_sifat_kerja
    public function std_sifat_kerja($id)
    {

        return $this->std_satisfaction($this->formula_sifat_kerja($id));
    }

    //std_komunikasi
    public function std_komunikasi($id)
    {

        return $this->std_satisfaction($this->formula_komunikasi($id));
    }

    //std_faedah
    public function std_faedah($id)
    {

        return $this->std_satisfaction($this->formula_faedah($id));
    }

    //std_semangat
    public function std_semangat($id)
    {

        return $this->std_engagement($this->formula_semangat($id));
    }

    //std_dedikasi
    public function std_dedikasi($id)
    {

        return $this->std_engagement($this->formula_dedikasi($id));
    }

    //std_kesungguhan
    public function std_kesungguhan($id)
    {

        return $this->std_engagement($this->formula_kesungguhan($id));
    }

    /*
     * DK_UMS
     */

    public function dk_ums($id)
    {

        $std = $this->std_hidup($id) + $this->std_affect($id) + $this->std_gaji($id) + $this->std_pangkat($id) + $this->std_ketua($id) + $this->std_faedah($id) + $this->std_ganjaran($id) + $this->std_prosedur($id) + $this->std_rakan($id) + $this->std_sifat_kerja($id) + $this->std_komunikasi($id);


        $std2 = $this->std_semangat($id) + $this->std_dedikasi($id) + $this->std_kesungguhan($id);


        $total = $std + $std2;


        return round(($total / 1400) * 100, 2);
    }

    /*
     * Kepuasan Kerja
     */

    public function kepuasan_kerja($id)
    {

        $total = $this->std_gaji($id) + $this->std_pangkat($id) + $this->std_ketua($id) + $this->std_faedah($id) + $this->std_ganjaran($id) + $this->std_prosedur($id) + $this->std_rakan($id) + $this->std_sifat_kerja($id) + $this->std_komunikasi($id);


        return round(($total / 900) * 100, 2);
    }

    /*
     * Keterlibatan Kerja
     */

    public function keterlibatan_kerja($id)
    {

        $total = $this->std_semangat($id) + $this->std_dedikasi($id) + $this->std_kesungguhan($id);

        return round(($total / 300) * 100, 2);
    }

    /*
     * Syukur
     */

    public function syukur($id)
    {

        $syukur = Syukur::find()->where(['main_id' => $id])->one();

        return round(($syukur->e1 / 10) * 100, 2);
    }



    public function kategori($val)
    {

        if ($val <= 49.99) {
            $result = 'RENDAH';
        }

        if ($val >= 50 && $val <= 79.99) {
            $result = 'SEDERHANA';
        }

        if ($val >= 80) {
            $result = 'TINGGI';
        }

        return $result;
    }

    public function kategoriQuartile($arr, $val)
    {
        // sort($arr);

        if ($val < UtilitiesFunc::Quartile($arr, 0.50)) {

            return  'RENDAH';
        }

        if ($val >= UtilitiesFunc::Quartile($arr, 0.50) && $val < UtilitiesFunc::Quartile($arr, 0.75)) {
            return 'SEDERHANA';
        }

        if ($val >= UtilitiesFunc::Quartile($arr, 0.75)) {

            return  'TINGGI';
        }
    }

    public function warnaKategori($tahap)
    {
        if ($tahap == 'RENDAH') {
            $result = 'red';
        }

        if ($tahap == 'SEDERHANA') {
            $result = 'orange';
        }

        if ($tahap == 'TINGGI') {
            $result = 'green';
        }

        return $result;
    }

    /**
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchRaw($params)
    {
        $query = TblMain::find()->with('results');
        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);



        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'icno' => $this->icno,
            'gred_id' => $this->gred_id,
            'dept_id' => $this->dept_id,
            'statlantikan' => $this->statlantikan,
            'tahun' => $this->tahun,
            'fasa' => $this->fasa,
            'create_dt' => $this->create_dt,
            'komen' => $this->komen,
            'cadangan' => $this->cadangan,
            'submit' => 1,
            'end_dt' => $this->end_dt,
        ]);

        return $dataProvider;
    }

    public static function totalCompleted($deptId, $tahun, $fasa)
    {

        $total = 0;

        $model = TblMain::find()->where(['dept_id' => $deptId, 'tahun' => $tahun, 'fasa' => $fasa, 'submit' => 1])->count();

        if ($model) {
            $total = $model;
        }

        return $total;
    }

    public static function PurataItemAll($tahun, $fasa)
    {
        $params = [':tahun' => $tahun, ':fasa' => $fasa, ':submit' => 1];

        $model = Yii::$app->db->createCommand(
            'SELECT AVG(b.b1) as b1, AVG(b.b2) as b2,AVG(b.b3) as b3,AVG(b.b4) as b4 ,AVG(b.b5) as b5 ,
            AVG(b.b6) as b6 ,AVG(b.b7) as b7 ,AVG(b.b8) as b8 ,AVG(b.b9) as b9 ,AVG(b.b10) as b10,
            AVG(d.d1) as d1, AVG(d.d2) as d2,AVG(d.d3) as d3,AVG(d.d4) as d4 ,AVG(d.d5) as d5 ,
            AVG(d.d6) as d6 ,AVG(d.d7) as d7 ,AVG(d.d8) as d8 ,AVG(d.d9) as d9,
            AVG(e.e1) as e1

            FROM utilities.dkums_tbl_main a 
            JOIN utilities.dkums_affect_measures b ON a.id = b.main_id
            JOIN utilities.dkums_job_engagement d ON a.id = d.main_id
            JOIN utilities.dkums_syukur e ON a.id = e.main_id

        WHERE a.tahun=:tahun AND a.fasa=:fasa AND submit=:submit'
        )
            ->bindValues($params)
            ->queryOne();


        return $model;
    }


    public static function PurataByDept2($deptId, $tahun, $fasa, $lantikan = null, $kategori = null)
    {

        $query = 'SELECT AVG(dkums) as dkums, 
        AVG(b.penilaian_hidup) as penilaian_hidup, 
        AVG(b.emosi_positif) as emosi_positif, 
        AVG(b.kepuasan_kerja) as kepuasan_kerja, 
        AVG(b.keterlibatan_kerja) as keterlibatan_kerja, 
        AVG(b.syukur) as syukur

        FROM utilities.dkums_tbl_main a 
        JOIN utilities.dkums_results b ON a.id = b.main_id
        JOIN hronline.tblprcobiodata d ON a.icno = d.ICNO
        JOIN hronline.gredjawatan e ON d.gredJawatan = e.id
        ';

        $params = [':tahun' => $tahun, ':fasa' => $fasa, ':submit' => 1];

        $condition = ' WHERE a.tahun=:tahun AND a.fasa=:fasa AND a.submit=:submit';


        if ($deptId) {
            $params = ArrayHelper::merge($params, [':deptId' => $deptId]);
            $condition .= ' AND a.dept_id=:deptId';
        }

        if ($lantikan) {
            $params = ArrayHelper::merge($params, [':lantikan' => $lantikan]);
            $condition .= ' AND d.statLantikan =:lantikan';
        }

        if ($kategori) {
            $params = ArrayHelper::merge($params, [':kategori' => $kategori]);
            $condition .= ' AND e.job_group =:kategori';
        }


        $model = Yii::$app->db->createCommand($query . $condition)->bindValues($params)->queryOne(1);

        $main = new TblMain();

        return [
            'dkums' => round($model['dkums'], 2),
            'tahap_dkums' => $main->kategori($model['dkums']),
            'penilaian_hidup' => round($model['penilaian_hidup'], 2),
            'tahap_penilaian_hidup' => $main->kategori($model['penilaian_hidup']),
            'emosi_positif' => round($model['emosi_positif'], 2),
            'tahap_emosi_positif' => $main->kategori($model['emosi_positif']),
            'kepuasan_kerja' => round($model['kepuasan_kerja'], 2),
            'tahap_kepuasan_kerja' => $main->kategori($model['kepuasan_kerja']),
            'keterlibatan_kerja' => round($model['keterlibatan_kerja'], 2),
            'tahap_keterlibatan_kerja' => $main->kategori($model['keterlibatan_kerja']),
            'syukur' => round($model['syukur'], 2),
            'tahap_syukur' => $main->kategori($model['syukur']),
        ];
    }

    public static function PurataByDept($deptId, $tahun, $fasa, $lantikan = null, $kategori = null)
    {

        $avg1 = 0;
        $avg2 = 0;
        $avg3 = 0;
        $avg4 = 0;
        $avg5 = 0;
        $avg6 = 0;

        $dkums = 0;
        $penilaian_hidup = 0;
        $emosi_positif = 0;
        $kepuasan_kerja = 0;
        $keterlibatan_kerja = 0;
        $syukur = 0;


        $model = TblMain::find()->joinWith(['results', 'kakitangan', 'jawatan b'])
            ->where(['tahun' => $tahun, 'fasa' => $fasa, 'submit' => 1])
            ->andFilterWhere(['dept_id' => $deptId])
            ->andFilterWhere(['tblprcobiodata.statLantikan' => $lantikan])
            ->andFilterWhere(['b.job_group' => $kategori])
            ->all();

        if ($model) {

            $total =  count($model);

            foreach ($model as $mdl) {
                $dkums += $mdl->results->dkums;
                $arr_dkums[] = $mdl->results->dkums;

                $penilaian_hidup += $mdl->results->penilaian_hidup;
                $arr_penilaian_hidup[] = $mdl->results->penilaian_hidup;


                $emosi_positif += $mdl->results->emosi_positif;
                $arr_emosi_positif[] = $mdl->results->emosi_positif;

                $kepuasan_kerja += $mdl->results->kepuasan_kerja;
                $arr_kepuasan_kerja[] = $mdl->results->kepuasan_kerja;

                $keterlibatan_kerja += $mdl->results->keterlibatan_kerja;
                $arr_keterlibatan_kerja[] = $mdl->results->keterlibatan_kerja;

                $syukur += $mdl->results->syukur;
                $arr_syukur[] = $mdl->results->syukur;
            }
            $avg1 = round($dkums / $total, 2);
            $avg2 = round($penilaian_hidup / $total, 2);
            $avg3 = round($emosi_positif / $total, 2);
            $avg4 = round($kepuasan_kerja / $total, 2);
            $avg5 = round($keterlibatan_kerja / $total, 2);
            $avg6 = round($syukur / $total, 2);
        }
        $main = new TblMain();

        return [
            'dkums' => $avg1,
            'tahap_dkums' => $main->kategori($avg1),
            'penilaian_hidup' => $avg2,
            'tahap_penilaian_hidup' => $main->kategori($avg2),
            'emosi_positif' => $avg3,
            'tahap_emosi_positif' => $main->kategori($avg3),
            'kepuasan_kerja' => $avg4,
            'tahap_kepuasan_kerja' => $main->kategori($avg4),
            'keterlibatan_kerja' => $avg5,
            'tahap_keterlibatan_kerja' => $main->kategori($avg5),
            'syukur' => $avg6,
            'tahap_syukur' => $main->kategori($avg6),
        ];
    }

    public static function purataSkalaByDept($deptId, $tahun, $fasa, $lantikan = null, $kategori = null)
    {
        $afekPositif = 0;
        $afekNegatif = 0;
        $semangat = 0;
        $dedikasi = 0;
        $kesungguhan = 0;


        $gaji = 0;
        $pangkat = 0;
        $penyeliaan = 0;
        $faedah = 0;
        $ganjaran = 0;
        $prosedur = 0;
        $rakan = 0;
        $sifat = 0;
        $komunikasi = 0;



        $a1 = 0;

        $b1 = 0;
        $b2 = 0;
        $b3 = 0;
        $b4 = 0;
        $b5 = 0;
        $b6 = 0;
        $b7 = 0;
        $b8 = 0;
        $b9 = 0;
        $b10 = 0;

        $c1 = 0;
        $c2 = 0;
        $c3 = 0;
        $c4 = 0;
        $c5 = 0;
        $c6 = 0;
        $c7 = 0;
        $c8 = 0;
        $c9 = 0;
        $c10 = 0;
        $c11 = 0;
        $c12 = 0;
        $c13 = 0;
        $c14 = 0;
        $c15 = 0;
        $c16 = 0;
        $c17 = 0;
        $c18 = 0;
        $c19 = 0;
        $c20 = 0;
        $c21 = 0;
        $c22 = 0;
        $c23 = 0;
        $c24 = 0;
        $c25 = 0;
        $c26 = 0;
        $c27 = 0;

        $d1 = 0;
        $d2 = 0;
        $d3 = 0;
        $d4 = 0;
        $d5 = 0;
        $d6 = 0;
        $d7 = 0;
        $d8 = 0;
        $d9 = 0;

        $e1 = 0;


        $main = new TblMain();

        $model = TblMain::find()
            ->joinWith(['relLifeEval', 'relAffectMeasure', 'relJobSatisfaction', 'relJobEngagement', 'relSyukur', 'kakitangan', 'jawatan b'])
            ->where(['tahun' => $tahun, 'fasa' => $fasa, 'submit' => 1])
            ->andFilterWhere(['dept_id' => $deptId])
            ->andFilterWhere(['tblprcobiodata.statLantikan' => $lantikan])
            ->andFilterWhere(['b.job_group' => $kategori])
            ->all();

        $total = 1;

        $purata = TblMain::PurataItemAll($tahun, $fasa);

        if ($model) {

            $total =  count($model);

            foreach ($model as $mdl) {
                $a1 += $mdl->relLifeEval->a1;

                $afekPositif += $mdl->afekPositif;
                $afekNegatif += $mdl->afekNegatif;

                $semangat += $mdl->semangat;
                $dedikasi += $mdl->dedikasi;
                $kesungguhan += $mdl->kesungguhan;
                $gaji += $mdl->gaji;
                $pangkat += $mdl->pangkat;
                $penyeliaan += $mdl->penyeliaan;
                $faedah += $mdl->faedah;
                $ganjaran += $mdl->ganjaran;
                $prosedur += $mdl->prosedur;
                $rakan += $mdl->rakan;
                $sifat += $mdl->sifat;
                $komunikasi += $mdl->komunikasi;

                $b1 += $mdl->relAffectMeasure->b1;
                $b2 += $mdl->relAffectMeasure->b2;
                $b3 += $mdl->relAffectMeasure->b3;
                $b4 += $mdl->relAffectMeasure->b4;
                $b5 += $mdl->relAffectMeasure->b5;
                $b6 += $mdl->relAffectMeasure->b6;
                $b7 += $mdl->relAffectMeasure->b7;
                $b8 += $mdl->relAffectMeasure->b8;
                $b9 += $mdl->relAffectMeasure->b9;
                $b10 += $mdl->relAffectMeasure->b10;

                $c1 += $mdl->relJobSatisfaction->c1;
                $c2 += $mdl->relJobSatisfaction->c2;
                $c3 += $mdl->relJobSatisfaction->c3;
                $c4 += $mdl->relJobSatisfaction->c4;
                $c5 += $mdl->relJobSatisfaction->c5;
                $c6 += $mdl->relJobSatisfaction->c6;
                $c7 += $mdl->relJobSatisfaction->c7;
                $c8 += $mdl->relJobSatisfaction->c8;
                $c9 += $mdl->relJobSatisfaction->c9;
                $c10 += $mdl->relJobSatisfaction->c10;
                $c11 += $mdl->relJobSatisfaction->c11;
                $c12 += $mdl->relJobSatisfaction->c12;
                $c13 += $mdl->relJobSatisfaction->c13;
                $c14 += $mdl->relJobSatisfaction->c14;
                $c15 += $mdl->relJobSatisfaction->c15;
                $c16 += $mdl->relJobSatisfaction->c16;
                $c17 += $mdl->relJobSatisfaction->c17;
                $c18 += $mdl->relJobSatisfaction->c18;
                $c19 += $mdl->relJobSatisfaction->c19;
                $c20 += $mdl->relJobSatisfaction->c20;
                $c21 += $mdl->relJobSatisfaction->c21;
                $c22 += $mdl->relJobSatisfaction->c22;
                $c23 += $mdl->relJobSatisfaction->c23;
                $c24 += $mdl->relJobSatisfaction->c24;
                $c25 += $mdl->relJobSatisfaction->c25;
                $c26 += $mdl->relJobSatisfaction->c26;
                $c27 += $mdl->relJobSatisfaction->c27;

                $d1 += $mdl->relJobEngagement->d1;
                $d2 += $mdl->relJobEngagement->d2;
                $d3 += $mdl->relJobEngagement->d3;
                $d4 += $mdl->relJobEngagement->d4;
                $d5 += $mdl->relJobEngagement->d5;
                $d6 += $mdl->relJobEngagement->d6;
                $d7 += $mdl->relJobEngagement->d7;
                $d8 += $mdl->relJobEngagement->d8;
                $d9 += $mdl->relJobEngagement->d9;

                $e1 += ($mdl->relSyukur) ? $mdl->relSyukur->e1 : 0;
            }
        }

        return [
            'afekPositif' => round($afekPositif / $total, 2),
            'afekNegatif' => round($afekNegatif / $total, 2),

            'semangat' => $avg_semangat = round($semangat / $total, 2),
            'tahap_semangat' => $main->kategori($avg_semangat),

            'dedikasi' => $avg_dedikasi = round($dedikasi / $total, 2),
            'tahap_dedikasi' => $main->kategori($avg_dedikasi),

            'kesungguhan' => $avg_kesungguhan = round($kesungguhan / $total, 2),
            'tahap_kesungguhan' => $main->kategori($avg_kesungguhan),

            'gaji' =>  $avg_gaji = round($gaji / $total, 2),
            'tahap_gaji' => $main->kategori($avg_gaji),

            'pangkat' => $avg_pangkat = round($pangkat / $total, 2),
            'tahap_pangkat' => $main->kategori($avg_pangkat),

            'penyeliaan' => $avg_penyeliaan = round($penyeliaan / $total, 2),
            'tahap_penyeliaan' => $main->kategori($avg_penyeliaan),

            'faedah' => $avg_faedah = round($faedah / $total, 2),
            'tahap_faedah' => $main->kategori($avg_faedah),

            'ganjaran' => $avg_ganjaran = round($ganjaran / $total, 2),
            'tahap_ganjaran' => $main->kategori($avg_ganjaran),

            'prosedur' => $avg_prosedur = round($prosedur / $total, 2),
            'tahap_prosedur' => $main->kategori($avg_prosedur),

            'rakan' => $avg_rakan = round($rakan / $total, 2),
            'tahap_rakan' => $main->kategori($avg_rakan),

            'sifat' => $avg_sifat = round($sifat / $total, 2),
            'tahap_sifat' => $main->kategori($avg_sifat),

            'komunikasi' => $avg_komunikasi = round($komunikasi / $total, 2),
            'tahap_komunikasi' => $main->kategori($avg_komunikasi),

            'a1' => round($a1 / $total, 2),
            'tahap_a1' => $main->skorColor(round($a1 / $total, 2), 1),


            'b1' => round($b1 / $total, 2),
            'b2' => round($b2 / $total, 2),
            'b3' => round($b3 / $total, 2),
            'b4' => round($b4 / $total, 2),
            'b5' => round($b5 / $total, 2),
            'b6' => round($b6 / $total, 2),
            'b7' => round($b7 / $total, 2),
            'b8' => round($b8 / $total, 2),
            'b9' => round($b9 / $total, 2),
            'b10' => round($b10 / $total, 2),

            'tahap_b1' => $main->tahapMean($purata['b1'], round($b1 / $total, 2)),
            'tahap_b2' => $main->tahapMean($purata['b2'], round($b2 / $total, 2), true),
            'tahap_b3' => $main->tahapMean($purata['b3'], round($b3 / $total, 2), true),
            'tahap_b4' => $main->tahapMean($purata['b4'], round($b4 / $total, 2), true),
            'tahap_b5' => $main->tahapMean($purata['b5'], round($b5 / $total, 2)),
            'tahap_b6' => $main->tahapMean($purata['b6'], round($b6 / $total, 2), true),
            'tahap_b7' => $main->tahapMean($purata['b7'], round($b7 / $total, 2)),
            'tahap_b8' => $main->tahapMean($purata['b8'], round($b8 / $total, 2)),
            'tahap_b9' => $main->tahapMean($purata['b9'], round($b9 / $total, 2), true),
            'tahap_b10' => $main->tahapMean($purata['b10'], round($b10 / $total, 2)),

            'c1' => round($c1 / $total, 2),
            'c2' => round($c2 / $total, 2),
            'c3' => round($c3 / $total, 2),
            'c4' => round($c4 / $total, 2),
            'c5' => round($c5 / $total, 2),
            'c6' => round($c6 / $total, 2),
            'c7' => round($c7 / $total, 2),
            'c8' => round($c8 / $total, 2),
            'c9' => round($c9 / $total, 2),
            'c10' => round($c10 / $total, 2),
            'c11' => round($c11 / $total, 2),
            'c12' => round($c12 / $total, 2),
            'c13' => round($c13 / $total, 2),
            'c14' => round($c14 / $total, 2),
            'c15' => round($c15 / $total, 2),
            'c16' => round($c16 / $total, 2),
            'c17' => round($c17 / $total, 2),
            'c18' => round($c18 / $total, 2),
            'c19' => round($c19 / $total, 2),
            'c20' => round($c20 / $total, 2),
            'c21' => round($c21 / $total, 2),
            'c22' => round($c22 / $total, 2),
            'c23' => round($c23 / $total, 2),
            'c24' => round($c24 / $total, 2),
            'c25' => round($c25 / $total, 2),
            'c26' => round($c26 / $total, 2),
            'c27' => round($c27 / $total, 2),

            'tahap_c1' => $main->skorColor(round($c1 / $total, 2), 2),
            'tahap_c2' => $main->skorColor(round($c2 / $total, 2), 3),
            'tahap_c3' => $main->skorColor(round($c3 / $total, 2), 2),
            'tahap_c4' => $main->skorColor(round($c4 / $total, 2), 3),
            'tahap_c5' => $main->skorColor(round($c5 / $total, 2), 2),
            'tahap_c6' => $main->skorColor(round($c6 / $total, 2), 3),
            'tahap_c7' => $main->skorColor(round($c7 / $total, 2), 3),
            'tahap_c8' => $main->skorColor(round($c8 / $total, 2), 2),
            'tahap_c9' => $main->skorColor(round($c9 / $total, 2), 2),
            'tahap_c10' => $main->skorColor(round($c10 / $total, 2), 2),
            'tahap_c11' => $main->skorColor(round($c11 / $total, 2), 3),
            'tahap_c12' => $main->skorColor(round($c12 / $total, 2), 2),
            'tahap_c13' => $main->skorColor(round($c13 / $total, 2), 3),
            'tahap_c14' => $main->skorColor(round($c14 / $total, 2), 3),
            'tahap_c15' => $main->skorColor(round($c15 / $total, 2), 3),
            'tahap_c16' => $main->skorColor(round($c16 / $total, 2), 3),
            'tahap_c17' => $main->skorColor(round($c17 / $total, 2), 3),
            'tahap_c18' => $main->skorColor(round($c18 / $total, 2), 3),
            'tahap_c19' => $main->skorColor(round($c19 / $total, 2), 2),
            'tahap_c20' => $main->skorColor(round($c20 / $total, 2), 2),
            'tahap_c21' => $main->skorColor(round($c21 / $total, 2), 2),
            'tahap_c22' => $main->skorColor(round($c22 / $total, 2), 3),
            'tahap_c23' => $main->skorColor(round($c23 / $total, 2), 2),
            'tahap_c24' => $main->skorColor(round($c24 / $total, 2), 2),
            'tahap_c25' => $main->skorColor(round($c25 / $total, 2), 3),
            'tahap_c26' => $main->skorColor(round($c26 / $total, 2), 2),
            'tahap_c27' => $main->skorColor(round($c27 / $total, 2), 3),

            'd1' => round($d1 / $total, 2),
            'd2' => round($d2 / $total, 2),
            'd3' => round($d3 / $total, 2),
            'd4' => round($d4 / $total, 2),
            'd5' => round($d5 / $total, 2),
            'd6' => round($d6 / $total, 2),
            'd7' => round($d7 / $total, 2),
            'd8' => round($d8 / $total, 2),
            'd9' => round($d9 / $total, 2),

            'tahap_d1' => $main->tahapMean($purata['d1'],  round($d1 / $total, 2)),
            'tahap_d2' => $main->tahapMean($purata['d2'],  round($d2 / $total, 2)),
            'tahap_d3' => $main->tahapMean($purata['d3'],  round($d3 / $total, 2)),
            'tahap_d4' => $main->tahapMean($purata['d4'],  round($d4 / $total, 2)),
            'tahap_d5' => $main->tahapMean($purata['d5'],  round($d5 / $total, 2)),
            'tahap_d6' => $main->tahapMean($purata['d6'],  round($d6 / $total, 2)),
            'tahap_d7' => $main->tahapMean($purata['d7'],  round($d7 / $total, 2)),
            'tahap_d8' => $main->tahapMean($purata['d8'],  round($d8 / $total, 2)),
            'tahap_d9' => $main->tahapMean($purata['d9'],  round($d9 / $total, 2)),

            'e1' => round($e1 / $total, 2),
            'tahap_e1' => $main->tahapMean($purata['e1'], round($e1 / $total, 2)),
        ];
    }



    //------------------------------------- GET SUB DIMENSI ---------------------------------------------------//


    public function getSemangat()
    {
        return $this->std_semangat($this->id);
    }

    public function getDedikasi()
    {
        return $this->std_dedikasi($this->id);
    }

    public function getKesungguhan()
    {
        return $this->std_kesungguhan($this->id);
    }

    public function getGaji()
    {
        return $this->std_gaji($this->id);
    }

    public function getPangkat()
    {
        return $this->std_pangkat($this->id);
    }

    public function getPenyeliaan()
    {
        return $this->std_ketua($this->id);
    }

    public function getFaedah()
    {
        return $this->std_faedah($this->id);
    }

    public function getGanjaran()
    {
        return $this->std_ganjaran($this->id);
    }

    public function getProsedur()
    {
        return $this->std_prosedur($this->id);
    }

    public function getRakan()
    {
        return $this->std_rakan($this->id);
    }
    public function getSifat()
    {
        return $this->std_sifat_kerja($this->id);
    }
    public function getKomunikasi()
    {
        return $this->std_komunikasi($this->id);
    }

    public function getAfekPositif()
    {
        return $this->std_affect_positif($this->id);
    }

    public function getAfekNegatif()
    {
        return $this->std_affect_negatif($this->id);
    }



    //------------------------------------- GET SUB DIMENSI ---------------------------------------------------//

    public static function skorColor($skor, $type)
    {
        //penilaian hidup
        if ($type == 1) {
            if ($skor >= 0 && $skor <= 4) {
                return 'label-danger';
            }
        }

        //kepuasan kerja
        if ($type == 2) {
            if ($skor >= 0 && $skor <= 3) {
                return 'label-danger';
            }
        }

        //kepuasan kerja reversed item
        if ($type == 3) {
            if ($skor >= 4) {
                return 'label-danger';
            }
        }

        return 'label-success';
    }

    public function tahapQuartile($arr, $val, $reverse = FALSE)
    {

        sort($arr);

        if ($val < UtilitiesFunc::Quartile($arr, 0.50)) {

            if ($reverse) {
                return 'label-success';
            }

            return  'label-danger';
        }

        if ($val >= UtilitiesFunc::Quartile($arr, 0.50) && $val < UtilitiesFunc::Quartile($arr, 0.75)) {
            return 'label-warning';
        }

        if ($val >= UtilitiesFunc::Quartile($arr, 0.75)) {
            if ($reverse) {
                return 'label-danger';
            }

            return  'label-success';
        }
    }

    public function tahapMean($avg, $val, $reverse = false)
    {
        if ($val < $avg) {

            if ($reverse) {
                return 'label-success';
            }

            return 'label-danger';
        }

        if ($val >= $avg) {

            if ($reverse) {
                return 'label-danger';
            }

            return 'label-success';
        }
    }


    public static function mitigasi($sub_domain)
    {
        $arr = [
            'gaji' => 'KAKITANGAN PERLU DIDEDAHKAN DENGAN PROGRAM PEMAHAMAN BERKAITAN GAJI DAN KENAIKAN PANGKAT. SELAIN ITU, KAKITANGAN JUGA DIBERIKAN TAKLIMAT ATAU KURSUS-KURSUS BERKAITAN PERKEMBANGAN DAN PENINGKATAN KERJAYA YANG SPESIFIK MENGIKUT SKIM DAN GRED MASING-MASING.',
            'pangkat' => 'KAKITANGAN PERLU DIDEDAHKAN DENGAN PROGRAM PEMAHAMAN BERKAITAN GAJI DAN KENAIKAN PANGKAT. SELAIN ITU, KAKITANGAN JUGA DIBERIKAN TAKLIMAT ATAU KURSUS-KURSUS BERKAITAN PERKEMBANGAN DAN PENINGKATAN KERJAYA YANG SPESIFIK MENGIKUT SKIM DAN GRED MASING-MASING.',
            'penyeliaan' => 'JABATAN YANG TERLIBAT PERLU MERANCANG DAN MENGANJURKAN PROGRAM-PROGRAM BAGI MENINGKATKAN HUBUNGAN PEKERJA-MAJIKAN. SELAIN ITU, KETUA JABATAN PERLU MENGHADIRI KURSUS-KURSUS BERKAITAN KEPIMPINAN, KOMUNIKASI BERKESAN DAN PENGURUSAN KONFLIK DI TEMPAT KERJA.',
            'faedah' => 'MENGANJURKAN TAKLIMAT BERKAITAN PEMAHAMAN DAN PENERANGAN TENTANG FAEDAH-FAEDAH SAMPINGAN YANG BOLEH DIPEROLEHI ATAU DIPOHON OLEH KAKITANGAN UMS.',
            'ganjaran' => 'MEMBERIKAN LEBIH BANYAK PENGHARGAAN KEPADA KAKITANGAN DALAM PELBAGAI BENTUK SEPERTI SAMBUTAN HARIJADI, PEMBERIAN HADIAH SEMPENA KELAHIRAN BAYI, ANUGERAH STAF TERBAIK BULANAN, BERTANYA KHABAR APABILA STAF SAKIT ATAU MENGALAMI MUSIBAH DAN PROGRAM-PROGRAM LAIN YANG BOLEH MENINGKATKAN MOTIVASI INTRINSIK DAN EKSTRINSIK KAKITANGAN.',
            'prosedur' => 'MENINGKATKAN PEMAHAMAN PEKERJA BERKAITAN PROSEDUR DAN PERATURAN DI TEMPAT KERJA ATAU MENGENALPASTI DAN MENAMBAHBAIK GARIS PANDUAN SEDIA ADA YANG MUNGKIN KURANG RELEVAN JIKA PERLU.',
            'rakan' => 'MENGANJURKAN AKTIVITI BAGI MENINGKATKAN SEMANGAT BERPASUKAN, NILAI INTERGRITI KUMPULAN, DAN KEFAHAMAN TERHADAP KARAKTER DIRI MAHUPUN RAKAN SEKERJA.',
            'sifat' => 'MENGANJURKAN AKTIVITI ATAU PROGRAM YANG BOLEH MENINGKATKAN KESERONOKAN BEKERJA. KAKITANGAN YANG TERLIBAT PERLU MENJAWAB UJIAN PERSONALITI UNTUK MENGENALPASTI FAKTOR YANG MEMPENGARUHI KESERONOKAN MEREKA BEKERJA BAGI MEMUDAHKAN PIHAK MAJIKAN MERANCANG DAN MELAKSANAKAN AKTIVITI DAN PROGRAM BERKAITAN.',
            'komunikasi' => 'MENGANJURKAN PROGRAM-PROGRAM YANG OLEH MENINGKATKAN KEMAHIRAN KOMUNIKASI KAKITANGAN',
            'semangat' => 'MENGANJURKAN PROGRAM-PROGRAM BAGI MENINGKATKAN MOTIVASI KERJA, KETERLIBATAN KERJA, RASA CINTA TERHADAP PEKERJAAN DAN PENINGKATAN NILAI INTEGRITI DI TEMPAT KERJA.',
            'dedikasi' => 'MENGANJURKAN PROGRAM-PROGRAM BAGI MENINGKATKAN MOTIVASI KERJA, KETERLIBATAN KERJA, RASA CINTA TERHADAP PEKERJAAN DAN PENINGKATAN NILAI INTEGRITI DI TEMPAT KERJA.',
            'kesungguhan' => 'MEMPERBANYAKKAN PROGRAM DAN AKTIVITI KESEDARAN BERKAITAN WORK LIFE BALANCED.',
        ];

        return $arr[$sub_domain];
    }

    public static function showMitigasi($tahap, $sub_domain)
    {

        // $find = ArrayHelper::getValue($tahap, 'label-danger');

        $tahap = ArrayHelper::toArray($tahap);

        $find = array_search('label-danger',$tahap);

        if ($find === 0 || $find === 1) {

            echo PopoverX::widget([
                'header' => '<span style="color:black;">Cadangan Mitigasi</span>',
                'type' => PopoverX::TYPE_DEFAULT,
                'placement' => PopoverX::ALIGN_BOTTOM,
                'content' => self::mitigasi($sub_domain),
                'toggleButton' => ['label' => '<i class="fa fa-info-circle" aria-hidden="true"></i></button>', 'class' => 'btn btn-default'],
            ]);
        }
    }
}
