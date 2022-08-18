<?php

namespace app\models\hronline_gaji;

use Yii;

/**
 * This is the model class for table "hronline_gaji.roc_reason".
 *
 * @property string $RR_REASON_CODE
 * @property string $RR_CMPY_CODE
 * @property string $RR_REASON_DESC
 * @property string $RR_STATUS
 * @property string $RR_ENTER_BY
 * @property string $RR_ENTER_DATE
 * @property string $RR_UPDATE_BY
 * @property string $RR_UPDATE_DATE
 * @property string $rr_report_title
 * @property string $rr_report_header
 * @property string $rr_remarks_template
 */
class RocReason extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'hrm.gaji_roc_reason';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['RR_REASON_CODE', 'RR_CMPY_CODE'], 'required'],
            [['RR_ENTER_DATE', 'RR_UPDATE_DATE'], 'safe'],
            [['rr_report_header', 'rr_remarks_template'], 'string'],
            [['RR_REASON_CODE', 'RR_ENTER_BY', 'RR_UPDATE_BY'], 'string', 'max' => 30],
            [['RR_CMPY_CODE', 'RR_STATUS'], 'string', 'max' => 10],
            [['RR_REASON_DESC', 'rr_report_title'], 'string', 'max' => 100],
            [['RR_REASON_CODE'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'RR_REASON_CODE' => 'Rr Reason Code',
            'RR_CMPY_CODE' => 'Rr Cmpy Code',
            'RR_REASON_DESC' => 'Rr Reason Desc',
            'RR_STATUS' => 'Rr Status',
            'RR_ENTER_BY' => 'Rr Enter By',
            'RR_ENTER_DATE' => 'Rr Enter Date',
            'RR_UPDATE_BY' => 'Rr Update By',
            'RR_UPDATE_DATE' => 'Rr Update Date',
            'rr_report_title' => 'Rr Report Title',
            'rr_report_header' => 'Rr Report Header',
            'rr_remarks_template' => 'Rr Remarks Template',
        ];
    }
}
