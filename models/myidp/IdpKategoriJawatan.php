<?php

namespace app\models\myidp;

use Yii;

/**
 * This is the model class for table "myidp.kategoriJawatan".
 *
 * @property string $kategoriJawatanID
 */
class IdpKategoriJawatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.idp_kategoriJawatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategoriJawatanID'], 'required'],
            [['kategoriJawatanID'], 'string', 'max' => 25],
            [['kategoriJawatanID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kategoriJawatanID' => 'Kategori Jawatan ID',
        ];
    }
}
