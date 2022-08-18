<?php

namespace app\models\gaji;

use Yii;

/**
 * This is the model class for table "hrm.gaji_temp_prev_lpg".
 *
 * @property int $id
 * @property string $staff_id
 * @property string $kod_saga
 * @property string $amount
 */
class TempPrevLpg extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.gaji_temp_prev_lpg';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    //public static function getDb()
    //{
    //    return Yii::$app->get('db2');
    //}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount'], 'number'],
            [['staff_id', 'kod_saga'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'kod_saga' => 'Kod Saga',
            'amount' => 'Amount',
        ];
    }
}