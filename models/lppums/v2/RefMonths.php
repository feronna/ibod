<?php

namespace app\models\lppums\v2;

use Yii;

/**
 * This is the model class for table "hrm.lppums_v2_ref_months".
 *
 * @property int $month
 * @property string $label
 * @property string $slabel
 */
class RefMonths extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_v2_ref_months';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['label'], 'string', 'max' => 50],
            [['slabel'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'month' => 'Month',
            'label' => 'Label',
            'slabel' => 'Slabel',
        ];
    }
}
