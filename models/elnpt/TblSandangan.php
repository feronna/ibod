<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_vw_tblrscosandangan".
 *
 * @property string $icno
 * @property string $ApmtTypeCd
 * @property string $latest_start_date
 */
class TblSandangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_vw_tblrscosandangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno', 'ApmtTypeCd'], 'required'],
            [['latest_start_date'], 'safe'],
            [['icno'], 'string', 'max' => 12],
            [['ApmtTypeCd'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'icno' => 'Icno',
            'ApmtTypeCd' => 'Apmt Type Cd',
            'latest_start_date' => 'Latest Start Date',
        ];
    }
}
