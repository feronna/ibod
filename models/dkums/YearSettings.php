<?php

namespace app\models\dkums;

use Yii;

/**
 * This is the model class for table "utilities.dkums_year_settings".
 *
 * @property int $id
 * @property string $tahun tahun
 * @property int $fasa fasa 1 or 2
 * @property int $status status ni mesti 1 jak aktif
 * @property string $start_dt Mula Pada
 * @property string $end_dt Tamat Pada
 * @property int $slot_id 
 */
class YearSettings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilities.dkums_year_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fasa', 'status', 'papar','slot_id'], 'integer'],
            [['start_dt', 'end_dt'], 'safe'],
            [['tahun'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tahun' => 'Tahun',
            'fasa' => 'Fasa',
            'status' => 'Status',
            'papar' => 'Papar Statistik',
            'statusText' => 'Status',
            'start_dt' => 'Tarikh Mula',
            'end_dt' => 'Tamat Pada',
            'slot_id' => 'IDP ID',
        ];
    }

    public function getStatusText()
    {
        return $this->status == 1 ? '<span class="label label-success">Aktif</span>' : '<span class="label label-danger">Tidak Aktif</span>';
    }

    public function getPaparText()
    {
        return $this->papar == 1 ? '<span class="label label-success">Ya</span>' : '<span class="label label-danger">Tidak</span>';
    }

    public static function fasaAktif()
    {
        return self::findOne(['status'=>1]);
    }
}
