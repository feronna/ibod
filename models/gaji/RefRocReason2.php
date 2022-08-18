<?php

namespace app\models\gaji;

use Yii;

/**
 * This is the model class for table "hrm.gaji_lpg".
 *
 * @property string $lpgCd
 * @property string $lpgModule
 * @property string $lpgType
 * @property string $lpgCreateType
 * @property string $lpgLayout
 * @property string $lpgTitle
 * @property string $lpgNm
 * @property string $lpgTopDesc
 * @property string $lpgBottomDesc
 */
class RefRocReason2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.gaji_lpg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpgModule'], 'string', 'max' => 20],
            [['lpgType'], 'string', 'max' => 4],
            [['lpgCreateType'], 'string', 'max' => 12],
            [['lpgLayout'], 'string', 'max' => 1],
            [['lpgTitle'], 'string', 'max' => 60],
            [['lpgNm'], 'string', 'max' => 100],
            [['lpgTopDesc'], 'string', 'max' => 120],
            [['lpgBottomDesc'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lpgCd' => 'Lpg Cd',
            'lpgModule' => 'Lpg Module',
            'lpgType' => 'Lpg Type',
            'lpgCreateType' => 'Lpg Create Type',
            'lpgLayout' => 'Lpg Layout',
            'lpgTitle' => 'Lpg Title',
            'lpgNm' => 'Lpg Nm',
            'lpgTopDesc' => 'Lpg Top Desc',
            'lpgBottomDesc' => 'Lpg Bottom Desc',
        ];
    }
}
