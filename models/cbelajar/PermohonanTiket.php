<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.ref_jenisPermohonan".
 *
 * @property int $id
 * @property string $jenisPermohonan
 * @property string $idBorang
 */
class PermohonanTiket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_ref_jenisPermohonan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenisPermohonan'], 'string', 'max' => 255],
            [['idBorang'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenisPermohonan' => 'Jenis Permohonan',
            'idBorang' => 'Id Borang',
        ];
    }
}
