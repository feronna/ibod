<?php

namespace app\models\kehadiran;

use app\models\cuti\AksesPengguna;
use Yii;
use app\models\hronline\Tblprcobiodata;

/**
 * This is the model class for table "attendance.tbl_ppv".
 *
 * @property int $id
 * @property string $icno
 * @property string $tarikh
 */
class TblPpv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendance.tbl_ppv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarikh'], 'safe'],
            // [['icno'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'tarikh' => 'Tarikh',
        ];
    }

    public function getKakitangan()
    {
        return $this->hasOne(Tblprcobiodata::className(), ['ICNO' => 'icno']);
    }

    public static function ppvByDay($date, $icno, $isdata = 0)
    {

        $staff = AksesPengguna::kakitanganSeliaan($icno);

        $array_own_staff = [];

        foreach ($staff as $r) {
            $array_own_staff[] = $r->ICNO;
        }

        $model = self::find()->joinWith('kakitangan')->where(['tbl_ppv.tarikh' => $date])->andWhere(['in', 'tbl_ppv.icno', $array_own_staff])->orderBy(['tblprcobiodata.CONm' => SORT_ASC])->all();

        if ($isdata == 1) {

            return $model;

        } else {
            return count($model);
        }

    }
}
