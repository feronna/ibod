<?php

namespace app\models\gaji;

use Yii;

/**
 * This is the model class for table "hrm.gaji_elaunname".
 *
 * @property int $id
 * @property string $nama_ringkas
 * @property string $nama_penuh
 * @property string $kod_saga
 */
class RefElaunName extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.gaji_elaunname';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_ringkas'], 'string', 'max' => 50],
            [['nama_penuh'], 'string', 'max' => 255],
            [['kod_saga'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_ringkas' => 'Nama Ringkas',
            'nama_penuh' => 'Nama Penuh',
            'kod_saga' => 'Kod Saga',
        ];
    }
}
