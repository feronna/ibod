<?php

namespace app\models\kontrak;

use Yii;

/**
 * This is the model class for table "kontrak.tbl_kpibyyear".
 *
 * @property int $id
 * @property int $kpi_id id dari table tbl_kpi
 * @property string $tahun
 * @property string $ulasan
 */
class TblKpiByYear extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.kontrak_tbl_kpibyyear';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kpi_id'], 'integer'],
            [['tahun'], 'safe'],
            [['ulasan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kpi_id' => 'Kpi ID',
            'tahun' => 'Tahun',
            'ulasan' => 'Ulasan',
        ];
    }
}
