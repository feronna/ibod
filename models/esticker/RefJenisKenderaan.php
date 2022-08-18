<?php

namespace app\models\esticker;

use Yii;

/**
 * This is the model class for table "e_sticker.jenis_kenderaan".
 *
 * @property string $KODJENIS
 * @property string $Keterangan
 * @property int $id
 */
class RefJenisKenderaan extends \yii\db\ActiveRecord
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
        return 'keselamatan.stc_jenis_kenderaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['KODJENIS', 'id'], 'required'],
            [['id'], 'integer'],
            [['KODJENIS'], 'string', 'max' => 3],
            [['Keterangan'], 'string', 'max' => 40],
            [['KODJENIS'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'KODJENIS' => 'Jenis Kod',
            'Keterangan' => 'Jenis Kenderaan',
            'id' => 'ID',
        ];
    }
}
