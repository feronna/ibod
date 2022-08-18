<?php

namespace app\models\Kemudahan;

use Yii;

/**
 * This is the model class for table "onapp.ref_jeniskemudahan".
 *
 * @property int $kemudahancd
 * @property string $kemudahan
 */
class Refjeniskemudahan extends \yii\db\ActiveRecord
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
        return 'utilities.fac_ref_jeniskemudahan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kemudahan'], 'required', 'message' => 'Ruang ini adalah mandatori'],
            [['kemudahan'], 'string', 'max' => 30],
            [['jumlah', 'amount'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kemudahancd' => 'Kemudahancd',
            'kemudahan' => 'Kemudahan',
        ];
    }
    public function getKodakaun()
    {
        return $this->hasOne(Refakaun::className(), ['kemudahancd' => 'kemudahancd']);
    }
}
