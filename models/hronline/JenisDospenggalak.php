<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.jenis_dospenggalak".
 *
 * @property int $id
 * @property string $nama
 * @property string $penerangan
 * @property int $isActive
 */
class JenisDospenggalak extends \yii\db\ActiveRecord
{
    
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    public static function tableName()
    {
        return 'hronline.jenis_dospenggalak';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['isActive'], 'integer'],
            [['nama'], 'string', 'max' => 50],
            [['penerangan'], 'string', 'max' => 200],
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
            'penerangan' => 'Penerangan',
            'isActive' => 'Is Active',
        ];
    }
}
