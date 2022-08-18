<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "{{%hrd.idp_tbl_bulan}}".
 *
 * @property int $id
 * @property string $month
 */
class TblMonths extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hrd.idp_tbl_bulan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'month' => 'Month',
        ];
    }

}
