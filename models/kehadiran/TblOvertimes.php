<?php

namespace app\models\kehadiran;

use Yii;

/**
 * This is the model class for table "tbl_overtimes".
 *
 * @property string $id
 * @property string $att_id
 * @property string $staff_id
 * @property string $staff_nric
 * @property string $shift_hr_in
 * @property string $shift_hr_out
 * @property string $act_clock_in
 * @property string $act_clock_out
 * @property string $ot_type
 */
class TblOvertimes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendance.tbl_overtimes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'att_id', 'staff_id', 'staff_nric', 'act_clock_in', 'act_clock_out', 'ot_type'], 'required'],
            [['id'], 'integer'],
            [['shift_hr_in', 'shift_hr_out', 'act_clock_in', 'act_clock_out'], 'safe'],
            [['att_id'], 'string', 'max' => 50],
            [['staff_id'], 'string', 'max' => 15],
            [['staff_nric'], 'string', 'max' => 12],
            [['ot_type'], 'string', 'max' => 2],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'att_id' => 'Att ID',
            'staff_id' => 'Staff ID',
            'staff_nric' => 'Staff Nric',
            'shift_hr_in' => 'Shift Hr In',
            'shift_hr_out' => 'Shift Hr Out',
            'act_clock_in' => 'Act Clock In',
            'act_clock_out' => 'Act Clock Out',
            'ot_type' => 'Ot Type',
        ];
    }
}
