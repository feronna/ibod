<?php

namespace app\models\Pergigian;

use Yii;

/**
 * This is the model class for table "Pergigian.tbl_years".
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
        return 'hrm.gigi_tbl_years';
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
