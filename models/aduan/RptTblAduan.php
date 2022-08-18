<?php

namespace app\models\aduan;

use Yii;
use yii\helpers\Html;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "keselamatan.rpt_tbl_aduan".
 *
 * @property int $aduan_id
 * @property string $staff_icno ICNO from hronline.tblprcobiodata
 * @property string $aduan_details
 * @property string $date_created
 * @property int $aduan_status 1 => NEW
 * @property string $penerima_icno Pegawai Keselamatan whom accepted/rejected the complaint
 * @property string $penerima_notes
 * @property string $penerima_date
 * @property string $reporter_icno
 * @property string $report
 * @property int $report_status
 * @property string $report_date
 * @property string $approver_icno
 * @property string $approval_date
 */
class RptTblAduan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.rpt_tbl_aduan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aduan_details', 'penerima_notes', 'officer_notes', 'report'], 'string'],
            [['date_created', 'penerima_date', 'officer_date', 'report_date', 'approval_date', 'cancelled_date'], 'safe'],
            [['aduan_status', 'report_status'], 'integer'],
            [['staff_icno', 'penerima_icno', 'officer_icno', 'reporter_icno', 'approver_icno'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'aduan_id' => 'Nombor Aduan',
            'staff_icno' => 'Nombor Kad Pengenalan',
            'aduan_details' => 'Butiran Aduan',
            'date_created' => 'Tarikh Aduan',
            'aduan_status' => 'Status Aduan',
            'penerima_icno' => 'Penerima Icno',
            'penerima_notes' => 'Penerima Notes',
            'penerima_date' => 'Penerima Date',
            'reporter_icno' => 'Reporter Icno',
            'report' => 'Report',
            'report_status' => 'Report Status',
            'report_date' => 'Report Date',
            'approver_icno' => 'Approver Icno',
            'approval_date' => 'Approval Date',
            'cancelled_date' => 'Cancelled Date',
        ];
    }

    public function getBiodata()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'staff_icno']);
    }

    public function getPenerima()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'penerima_icno']);
    }

    public function getPegawai()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'officer_icno']);
    }

    public function getAduanStatus()
    {
        return $this->hasOne(RptRefStatusAduan::className(), ['id' => 'aduan_status']);
    }

    public function getNomborAdu()
    {
        $a = 'BKUMS' . $this->aduan_id;

        return $a;
    }

    public function getTarikhAdu()
    {

        $date = \Yii::$app->formatter->asDate($this->date_created, 'php:d-m-Y');
        return $date;
    }

    public function getTarikhBatal()
    {

        $date = \Yii::$app->formatter->asDate($this->cancelled_date, 'php:d-m-Y');
        return $date;
    }

    public function getTarikhLaporan()
    {

        $date = \Yii::$app->formatter->asDate($this->report_date, 'php:d-m-Y');
        return $date;
    }

    public function getLongStatus()
    {
        $a = "";

        if ($this->date_created) {

            if ($this->staff_icno) {
                $a = 'Dihantar Oleh :</br></br>';
                $a = $a . ' ' . strtoupper($this->biodata->gelaran->Title) . ' ' . $this->biodata->CONm . '</br>';
                $a = $a . ' ' . strtoupper($this->biodata->jawatan->nama) . '</br>';
                $a = $a . ' ' . strtoupper($this->biodata->department->fullname) . '</br></br>';
            }
            $a = $a . ' ' . 'Tarikh : ' . Yii::$app->formatter->asDate($this->date_created);
            $a = $a . ' ' . '</br></br>';
            $a = $a . ' ' . 'Ulasan : ';
            $a = $a . ' ' . '<i>' . $this->penerima_notes . '</i>';
        } else {
            echo '';
        }
        return $a;
    }

    public function getStatusPenerima()
    {
        $a = "";

        if ($this->penerima_date) {

            if ($this->penerima_date) {
                $a = 'Disahkan Oleh :</br></br>';
                $a = $a . ' ' . strtoupper($this->penerima->gelaran->Title) . ' ' . $this->penerima->CONm . '</br>';
                $a = $a . ' ' . strtoupper($this->penerima->jawatan->nama) . '</br>';
                $a = $a . ' ' . strtoupper($this->penerima->department->fullname) . '</br></br>';
            }
            $a = $a . ' ' . 'Tarikh : ' . Yii::$app->formatter->asDate($this->penerima_date);
            $a = $a . ' ' . '</br></br>';
            $a = $a . ' ' . 'Ulasan : ';
            $a = $a . ' ' . '<i>' . $this->penerima_notes . '</i>';
        } else {
            echo '';
        }
        return $a;
    }

    public function getStatusLaporan()
    {

        $a = " ";
        
        if ($this->report_status == '1'){
            $a = '<span class="label label-default">-</span>';    
        } elseif ($this->report_status == '2') {
            $a = '<span class="label label-primary">LAPORAN BARU</span>';
        } elseif ($this->report_status == '3') {
            $a = '<span class="label label-success">LAPORAN TELAH DISEMAK</span>';
        } 
        
        return $a;
    }

    public function calcPendingAduan()
    {

        $currentYear = date('Y');

        $count = RptTblAduan::find()
                    ->where(['aduan_status' => '1'])
                    ->all();

        if ($count) {
            return '&nbsp;<span class="badge bg-red">' . count($count) . '</span>';
        } else {
            return ' ';
        }
    }

    public function calcPendingPenyiasat()
    {

        $currentYear = date('Y');

        $count = RptTblAduan::find()
                    ->where(['aduan_status' => '2'])
                    ->all();

        if ($count) {
            return '&nbsp;<span class="badge bg-red">' . count($count) . '</span>';
        } else {
            return ' ';
        }
    }

    // public function afterFind()
    // {
    //     //$this->date_created = Yii::$app->formatter->asDate($this->date_created, 'dd/MM/yyyy');
    //     $this->date_created = \Yii::$app->formatter->asDate($this->date_created, 'php:d-m-Y');
    //     return true;
    // }
}
