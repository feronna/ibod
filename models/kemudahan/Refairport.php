<?php

namespace app\models\kemudahan;

use Yii;

/**
 * This is the model class for table "utilities.fac_ref_airport".
 *
 * @property string $kod
 * @property string $nama_airport
 * @property string $lokasi
 * @property string $location
 * @property int $is_active
 */
class Refairport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.fac_ref_airport';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_active'], 'integer'],
            [['kod'], 'string', 'max' => 10],
            [['nama_airport', 'lokasi', 'location'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kod' => 'Kod',
            'nama_airport' => 'Nama Airport',
            'lokasi' => 'Lokasi',
            'location' => 'Location',
            'is_active' => 'Is Active',
        ];
    }
}
