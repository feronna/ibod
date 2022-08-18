<?php

namespace app\models\cuti;

use Yii;

/**
 * This is the model class for table "e_cuti.cuti_umum".
 *
 * @property int $id
 * @property string $nama_cuti
 * @property string $tarikh_cuti
 * @property string $sabah_sahaja
 * @property string $wilayah_sahaja
 * @property string $catatan
 */
class CutiUmum extends \yii\db\ActiveRecord
{

    // add the function below:
    public static function getDb()
    {
        return Yii::$app->get('db'); // second database
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cuti_public_holiday';
        // return 'e_cuti.cuti_umum';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tarikh_cuti'], 'safe'],
            [['sabah_sahaja', 'wilayah_sahaja'], 'string'],
            [['nama_cuti', 'catatan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_cuti' => 'Nama Cuti',
            'tarikh_cuti' => 'Tarikh Cuti',
            'sabah_sahaja' => 'Sabah Sahaja',
            'wilayah_sahaja' => 'Wilayah Sahaja',
            'catatan' => 'Catatan',
        ];
    }

    public static function getCutiUmum($date)
    {
// $date = "2020-05-30";
        $model = CutiUmum::findOne(['tarikh_cuti' => $date]);
        if ($model) {
            return true;
        }
    }
}
