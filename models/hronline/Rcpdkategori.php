<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.r_cpd_kategori".
 *
 * @property int $rck_kod_kategori
 * @property string $rck_deskripsi_aktiviti
 * @property string $rck_edeskripsi_aktiviti
 */
class Rcpdkategori extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.r_cpd_kategori';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rck_kod_kategori'], 'required'],
            [['rck_kod_kategori'], 'integer'],
            [['rck_deskripsi_aktiviti', 'rck_edeskripsi_aktiviti'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rck_kod_kategori' => 'Rck Kod Kategori',
            'rck_deskripsi_aktiviti' => 'Rck Deskripsi Aktiviti',
            'rck_edeskripsi_aktiviti' => 'Rck Edeskripsi Aktiviti',
        ];
    }
}
