<?php

namespace app\models\kehadiran;

use Yii;

/**
 * This is the model class for table "tbl_aksesselfhealth".
 *
 * @property int $id
 * @property string $icno
 * @property int $role
 */
class TblAksesselfhealth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendance.tbl_aksesselfhealth';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role'], 'integer'],
            [['icno'], 'string', 'max' => 14],
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
            'role' => 'Role',
        ];
    }
}
