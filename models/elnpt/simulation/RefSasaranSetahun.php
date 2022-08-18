<?php

namespace app\models\elnpt\simulation;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v3_ref_sasaran_setahun".
 *
 * @property int $id
 * @property int $kategori
 * @property string $gred
 * @property int $sasaran
 */
class RefSasaranSetahun extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v3_ref_sasaran_setahun';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategori', 'sasaran'], 'integer'],
            [['gred'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kategori' => 'Kategori',
            'gred' => 'Gred',
            'sasaran' => 'Sasaran',
        ];
    }
}
