<?php

namespace app\models\portfolio;

use Yii;

/**
 * This is the model class for table "hrm.portfolio_ref_carta_fungsi".
 *
 * @property int $id_fungsi
 * @property string $keterangan
 */
class RefCartaFungsi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.portfolio_ref_carta_fungsi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['keterangan'], 'string', 'max' => 555],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_fungsi' => 'Id Fungsi',
            'keterangan' => 'Keterangan',
        ];
    }
}
