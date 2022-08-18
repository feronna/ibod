<?php

namespace app\models\keselamatan;

use app\models\hronline\GredJawatan;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\RefShifts;
use app\models\hronline\Tblprcobiodata;
use app\models\kehadiran\TblWp;
use app\models\keselamatan\TblStaffKeselamatan;
use app\models\patrol\PatrolExchangepos;

/**
 * This is the model class for table "keselamatan.tbl_shift_keselamatan".
 *
 * @property int $id
 * @property string $icno
 * @property string $tarikh
 * @property string $year
 * @property string $month
 * @property int $shift_id
 */
class TblShiftKeselamatan extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.tbl_shift_keselamatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarikh', 'year'], 'safe'],
            [['shift_id'], 'required', 'message' => 'Please Select Shift'],
            [['shift_id', 'unit_id', 'pos_kawalan_id', 'campus_id'], 'integer'],
            [['icno'], 'string', 'max' => 20],
            [['month'], 'string', 'max' => 15],
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
            'tarikh' => 'Tarikh',
            'year' => 'Year',
            'month' => 'Month',
            'shift_id' => 'Shift ID',
            'unit_id' => 'Unit ID',
            'pos_kawalan_id' => 'pos kawalan id',
        ];
    }

    public static function CountHadirYearlySpecific($month, $year, $type, $icno, $key, $value)
    {
        $mth = \app\models\keselamatan\TblRekod::viewMonth($month);
        $val = '0';
        $model = TblRollcall::findOne(['anggota_icno' => $icno, 'type' => $type]);

        if ($model) {
            //            $model = TblRollcall::find()->where(['between', 'date', "2020-01-02", "2020-01-09"])->one();

            $val = (new \yii\db\Query())
                ->from('keselamatan.tbl_rollcall')
                ->where(['month' => $mth])
                ->andWhere(['year' => $year])
                ->andWhere(['anggota_icno' => $icno])
                ->andWhere([$key => $value])
                ->count();
        }
        return $val;
    }

    public function getWp()
    {
        return $this->hasOne(RefShifts::className(), ['id' => 'shift_id']);
    }

    public function viewShift($icno, $tarikh)
    {
        $val = false;

        $model = TblShiftKeselamatan::findOne(['icno' => $icno, 'tarikh' => $tarikh]);

        if ($model) {
            $val = $model->wp->jenis_shifts;
        }
        return $val;
    }
 
    public static function shift($icno)
    {
        $val = 'WBF';

        $model = TblShiftKeselamatan::findOne(['icno' => $icno, 'tarikh' => date('Y-m-d')]);

        if ($model) {
            $val = $model->wp->jenis_shifts;
        }
        return $val;
    }

    public function getStaff()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public static function gred($icno) {
        $staff = Tblprcobiodata::findOne(['ICNO'=>$icno]);
        $model = GredJawatan::find()->where(['id' => $staff->gredJawatan])->one();

        return $model->gred;
    }
    public static function name($id){
        $val = "";
        $model = Tblprcobiodata::findOne(['ICNO' => $id]);
        if($model){
            $val = $model->CONm;
        }
        return $val;
    }
    public static function syif($id){
        $val = "";
        $model = RefShifts::findOne(['id' => $id]);
        if($model){
            $val = $model->jenis_shifts;
        }
        return $val;
    }

    public function countSyif($id, $pos, $units, $tarikh)
    {
        //        var_dump($id,$pos,$units,$tarikh);
        //        var_dump($pos);
        //        $mod = TblShiftKeselamatan::findOne(['tarikh' => $tarikh]);

        $val = false;
        $val2 = false;
        $val1 = false;
        $model = TblShiftKeselamatan::findOne(['tarikh' => $tarikh]);
        //        var_dump($tarikh);die;
        if ($model) {
            //            $ids = $model->wp->id;
            //            var_dump($ids);   
            //            die;
            $val1 = (new \yii\db\Query())
                ->from('keselamatan.tbl_shift_keselamatan')
                ->where(['shift_id' => $id])
                ->andWhere(['tarikh' => $tarikh])
                ->andWhere(['unit_id' => $units])
                ->andWhere(['pos_kawalan_id' => $pos])
                ->count();
            //            echo $val1;die;
            $val2 = (new \yii\db\Query())
                ->from('keselamatan.tbl_ot')
                ->where(['shift_id' => $id])
                ->andWhere(['tarikh' => $tarikh])
                ->andWhere(['unit_id' => $units])
                ->andWhere(['pos_kawalan_id' => $pos])
                ->count();
            $val3 = (new \yii\db\Query())
                ->from('keselamatan.tbl_lmt')
                ->where(['lmt_id' => $id])
                ->andWhere(['tarikh' => $tarikh])
                ->andWhere(['unit_id' => $units])
                ->andWhere(['pos_kawalan_id' => $pos])
                ->count();
            //            echo $val2;die;

            $val = $val1 + $val2 + $val3;
            //                    var_dump($val);die;
        }
        return $val;
    }
