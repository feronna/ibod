<?php

namespace app\models\keselamatan;
use app\models\hronline\Tblprcobiodata;
use Yii;

/**
 * This is the model class for table "keselamatan.tbl_lmt_keselamatan".
 *
 * @property int $id
 * @property string $staff_icno
 * @property string $pos_kawalan
 * @property int $unit_id
 * @property int $ketua_pos
 * @property int $penolong_ketua_pos
 * @property string $month
 * @property string $year
 * @property string $added_by
 * @property string $created_at
 * @property string $kampus
 */
class TblLmtKeselamatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.tbl_lmt_keselamatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unit_id', 'ketua_pos', 'penolong_ketua_pos','pos_kawalan_id'], 'integer'],
            [['year', 'created_at'], 'safe'],
            [['staff_icno', 'added_by', 'kampus'], 'string', 'max' => 20],
            //            [['pos_kawalan_id'], 'string', 'max' => 50],
            [['month'], 'string', 'max' => 15],
            [['pos_kawalan_id','staff_icno','kampus','year','month','unit_id'], 'required','message' => 'Sila Isi Ruangan Ini !'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_icno' => 'Staff Icno',
            'pos_kawalan' => 'Pos Kawalan',
            'unit_id' => 'Unit ID',
            'ketua_pos' => 'Ketua Pos',
            'penolong_ketua_pos' => 'Penolong Ketua Pos',
            'month' => 'Month',
            'year' => 'Year',
            'added_by' => 'Added By',
            'created_at' => 'Created At',
            'kampus' => 'Kampus',
        ];
    }
     public function getCampus() {
        return $this->hasOne(\app\models\hronline\Campus::className(), ['campus_id' => 'kampus']);
    }
     public function getStaff() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'staff_icno']);
    }
      public function getPos() {
        return $this->hasOne(RefPosLmt::className(), ['id' => 'pos_kawalan_id']);
    }
      public function getUnitname() {
        return $this->hasOne(RefUnit::className(), ['id' => 'unit_id']);
    }
      public function getBulan() {

        $mth = $this->month;
        $nama_bulan = '';

        if ($mth == 1) {
            $nama_bulan = 'Januari';
        }
        if ($mth == 2) {
            $nama_bulan = 'Februari';
        }
        if ($mth == 3) {
            $nama_bulan = 'Mac';
        }
        if ($mth == 4) {
            $nama_bulan = 'April';
        }
        if ($mth == 5) {
            $nama_bulan = 'Mei';
        }
        if ($mth == 6) {
            $nama_bulan = 'Jun';
        }
        if ($mth == 7) {
            $nama_bulan = 'Julai';
        }
        if ($mth == 8) {
            $nama_bulan = 'Ogos';
        }
        if ($mth == 9) {
            $nama_bulan = 'September';
        }
        if ($mth == 10) {
            $nama_bulan = 'Oktober';
        }
        if ($mth == 11) {
            $nama_bulan = 'November';
        }
        if ($mth == 12) {
            $nama_bulan = 'Disember';
        }

        return $nama_bulan;
    }
}
