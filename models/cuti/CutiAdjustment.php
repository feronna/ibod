<?php

namespace app\models\cuti;

use Yii;

/**
 * This is the model class for table "hrm.cuti_adjustment".
 *
 * @property int $id
 * @property string $icno
 * @property string $layak_mula
 * @property string $layak_tamat
 * @property int $layak_selaras
 * @property int $gcr_selaras
 * @property int $cbth_selaras
 * @property int $hapus_selaras
 * @property string $catatan
 * @property string $adjfile
 * @property string $adjust_by
 * @property string $date_created
 */
class CutiAdjustment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.cuti_adjustment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['layak_mula', 'layak_tamat', 'date_created'], 'safe'],
            [['layak_selaras', 'gcr_selaras', 'cbth_selaras', 'hapus_selaras'], 'integer'],
            [['catatan', 'adjfile'], 'string'],
            [['icno', 'adjust_by'], 'string', 'max' => 12],
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
            'layak_mula' => 'Layak Mula',
            'layak_tamat' => 'Layak Tamat',
            'layak_selaras' => 'Layak Selaras',
            'gcr_selaras' => 'Gcr Selaras',
            'cbth_selaras' => 'Cbth Selaras',
            'hapus_selaras' => 'Hapus Selaras',
            'catatan' => 'Catatan',
            'adjfile' => 'Adjfile',
            'adjust_by' => 'Adjust By',
            'date_created' => 'Date Created',
        ];
    }
}
