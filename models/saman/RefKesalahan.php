<?php

namespace app\models\saman;

use Yii;

/**
 * This is the model class for table "ekeselamatan.r_11_eks_kesalahant".
 *
 * @property string $KODSALAH
 * @property string $KODAKTA
 * @property string $KODCETAK
 * @property string $KETERANGAN
 * @property string $HARGA1
 * @property string $HARGA2
 * @property string $HARGA3
 * @property string $HARGA4
 * @property string $HARGAKUNCITAYAR
 */
class RefKesalahan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ekeselamatan.r_11_eks_kesalahant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['KODSALAH'], 'required'],
            [['HARGA1', 'HARGA2', 'HARGA3', 'HARGA4', 'HARGAKUNCITAYAR'], 'number'],
            [['KODSALAH', 'KODAKTA'], 'string', 'max' => 10],
            [['KODCETAK'], 'string', 'max' => 20],
            [['KETERANGAN'], 'string', 'max' => 100],
            [['KODSALAH'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'KODSALAH' => 'Kodsalah',
            'KODAKTA' => 'Kodakta',
            'KODCETAK' => 'Kodcetak',
            'KETERANGAN' => 'Keterangan',
            'HARGA1' => 'Harga 1',
            'HARGA2' => 'Harga 2',
            'HARGA3' => 'Harga 3',
            'HARGA4' => 'Harga 4',
            'HARGAKUNCITAYAR' => 'Hargakuncitayar',
        ];
    }
}
