<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "dbo.vw_LNPT_Clinical".
 *
 * @property string $Activity
 * @property string $Code
 * @property string $StartDate
 * @property string $EndDate
 * @property string $StartTime
 * @property string $EndTime
 * @property string $CreateDate
 * @property string $CreateBy
 * @property string $ApproveStatus
 */
class TblLnptClinical extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dbo.vw_LNPT_Clinical';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db10');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['StartDate', 'EndDate', 'CreateDate'], 'safe'],
            [['Activity'], 'string', 'max' => 100],
            [['Code'], 'string', 'max' => 50],
            [['StartTime', 'EndTime'], 'string', 'max' => 5],
            [['CreateBy'], 'string', 'max' => 20],
            [['ApproveStatus'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Activity' => 'Activity',
            'Code' => 'Code',
            'StartDate' => 'Start Date',
            'EndDate' => 'End Date',
            'StartTime' => 'Start Time',
            'EndTime' => 'End Time',
            'CreateDate' => 'Create Date',
            'CreateBy' => 'Create By',
            'ApproveStatus' => 'Approve Status',
        ];
    }
}
