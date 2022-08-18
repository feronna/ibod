<?php

namespace app\models\mohonjawatan;

use Yii;

/**
 * This is the model class for table "mohonjawatan.tbl_mohontest".
 *
 * @property int $id
 * @property string $tujuan
 * @property string $jwtdipohon
 * @property int $bilangan
 * @property string $justifikasi
 */
class TblMohontest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mohonjawatan.tbl_mohontest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bilangan'], 'integer'],
            [['tujuan', 'justifikasi'], 'string', 'max' => 250],
            [['jwtdipohon'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tujuan' => 'Tujuan',
            'jwtdipohon' => 'Jawatan Dan Gred Dipohon',
            'bilangan' => 'Bilangan',
            'justifikasi' => 'Justifikasi',
        ];
    }
}
