<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.ref_epf_type".
 *
 * @property string $ET_CODE
 * @property string $ET_CMPY_CODE
 * @property string $ET_DESC
 * @property string $ET_DEFAULT
 * @property string $ET_EMPLOYEE_PCT
 * @property string $ET_EMPLOYER_PCT
 * @property string $ET_ENTER_BY
 * @property string $ET_ENTER_DATE
 * @property string $ET_UPDATE_BY
 * @property string $ET_UPDATE_DATE
 * @property string $ET_STATUS
 * @property string $et_employer_rm
 */
class RefEpfType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.ref_epf_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ET_CODE', 'ET_CMPY_CODE'], 'required'],
            [['ET_EMPLOYEE_PCT', 'ET_EMPLOYER_PCT', 'et_employer_rm'], 'number'],
            [['ET_CODE'], 'string', 'max' => 50],
            [['ET_CMPY_CODE', 'ET_ENTER_DATE', 'ET_STATUS'], 'string', 'max' => 10],
            [['ET_DESC'], 'string', 'max' => 100],
            [['ET_DEFAULT'], 'string', 'max' => 1],
            [['ET_ENTER_BY', 'ET_UPDATE_BY'], 'string', 'max' => 30],
            [['ET_UPDATE_DATE'], 'string', 'max' => 20],
            [['ET_CODE', 'ET_CMPY_CODE'], 'unique', 'targetAttribute' => ['ET_CODE', 'ET_CMPY_CODE']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ET_CODE' => 'Et Code',
            'ET_CMPY_CODE' => 'Et Cmpy Code',
            'ET_DESC' => 'Et Desc',
            'ET_DEFAULT' => 'Et Default',
            'ET_EMPLOYEE_PCT' => 'Et Employee Pct',
            'ET_EMPLOYER_PCT' => 'Et Employer Pct',
            'ET_ENTER_BY' => 'Et Enter By',
            'ET_ENTER_DATE' => 'Et Enter Date',
            'ET_UPDATE_BY' => 'Et Update By',
            'ET_UPDATE_DATE' => 'Et Update Date',
            'ET_STATUS' => 'Et Status',
            'et_employer_rm' => 'Et Employer Rm',
        ];
    }
}
