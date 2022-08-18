<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.ref_penerbangan".
 *
 * @property int $id
 * @property string $jenisKelas
 * @property string $idKelas
 */
class RefPenerbangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_ref_penerbangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenisKelas'], 'string', 'max' => 255],
            [['idKelas'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenisKelas' => 'Jenis Kelas',
            'idKelas' => 'Id Kelas',
        ];
    }
}
