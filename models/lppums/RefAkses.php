<?php

namespace app\models\lppums;

use Yii;

/**
 * This is the model class for table "new_hrm.lppums_ref_akses".
 *
 * @property string $akses_id
 * @property int $akses_lpp
 * @property int $akses_lpp_tahun
 * @property int $assign_pp
 * @property int $akses_markah_PPP
 * @property int $akses_markah_PPK
 * @property int $akses_markah_purata
 * @property int $akses_kj
 * @property string $akses_set_akses
 * @property int $akses_laporan
 * @property int $laporan_status_lpp
 * @property int $laporan_markah_lpp
 * @property int $request_log
 * @property int $akses_laporan_csv
 * @property string $akses_label
 * @property int $akses_reset
 * @property int $akses_backup
 * @property int $akses_apc
 */
class RefAkses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_akses';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['akses_lpp', 'akses_lpp_tahun', 'assign_pp', 'akses_markah_PPP', 'akses_markah_PPK', 'akses_markah_purata', 'akses_kj', 'akses_laporan', 'laporan_status_lpp', 'laporan_markah_lpp', 'request_log', 'akses_laporan_csv', 'akses_reset', 'akses_backup', 'akses_apc'], 'integer'],
            [['akses_set_akses', 'akses_label'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'akses_id' => 'Akses ID',
            'akses_lpp' => 'Akses Lpp',
            'akses_lpp_tahun' => 'Akses Lpp Tahun',
            'assign_pp' => 'Assign Pp',
            'akses_markah_PPP' => 'Akses Markah  Ppp',
            'akses_markah_PPK' => 'Akses Markah  Ppk',
            'akses_markah_purata' => 'Akses Markah Purata',
            'akses_kj' => 'Akses Kj',
            'akses_set_akses' => 'Akses Set Akses',
            'akses_laporan' => 'Akses Laporan',
            'laporan_status_lpp' => 'Laporan Status Lpp',
            'laporan_markah_lpp' => 'Laporan Markah Lpp',
            'request_log' => 'Request Log',
            'akses_laporan_csv' => 'Akses Laporan Csv',
            'akses_label' => 'Akses Label',
            'akses_reset' => 'Akses Reset',
            'akses_backup' => 'Akses Backup',
            'akses_apc' => 'Akses Apc',
        ];
    }
}
