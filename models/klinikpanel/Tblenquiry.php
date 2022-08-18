<?php

namespace app\models\klinikpanel;

use Yii;

/**
 * This is the model class for table "hrm.myhealth_tblenquiry".
 *
 * @property int $id
 * @property string $enquiry
 * @property int $status 0= Entry, 1=Completed
 * @property string $remark
 * @property string $entry_dt
 * @property int $entry_by
 * @property string $remark_dt
 * @property int $remark_by
 */
class Tblenquiry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.myhealth_tblenquiry';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['enquiry', 'remark'], 'string'],
            [['status', 'entry_by', 'remark_by'], 'integer'],
            [['entry_dt', 'remark_dt'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'enquiry' => 'Enquiry',
            'status' => 'Status',
            'remark' => 'Remark',
            'entry_dt' => 'Entry Dt',
            'entry_by' => 'Entry By',
            'remark_dt' => 'Remark Dt',
            'remark_by' => 'Remark By',
        ];
    }
    
    public function getStatusK()
    {
        if ($this->status == 0) {
            return '<span class="label label-warning">BARU</span>';
        }   
        if ($this->status == 1) {
            return '<span class="label label-success">SELESAI</span>';
        }
        if ($this->status == 2) {
            return '<span class="label label-primary">DALAM TINDAKAN SEMAKAN</span>';
        }
    }
    
    public function getKlinik()
    {
        return $this->hasOne(RefKlinikpanel::className(), ['klinik_id' => 'entry_by']);
    }
            
}
