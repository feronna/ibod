<?php

namespace app\models\cbelajar;

use Yii;

/**
 * This is the model class for table "cbelajar.tbl_semak_doktoral".
 *
 * @property int $int
 * @property string $icno
 * @property int $iklan_id
 * @property string $terima
 * @property int $syarat_id
 * @property string $semak_doktoral
 * @property string $catatan
 * @property string $status_semakan
 * @property string $semak_by
 * @property string $semak_dt
 * @property int $tahun
 * @property int $parent_id
 * @property int $idBorang
 */
class TblSemakDoktoral extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrd.cb_tbl_semak_doktoral';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['iklan_id', 'syarat_id', 'tahun', 'parent_id', 'idBorang'], 'integer'],
            [['catatan'], 'string'],
            [['semak_dt'], 'safe'],
            [['icno', 'semak_by'], 'string', 'max' => 12],
            [['terima'], 'string', 'max' => 10],
            [['semak_doktoral'], 'string', 'max' => 20],
            [['status_semakan'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'int' => 'Int',
            'icno' => 'Icno',
            'iklan_id' => 'Iklan ID',
            'terima' => 'Terima',
            'syarat_id' => 'Syarat ID',
            'semak_doktoral' => 'Semak Doktoral',
            'catatan' => 'Catatan',
            'status_semakan' => 'Status Semakan',
            'semak_by' => 'Semak By',
            'semak_dt' => 'Semak Dt',
            'tahun' => 'Tahun',
            'parent_id' => 'Parent ID',
            'idBorang' => 'Id Borang',
        ];
    }
}
