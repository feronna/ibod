<?php

namespace app\models\keselamatan;
use app\models\hronline\Tblprcobiodata;

use Yii;

/**
 * This is the model class for table "keselamatan.tbl_warnakad".
 *
 * @property int $id
 * @property string $month_date generate setiap 1 haribulan
 * @property string $icno setiap bulan cuma ada 1 sahaja icno
 * @property string $color YELLOW = kuning , GREEN = hijau, RED = merah
 * @property int $ketidakpatuhan Jumlah Ketidakpatuhan
 * @property int $approved Jumlah Ketidakpatuhan yang diluluskan
 * @property int $disapproved Jumlah Ketidakpatuhan yang tidak diluluskan
 */
class TblWarnakad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.tbl_warnakad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month_date', 'icno', 'color'], 'required'],
            [['month_date'], 'safe'],
            [['ketidakpatuhan', 'approved', 'disapproved'], 'integer'],
            [['icno'], 'string', 'max' => 15],
            [['color'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'month_date' => 'Month Date',
            'icno' => 'Icno',
            'color' => 'Color',
            'ketidakpatuhan' => 'Ketidakpatuhan',
            'approved' => 'Approved',
            'disapproved' => 'Disapproved',
        ];
    }
    public static function WarnaKadSemasa($icno, $month, $type = NULL, $year) {

        $value = '';
               
        $sql = 'SELECT * FROM keselamatan.tbl_warnakad WHERE icno=:icno AND MONTH(month_date)=:month AND YEAR(month_date)=:year';
        $model = TblWarnakad::findBySql($sql, [':icno' => $icno, 'month' => $month, 'year'=>$year])->one();

        if ($model) {

            if ($type == NULL) {
                $value = $model->color;
            }

            if ($type == 1) {
                $value = $model->ketidakpatuhan;
            }
            if ($type == 2) {
                $value = $model->approved;
            }
            if ($type == 3) {
                $value = $model->disapproved;
            }
        }

        return strtolower($value);
    }
    public function getKakitangan() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
    public function getStaff() {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }
}
