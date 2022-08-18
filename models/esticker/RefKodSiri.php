<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "{{%keselamatan.stc_ref_kod}}".
 *
 * @property int $id
 * @property string $veh_type
 * @property string $kod_siri
 * @property string $desc
 */
class RefKodSiri extends \yii\db\ActiveRecord
{
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%keselamatan.stc_ref_kod}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['veh_type'], 'string', 'max' => 10],
            [['kod_siri'], 'string', 'max' => 5],
            [['stc_type'], 'integer', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'veh_type' => 'Jenis Kenderaan',
            'kod_siri' => 'Kod Siri',
            'stc_type' => 'Jenis Pelekat',
        ];
    }
}
