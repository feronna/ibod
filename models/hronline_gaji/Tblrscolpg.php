<?php

namespace app\models\hronline_gaji;


use Yii;
use app\models\hronline\GredJawatan;
use app\models\hronline\Tblprcobiodata;
use app\models\gaji\RefRocReason2;
use app\models\gaji\Tblrscoelaun;

class Tblrscolpg extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'hrm.gaji_tblrscolpg';
    }

   public static function getDb()
   {
       return Yii::$app->get('db2');
   }
    
    public $bulan;

    public function rules()
    {
        return [
            [['t_lpg_cd', 't_lpg_peringkat', 't_lpg_tingkat', 't_lpg_jawatan_id', 't_lpg_dept_id', 't_lpg_id_sort'], 'integer'],
            [['t_lpg_date_start', 't_lpg_date_end', 't_lpg_app_by_datetime', 't_lpg_ver_by_datetime', 'created_datetime', 'updated_datetime', 'bulan'], 'safe'],
            [['t_lpg_amount'], 'number'],
            [['t_lpg_remark'], 'string'],
            [['t_lpg_ICNO', 't_lpg_app_by', 'created_by', 'updated_by'], 'string', 'max' => 12],
            [['t_lpg_marital_cd'], 'string', 'max' => 1],
            [['t_lpg_app_status', 't_lpg_ver_status'], 'string', 'max' => 8],
            [['t_lpg_ver_by'], 'string', 'max' => 50],
            [['t_lpg_cd', 't_lpg_date_start', 't_lpg_remark'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            't_lpg_id' => 'T Lpg ID',
            't_lpg_ICNO' => 'T Lpg Icno',
            't_lpg_cd' => 'T Lpg Cd',
            't_lpg_date_start' => 'T Lpg Date Start',
            't_lpg_date_end' => 'T Lpg Date End',
            't_lpg_peringkat' => 'T Lpg Peringkat',
            't_lpg_tingkat' => 'T Lpg Tingkat',
            't_lpg_amount' => 'T Lpg Amount',
            't_lpg_remark' => 'T Lpg Remark',
            't_lpg_jawatan_id' => 'T Lpg Jawatan ID',
            't_lpg_dept_id' => 'T Lpg Dept ID',
            't_lpg_marital_cd' => 'T Lpg Marital Cd',
            't_lpg_app_by' => 'T Lpg App By',
            't_lpg_app_status' => 'T Lpg App Status',
            't_lpg_app_by_datetime' => 'T Lpg App By Datetime',
            't_lpg_ver_by' => 'T Lpg Ver By',
            't_lpg_ver_status' => 'T Lpg Ver Status',
            't_lpg_ver_by_datetime' => 'T Lpg Ver By Datetime',
            't_lpg_id_sort' => 'T Lpg Id Sort',
            'created_by' => 'Created By',
            'created_datetime' => 'Created Datetime',
            'updated_by' => 'Updated By',
            'updated_datetime' => 'Updated Datetime',
        ];
    }
//    http://localhost/staff/web/saraan/rekod-lpg?icno=650519125235
    
    public function getStaf() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 't_lpg_ICNO']);
    }
    
    public function getJawatan() {
        return $this->hasOne(GredJawatan::className(), ['id' => 't_lpg_jawatan_id']);
    }
    
    public function getPengesah() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 't_lpg_ver_by']);
    }
    
    public function getJenisLpg() {
        return $this->hasOne(RefRocReason2::className(), ['lpgCd' => 't_lpg_cd']);
    }
    
    public function getAmtOld() {
        $prev = $this->find()->where(['<', 't_lpg_id', $this->t_lpg_id])->orderBy('t_lpg_id desc')->one();
        return $prev->t_lpg_amount;
    }
    
    public function getElaun() {
        return $this->hasMany(Tblrscoelaun::className(), ['el_lpg_id' => 't_lpg_id']);
    }
    
    public function getOldElaun() {
        $prev = $this->find()->where(['<', 't_lpg_id', $this->t_lpg_id])->orderBy('t_lpg_id desc')->one();
        return $this->hasMany(Tblrscoelaun::className(), ['el_lpg_id' => $prev->t_lpg_id]);
    }
    
    public function getSumNew() {
        return $this->hasMany(Tblrscoelaun::className(), ['el_lpg_id' => 't_lpg_id'])->sum('el_amount') + $this->t_lpg_amount;
    }
    
    public function getSumOld() {
        $prev = $this->find()->where(['<', 't_lpg_id', $this->t_lpg_id])->orderBy('t_lpg_id desc')->one();
        return Tblrscoelaun::find()->where(['el_lpg_id' => $prev->t_lpg_id])->sum('el_amount') + $prev->t_lpg_amount;
    }
    
}

