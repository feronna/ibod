<?php

namespace app\models\cuti;

use Yii;

/**
 * This is the model class for table "hrm.cuti_log".
 *
 * @property string $ntf_id
 * @property string $ntf_session_id
 * @property string $ntf_tindakan Peraku Dok, Peraku, Lulus, etc
 * @property string $ntf_status
 * @property int $ntf_cr_id
 * @property int $ntf_crp_id cuti_rekod_pinda_id
 * @property int $ntf_crb_id cuti_rekod_batal_id
 * @property string $ntf_datetime
 * @property string $ntf_ip
 * @property string $full_date
 * @property string $start_date
 * @property string $end_date
 */
class CutiLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cuti_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ntf_cr_id', 'ntf_crp_id', 'ntf_crb_id'], 'integer'],
            [['ntf_datetime', 'start_date', 'end_date'], 'safe'],
            [['ntf_session_id'], 'string', 'max' => 12],
            [['ntf_tindakan', 'full_date'], 'string', 'max' => 50],
            [['ntf_status'], 'string', 'max' => 15],
            [['ntf_ip'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ntf_id' => 'Ntf ID',
            'ntf_session_id' => 'Ntf Session ID',
            'ntf_tindakan' => 'Ntf Tindakan',
            'ntf_status' => 'Ntf Status',
            'ntf_cr_id' => 'Ntf Cr ID',
            'ntf_crp_id' => 'Ntf Crp ID',
            'ntf_crb_id' => 'Ntf Crb ID',
            'ntf_datetime' => 'Ntf Datetime',
            'ntf_ip' => 'Ntf Ip',
            'full_date' => 'Full Date',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
        ];
    }
}
