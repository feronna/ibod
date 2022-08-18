<?php

namespace app\models\e_perkhidmatan;

use Yii;
use app\models\hronline\Tblprcobiodata;
class PermitApplication extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%keselamatan.utils_tbl_permit_application}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'user_contact_no', 'company_contact_no', 'application_status', 'payment_status', 'rasmi_status', 'app_type'], 'integer'],
            [['date_start', 'date_end', 'time_start', 'time_end', 'date_applied', 'date_verified', 'date_approved'], 'safe'],
            [['company_name', 'verifier_notes'], 'string'],
            [['payment_total'], 'number'],
            [['installed_location', 'permit_no'], 'string', 'max' => 255],
            [['verifier_id', 'approver_id', 'payment_verifier'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'app_id' => 'App ID',
            'event_id' => 'Event ID',
            'installed_location' => 'Installed Location',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'time_start' => 'Time Start',
            'time_end' => 'Time End',
            'user_contact_no' => 'User Contact No',
            'company_name' => 'Company Name',
            'company_contact_no' => 'Company Contact No',
            'application_status' => 'Application Status',
            'date_applied' => 'Date Applied',
            'date_verified' => 'Date Verified',
            'verifier_id' => 'Verifier ID',
            'verifier_notes' => 'Verifier Notes',
            'date_approved' => 'Date Approved',
            'approver_id' => 'Approver ID',
            'payment_status' => 'Payment Status',
            'payment_total' => 'Payment Total',
            'payment_verifier' => 'Payment Verifier',
            'rasmi_status' => 'Rasmi Status',
            'permit_no' => 'Permit No',
            'app_type' => 'Application Type',
        ];
    }

    public function getEvent() {
        return $this->hasOne(TblEvent::className(), ['event_id' => 'event_id']);
    }

    public function getReference() {
        return $this->hasOne(RefApp::className(), ['id' => 'app_type']);
    }

    public function getAppStatus() {

        $status = '<span class="label label-default">BELUM DIISI</span>';

        if ($this->application_status != '0'){
        
            if ($this->application_status == '1') {
                $status = '<span class="label label-primary">BARU</span>';     
            } elseif ($this->application_status == '2') {
                $status = '<span class="label label-info">SUDAH DIISI</span>';
            } elseif ($this->application_status == '3') {
                $status = '<span class="label label-success">SUDAH DIHANTAR</span>';
            } 
        }

        return $status;
    }
}
