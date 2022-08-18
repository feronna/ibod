<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.accesssecondlevel".
 *
 * @property int $id
 * @property string $nama
 * @property int $jenis
 */
class AksesLevelKedua extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.accesssecondlevel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis'], 'integer'],
            [['nama'], 'string', 'max' => 30],
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
            'jenis' => 'Jenis',
        ];
    }
}
