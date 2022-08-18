<?php

namespace app\models\ikalendar;

use Yii;

/**
 * This is the model class for table "hronline.laporan".
 *
 * @property string $date
 * @property int $event_id
 * @property int $tarikh
 * @property int $bulan
 * @property int $tahun
 * @property string $masa_mula
 * @property string $masa_tamat
 * @property string $status
 * @property string $kategori
 * @property string $nama_aktiviti
 * @property string $tempat_aktiviti
 * @property int $category_id
 * @property int $sub_of
 * @property int $user_id
 * @property int $stats_id
 * @property string $tarikh_tunda
 * @property string $description
 */
class TblLaporan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hronline.laporan';
    }

    public static function primaryKey()
    {
        return ["event_id"];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'masa_mula', 'masa_tamat', 'tarikh_tunda'], 'safe'],
            [['event_id', 'tarikh', 'bulan', 'tahun', 'category_id', 'sub_of', 'user_id', 'stats_id'], 'integer'],
            [['description'], 'string'],
            [['status', 'nama_aktiviti', 'tempat_aktiviti'], 'string', 'max' => 255],
            [['kategori'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'date' => 'Date',
            'event_id' => 'Event ID',
            'tarikh' => 'Tarikh',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'masa_mula' => 'Masa Mula',
            'masa_tamat' => 'Masa Tamat',
            'status' => 'Status',
            'kategori' => 'Kategori',
            'nama_aktiviti' => 'Nama Aktiviti',
            'tempat_aktiviti' => 'Tempat Aktiviti',
            'category_id' => 'Category ID',
            'sub_of' => 'Sub Of',
            'user_id' => 'User ID',
            'stats_id' => 'Stats ID',
            'tarikh_tunda' => 'Tarikh Tunda',
            'description' => 'Description',
        ];
    }
}
