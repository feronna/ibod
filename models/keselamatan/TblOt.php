<?php

namespace app\models\keselamatan;

use app\models\keselamatan\RefShifts;
use app\models\hronline\Tblprcobiodata;
use app\models\kehadiran\TblWp;
use Yii;

/**
 * This is the model class for table "keselamatan.tbl_ot".
 *
 * @property int $id
 * @property string $icno
 * @property string $tarikh
 * @property string $year
 * @property string $month
 * @property int $shift_id
 */
class TblOt extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.tbl_ot';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarikh', 'year'], 'safe'],
            [['campus_id', 'shift_id', 'unit_id', 'pos_kawalan_id'], 'integer'],
            [['icno', 'month'], 'string', 'max' => 20],
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

    public function getWp()
    {
        return $this->hasOne(RefShifts::className(), ['id' => 'shift_id']);
    }

    public function getUnitname()
    {
        return $this->hasOne(RefUnit::className(), ['id' => 'unit_id']);
    }

    public function getPos()
    {
        return $this->hasOne(RefPosKawalan::className(), ['id' => 'pos_kawalan_id']);
    }

    public function viewOt($icno, $tarikh)
    {
        //        var_dump($icno, $tarikh,$month,$unit,$pos);die;
        $val = false;

        $model = TblOt::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
        //        $model = TblOt::find()
        //                ->where(['icno' => $icno, 'tarikh' => $tarikh,'month' => $month,'pos_kawalan_id'=>$pos,'unit_id'=>$unit])
        //                ->one();
        //        \yii\helpers\VarDumper::dump($model->tarikh);die;

        if ($model) {
            $val = $model->wp->jenis_shifts;
        }

        return $val;
    }

    public function getStaff()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public function countOt($id, $month, $year)
    {

        $val = (new \yii\db\Query())
            ->from('keselamatan.tbl_ot')
            ->where(['icno' => $id])
            ->andWhere(['month' => $month])
            ->andWhere(['year' => $year])
            ->andWhere(['!=', 'shift_id', '1'])
            ->count();
        //            var_dump($val);die;
        return $val;
    }

    public function countJumlahOt($id, $month, $year)
    {

        $val1 = (new \yii\db\Query())
            ->from('keselamatan.tbl_ot')
            ->where(['icno' => $id])
            ->andWhere(['month' => $month])
            ->andWhere(['year' => $year])
            ->andWhere(['!=', 'shift_id', '1'])
            ->count();
        $val = $val1 * 8;
        //  var_dump($val);die;
        return $val;
    }

    public function countJumlah($id, $month, $year, $units, $pos)
    {
        //        var_dump($month,$units);die;
        $val1 = (new \yii\db\Query())
            ->from('keselamatan.tbl_ot')
            //                    ->where(['icno' => $id])
            ->andWhere(['month' => $month])
            ->andWhere(['year' => $year])
            ->andWhere(['unit_id' => $units])
            ->andWhere(['pos_kawalan_id' => $pos])
            ->andWhere(['!=', 'shift_id', '1'])
            ->count();

        //              $val = $val1 + $val1;
        //  var_dump($val);die;
        return $val1;
    }

    public function countJumlahJam($id, $month, $year, $units, $pos)
    {
        //        var_dump($month);die;
        $val1 = (new \yii\db\Query())
            ->from('keselamatan.tbl_ot')
            //                    ->where(['icno' => $id])
            ->andWhere(['month' => $month])
            ->andWhere(['year' => $year])
            ->andWhere(['unit_id' => $units])
            ->andWhere(['pos_kawalan_id' => $pos])
            ->andWhere(['!=', 'shift_id', '1'])
            ->count();

        $val = $val1 * 8;
        //  $val = $val2
        //  var_dump($val);die;
        return $val;
    }

    public static function curr_ot($icno, $display = null)
    {

        $val = '';
        $today = date('Y-m-d');
        $date_before = date('Y-m-d', strtotime($today . ' -1 day'));

        $staff = TblStaffKeselamatan::find()->where(['staff_icno' => $icno])->one();
        //            var_dump($staff);die;
        //check dlu klu ada dlm staf list utk shift
        if ($staff) {
            $shift = TblOt::find()->where(['icno' => $icno, 'tarikh' => $today])->one();
            //            var_dump($shift);die;
            if (!$shift) {
                $val = null;
            } else {
                $val = $shift->shift_id;
                //            var_dump($val);die;
            }
            //  $val = $shift->shift_id;
            //klu tiada pakai yang wbb biasa sja
        } else {
            $sql = 'SELECT * FROM attendance.tbl_wp WHERE icno=:icno AND status=:status AND (DATE(NOW()) BETWEEN start_date AND end_date OR end_date IS NULL)';
            $model = TblWp::findBySql($sql, [':icno' => $icno, ':status' => 'APPROVED'])->one();
            if ($model) {
                $val = $model->wp_id;
            }else{
                $val = 1;
            }
        }

        if ($display) {
            $val = $model->wp->jenis_wp;
        }

        return $val;
    }
    public static function lastot($icno, $display = null)
    {

        $val = '';
        $today = date('Y-m-d');
        $date_before = date('Y-m-d', strtotime($today . ' -1 day'));

        $staff = TblStaffKeselamatan::find()->where(['staff_icno' => $icno])->one();
        //            var_dump($staff);die;
        //check dlu klu ada dlm staf list utk shift
        if ($staff) {
            $shift = TblOt::find()->where(['icno' => $icno, 'tarikh' => $date_before])->one();
            //            var_dump($shift);die;
            if (!$shift) {
                $val = null;
            } else {
                $val = $shift->shift_id;
                //            var_dump($val);die;
            }
            //  $val = $shift->shift_id;
            //klu tiada pakai yang wbb biasa sja
        } else {
            $sql = 'SELECT * FROM attendance.tbl_wp WHERE icno=:icno AND status=:status AND (DATE(NOW()) BETWEEN start_date AND end_date OR end_date IS NULL)';
            $model = TblWp::findBySql($sql, [':icno' => $icno, ':status' => 'APPROVED'])->one();
            $val = $model->wp_id;
        }

        if ($display) {
            $val = $model->wp->jenis_wp;
        }

        return $val;
    }
    public static function lastotcheck($icno, $date_before)
    {

        $val = '';
        // $today = date('Y-m-d');
        // $date_before = date('Y-m-d', strtotime($today . ' -1 day'));

        $staff = TblStaffKeselamatan::find()->where(['staff_icno' => $icno])->one();
        //            var_dump($staff);die;
        //check dlu klu ada dlm staf list utk shift
        if ($staff) {
            $shift = TblOt::find()->where(['icno' => $icno, 'tarikh' => $date_before])->one();
            //            var_dump($shift);die;
            if (!$shift) {
                $val = null;
            } else {
                $val = $shift->shift_id;
                //            var_dump($val);die;
            }
            //  $val = $shift->shift_id;
            //klu tiada pakai yang wbb biasa sja
        } else {
            $sql = 'SELECT * FROM attendance.tbl_wp WHERE icno=:icno AND status=:status AND (DATE(NOW()) BETWEEN start_date AND end_date OR end_date IS NULL)';
            $model = TblWp::findBySql($sql, [':icno' => $icno, ':status' => 'APPROVED'])->one();
            $val = $model->wp_id;
        }

        // if ($display) {
        //     $val = $model->wp->jenis_wp;
        // }

        return $val;
    }

    public function getSyif()
    {
        return $this->hasOne(RefShifts::className(), ['id' => 'shift_id']);
    }
}
