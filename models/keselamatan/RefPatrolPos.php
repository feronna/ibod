<?php

namespace app\models\keselamatan;

use Yii;

/**
 * This is the model class for table "keselamatan.ref_patrol_pos".
 *
 * @property int $id
 * @property string $jenis_shifts
 * @property string $details
 * @property string $start_time
 * @property string $end_time
 * @property string $start_date
 * @property string $end_date
 * @property string $entry_by
 * @property string $update_by
 * @property string $update_dt
 * @property int $active
 * @property int $campus_id
 */
class RefPatrolPos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.ref_patrol_pos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_time', 'end_time', 'start_date', 'end_date'], 'safe'],
            [['active', 'campus_id'], 'integer'],
            [['jenis_shifts'], 'string', 'max' => 100],
            [['details'], 'string', 'max' => 255],
            [['entry_by', 'update_by', 'update_dt'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenis_shifts' => 'Jenis Shifts',
            'details' => 'Details',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'entry_by' => 'Entry By',
            'update_by' => 'Update By',
            'update_dt' => 'Update Dt',
            'active' => 'Active',
            'campus_id' => 'Campus ID',
        ];
    }

    public function getStatus()
    {
        if ($this->active == '1') {
            return '<span class="label label-success">Aktif</span>';
        } else {
            return '<span class="label label-warning">Tidak Aktif</span>';
        }
    }
}
