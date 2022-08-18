<?php

namespace app\models\utilities\epos;

use Yii;

/**
 * This is the model class for table "utilities.pos_ref_jenis_barang".
 *
 * @property int $id
 * @property string $jenis_barang
 * @property int $status 1=aktif;0=tidak aktif
 */
class PosJenisBarang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.pos_ref_jenis_barang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['jenis_barang'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenis_barang' => 'Jenis Barang',
            'status' => 'Status',
        ];
    }
}
