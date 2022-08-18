<?php

namespace app\models\kehadiran;

use Yii;

/**
 * This is the model class for table "tbl_years".
 *
 * @property int $id
 * @property string $year
 * @property int $status
 */
class TblYears extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendance.tbl_years';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['year'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'year' => 'Year',
            'status' => 'Status',
        ];
    }
}
