<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_vw_tblprawd_apt".
 *
 * @property string $ICNO
 * @property string $AwdCd
 * @property string $last_date_awd
 */
class TblApt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_vw_tblprawd_apt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ICNO'], 'required'],
            [['last_date_awd'], 'safe'],
            [['ICNO'], 'string', 'max' => 12],
            [['AwdCd'], 'string', 'max' => 7],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ICNO' => 'Icno',
            'AwdCd' => 'Awd Cd',
            'last_date_awd' => 'Last Date Awd',
        ];
    }
}
