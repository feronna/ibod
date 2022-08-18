<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.ref_socso_type".
 *
 * @property string $ST_CODE
 * @property string $ST_CMPY_CODE
 * @property string $ST_DESC
 * @property string $ST_DEFAULT
 * @property string $ST_ENTER_BY
 * @property string $ST_ENTER_DATE
 * @property string $ST_UPDATE_BY
 * @property string $ST_UPDATE_DATE
 * @property string $ST_STATUS
 */
class RefSocsoType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.ref_socso_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ST_CODE', 'ST_CMPY_CODE'], 'required'],
            [['ST_CODE', 'ST_ENTER_BY', 'ST_ENTER_DATE', 'ST_UPDATE_BY', 'ST_UPDATE_DATE', 'ST_STATUS'], 'string', 'max' => 30],
            [['ST_CMPY_CODE'], 'string', 'max' => 10],
            [['ST_DESC'], 'string', 'max' => 100],
            [['ST_DEFAULT'], 'string', 'max' => 1],
            [['ST_CODE', 'ST_CMPY_CODE'], 'unique', 'targetAttribute' => ['ST_CODE', 'ST_CMPY_CODE']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ST_CODE' => 'St Code',
            'ST_CMPY_CODE' => 'St Cmpy Code',
            'ST_DESC' => 'St Desc',
            'ST_DEFAULT' => 'St Default',
            'ST_ENTER_BY' => 'St Enter By',
            'ST_ENTER_DATE' => 'St Enter Date',
            'ST_UPDATE_BY' => 'St Update By',
            'ST_UPDATE_DATE' => 'St Update Date',
            'ST_STATUS' => 'St Status',
        ];
    }
}
