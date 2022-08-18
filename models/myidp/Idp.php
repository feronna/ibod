<?php

namespace app\models\myidp;

use Yii;
use app\models\myidp\RptStatistikIdpV2;

/**
 * This is the model class for table "idp.v_idp_profil".
 *
 * @property int $id
 * @property int $tahun
 * @property int $susunan
 * @property int $kumpulan
 * @property string $nama_kumpulan
 * @property string $v_co_icno
 * @property string $v_co_umsper
 * @property string $v_co_title
 * @property string $v_co_name
 * @property string $v_co_gender
 * @property string $v_co_sts
 * @property int $v_co_app_cd
 * @property string $v_co_app
 * @property string $v_co_app_startdate
 * @property int $campus_id
 * @property string $v_co_campus
 * @property string $v_co_gred
 * @property string $v_co_jwtn
 * @property int $DeptId
 * @property string $v_co_dept_sn
 * @property string $v_co_dept_fn
 * @property string $v_co_job_grp
 * @property string $v_co_cpd_group_name
 * @property string $v_co_sand_date
 * @property int $v_co_tempoh_sandangan_month
 * @property string $v_co_tempoh_sandangan_year
 * @property string $gred_skim
 * @property string $gred_no
 * @property int $kategori 1=Akademik,2=Bukan Akademik
 * @property int $tahap
 * @property int $gredjawatan
 * @property int $v_co_cpd_group
 * @property int $v_mata_minima
 * @property int $v_mata_terkumpul Mata Terkumpul Dari Tahun Lepas
 * @property int $v_cf_umum
 * @property int $v_idp_teras
 * @property int $v_idp_elektif
 * @property int $v_idp_umum
 * @property string $pp
 * @property string $hod
 * @property int $isPegawaiUtama 0=Bukan, 1=Ya
 * @property string $updatedate
 * @property int $bhgn_id
 * @property string $ServStatusNm
 * @property int $ServStatusCd
 * @property string $ServStatusStDt
 * @property int $v_matamin_teras_uni
 * @property int $v_idp_teras_uni
 * @property int $v_cf_teras_skim
 * @property int $v_matamin_teras_skim
 * @property int $v_idp_teras_skim
 * @property int $v_cf_elektif
 * @property int $v_matamin_elektif
 */
