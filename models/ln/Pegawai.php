<?php

namespace app\models\ln;

use Yii;

/**
 * This is the model class for table "ln.tbl_pegawai".
 *
 * @property int $id
 * @property string $penyemak_icno
 * @property string $pelulus_icno
 * @property string $bendahari_icno
 */
class Pegawai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
//        return 'ln.tbl_pegawai';
        return 'hrm.ln_tbl_pegawai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['peraku_icno', 'penyemak_icno', 'pelulus_icno', 'bendahari_icno'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'peraku_icno' => 'Peraku Icno',
            'penyemak_icno' => 'Penyemak Icno',
            'pelulus_icno' => 'Pelulus Icno',
            'bendahari_icno' => 'Bendahari Icno',
        ];
    }
}
