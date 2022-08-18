<?php

namespace app\models\Kemudahan;

use Yii;

/**
 * This is the model class for table "onapp.ref_setpegawai".
 *
 * @property int $id
 * @property string $pemohon_icno
 * @property string $peraku_icno
 * @property string $pelulus_icno
 */
class Refsetpegawai extends \yii\db\ActiveRecord
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
        return 'facilty.ref_setpegawai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pemohon_icno', 'peraku_icno', 'pelulus_icno'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pemohon_icno' => 'Pemohon Icno',
            'peraku_icno' => 'Peraku Icno',
            'pelulus_icno' => 'Pelulus Icno',
        ];
    }
}
