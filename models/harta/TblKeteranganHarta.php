<?php

namespace app\models\harta;

use Yii;

/**
 * This is the model class for table "harta.tbl_keterangan_harta".
 *
 * @property int $hartas_id
 * @property string $keterangan
 * @property int $senarai_id
 */
class TblKeteranganHarta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.harta_tbl_keterangan_harta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hartas_id', 'senarai_id'], 'integer'],
            [['keterangan'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'hartas_id' => 'Hartas ID',
            'keterangan' => 'Keterangan',
            'senarai_id' => 'Senarai ID',
        ];
    }
}
