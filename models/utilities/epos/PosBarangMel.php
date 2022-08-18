<?php

namespace app\models\utilities\epos;

use Yii;

/**
 * This is the model class for table "utilities.pos_tbl_barang_mel".
 *
 * @property int $id
 * @property string $nama_barang
 * @property string $penerangan_barang
 * @property int $jenis_barang
 * @property int $kuantiti
 */
class PosBarangMel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.pos_tbl_barang_mel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penerangan_barang'], 'string'],
            [['jenis_barang', 'kuantiti','permohonan_id'], 'integer'],
            [['nama_barang'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_barang' => 'Nama Barang',
            'penerangan_barang' => 'Penerangan Barang',
            'jenis_barang' => 'Jenis Barang',
            'kuantiti' => 'Kuantiti',
            'permohonan_id' => 'ID Permohonan',
        ];
    }

    public function getMel() {
        return $this->hasOne(PosTblPermohonan::className(), ['id' => 'pemrohonan_id']);
    }
    public function getJenisBarang() {
        return $this->hasOne(PosJenisBarang::className(), ['id' => 'jenis_barang']);
    }
}
