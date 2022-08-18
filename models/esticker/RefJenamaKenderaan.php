<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "e_sticker.model_kenderaan".
 *
 * @property string $KODMODEL
 * @property string $KODJENIS
 * @property string $KETERANGAN
 * @property int $ID
 */
class RefJenamaKenderaan extends \yii\db\ActiveRecord
{
    // add the function below:
    public static function getDb() {
        return Yii::$app->get('db'); // second database
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keselamatan.stc_model_kenderaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['KODMODEL', 'ID'], 'required'],
            [['ID'], 'integer'],
            [['KODMODEL'], 'string', 'max' => 3],
            [['KODJENIS'], 'string', 'max' => 20],
            [['KETERANGAN'], 'string', 'max' => 40],
            [['KODMODEL'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'KODMODEL' => 'Kodmodel',
            'KODJENIS' => 'Kodjenis',
            'KETERANGAN' => 'Keterangan',
            'ID' => 'ID',
        ];
    }
}
