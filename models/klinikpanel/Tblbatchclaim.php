<?php

namespace app\models\klinikpanel;


use Yii;

/**
 * This is the model class for table "myhealth.tblbatchclaim".
 *
 * @property int $batch_id
 * @property string $batch_date_issued
 * @property string $total_batch_claim
 * @property int $batch_status_id
 * @property int $batch_process_id
 * @property string $process_created
 * @property int $batch_klinik_id
 * @property string $total_batch_claim_paid
 */
class Tblbatchclaim extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    
    public static function tableName()
    {
        return 'hrm.myhealth_tblbatchclaim';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['batch_date_issued', 'process_created','isMedcare','check_by','remarks','status_check'], 'safe'],
            [['total_batch_claim', 'total_batch_claim_paid'], 'number'],
            [['batch_status_id', 'batch_process_id', 'batch_klinik_id'], 'integer'],
  
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'batch_id' => 'Batch ID',
            'batch_date_issued' => 'Batch Date Issued',
            'total_batch_claim' => 'Total Batch Claim',
            'batch_status_id' => 'Batch Status ID',
            'batch_process_id' => 'Batch Process ID',
            'process_created' => 'Process Created',
            'batch_klinik_id' => 'Batch Klinik ID',
            'total_batch_claim_paid' => 'Total Batch Claim Paid',
        ];
    }
    
    public function getKlinik() {
        return $this->hasOne(RefKlinikpanel::className(), ['klinik_id' => 'batch_klinik_id']);
    }

    public static function totalPendingSemak($icno)
    {
        $count = self::find()
            ->where(['check_by' => $icno])
            ->andWhere(['status_check' => 0])
            ->asArray()
            ->count('batch_id');

        return $count;
    }

    public function getStatus()
    {
        if ($this->status_check == 0) {
            return '<span class="label label-primary">BARU</span>';
        }
        if ($this->status_check == 1) {
            return '<span class="label label-success">SELESAI SEMAKAN</span>';
        }
        if ($this->status_check == 2) {
            return '<span class="label label-success">PERLU PEMBETULAN</span>';
        }
    }

    public function getDisplayId()
    {
        return '<span class="label label-info">'.$this->batch_id.'</span>';
    }

}