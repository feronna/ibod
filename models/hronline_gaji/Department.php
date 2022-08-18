<?php

namespace app\models\hronline_gaji;

use Yii;
use app\models\myidp\RptStatistikIdpV2;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\DeptCat;

class Department extends \yii\db\ActiveRecord {

    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }

    public static function tableName() {
        return 'hronline.department';
    }

    public function rules() {
        return [
                [['category_id', 'isActive', 'cluster', 'dept_cat_id', 'sub_of'], 'integer'],
                [['address'], 'string'],
                [['fullname'], 'string', 'max' => 300],
                [['shortname', 'chief'], 'string', 'max' => 60],
                [['mymohesCd'], 'string', 'max' => 4],
                [['pp', 'bos'], 'string', 'max' => 12],
                [['idMM'], 'string', 'max' => 20],
                [['fax_no', 'tel_no', 'pa_email'], 'string', 'max' => 50],
                [['chief', 'address','fax_no', 'tel_no', 'pa_email'], 'required', 'on'=>'update_department_info', 'message'=>'Ruang ini adalah mandatori'],
                [['fullname','shortname','chief','pp', 'address','fax_no', 'tel_no', 'pa_email','dept_cat_id','isActive','mymohesCd','cluster'], 'required', 'on'=>'tk_jabatan', 'message'=>'Ruang ini adalah mandatori'],
                [['uc_no'], 'string', 'max'=>10],
                
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'fullname' => 'JFPIU',
            'shortname' => 'JFPIU',
            'chief' => 'Chief',
            'mymohesCd' => 'Mymohes Cd',
            'category_id' => 'Category ID',
            'pp' => 'Pp',
            'bos' => 'Bos',
            'isActive' => 'Is Active',
            'idMM' => 'Id Mm',
            'cluster' => 'Cluster',
            'dept_cat_id' => 'Dept Cat ID',
            'sub_of' => 'Sub Of',
            'address' => 'Address',
            'fax_no' => 'Fax No',
            'tel_no' => 'Tel No',
            'uc_no' => 'UC No',
            'pa_email' => 'Pa Email',
        ];
    }
	
    public function getBiodata(){
        return $this->hasOne(Tblprcobiodata::className(), ['DeptId' => 'id']);
    }
	public function getChiefBiodata(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'chief']);
    }
    public function getppBiodata(){
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pp']);
    }
    
    public function getK_jabatan() {
        if ($this->chief !== NULL) {
            return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'chief']);
        } else {
            return '<span class="label label-warning">Not Set</span>';
        }
    }

    public function getP_pendaftar() {

        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'pp']);
    }

    public function getActive() {
        if ($this->isActive == 1) {
            return '<span ">Aktif</span>';
        }else{
            return '<span ">Tidak Aktif</span>';

        }
    }
     public function getDeptCat() {

        return $this->hasOne(DeptCat::className(), ['id' => 'dept_cat_id']);
    }
     public function getDeptSub() {

        return $this->hasOne(Department::className(), ['id' => 'sub_of']);
    }
    
    public function countStaffDept($kumpulan, $category) {
        
        $count = 0;
        
        if ($category == 0){ //keseluruhan
            
            $count = Tblprcobiodata::find()
                    ->where(['DeptId' => $kumpulan])
                    ->andWhere(['Status' => '1'])
                    ->count();
            
        } elseif ($category == 1) { //akademik
            
            $count = RptStatistikIdpV2::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['cpd_group' => $kumpulan, 'job_category' => 1])
                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1'])
                    ->count();
            
        } elseif ($category == 2){ //pentadbiran
            
            $count = RptStatistikIdpV2::find()
                    ->joinWith('biodata.jawatan')
                    ->where(['cpd_group' => $kumpulan, 'job_category' => 2])
                    ->andWhere(['staf_status' => '1', 'statusIDP' => '1'])
                    ->count();
            
        }
        return $count;
        
    }
   
    
}
