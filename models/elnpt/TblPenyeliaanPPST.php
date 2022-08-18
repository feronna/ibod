<?php

namespace app\models\elnpt;

use Yii;

/**
 * This is the model class for table "hrm.tbl_penyeliaan_ppst".
 *
 * @property string $lpp_id
 * @property double $phd_utama
 * @property double $phd_sama
 * @property double $sarjana_utama
 * @property double $sarjana_sama
 * @property double $s_muda_utama
 * @property double $s_muda_sama
 */
class TblPenyeliaanPpst extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.tbl_penyeliaan_ppst';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lpp_id'], 'required'],
            [['lpp_id'], 'integer'],
            [['phd_utama', 'phd_sama', 'sarjana_utama', 'sarjana_sama', 's_muda_utama', 's_muda_sama'], 'number'],
            [['lpp_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lpp_id' => 'Lpp ID',
            'phd_utama' => 'Phd Utama',
            'phd_sama' => 'Phd Sama',
            'sarjana_utama' => 'Sarjana Utama',
            'sarjana_sama' => 'Sarjana Sama',
            's_muda_utama' => 'S Muda Utama',
            's_muda_sama' => 'S Muda Sama',
        ];
    }
}
