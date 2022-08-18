<?php

namespace app\models\e_perkhidmatan;

use Yii;

/**
 * This is the model class for table "{{%keselamatan.utils_tbl_event}}".
 *
 * @property int $event_id
 * @property string $event_name
 * @property string $event_location
 * @property string $event_date_start
 * @property string $event_date_end
 * @property string $event_time_start
 * @property string $event_time_end
 * @property int $event_anggaran_peserta Anggaran peserta untuk setiap program diperlukan untuk membuat anggaran jumlah anggota jika kawalan keselamatan diperlukan.
 * @property int $event_application_status 1 => BARU
 * @property int $dept_id
 * @property string $user_id
 * @property int $papan_tanda_status
 * @property int $banner_status
 * @property string $banner_location
 * @property string $banner_date_start
 * @property string $banner_date_end
 * @property string $banner_time_start
 * @property string $banner_time_end
 * @property string $banner_company_name
 * @property string $banner_company_no
 * @property string $banner_title
 * @property string $banner_permit_no
 * @property int $banner_payment_status
 * @property double $banner_payment_total
 * @property string $banner_payment_verifier
 * @property string $event_date_applied
 * @property string $event_date_verified
 * @property string $event_verifier_id PENGESAH DARI BAHAGIAN KESELAMATAN
 * @property string $event_verifier_notes ULASAN PENGESAH
 * @property string $event_date_approved
 * @property string $event_approver_id PELULUS DARI BAHAGIAN KESELAMATAN
 * @property string $event_approver_notes ULASAN PELULUS
 * @property int $kawalan_status 0 => TIDAK PERLU KAWALAN KESELAMATAN, 1 => PERLU KAWALAN KESELAMATAN
 * @property int $parkir_status 0 => TIDAK PERLU PARKIR, 1 => PERLU PARKIR
 * @property string $event_pemohon_id
 * @property string $papan_tanda_title
 * @property string $papan_tanda_date_start
 * @property string $papan_tanda_date_end
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file1;

    public static function tableName()
    {
        return '{{%keselamatan.utils_tbl_event}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_date_start', 'event_date_end', 'event_time_start', 'event_time_end', 'banner_date_start', 'banner_date_end', 'banner_time_start', 'banner_time_end', 'event_date_applied', 'event_date_verified', 'event_date_approved', 'papan_tanda_date_start', 'papan_tanda_date_end'], 'safe'],
            [['event_anggaran_peserta', 'event_application_status', 'dept_id', 'papan_tanda_status', 'banner_status', 'banner_payment_status', 'kawalan_status', 'parkir_status', 'countdown_status'], 'integer'],
            [['banner_company_name', 'banner_title', 'event_verifier_notes', 'event_approver_notes', 'papan_tanda_title'], 'string'],
            [['banner_payment_total'], 'number'],
            [['event_name', 'event_location', 'user_id', 'banner_location', 'banner_permit_no'], 'string', 'max' => 255],
            [['banner_company_no'], 'string', 'max' => 25],
            [['banner_filename'], 'string', 'max' => 100],
            [['banner_payment_verifier', 'event_verifier_id', 'event_approver_id', 'event_pemohon_id'], 'string', 'max' => 12],
            [['file1'], 'file', 'extensions' => ['pdf', 'png', 'jpg', 'jpeg'], 'maxSize' => 2 * 1024 * 1024],
            [['file1'], 'safe'],
            // [['file1'], 'required', 'message' => 'Ruangan ini adalah mandatori'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'event_id' => 'Event ID',
            'event_name' => 'Event Name',
            'event_location' => 'Event Location',
            'event_date_start' => 'Event Date Start',
            'event_date_end' => 'Event Date End',
            'event_time_start' => 'Event Time Start',
            'event_time_end' => 'Event Time End',
            'event_anggaran_peserta' => 'Event Anggaran Peserta',
            'event_application_status' => 'Event Application Status',
            'dept_id' => 'Dept ID',
            'user_id' => 'User ID',
            'papan_tanda_status' => 'Papan Tanda Status',
            'banner_status' => 'Banner Status',
            'banner_location' => 'Banner Location',
            'banner_date_start' => 'Banner Date Start',
            'banner_date_end' => 'Banner Date End',
            'banner_time_start' => 'Banner Time Start',
            'banner_time_end' => 'Banner Time End',
            'banner_company_name' => 'Banner Company Name',
            'banner_company_no' => 'Banner Company No',
            'banner_title' => 'Banner Title',
            'banner_permit_no' => 'Banner Permit No',
            'banner_payment_status' => 'Banner Payment Status',
            'banner_payment_total' => 'Banner Payment Total',
            'banner_payment_verifier' => 'Banner Payment Verifier',
            'banner_filename' => 'Banner File Name',
            'event_date_applied' => 'Event Date Applied',
            'event_date_verified' => 'Event Date Verified',
            'event_verifier_id' => 'Event Verifier ID',
            'event_verifier_notes' => 'Event Verifier Notes',
            'event_date_approved' => 'Event Date Approved',
            'event_approver_id' => 'Event Approver ID',
            'event_approver_notes' => 'Event Approver Notes',
            'kawalan_status' => 'Kawalan Status',
            'parkir_status' => 'Parkir Status',
            'event_pemohon_id' => 'Event Pemohon ID',
            'pt_title' => 'Papan Tanda Title',
            'pt_date_start' => 'Papan Tanda Date Start',
            'pt_date_end' => 'Papan Tanda Date End',
        ];
    }

    public function getStatusPermohonan()
    {
        $a = " - ";

        if ($this->event_application_status == '1') {
            $a = '<span class="label label-primary">PERMOHONAN BARU</span>';
        } elseif ($this->event_application_status == '2') {
            $a = '<span class="label label-warning">PERMOHONAN DISEMAK</span>';
        } elseif ($this->event_application_status == '3') {
            $a = '<span class="label label-info">PERMOHONAN DITERIMA</span>';
        } elseif ($this->event_application_status == '4') {
            $a = '<span class="label label-danger">PERMOHONAN DITOLAK</span>';
        } elseif ($this->event_application_status == '5') {
            $a = '<span class="label label-success">PERMOHONAN BERJAYA</span>';
        }

        return $a;
    }

    public function getTarikhPohon()
    {
        $date = \Yii::$app->formatter->asDate($this->event_date_applied, 'php:d-m-Y');
        return $date;
    }

    public function test()
    {
        $app_type = '0';

        if ($this->countdown_status == '1') {
            $app_type = '1';
        }

        if ($this->papan_tanda_status == '1') {
            $app_type = '2';
        }

        if ($this->parkir_status == '1') {
            $app_type = '3';
        }

        if ($this->kawalan_status == '1') {
            $app_type = '4';
        }

        if ($this->banner_status == '1') {
            $app_type = '5';
        }

        return $app_type;
    }

    public function getReference($app_type)
    {
        return $this->hasOne(RefApp::className(), ['id' => $app_type]);
    }
}
