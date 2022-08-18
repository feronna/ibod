<?php

namespace app\models\hronline;

use Yii;

/**
 * This is the model class for table "hronline.kategoribadanprofesional".
 *
 * @property int $id
 * @property string $kategoriNm
 */
class Kategoribadanprofesional extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db2'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.kategoribadanprofesional';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kategoriNm'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kategoriNm' => 'Kategori Nm',
        ];
    }
}
