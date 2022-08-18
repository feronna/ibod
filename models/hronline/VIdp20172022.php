<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.v_idp_2017_2022".
 *
 * @property string $staffID
 * @property string $tajukLatihan
 * @property int $tahunMula
 * @property string $tarikhMula
 * @property string $lokasi
 * @property int $siriLatihanID
 */
class VIdp20172022 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.v_idp_2017_2022';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tajukLatihan'], 'string'],
            [['tahunMula', 'siriLatihanID'], 'integer'],
            [['tarikhMula'], 'safe'],
            [['staffID'], 'string', 'max' => 12],
            [['lokasi'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'staffID' => 'Staff ID',
            'tajukLatihan' => 'Tajuk Latihan',
            'tahunMula' => 'Tahun Mula',
            'tarikhMula' => 'Tarikh Mula',
            'lokasi' => 'Lokasi',
            'siriLatihanID' => 'Siri Latihan ID',
        ];
    }
}
