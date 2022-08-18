<?php

namespace app\models\ejobs;

use Yii;

/**
 * This is the model class for table "ejobs.iklan_kelayakan".
 *
 * @property int $id
 * @property int $iklan_id
 * @property string $akademik_desc
 * @property string $syarat_tamb_desc
 */
class Kelayakan extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db7');  // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ejobs.iklan_kelayakan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jawatan_id', 'akademik_desc'], 'required', 'message'=>'Ruang ini adalah mandatori'],
            [['jawatan_id'], 'integer'],
            [['akademik_desc', 'syarat_tamb_desc'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jawatan_id' => 'Iklan ID',
            'akademik_desc' => 'Akademik',
            'syarat_tamb_desc' => 'Syarat Tambahan',
        ];
    }
}
