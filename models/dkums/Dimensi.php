<?php

namespace app\models\dkums;

use Yii;

/**
 * This is the model class for table "utilities.dkums_dimensi".
 *
 * @property int $id
 * @property int $main_id
 * @property string $semangat
 * @property string $dedikasi
 * @property string $kesungguhan
 * @property string $gaji
 * @property string $pangkat
 * @property string $penyeliaan
 * @property string $faedah
 * @property string $ganjaran
 * @property string $prosedur
 * @property string $rakan
 * @property string $sifat
 * @property string $komunikasi
 */
class Dimensi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.dkums_dimensi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main_id'], 'integer'],
            [['semangat', 'dedikasi', 'kesungguhan', 'gaji', 'pangkat', 'penyeliaan', 'faedah', 'ganjaran', 'prosedur', 'rakan', 'sifat', 'komunikasi'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'main_id' => 'Main ID',
            'semangat' => 'Semangat',
            'dedikasi' => 'Dedikasi',
            'kesungguhan' => 'Kesungguhan',
            'gaji' => 'Gaji',
            'pangkat' => 'Pangkat',
            'penyeliaan' => 'Penyeliaan',
            'faedah' => 'Faedah',
            'ganjaran' => 'Ganjaran',
            'prosedur' => 'Prosedur',
            'rakan' => 'Rakan',
            'sifat' => 'Sifat',
            'komunikasi' => 'Komunikasi',
        ];
    }
}
