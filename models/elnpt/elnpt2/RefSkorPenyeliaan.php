<?php

namespace app\models\elnpt\elnpt2;

use Yii;

/**
 * This is the model class for table "hrm.elnpt_v2_ref_skor_penyeliaan".
 *
 * @property int $id
 * @property double $belum_utama
 * @property double $telah_utama_sem
 * @property double $telah_utama
 * @property double $belum_sama
 * @property double $telah_sama_sem
 * @property double $telah_sama
 */
class RefSkorPenyeliaan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.elnpt_v2_ref_skor_penyeliaan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['belum_utama', 'telah_utama_sem', 'telah_utama', 'belum_sama', 'telah_sama_sem', 'telah_sama'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'belum_utama' => 'Belum Utama',
            'telah_utama_sem' => 'Telah Utama Sem',
            'telah_utama' => 'Telah Utama',
            'belum_sama' => 'Belum Sama',
            'telah_sama_sem' => 'Telah Sama Sem',
            'telah_sama' => 'Telah Sama',
        ];
    }
}
