<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "hrm.lppums_v_markah_keseluruhan".
 *
 * @property string $ICNO
 * @property string $TAHUN
 * @property double $MARKAH
 */
class TblMarkahKeseluruhanView extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_v_markah_keseluruhan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TAHUN'], 'safe'],
            [['MARKAH'], 'number'],
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
