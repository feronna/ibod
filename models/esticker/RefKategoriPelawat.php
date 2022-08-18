<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "{{%keselamatan.stc_kategori_pelawat}}".
 *
 * @property int $id
 * @property string $nama
 */
class RefKategoriPelawat extends \yii\db\ActiveRecord
{
    
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%keselamatan.stc_kategori_pelawat}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'string', 'max' => 150],
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
