<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v2_tbl_persidangan".
 *
 * @property int $id
 * @property string $lpp_id
 * @property string $kategori
 * @property string $nama_projek
 * @property string $peranan
 * @property string $tahap
 */
class TblPersidangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_tbl_persidangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id'], 'integer'],
            [['kategori', 'peranan', 'tahap'], 'string', 'max' => 20],
            [['nama_projek'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lpp_id' => 'Lpp ID',
            'kategori' => 'Kategori',
            'nama_projek' => 'Nama Projek',
            'peranan' => 'Peranan',
            'tahap' => 'Tahap',
        ];
    }
}
