<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "idp.r_tahap".
 *
 * @property int $tahap_id
 * @property string $tahap_nama
 */
class Tahap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_ref_tahap';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tahap_nama'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tahap_id' => 'Tahap ID',
            'tahap_nama' => 'Tahap Nama',
        ];
    }
}
