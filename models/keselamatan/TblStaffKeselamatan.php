<?php

namespace app\models\keselamatan;

use app\models\hronline\Campus;
use app\models\hronline\GredJawatan;
use app\models\hronline\Tblprcobiodata;
use app\models\keselamatan\RefPosKawalan;
//use app\models\keselamatan\TblStaffKeselamatan;
use app\models\keselamatan\TblShiftKeselamatan;
use app\models\keselamatan\RefUnit;
use app\models\keselamatan\RefShifts;
use app\models\keselamatan\TblOt;
use Yii;

/**
 * This is the model class for table "keselamatan.tbl_staff_keselamatan".
 *
 * @property int $id
 * @property string $staff_icno
 * @property string $pos_kawalan_id
 * @property int $unit_id bravo,alpha,scc
 * @property string $ketua_pos
 * @property string $penolong_ketua_pos
 * @property string $month
 * @property string $year
 * @property string $added_by
 * @property string $created_at
 */
class TblStaffKeselamatan extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.tbl_staff_keselamatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['unit_id','tukar_pos','isActive','campus_id','isExcluded'], 'integer'],
            [['year', 'created_at'], 'safe'],
            [['staff_icno', 'ketua_pos', 'penolong_ketua_pos', 'added_by'], 'string', 'max' => 20],
            [['pos_kawalan_id'], 'string', 'max' => 50],
            [['month'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'tukar_pos' => 'Tukar Pos',
            'staff_icno' => 'Staff Icno',
            'pos_kawalan_id' => 'Pos Kawalan ID',
            'unit_id' => 'Unit ID',
            'ketua_pos' => 'Ketua Pos',
            'penolong_ketua_pos' => 'Penolong Ketua Pos',
            'month' => 'Month',
            'year' => 'Year',
            'added_by' => 'Added By',
            'created_at' => 'Created At',
        ];
    }
    public static function staffKeselamatan($skim,$gred_no){
        if($skim == "KP" && $gred_no < 40){
            return true;
        }
        else{
            return false;
        }

    }
    public static function jawatan($id){
        $identity = Tblprcobiodata::find()->where(['ICNO'=>$id])->one();
        $jawatan = GredJawatan::find()->where(['id'=>$identity->gredJawatan])->one();
        return $jawatan->fname;

    }
    public function getStaff() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'staff_icno']);
    }
    public function getCampus() {
        return $this->hasOne(Campus::className(), ['campus_id' => 'campus_id']);
    }
    public function getClockin() {
        $val = '';
        if($this->isExcluded == 1){
            $val = "STARS";
        }else{
            $val = "SKB";
        }
        return $val;
    }

    public function getPos() {
        return $this->hasOne(RefPosKawalan::className(), ['id' => 'pos_kawalan_id']);
    }
    public function getPosdaily() {
        return $this->hasOne(RefPosKawalan::className(), ['id' => 'pos_kawalan_id']);
    }
    public function getSyifdaily() {
        return $this->hasOne(TblShiftKeselamatan::className(), ['id' => 'pos_kawalan_id']);
    }
    public function getSyif(){
        $date = date('Y-m-d');
        $identity = TblShiftKeselamatan::find()->where(['tarikh'=>$date])->andWhere(['icno'=> $this->staff->ICNO])->one();
        $syif = RefShifts::find()->where(['id'=>$identity->shift_id])->one();
        return $syif->jenis_shifts;
    }
    public function getSyifot(){
        $date = date('Y-m-d');
        $identity = TblOt::find()->where(['tarikh'=>$date])->andWhere(['icno'=> $this->staff->ICNO])->one();
//        var_dump($identity);die;
        $syif = RefShifts::find()->where(['id'=>$identity->shift_id])->one();
        return $syif->jenis_shifts;
    }
    
    public function getUnitname() {
        return $this->hasOne(RefUnit::className(), ['id' => 'unit_id']);
    }

    public function getKp() {
        if ($this->ketua_pos == '1') {
            return '<span ">KP</span>';
        }if ($this->penolong_ketua_pos == '1'){
            return '<span "> PKP </span>';
        }
    }
}
