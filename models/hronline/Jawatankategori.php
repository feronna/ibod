<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.jawatankategori".
 *
 * @property int $id
 * @property string $kategori
 * @property string $kategoriMM
 */
class Jawatankategori extends \yii\db\ActiveRecord
{
    public $_totalCount;
    
    public static function tableName()
    {
        return 'hronline.jawatankategori';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db2');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['kategori'], 'string', 'max' => 100],
            [['kategoriMM'], 'string', 'max' => 10],
            [['id'], 'unique'],
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
            'kategoriMM' => 'Kategori Mm',
        ];
    }

    public function getGredJawatan() {
        return $this->hasMany(GredJawatan::className(), ['job_category' => 'id']);
    }
}
