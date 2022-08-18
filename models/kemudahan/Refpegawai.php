<?php

namespace app\models\Kemudahan;

use Yii;

/**
 * This is the model class for table "onapp.ref_pegawai".
 *
 * @property int $id
 * @property string $penyelia_icno
 * @property string $penyelia2_icno
 * @property string $pegawai_icno
 * @property string $pemohon_icno
 */
class Refpegawai extends \yii\db\ActiveRecord
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
        return 'utilities.fac_ref_pegawai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pembantu_tadbir', 'pembantu_tadbir2', 'pegawai_bsm', 'admin', 'pegawai_bendahari'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pembantu_tadbir' => 'pembantu tadbir',
            'pembantu_tadbir2' => 'pembantu tadbir2',
            'pegawai_bsm' => 'pegawai bsm',
            'admin' => 'Admin',
            'pegawai_bendahari' => 'pegawai bendahari',
        ];
    }
}
