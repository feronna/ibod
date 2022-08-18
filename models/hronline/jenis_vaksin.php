<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.jenis_vaksin".
 *
 * @property int $id
 * @property string $nama_vaksin
 * @property string $manufacturer
 */
class jenis_vaksin extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    public static function tableName()
    {
        return 'hronline.jenis_vaksin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_vaksin', 'manufacturer'], 'string', 'max' => 255],
            [['isActive'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_vaksin' => 'Nama Vaksin',
            'manufacturer' => 'Manufacturer',
        ];
    }
}
