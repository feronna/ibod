<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "hrm.lppums_v_average_mark".
 *
 * @property string $ICNO
 * @property string $YEAR
 * @property int $position_id
 * @property string $ppp_icno
 * @property string $ppk_icno
 * @property double $average_mark
 */
class TblAvgMark extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_v_average_mark';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['YEAR'], 'safe'],
            [['position_id'], 'integer'],
            [['average_mark'], 'number'],
            [['ICNO', 'ppp_icno', 'ppk_icno'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
            'YEAR' => 'Year',
            'position_id' => 'Position ID',
            'ppp_icno' => 'Ppp Icno',
            'ppk_icno' => 'Ppk Icno',
            'average_mark' => 'Average Mark',
        ];
    }
}
