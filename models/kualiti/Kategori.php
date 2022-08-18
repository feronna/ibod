<?php

namespace app\models\kualiti;

use Yii;

/**
 * This is the model class for table "utilities.kualiti_kategori".
 *
 * @property int $kategori_id
 * @property string $kategori_nama
 */
class Kategori extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.kualiti_kategori';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategori_nama'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kategori_id' => 'Kategori ID',
            'kategori_nama' => 'Kategori',
        ];
    }

    
}
