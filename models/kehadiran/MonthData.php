<?php

namespace app\models\kehadiran;

use Yii;

/**
 * This is the model class for table "monthly_rpt".
 *
 * @property string $nama
 * @property int $dept_id
 * @property int $gred_id
 * @property string $icno
 * @property int $bulan
 * @property int $tahun
 * @property string $late_in
 * @property string $early_out
 * @property double $incomplete
 * @property double $absent
 * @property double $external
 * @property string $approved
 * @property string $rejected
 * @property string $total_day
 */
class MonthData extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'attendance.monthly_rpt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['dept_id', 'gred_id', 'bulan', 'tahun', 'total_day'], 'integer'],
            [['late_in', 'early_out', 'incomplete', 'absent', 'external', 'approved', 'rejected'], 'number'],
            [['nama'], 'string', 'max' => 255],
            [['icno'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'nama' => 'Staff Name',
            'dept_id' => 'Dept ID',
            'gred_id' => 'Gred ID',
            'icno' => 'Icno',
            'bulan' => 'Month',
            'tahun' => 'Tahun',
            'late_in' => 'Late In',
            'early_out' => 'Early Out',
            'incomplete' => 'Incomplete',
            'absent' => 'Absent',
            'external' => 'External',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'total_day' => 'Working Days',
        ];
    }

    public static function total($icno, $fieldName, $year){
        return self::find()->select($fieldName)->where(['icno'=>$icno, 'tahun'=>$year])->count();

    }

    public static function getTotal($provider, $fieldName) {
        $total = 0;

        foreach ($provider as $item) {
            $total += $item[$fieldName];
        }

        return $total;
    }

}
