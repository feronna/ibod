<?php

namespace app\models\patrol;

use Yii;

/**
 * This is the model class for table "keselamatan.patrol_tbl_report".
 *
 * @property int $id
 * @property string $icno
 * @property int $pos_id
 * @property int $shift_id
 * @property string $do_onduty
 * @property string $date
 * @property string $report
 * @property string $report_dt
 * @property string $approver_remark
 * @property string $approve_dt
 * @property string $status
 * @property int $campus_id
 * @property string $remark
 * @property int $count indicating patrolling round, except for count = 5 (indicating do report)
 */
class PatrolTblReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.patrol_tbl_report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pos_id', 'shift_id', 'campus_id', 'count','type'], 'integer'],
            [['date', 'report_dt', 'approve_dt'], 'safe'],
            [['remark'], 'string'],
            [['icno', 'do_onduty'], 'string', 'max' => 12],
            [['report', 'approver_remark'], 'string', 'max' => 250],
            [['status'], 'string', 'max' => 8],
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
            'pos_id' => 'Pos ID',
            'shift_id' => 'Shift ID',
            'do_onduty' => 'Do Onduty',
            'date' => 'Date',
            'report' => 'Report',
            'report_dt' => 'Report Dt',
            'approver_remark' => 'Approver Remark',
            'approve_dt' => 'Approve Dt',
            'status' => 'Status',
            'campus_id' => 'Campus ID',
            'remark' => 'Remark',
            'count' => 'Count',
        ];
    }
    public static function remark($icno, $date, $pos, $shift,$count)
    {
        $val = "";
        $model = self::find()->where(['icno' => $icno])->andWhere(['date' => $date]
        )->andWhere(['pos_id' => $pos])->andWhere(['shift_id' => $shift])->andWhere(['count' => $count])->one();
        if ($model) {
            $val = $model->report;
        }
        return $val;
    }

    public static function getreport($icno, $pos, $shift, $date)
    {
        $val = '';
        $model = self::findOne(['icno' => $icno, 'shift_id' => $shift, 'pos_id' => $pos, 'date' => $date,'count' => 0]);
        if ($model) {
            $val = $model->report . '<br>' . 'Laporan Tamat Bertugas dihantar pada: '. $model->report_dt;
        }
        return $val;
    }
    public static function getreportdo($icno, $pos, $shift, $date)
    {
        $val = '';
        $model = self::findOne(['icno' => $icno, 'shift_id' => $shift, 'pos_id' => $pos, 'date' => $date,'count' => 5]);
        if ($model) {
            $val = $model->report;
        }
        return $val;
    }
}
