<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "hrd.idp_ref_kategori".
 *
 * @property int $kategori_id
 * @property string $kategori_nama
 * @property string $kategori_nama_bi
 * @property string $asal
 * @property int $academic
 * @property int $admin
 */
class RefKategori extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_ref_kategori';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['academic', 'admin'], 'integer'],
            [['kategori_nama', 'kategori_nama_bi', 'asal'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kategori_id' => 'Kategori ID',
            'kategori_nama' => 'Kategori Nama',
            'kategori_nama_bi' => 'Kategori Nama Bi',
            'asal' => 'Asal',
            'academic' => 'Academic',
            'admin' => 'Admin',
        ];
    }
}
