<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.ref_tax_formula_type".
 *
 * @property string $TFT_FORMULA_TYPE_CODE
 * @property string $TFT_CMPY_CODE
 * @property string $TFT_DESC
 * @property string $TFT_DEFAULT
 * @property string $TFT_STATUS
 * @property string $TFT_ENTER_BY
 * @property string $TFT_ENTER_DATE
 * @property string $TFT_UPDATE_BY
 * @property string $TFT_UPDATE_DATE
 */
class RefTaxFormulaType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.ref_tax_formula_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TFT_FORMULA_TYPE_CODE', 'TFT_CMPY_CODE'], 'required'],
            [['TFT_FORMULA_TYPE_CODE', 'TFT_CMPY_CODE', 'TFT_STATUS'], 'string', 'max' => 10],
            [['TFT_DESC'], 'string', 'max' => 200],
            [['TFT_DEFAULT'], 'string', 'max' => 1],
            [['TFT_ENTER_BY', 'TFT_ENTER_DATE', 'TFT_UPDATE_BY', 'TFT_UPDATE_DATE'], 'string', 'max' => 30],
            [['TFT_FORMULA_TYPE_CODE', 'TFT_CMPY_CODE'], 'unique', 'targetAttribute' => ['TFT_FORMULA_TYPE_CODE', 'TFT_CMPY_CODE']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'TFT_FORMULA_TYPE_CODE' => 'Tft Formula Type Code',
            'TFT_CMPY_CODE' => 'Tft Cmpy Code',
            'TFT_DESC' => 'Tft Desc',
            'TFT_DEFAULT' => 'Tft Default',
            'TFT_STATUS' => 'Tft Status',
            'TFT_ENTER_BY' => 'Tft Enter By',
            'TFT_ENTER_DATE' => 'Tft Enter Date',
            'TFT_UPDATE_BY' => 'Tft Update By',
            'TFT_UPDATE_DATE' => 'Tft Update Date',
        ];
    }
}
