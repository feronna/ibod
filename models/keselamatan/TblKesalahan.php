<?php

namespace app\models\keselamatan;

use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "keselamatan.tbl_kesalahan".
 *
 * @property int $id
 * @property string $icno
 * @property string $month
 * @property string $year
 * @property int $thtc
 * @property int $thlm
 * @property int $thtm
 * @property int $lhb
 * @property int $mpktk
 * @property int $mlasm
 * @property int $thb
 * @property int $thp
 * @property int $gmk
 * @property string $lain_lain
 * @property int $syifA
 * @property int $syifB
 * @property int $syifC
 * @property string $tarikh
 * @property string $entry_by
 * @property string $entry_dt
 * @property string $updated_by
 * @property string $update_dt
 * @property string $no_rujukan
 * @property string $remark
 * @property string $remark_status
 */
class TblKesalahan extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'keselamatan.tbl_kesalahan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['year', 'tarikh', 'entry_dt', 'update_dt', 'app_dt'], 'safe'],
            [['thtc', 'thlm', 'thtm', 'lhb', 'mpktk', 'mlasm', 'thb', 'thp', 'gmk', 'syifB', 'syifC'], 'integer'],
            [['icno', 'entry_by', 'updated_by'], 'string', 'max' => 20],
            [['month'], 'string', 'max' => 10],
            [['syif'], 'string', 'max' => 5],
            [['remark_status'], 'required', 'on' => 'reason', 'message' => 'Sila Pilih Status Pengesahan !'],
            [['lain_lain', 'app_remark'], 'string', 'max' => 255],
            [['no_rujukan'], 'string', 'max' => 100],
            [['remark'], 'string', 'max' => 500],
            [['remark_status'], 'string', 'max' => 15],
            [['peg_peraku', 'peg_pelulus'], 'string', 'max' => 25],
            [['remark_status'], 'required', 'on' => 'reason', 'message' => 'Sila Pilih Status Pengesahan !'],
            [['tarikh', 'syif'], 'required', 'message' => 'Sila Isi Bahagian Ini!'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'month' => 'Month',
            'year' => 'Year',
            'thtc' => 'Thtc',
            'thlm' => 'Thlm',
            'thtm' => 'Thtm',
            'lhb' => 'Lhb',
            'mpktk' => 'Mpktk',
            'mlasm' => 'Mlasm',
            'thb' => 'Thb',
            'thp' => 'Thp',
            'gmk' => 'Gmk',
            'lain_lain' => 'Lain Lain',
            'syifA' => 'Syif A',
            'syifB' => 'Syif B',
            'syifC' => 'Syif C',
            'tarikh' => 'Tarikh',
            'entry_by' => 'Entry By',
            'entry_dt' => 'Entry Dt',
            'updated_by' => 'Updated By',
            'update_dt' => 'Update Dt',
            'no_rujukan' => 'No Rujukan',
            'remark' => 'Remark',
            'remark_status' => 'Remark Status',
        ];
    }

    public function getStaff() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public function getShift() {
        if ($this->syifA == 1) {
            return '<span>A</span>';
        } elseif ($this->syifB == 1) {
            return '<span>B</span>';
        } elseif ($this->syifC == 1) {
            return '<span>C</span>';
        }
    }

    public function getPeraku() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'peg_peraku']);
    }

    public function getRmk() {
        if ($this->remark_status == 'ENTRY') {
            return '<font>[ &#x2716; ]</font>';
        }
        if ($this->remark_status == 'REMARKED') {
            return '<font>[ &#10004; ]</font>';
        }
        if ($this->remark_status == 'APPROVED') {
            return '<font color="white" style="background-color:green;">[ &#10004; ]</font>';
        }
        if ($this->remark_status == 'REJECTED') {
            return '<font color="white" style="background-color:red;">[ &#x2716; ]</font>';
        }
    }

    public function getBln() {

        if ($this->month == '01') {
            return '<span>JANUARI</span>';
        } elseif ($this->month == '02') {
            return '<span>FEBRUARI</span>';
        } elseif ($this->month == '03') {
            return '<span>MAC</span>';
        } elseif ($this->month == '04') {
            return '<span>APRIL</span>';
        } elseif ($this->month == '05') {
            return '<span>MEI</span>';
        } elseif ($this->month == '06') {
            return '<span>JUN</span>';
        } elseif ($this->month == '07') {
            return '<span>JULAI</span>';
        } elseif ($this->month == '08') {
            return '<span>OGOS</span>';
        } elseif ($this->month == '09') {
            return '<span">SEPTEMBER</span>';
        } elseif ($this->month == '10') {
            return '<span">OKTOBER</span>';
        } elseif ($this->month == '11') {
            return '<span">NOVEMBER</span>';
        } elseif ($this->month == '12') {
            return '<span">DISEMBER</span>';
        }
        //     
        //        return date_format(date_create($bulan), "d").' '.$m.' '.date_format(date_create($bulan), "Y");
    }

    public function getFormatTimeIn() {

        $val = '-';

        if ($this->time_in) {

            $val = $this->changeDatetimeToTime($this->time_in);
        }

        return $val;
    }

    public function getDate() {

         $val = '-';

        if ($this->tarikh) {

            $val = date_format($this->tarikh, "d/m/Y");
//            $val = $this->changeDatetimeToTime($this->time_in);
        }

        return $val;
//        $dt = date_create($date);
//
//        $v = date_format($dt, "d/m/Y");

        return $val;
    }
 public function changeDateFormat($date) {

        $dt = date_create($date);

        $v = date_format($dt, "d/m/Y");

        return $v;
    }
 public function getFormatTarikh() {

        return $this->changeDateFormat($this->tarikh);
    }

    public function getStatus() {
        if ($this->remark_status == 'ENTRY') {
            return ' <span class="label label-info">MENUNGGU PENGESAHAN PEGAWAI</span> ';
        }
        if ($this->remark_status == 'REMARKED') {
            return ' <span class="label label-warning">MENUNGGU PENGESAHAN</span> ';
        }
        if ($this->remark_status == 'APPROVED') {
            return ' <span class="label label-success">DITERIMA</span> ';
        }
        if ($this->remark_status == 'REJECTED') {
            return ' <span class="label label-danger">DITOLAK</span> ';
        }
    }

    public function getStatusAll() {

        $thtc = '';
        $thlm = '';
        $thtm = '';
        $lhb = '';
        $mpktk = '';
        $mlasm = '';
        $thb = '';
        $thp = '';
        $gmk = '';


        if ($this->thtc == '1') {
            $thtc = 'THTC';
        }if ($this->thlm == '1') {
            $thlm = 'THLM';
        }if ($this->thtm == '1') {
            $thtm = 'THTM';
        }if ($this->lhb == '1') {
            $lhb = 'LHB';
        }if ($this->mpktk == '1') {
            $mpktk = 'MPKTK';
        }if ($this->mlasm == '1') {
            $mlasm = 'MLASM';
        }if ($this->thb == '1') {
            $thb = 'THB';
        }if ($this->thp == '1') {
            $thp = 'THP';
        }if ($this->gmk == '1') {
            $gmk = 'GMK';
        }

        return '<span class="label label-danger">' . $thtc . '</span>' .
                ' <span class="label label-danger">' . $thlm . '</span> ' .
                ' <span class="label label-danger">' . $thtm . '</span>' . '</span> ' .
                ' <span class="label label-danger">' . $lhb . '</span> ' .
                ' <span class="label label-danger">' . $mpktk . '</span>' .
                ' <span class="label label-danger">' . $mlasm . '</span>' .
                ' <span class="label label-danger">' . $thb . '</span>' .
                ' <span class="label label-danger">' . $thp . '</span>' .
                ' <span class="label label-danger">' . $gmk . '</span>' .
                ' <span class="label label-danger">' . $gmk . '</span>' .
                ' <span class="label label-danger">' . $this->lain_lain . '</span>';
    }

}
