<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.ref_pegawai".
 *
 * @property int $id
 * @property string $penyelia_icno
 * @property string $penyelia2_icno
 * @property string $pegawai_icno
 * @property string $pemohon_icno
 */
class RefPegawai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cbelajar.ref_pegawai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penyelia_icno', 'penyelia2_icno', 'pegawai_icno', 'pemohon_icno'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'penyelia_icno' => 'Penyelia Icno',
            'penyelia2_icno' => 'Penyelia2 Icno',
            'pegawai_icno' => 'Pegawai Icno',
            'pemohon_icno' => 'Pemohon Icno',
        ];
    }
}
