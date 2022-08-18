<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "hrd.idp_ref_peringkat".
 *
 * @property int $id
 * @property string $nama
 */
class IdpRefPeringkat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_ref_peringkat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'string', 'max' => 155],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
        ];
    }
}
