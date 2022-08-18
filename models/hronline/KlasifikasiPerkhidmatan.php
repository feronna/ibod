<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.klasifikasi_perkhidmatan".
 *
 * @property int $id
 * @property string $nama
 * @property string $gred
 */
class KlasifikasiPerkhidmatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.klasifikasi_perkhidmatan';
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
            [['nama'], 'string', 'max' => 255],
            [['gred_skim'], 'string', 'max' => 2],
            [['status'], 'string'],
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
            'gred_skim' => 'Gred Skim',
            'gred_skim' => 'Gred Skim',
            'status' => 'Status',
        ];
    }
}
