<?php

namespace app\models\cuti;

use Yii;

/**
 * This is the model class for table "hrm.cuti_tbl_research".
 *
 * @property int $id
 * @property int $cuti_record_id
 * @property string $title
 * @property string $summary
 * @property string $geran_id FK from table smppi
 * @property string $verify_by KJ
 * @property string $verify_remark
 * @property string $verify_status
 * @property string $verify_dt
 * @property string $nc_by if leave is not in Malaysia
 * @property string $nc_remark
 * @property string $nc_dt
 * @property string $nc_status
 * @property string $bsm_by
 * @property string $bsm_remark
 * @property string $bsm_dt
 * @property string $bsm_status
 */
class TblResearch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cuti_tbl_research';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cuti_record_id'], 'integer'],
            [['title', 'summary', 'verify_remark', 'nc_remark', 'bsm_remark','kpi','justifikasi','research_id'], 'string'],
            [['verify_dt', 'nc_dt', 'bsm_dt'], 'safe'],
            [['geran_id'], 'string', 'max' => 20],
            [['verify_by', 'verify_status', 'nc_by', 'nc_status', 'bsm_by', 'bsm_status','icno'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cuti_record_id' => 'Cuti Record ID',
            'title' => 'Title',
            'summary' => 'Summary',
            'geran_id' => 'Geran ID',
            'verify_by' => 'Verify By',
            'verify_remark' => 'Verify Remark',
            'verify_status' => 'Verify Status',
            'verify_dt' => 'Verify Dt',
            'nc_by' => 'Nc By',
            'nc_remark' => 'Nc Remark',
            'nc_dt' => 'Nc Dt',
            'nc_status' => 'Nc Status',
            'bsm_by' => 'Bsm By',
            'bsm_remark' => 'Bsm Remark',
            'bsm_dt' => 'Bsm Dt',
            'bsm_status' => 'Bsm Status',
        ];
    }
}
