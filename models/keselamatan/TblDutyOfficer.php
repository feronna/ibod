<?php

namespace app\models\keselamatan;

use Yii;

/**
 * This is the model class for table "keselamatan.tbl_duty_officer".
 *
 * @property int $id
 * @property string $icno
 * @property string $user_type DO,PM,Penyelia
 * @property string $isActive
 */
class TblDutyOfficer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.tbl_duty_officer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno'], 'string', 'max' => 20],
            [['user_type'], 'string', 'max' => 15],
            [['isActive'], 'string', 'max' => 10],
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
            'user_type' => 'User Type',
            'isActive' => 'Is Active',
        ];
    }
}
