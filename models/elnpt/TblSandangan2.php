<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_vw_tblrscosandangan_02".
 *
 * @property string $icno
 * @property string $ApmtTypeCd
 * @property string $start_date
 */
class TblSandangan2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_vw_tblrscosandangan_02';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['icno', 'ApmtTypeCd'], 'required'],
            [['start_date'], 'safe'],
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
            'start_date' => 'Start Date',
        ];
    }
}
