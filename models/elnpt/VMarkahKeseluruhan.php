<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v_markah_keseluruhan".
 *
 * @property string $ICNO
 * @property string $TAHUN
 * @property double $MARKAH
 */
class VMarkahKeseluruhan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v_markah_keseluruhan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TAHUN', 'MARKAH'], 'number'],
            [['ICNO'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
            'TAHUN' => 'Tahun',
            'MARKAH' => 'Markah',
        ];
    }
}