//day before wp
    public static function lastwpcheck($icno,$date_before)
    {
// echo $date_before;die;
        $val = '';
        // $today = date('Y-m-d');
        // $date_before = date('Y-m-d', strtotime($today . ' -1 day'));


        $staff = TblStaffKeselamatan::find()->where(['staff_icno' => $icno])->one();
            //    var_dump($staff);die;
        //check dlu klu ada dlm staf list utk shift
        if ($staff) {
            $shift = TblShiftKeselamatan::find()->where(['icno' => $icno, 'tarikh' => $date_before])->one();
            //            var_dump($shift);die;
            if (!$shift) {
                $val = null;
            } else {
                $val = $shift->shift_id;
            }
            //  $val = $shift->shift_id;
            //klu tiada pakai yang wbb biasa sja
        } else {
            $sql = 'SELECT * FROM attendance.tbl_wp WHERE icno=:icno AND status=:status AND (DATE(NOW()) BETWEEN start_date AND end_date OR end_date IS NULL)';
            $model = TblWp::findBySql($sql, [':icno' => $icno, ':status' => 'APPROVED'])->one();
            $val = $model->wp_id;
            //            var_dump($model);die;
        }

        // if ($display) {
        //     $val = $model->wp->jenis_wp;
        // }

        //        var_dump($val);die;
        return $val;
    }
    public static function lastwp($icno, $display = null)
    {

        $val = '';
        $today = date('Y-m-d');
        $date_before = date('Y-m-d', strtotime($today . ' -1 day'));


        $staff = TblStaffKeselamatan::find()->where(['staff_icno' => $icno])->one();
            //    var_dump($staff);die;
        //check dlu klu ada dlm staf list utk shift
        if ($staff) {
            $shift = TblShiftKeselamatan::find()->where(['icno' => $icno, 'tarikh' => $date_before])->one();
            //            var_dump($shift);die;
            if (!$shift) {
                $val = null;
            } else {
                $val = $shift->shift_id;
            }
            //  $val = $shift->shift_id;
            //klu tiada pakai yang wbb biasa sja
        } else {
            $sql = 'SELECT * FROM attendance.tbl_wp WHERE icno=:icno AND status=:status AND (DATE(NOW()) BETWEEN start_date AND end_date OR end_date IS NULL)';
            $model = TblWp::findBySql($sql, [':icno' => $icno, ':status' => 'APPROVED'])->one();
            $val = $model->wp_id;
            //            var_dump($model);die;
        }

        if ($display) {
            $val = $model->wp->jenis_wp;
        }

        //        var_dump($val);die;
        return $val;
    }

    public static function curr_wp($icno, $display = null)
    {

        $val = '';
        $today = date('Y-m-d');

        $staff = TblStaffKeselamatan::find()->where(['staff_icno' => $icno])->one();
            //    var_dump($staff);die;
        //check dlu klu ada dlm staf list utk shift
        if ($staff) {
            $shift = TblShiftKeselamatan::find()->where(['icno' => $icno, 'tarikh' => $today])->one();
            //            var_dump($shift);die;
            if (!$shift) {
                $val = null;
            } else {
                $val = $shift->shift_id;
            }
            //  $val = $shift->shift_id;
            //klu tiada pakai yang wbb biasa sja
        } else {
            $sql = 'SELECT * FROM attendance.tbl_wp WHERE icno=:icno AND status=:status AND (DATE(NOW()) BETWEEN start_date AND end_date OR end_date IS NULL)';
            $model = TblWp::findBySql($sql, [':icno' => $icno, ':status' => 'APPROVED'])->one();
            $val = $model->wp_id;
            //            var_dump($model);die;
        }

        if ($display) {
            $val = $model->wp->jenis_wp;
        }

        //        var_dump($val);die;
        return $val;
    }

    public function getUnitname()
    {
        return $this->hasOne(RefUnit::className(), ['id' => 'unit_id']);
    }

    public function getSyif()
    {
        return $this->hasOne(RefShifts::className(), ['id' => 'shift_id']);
    }

    public function getPos()
    {
        return $this->hasOne(RefPosKawalan::className(), ['id' => 'pos_kawalan_id']);
    }
    public static function viewPos($icno, $tarikh){
        $val = false;

        $model = TblShiftKeselamatan::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
        $tukarpos = PatrolExchangepos::findOne(['icno' =>$icno,'tarikh' =>$tarikh]);
        if ($model) {
            if($tukarpos){
                $pos = RefPosKawalan::findOne(['id' => $tukarpos->pos_baru]);

                $val = $model->pos->pos_kawalan .'('. $pos->pos_kawalan .')';

            }else{
                $val = $model->pos->pos_kawalan;

            }
        }
        return $val;

    }
    public static function last_wp($icno, $display = null)
    {

        $val = '';
        
        $today = date('Y-m-d');
        $date_before = date('Y-m-d', strtotime($today . ' -1 day'));

        $staff = TblStaffKeselamatan::find()->where(['staff_icno' => $icno])->one();
        //        var_dump($staff);die;
        //check dlu klu ada dlm staf list utk shift
        if ($staff) {
            $shift = TblShiftKeselamatan::find()->where(['icno' => $icno, 'tarikh' => $date_before])->one();
            //            var_dump($shift);die;
            if (!$shift) {
                $val = null;
            } else {
                $val = $shift->shift_id;
            }
            //  $val = $shift->shift_id;
            //klu tiada pakai yang wbb biasa sja
        } else {
            $sql = 'SELECT * FROM attendance.tbl_wp WHERE icno=:icno AND status=:status AND (DATE(NOW()) BETWEEN start_date AND end_date OR end_date IS NULL)';
            $model = TblWp::findBySql($sql, [':icno' => $icno, ':status' => 'APPROVED'])->one();
            $val = $model->wp_id;
            //            var_dump($model);die;
        }

        if ($display) {
            $val = $model->wp->jenis_wp;
        }

        //        var_dump($val);die;
        return $val;
    }
}