class Idp extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    
    public static function tableName()
    {
        return 'idp.v_idp_profil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun', 'susunan', 'kumpulan', 'v_co_app_cd', 'campus_id', 'DeptId', 'v_co_tempoh_sandangan_month', 'kategori', 'tahap', 'gredjawatan', 'v_co_cpd_group', 'v_mata_minima', 'v_mata_terkumpul', 'v_cf_umum', 'v_idp_teras', 'v_idp_elektif', 'v_idp_umum', 'isPegawaiUtama', 'bhgn_id', 'ServStatusCd', 'v_matamin_teras_uni', 'v_idp_teras_uni', 'v_cf_teras_skim', 'v_matamin_teras_skim', 'v_idp_teras_skim', 'v_cf_elektif', 'v_matamin_elektif'], 'integer'],
            [['v_co_app_startdate', 'v_co_sand_date', 'updatedate', 'ServStatusStDt'], 'safe'],
            [['v_co_tempoh_sandangan_year'], 'number'],
            [['nama_kumpulan', 'v_co_job_grp', 'v_co_cpd_group_name'], 'string', 'max' => 100],
            [['v_co_icno', 'pp', 'hod'], 'string', 'max' => 12],
            [['v_co_umsper'], 'string', 'max' => 15],
            [['v_co_title', 'v_co_name', 'v_co_sts', 'v_co_app', 'v_co_campus', 'v_co_jwtn', 'ServStatusNm'], 'string', 'max' => 255],
            [['v_co_gender'], 'string', 'max' => 1],
            [['v_co_gred'], 'string', 'max' => 10],
            [['v_co_dept_sn'], 'string', 'max' => 60],
            [['v_co_dept_fn'], 'string', 'max' => 300],
            [['gred_skim', 'gred_no'], 'string', 'max' => 5],
            [['v_co_icno', 'tahun'], 'unique', 'targetAttribute' => ['v_co_icno', 'tahun']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tahun' => 'Tahun',
            'susunan' => 'Susunan',
            'kumpulan' => 'Kumpulan',
            'nama_kumpulan' => 'Nama Kumpulan',
            'v_co_icno' => 'V Co Icno',
            'v_co_umsper' => 'V Co Umsper',
            'v_co_title' => 'V Co Title',
            'v_co_name' => 'V Co Name',
            'v_co_gender' => 'V Co Gender',
            'v_co_sts' => 'V Co Sts',
            'v_co_app_cd' => 'V Co App Cd',
            'v_co_app' => 'V Co App',
            'v_co_app_startdate' => 'V Co App Startdate',
            'campus_id' => 'Campus ID',
            'v_co_campus' => 'V Co Campus',
            'v_co_gred' => 'V Co Gred',
            'v_co_jwtn' => 'V Co Jwtn',
            'DeptId' => 'Dept ID',
            'v_co_dept_sn' => 'V Co Dept Sn',
            'v_co_dept_fn' => 'V Co Dept Fn',
            'v_co_job_grp' => 'V Co Job Grp',
            'v_co_cpd_group_name' => 'V Co Cpd Group Name',
            'v_co_sand_date' => 'V Co Sand Date',
            'v_co_tempoh_sandangan_month' => 'V Co Tempoh Sandangan Month',
            'v_co_tempoh_sandangan_year' => 'V Co Tempoh Sandangan Year',
            'gred_skim' => 'Gred Skim',
            'gred_no' => 'Gred No',
            'kategori' => 'Kategori',
            'tahap' => 'Tahap',
            'gredjawatan' => 'Gredjawatan',
            'v_co_cpd_group' => 'V Co Cpd Group',
            'v_mata_minima' => 'Mata IDP Minimum Kumpulan',
            'v_mata_terkumpul' => 'Mata IDP Dibawa Ke Hadapan',
            'v_cf_umum' => 'V Cf Umum',
            'v_idp_teras' => 'V Idp Teras',
            'v_idp_elektif' => 'V Idp Elektif',
            'v_idp_umum' => 'V Idp Umum',
            'pp' => 'Pp',
            'hod' => 'Hod',
            'isPegawaiUtama' => 'Is Pegawai Utama',
            'updatedate' => 'Updatedate',
            'bhgn_id' => 'Bhgn ID',
            'ServStatusNm' => 'Serv Status Nm',
            'ServStatusCd' => 'Serv Status Cd',
            'ServStatusStDt' => 'Serv Status St Dt',
            'v_matamin_teras_uni' => 'Wajib Teras Universiti',
            'v_idp_teras_uni' => 'V Idp Teras Uni',
            'v_cf_teras_skim' => 'V Cf Teras Skim',
            'v_matamin_teras_skim' => 'V Matamin Teras Skim',
            'v_idp_teras_skim' => 'V Idp Teras Skim',
            'v_cf_elektif' => 'V Cf Elektif',
            'v_matamin_elektif' => 'V Matamin Elektif',

        ];
    }
    
    public function getSameIcno()
    {
        return $this->hasOne(RptStatistikIdpV2::className(),['icno' => 'v_co_icno', 'tahun' => 'tahun']);
    }
    
    /*****************************************************************************/
    /**get 'tahap' **/
    public function getTahapKhidmat() {
        
        if (($this->tahap) == 3){
            //$tahap='LANJUTAN';
            return 'LANJUTAN';
        }
        else if (($this->tahap) == 2){
            //$tahap='PERTENGAHAN';
            return 'PERTENGAHAN';
        }
        else{
            //$tahap='ASAS';
            return 'ASAS';
        }
    }
    
    /*****************************************************************************/
    /**get 'tempoh perkhidmatan di gred semasa' **/
    //get current year
    public function getTempohKhidmatGredSemasa() {
        
        //get current user ID
        $id = Yii::$app->user->getId();
        
        /*****************************************************************************/
        /**get 'tempoh perkhidmatan di gred semasa' **/
        //get current year
        //$currentYear = date('Y');
        $currentYear = 2019;
        
        //find [v_co_icno] from database that match with [$id]-currentUser AND 
        //find [tahun] from database that match with [$currentYear]
        $model = Idp::findOne(['v_co_icno' => $id,'tahun' => $currentYear]);
        //$mata = Idp::find()->where(['v_co_icno' => $id,'tahun' => $currentYear]);
        
        //example of a relation
        //$model = $this->hasOne(Idp::className(), ['v_co_icno' => $id])->where(['tahun' => $currentYear]);
        
        //get today's date
        $currentDate = date('Y-m-d');
        
        //get 'tarikh sandangan bagi gred terkini' from database
        //function date_create() return a new DateTime object - if omitted, the date will be read as a string - DKW
        $datetime1 = date_create($model->v_co_sand_date);
        $datetime2 = date_create($currentDate);
        
        //date_diff() function calculate the difference two dates
        $tempohKhidmat = date_diff($datetime1, $datetime2);

        //format the date difference
        $tempohKhidmat2 =  $tempohKhidmat->format('%y TAHUN %m BULAN %d HARI');
        
        return $tempohKhidmat2;
    }
    
    
//    public function getTest(){
//        
//        $id = Yii::$app->user->getId();
//        
//        $currentYear = date('Y');
//        
//        return Idp::findOne(['v_co_icno' => $id,'tahun' => $currentYear]);
//    }
    /*****************************************************************************/
    /**get 'PEGAWAI PELULUS KURSUS JFPIU' name from his IC no **/
    public function getPegawaiPelulus(){
        
        $nama_pegawai = "TIADA DATA";
        
        $pegawai_icno = $this->pp;
        $model2 = Idp::findOne(['v_co_icno' => $pegawai_icno]);
        
        if ($model2) {
            $nama_pegawai = $model2->v_co_title.' '.$model2->v_co_name;
        }
        
        return $nama_pegawai;
    }      
}