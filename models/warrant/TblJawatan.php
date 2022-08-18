<?php

namespace app\models\warrant;

use app\models\hronline\Kumpulankhidmat;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "warrant.tbl_jawatan".
 *
 * @property int $id
 * @property string $jawatan
 * @property string $gred
 * @property int $jumlah_waran
 * @property int $kategori 1 akad | 2 bkn akad
 * @property int $kumpkhidmat_id refer hronline kumpkhidmat
 */
class TblJawatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'warrant.tbl_jawatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jumlah_waran', 'kategori', 'kumpkhidmat_id','isActive'], 'integer'],
            [['jawatan', 'gred'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jawatan' => 'Jawatan',
            'gred' => 'Gred',
            'jumlah_waran' => 'Jumlah Waran',
            'kategori' => 'Kategori',
            'kumpkhidmat_id' => 'Kumpkhidmat ID',
        ];
    }
    public function getCategory()
    {

        if($this->kategori == 1){
            $v = "Akademik";
            return $v;
        }
        if($this->kategori == 2){
            $v = "Pentadbiran";
            return $v;
        }
    }
    public function getKhidmat(){
        $khidmat = Kumpulankhidmat::findOne(['id'=>$this->kumpkhidmat_id]);
        return $khidmat->name;
    }
    public static function WarrantTotal($cat) {

        
        $query = (new \yii\db\Query())->from('warrant.tbl_jawatan')->where(['kategori' => $cat]);
        $sum = $query->sum('jumlah_waran');

        return $sum;
    }

    public static function Totals($cat){

        if($cat == 1){

        $sql = 'SELECT a.`ICNO`            
        FROM hronline.`tblprcobiodata` a
        LEFT JOIN hronline.`department` b ON b.`id` = a.`DeptId`
        LEFT JOIN hronline.`programpengajaran` c ON c.`id` = a.`KodProgram`
        LEFT JOIN hronline.`appointmentstatus` d ON d.`ApmtStatusCd` = a.`statLantikan`
        LEFT JOIN hronline.`servicestatus` e ON e.`ServStatusCd` = a.`Status`
        LEFT JOIN hronline.`gredjawatan` f ON f.`id` = a.`gredJawatan`
        
        WHERE a.`Status` !=  6
        AND f.`job_category` = 1
        AND a.`statLantikan` = 1
        ';
        $total = Tblprcobiodata::findBySql($sql)->count();
        // var_dump($total);die;
        }
        if($cat == 2){

            $sql = 'SELECT a.`ICNO`            
            FROM hronline.`tblprcobiodata` a
            LEFT JOIN hronline.`department` b ON b.`id` = a.`DeptId`
            LEFT JOIN hronline.`programpengajaran` c ON c.`id` = a.`KodProgram`
            LEFT JOIN hronline.`appointmentstatus` d ON d.`ApmtStatusCd` = a.`statLantikan`
            LEFT JOIN hronline.`servicestatus` e ON e.`ServStatusCd` = a.`Status`
            LEFT JOIN hronline.`gredjawatan` f ON f.`id` = a.`gredJawatan`
            
            WHERE a.`Status` !=  6
            AND f.`job_category` = 2
            AND a.`statLantikan` = 1
            ';
            $total = Tblprcobiodata::findBySql($sql)->count();
        }

        return $total;
    }
    public static function TotalKontrak($cat){

        if($cat == 1){

        $sql = 'SELECT a.`ICNO`            
        FROM hronline.`tblprcobiodata` a
        LEFT JOIN hronline.`department` b ON b.`id` = a.`DeptId`
        LEFT JOIN hronline.`programpengajaran` c ON c.`id` = a.`KodProgram`
        LEFT JOIN hronline.`appointmentstatus` d ON d.`ApmtStatusCd` = a.`statLantikan`
        LEFT JOIN hronline.`servicestatus` e ON e.`ServStatusCd` = a.`Status`
        LEFT JOIN hronline.`gredjawatan` f ON f.`id` = a.`gredJawatan`
        
        WHERE a.`Status` !=  6
        AND f.`job_category` = 1
        AND a.`statLantikan` = 3
        ';
        $total = Tblprcobiodata::findBySql($sql)->count();
        // var_dump($total);die;
        }
        if($cat == 2){

            $sql = 'SELECT a.`ICNO`            
            FROM hronline.`tblprcobiodata` a
            LEFT JOIN hronline.`department` b ON b.`id` = a.`DeptId`
            LEFT JOIN hronline.`programpengajaran` c ON c.`id` = a.`KodProgram`
            LEFT JOIN hronline.`appointmentstatus` d ON d.`ApmtStatusCd` = a.`statLantikan`
            LEFT JOIN hronline.`servicestatus` e ON e.`ServStatusCd` = a.`Status`
            LEFT JOIN hronline.`gredjawatan` f ON f.`id` = a.`gredJawatan`
            
            WHERE a.`Status` !=  6
            AND f.`job_category` = 2
            AND a.`statLantikan` = 3
            ';
            $total = Tblprcobiodata::findBySql($sql)->count();
        }

        return $total;
    }

    public static function WarrantTotals() {

        $akademik = (new \yii\db\Query())->from('warrant.tbl_jawatan')->where(['kategori' => 1]);
        $pentadbiran = (new \yii\db\Query())->from('warrant.tbl_jawatan')->where(['kategori' => 2]);
        $sum1 = $akademik->sum('jumlah_waran');
        $sum2 = $pentadbiran->sum('jumlah_waran');
        $total = $sum1 + $sum2;

   
    return $total;
}
}
