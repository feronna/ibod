<?php

namespace app\models\Kemudahan;

use Yii;

/**
 * This is the model class for table "facility.ref_records".
 *
 * @property int $id
 * @property string $icno
 * @property string $gelaran
 * @property string $nama
 * @property string $jawatan
 * @property string $jfpiu
 * @property string $destinasi
 * @property string $tarikh
 * @property string $jumlah
 */
class Refrecords extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'facility.ref_records';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['status'], 'integer', 'max' => 2],
            [['icno'], 'string', 'max' => 12],
            [['facility'], 'string', 'max' => 50],
            [['gelaran'], 'string', 'max' => 30],
            [['nama'], 'string', 'max' => 35],
            [['jawatan'], 'string', 'max' => 47],
            [['jfpiu'], 'string', 'max' => 14],
            [['destinasi'], 'string', 'max' => 27],
            [['tarikh'], 'string', 'max' => 29],
            [['jumlah'], 'string', 'max' => 11],
            [['id'], 'unique'],
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
            'status' => 'status',
            'facility' => 'facility',
            'gelaran' => 'Gelaran',
            'nama' => 'Nama',
            'jawatan' => 'Jawatan',
            'jfpiu' => 'Jfpiu',
            'destinasi' => 'Destinasi',
            'tarikh' => 'Tarikh',
            'jumlah' => 'Jumlah',
        ];
    }
}
