<?php

namespace app\models\keselamatan;

use Yii;

/**
 * This is the model class for table "keselamatan.tbl_laporan_kejadian".
 *
 * @property int $id
 * @property string $laporan
 * @property string $entered_by
 * @property string $syif
 * @property string $date
 */
class TblLaporanKejadian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.tbl_laporan_kejadian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['campus_id'], 'integer'],
            [['laporan'], 'string'],
            [['entered_by'], 'string', 'max' => 12],
            [['syif'], 'string', 'max' => 2],
            [['syif'], 'required', 'message' => 'Sila Pilih Syif !'],
            [['date'], 'required', 'message' => 'Sila Pilih Tarikh !'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'laporan' => 'Laporan',
            'entered_by' => 'Entered By',
            'syif' => 'Syif',
            'date' => 'Date',
        ];
    }
    public function getFormatTarikh()
    {

        return $this->changeDateFormat($this->date);
    }
    public function changeDateFormat($date)
    {

        $dt = date_create($date);

        $v = date_format($dt, "d/m/Y");

        return $v;
    }

}
