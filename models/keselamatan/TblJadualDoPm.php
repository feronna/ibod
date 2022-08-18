<?php

namespace app\models\keselamatan;
use app\models\hronline\Tblprcobiodata;
use app\models\keselamatan\RefShifts;
use Yii;

/**
 * This is the model class for table "keselamatan.tbl_jadual_do_pm".
 *
 * @property int $id
 * @property string $icno
 * @property string $tarikh
 * @property string $year
 * @property string $month
 * @property int $shift_id
 * @property int $unit_id
 * @property int $pos_kawalan_id
 * @property int $campus_id
 */
class TblJadualDoPm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.tbl_jadual_do_pm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarikh', 'year'], 'safe'],
            [['shift_id', 'unit_id', 'pos_kawalan_id', 'campus_id'], 'integer'],
            [['icno'], 'string', 'max' => 12],
            [['month'], 'string', 'max' => 2],
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
            'pos_kawalan_id' => 'Pos Kawalan ID',
            'campus_id' => 'Campus ID',
        ];
    }
    public function getShiftRollcall()
    {
        return $this->hasOne(RefShifts::className(), ['jenis_shifts' => 'shift_id']);
    }

    public function getStaff()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public function getWp()
    {
        return $this->hasOne(RefShifts::className(), ['id' => 'shift_id']);
    }

    public static function viewShift($icno, $tarikh)
    {
        // var_dump($icno, $tarikh);
        $val = false;

        $model = TblJadualDoPm::findOne(['icno' => $icno, 'tarikh' => $tarikh]);
// var_dump($model->tarikh);die;
        if ($model) {
            $val = $model->wp->jenis_shifts;
        }
        return $val;
    }

}
