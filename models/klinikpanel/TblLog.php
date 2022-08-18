<?php

namespace app\models\klinikpanel;

use Yii;

/**
 * This is the model class for table "hrm.myhealth_tbl_log".
 *
 * @property int $id
 * @property int $rawatan_id
 * @property string $icno
 * @property string $tindakan
 * @property int $visit_klinik_id
 * @property string $amount
 * @property string $log_dt
 * @property string $log_by
 */
class TblLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myhealth_tbl_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'rawatan_id', 'visit_klinik_id'], 'integer'],
            [['amount'], 'number'],
            [['log_dt','rawatan_dt'], 'safe'],
            [['icno', 'log_by','log_remark'], 'string', 'max' => 255],
            [['tindakan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rawatan_id' => 'Rawatan ID',
            'icno' => 'Icno',
            'tindakan' => 'Tindakan',
            'visit_klinik_id' => 'Visit Klinik ID',
            'amount' => 'Amount',
            'log_dt' => 'Log Dt',
            'log_by' => 'Log By',
        ];
    }
}
