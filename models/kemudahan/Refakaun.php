<?php

namespace app\models\Kemudahan;

use Yii;

/**
 * This is the model class for table "onapp.ref_akaun".
 *
 * @property int $akauncd
 * @property string $kodAkaun
 * @property int $kemudahancd
 */
class Refakaun extends \yii\db\ActiveRecord
{
     // add the function below:
//    public static function getDb() {
//        return Yii::$app->get('db7'); // second database
//    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.fac_ref_akaun';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kodAkaun'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['kemudahancd'], 'integer'],
            [['kodAkaun'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'akauncd' => 'Akauncd',
            'kodAkaun' => 'Kod Akaun',
            'kemudahancd' => 'Kemudahancd',
        ];
    }
    public function getKodkemudahan()
    {
        return $this->hasOne(Refjeniskemudahan::className(), ['kemudahancd' => 'kemudahancd']);
    }
}
