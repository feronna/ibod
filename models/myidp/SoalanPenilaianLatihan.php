<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "myidp.soalanPenilaianLatihan".
 *
 * @property string $soalanID
 * @property string $soalan
 * @property string $jenisSoalan
 */
class SoalanPenilaianLatihan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_ref_soalanPenilaianLatihan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['soalanID'], 'required'],
            [['soalan'], 'string'],
            [['soalanID'], 'string', 'max' => 12],
            [['jenisSoalan'], 'string', 'max' => 1],
            [['soalanID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'soalanID' => 'Soalan ID',
            'soalan' => 'Soalan',
            'jenisSoalan' => 'Jenis Soalan',
        ];
    }
}
