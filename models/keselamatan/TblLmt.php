<?php

namespace app\models\keselamatan;

use app\models\hronline\Tblprcobiodata;
use app\models\keselamatan\RefLmt;
use app\models\keselamatan\RefPosLmt;
use Yii;

/**
 * This is the model class for table "keselamatan.tbl_lmt".
 *
 * @property int $id
 * @property string $icno
 * @property string $tarikh
 * @property string $year
 * @property string $month
 * @property string $lmt_id
 */
class TblLmt extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.tbl_lmt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['tarikh', 'year', 'do_add_dt'], 'safe'],
            [['icno', 'do_add_icno'], 'string', 'max' => 20],
            [['campus_id','lmt_id', 'unit_id', 'pos_kawalan_id'], 'integer'],
            [['month'], 'string', 'max' => 10],
//            [['pos_kawalan'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'tarikh' => 'Tarikh',
            'year' => 'Year',
            'month' => 'Month',
            'lmt_id' => 'Lmt ID',
        ];
    }

    public function getPos() {
        return $this->hasOne(RefPosLmt::className(), ['id' => 'pos_kawalan_id']);
    }

    public function getStaff() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public function getSyif() {
        return $this->hasOne(RefLmt::className(), ['id' => 'lmt_id']);
    }

    public function getUnitname() {
        return $this->hasOne(RefUnit::className(), ['id' => 'unit_id']);
    }

    public function getWp() {

        return $this->hasOne(RefLmt::className(), ['id' => 'lmt_id']);
    }

    public function viewLmt($icno, $tarikh, $month, $units, $pos) {
//        var_dump($icno, $tarikh,$month,$units,$pos);die;
        $val = false;

        $model = TblLmt::find()
                ->where(['icno' => $icno, 'tarikh' => $tarikh, 'month' => $month, 'pos_kawalan_id' => $pos, 'unit_id' => $units])
                ->one();
//        var_dump($model->do_add_icno);die;
        if ($model) {
            $val = $model->wp->jenis_shifts;
        }
//        var_dump($val);die;
        return $val;
    }
    public static function last_lmt($icno) {

        $val = '';
        $today = date('Y-m-d');
        $date_before = date('Y-m-d', strtotime($today . ' -1 day'));

        $staff = TblLmtKeselamatan::find()->where(['staff_icno' => $icno])->one();
//            var_dump($staff);die;
        //check dlu klu ada dlm staf list utk shift
        if ($staff) {
            $shift = TblLmt::find()->where(['icno' => $icno, 'tarikh' => $date_before])->one();
//            var_dump($shift);die;
            if (!$shift) {
                $val = null;
            } else {
                $val = $shift->lmt_id;
                //            var_dump($val);die;
            }
            //  $val = $shift->shift_id;
            //klu tiada pakai yang wbb biasa sja
        }
       else {
          
        }

        return $val;
    }
    public static function curr_lmt($icno, $display = null) {

        $val = '';
        $today = date('Y-m-d');

        $staff = TblLmtKeselamatan::find()->where(['staff_icno' => $icno])->one();

        //check dlu klu ada dlm staf list utk shift LMT
        if ($staff) {
            $shift = TblLmt::find()->where(['icno' => $icno, 'tarikh' => $today])->one();

            if (!$shift) {
                $val = null;
            } else {
                $val = $shift->lmt_id;
            }
            //  $val = $shift->shift_id;
            //klu tiada pakai yang wbb biasa sja
        }
//        else {
//            $sql = 'SELECT * FROM attendance.tbl_wp WHERE icno=:icno AND status=:status AND (DATE(NOW()) BETWEEN start_date AND end_date OR end_date IS NULL)';
//            $model = TblWp::findBySql($sql, [':icno' => $icno, ':status' => 'APPROVED'])->one();
//            $val = $model->wp_id;
//        }

        if ($display) {
            $val = $model->wp->jenis_wp;
        }

        return $val;
    }

}
