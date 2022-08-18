<?php

namespace app\models\pinjaman;

use Yii;

/**
 * This is the model class for table "hrm.fac_ref_emolumen".
 *
 * @property int $id
 * @property string $icno
 * @property string $sesi
 * @property string $tahun
 * @property int $status_semasa status permohonan aktif tidak aktif
 * @property int $isActive
 */
class Refemolumen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.fac_ref_emolumen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['emolumen_date'], 'safe'],
            [['status_semasa', 'isActive', 'parent_id'], 'integer'],
            [['icno'], 'string', 'max' => 12],
            [['sesi', 'tahun'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'icno' => 'Icno',
            'sesi' => 'Sesi',
            'tahun' => 'Tahun',
            'status_semasa' => 'Status Semasa',
            'isActive' => 'Is Active',
            'parent_id' => 'Parent Id',
            'emolumen_date' => 'Tarikh Emolumen',

        ];
    }
}
