<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "hrd.idp_tbl_years".
 *
 * @property int $id
 * @property string $year
 * @property int $status
 * @property int $admin_status
 */
class TblYears extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_tbl_years';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'admin_status'], 'integer'],
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
            'admin_status' => 'Admin Status',
        ];
    }
}
