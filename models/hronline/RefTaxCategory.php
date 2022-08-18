<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.ref_tax_category".
 *
 * @property string $TC_CATEGORY_CODE
 * @property string $TC_CMPY_CODE
 * @property string $TC_CATEGORY_DESC
 * @property string $TC_DEFAULT
 * @property string $TC_ENTER_BY
 * @property string $TC_ENTER_DATE
 * @property string $TC_UPDATE_BY
 * @property string $TC_UPDATE_DATE
 * @property string $TC_STATUS
 */
class RefTaxCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.ref_tax_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TC_CATEGORY_CODE', 'TC_CMPY_CODE'], 'required'],
            [['TC_CATEGORY_CODE', 'TC_CMPY_CODE'], 'string', 'max' => 10],
            [['TC_CATEGORY_DESC'], 'string', 'max' => 100],
            [['TC_DEFAULT'], 'string', 'max' => 1],
            [['TC_ENTER_BY', 'TC_ENTER_DATE', 'TC_UPDATE_BY', 'TC_UPDATE_DATE', 'TC_STATUS'], 'string', 'max' => 30],
            [['TC_CATEGORY_CODE', 'TC_CMPY_CODE'], 'unique', 'targetAttribute' => ['TC_CATEGORY_CODE', 'TC_CMPY_CODE']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'TC_CATEGORY_CODE' => 'Tc Category Code',
            'TC_CMPY_CODE' => 'Tc Cmpy Code',
            'TC_CATEGORY_DESC' => 'Tc Category Desc',
            'TC_DEFAULT' => 'Tc Default',
            'TC_ENTER_BY' => 'Tc Enter By',
            'TC_ENTER_DATE' => 'Tc Enter Date',
            'TC_UPDATE_BY' => 'Tc Update By',
            'TC_UPDATE_DATE' => 'Tc Update Date',
            'TC_STATUS' => 'Tc Status',
        ];
    }
}
