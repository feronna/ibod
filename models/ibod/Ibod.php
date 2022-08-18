<?php

namespace app\models\ibod;

use Yii;

/**
 * This is the model class for table "hrm.lpu_tbl_ibod".
 *
 * @property int $id
 * @property string $icno
 * @property string $lpu_name
 * @property string $lpu_position
 * @property string $lpu_start_date
 * @property string $lpu_end_date
 * @property string $lpu_entry_date
 * @property string $updated_date
 * @property string $updated_by
 * @property int $isActive
 * @property string $attachment
 * @property string $catatan
 */
class Ibod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lpu_tbl_ibod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpu_start_date', 'lpu_end_date', 'lpu_entry_date', 'updated_date'], 'safe'],
            [['isActive'], 'integer'],
            [['attachment', 'catatan'], 'string'],
            [['icno', 'updated_by'], 'string', 'max' => 12],
            [['lpu_name', 'lpu_position'], 'string', 'max' => 255],
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
            'lpu_name' => 'Lpu Name',
            'lpu_position' => 'Lpu Position',
            'lpu_start_date' => 'Lpu Start Date',
            'lpu_end_date' => 'Lpu End Date',
            'lpu_entry_date' => 'Lpu Entry Date',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'isActive' => 'Is Active',
            'attachment' => 'Attachment',
            'catatan' => 'Catatan',
        ];
    }
}
