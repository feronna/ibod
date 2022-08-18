<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "keselamatan.kontrak_type".
 *
 * @property int $id
 * @property string $jenis_desc
 */
class RefJenisKontraktor extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.kontrak_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis_desc'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jenis_desc' => 'Jenis Desc',
        ];
    }
}
