<?php

namespace app\models\myintegriti;

use Yii;
use app\models\myintegriti\TblBhgnA;
use app\models\myintegriti\TblBhgnB;
use app\models\myintegriti\TblBhgnC;
use app\models\myintegriti\RefBhgnA;
use yii\helpers\Html;

/**
 * This is the model class for table "utilities.itg_tbl_penilaian".
 *
 * @property int $id
 * @property string $icno
 * @property int $tahun
 * @property string $created_dt
 * @property int $status 1-pending, 2-complete
 */
class TblPenilaian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.itg_tbl_penilaian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahun', 'status'], 'integer'],
            [['created_dt'], 'safe'],
            [['icno'], 'string', 'max' => 14],
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
            'tahun' => 'Tahun',
            'created_dt' => 'Created Dt',
            'status' => 'Status',
        ];
    }
    
    public function getBiodata() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    
    public function getDepartment() {
        return $this->hasOne(\app\models\hronline\Department::className(), ['id' => 'dept_id']);
    }
    
    public function getJawatan() {
        return $this->hasOne(\app\models\hronline\GredJawatan::className(), ['id' => 'gred_id']);
    }
    
    public function getA() {
        return $this->hasOne(TblBhgnA::className(), ['id_penilaian' => 'id']);
    }
    
    public function getB() {
        return $this->hasOne(TblBhgnB::className(), ['id_penilaian' => 'id']);
    }
    
    public function getC() {
        return $this->hasOne(TblBhgnC::className(), ['id_penilaian' => 'id']);
    }
    
    public static function haspending($icno){
        if(static::find()->where(['icno' => $icno, 'status' => 1])->one()){
            return true;
        }else{
            return false;
        }
    }
    
    public static function isOwner($id, $icno, $status)
    {
          if (static::findOne(['id' => $id, 'icno' => $icno, 'status' => $status])){
                return true;
          } else {
                return false;
          }
    }
    
    public function getStatuslabel()
    {
          if ($this->status == 2){
                return '<span class="label label-success">Complete</span>';
          } else {
                return '<span class="label label-warning">Pending</span>';
          }
    }
    
    public function getStatusA()
    {
        $a = TblBhgnA::find()->where(['id_penilaian' => $this->id])->one();
        for ($i=1;$i<70;$i++){
            $col = 'q'.$i;
            if($a->$col == NULL){
                return false;
            }
        }
        return true;
    }
    
    public function getButtonA(){
        if($this->statusA){
            return Html::a('<span class="label label-success">Bahagian A</span>', ['bahagiana', 'id' => $this->id]);
        }else{
            return Html::a('<span class="label label-warning">Bahagian A</span>', ['bahagiana', 'id' => $this->id]);
        }
    }
    
    public function getStatusB()
    {
        $a = TblBhgnB::find()->where(['id_penilaian' => $this->id])->one();
        if($a){
        for ($i=1;$i<42;$i++){
            $col = 'q'.$i;
            if($a->$col == NULL){
                return false;
            }
        }
        return true;}
    }
    
    public function getButtonB(){
        if($this->statusA){
            if($this->statusB){
                return Html::a('<span class="label label-success">Bahagian B</span>', ['bahagianb', 'id' => $this->id]);
            }else{
                return Html::a('<span class="label label-warning">Bahagian B</span>', ['bahagianb', 'id' => $this->id]);
            }
        }else{
            return '<span class="label label-default">Bahagian B</span>';
        }
    }
    
    public function getStatusC()
    {
        $a = TblBhgnC::find()->where(['id_penilaian' => $this->id])->one();
        if($a){
        for ($i=1;$i<11;$i++){
            $col = 'b'.$i;
            if(!isset($a->$col)){
                return false;
            }
        }
        if(!$a->komen){
            return false;
        }
        return true;}
    }
    
    public static function fdate($date) {
        return date_format(date_create($date), "d/m/Y H:i:s");
    }
    
    public function getButtonC(){
        if($this->statusB){
            if($this->statusC){
                return Html::a('<span class="label label-success">Bahagian C</span>', ['bahagianc', 'id' => $this->id]);
            }else{
                return Html::a('<span class="label label-warning">Bahagian C</span>', ['bahagianc', 'id' => $this->id]);
            }
        }else{
            return '<span class="label label-default">Bahagian C</span>';
        }
    }
    
    public function getRefamanah() {
        return RefBhgnA::find()->where(['code' => 'A'])->all();
    }
    
    public function getAmanahpoint(){
        $model = $this->a;
        $total = 0;
        foreach ($this->refamanah as $a){
            $col = 'q'.$a->id;
            $total = $total + $model->$col;
        }
        return $total/(count($this->refamanah)*5);
    }
    
    public function getRefbijaksana() {
        return RefBhgnA::find()->where(['code' => 'B'])->all();
    }
    
    public function getBijaksanapoint(){
        $model = $this->a;
        $total = 0;
        foreach ($this->refbijaksana as $a){
            $col = 'q'.$a->id;
            $total = $total + $model->$col;
        }
        return $total/(count($this->refbijaksana)*5);
    }
    
    public function getRefhemah() {
        return RefBhgnA::find()->where(['code' => 'B'])->all();
    }
    
    public function getHemahpoint(){
        $model = $this->a;
        $total = 0;
        foreach ($this->refhemah as $a){
            $col = 'q'.$a->id;
            $total = $total + $model->$col;
        }
        return $total/(count($this->refhemah)*5);
    }
    
    public function getRefsosial() {
        return RefBhgnA::find()->where(['code' => 'S'])->all();
    }
    
    public function getSosialpoint(){
        $model = $this->a;
        $total = 0;
        foreach ($this->refsosial as $a){
            $col = 'q'.$a->id;
            $total = $total + $model->$col;
        }
        return $total/(count($this->refsosial)*5);
    }
    
    public static function listofyear() {
       return self::find()->select('tahun')->distinct()->all();
    }
    
    public static function averageindex($year) {
       $model = self::find()->where(['tahun' => $year, 'status' => 2]);
       return round($model->sum('indeks_integriti')/$model->count(),2);
    }
    
    public static function totalfemale($year){
        return self::find()->joinWith('biodata', false, 'LEFT JOIN')->where(['hronline.tblprcobiodata.GenderCd' => 'P', 'itg_tbl_penilaian.status' => 2, 'tahun' => $year])->count();
    }
    
    public static function totalmale($year){
        return self::find()->joinWith('biodata', false, 'LEFT JOIN')->where(['hronline.tblprcobiodata.GenderCd' => 'L', 'itg_tbl_penilaian.status' => 2, 'tahun' => $year])->count();
    }
    
    public static function averagestatusbar($score){
        switch($score){
        case($score < 50):
            return 'progress-bar-danger';
        case($score < 80):
            return 'progress-bar-warning';
        case($score < 85):
            return 'progress-bar-info';
        case($score <= 100):
            return 'progress-bar-success';
    }
    }
    
    public static function averagestatus($score){
        switch($score){
        case($score < 50):
            return 'Lemah';
        case($score < 80):
            return 'Biasa';
        case($score < 85):
            return 'Baik';
        case($score <= 100):
            return 'Cemerlang';
    }
    }
}
