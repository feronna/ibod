<?php

namespace app\models\kontrak;

use Yii;

/**
 * This is the model class for table "kontrak.tbl_maklumatlain".
 *
 * @property int $id
 * @property int $kontrak_id
 * @property int $kredit_mengajar
 * @property int $pelajar
 * @property double $jumlah_geran_penyelidik_utama
 * @property double $jumlah_geran_penyelidik_bersama
 * @property int $bil_geran_penyelidik_utama
 * @property int $bil_geran_penyelidik_bersama
 * @property int $jurnal
 * @property int $buku
 * @property int $bab_dalam_buku
 * @property int $penulis_utama
 * @property int $phd
 * @property int $master
 * @property int $perundingan
 * @property int $late1
 * @property int $late2
 * @property int $late3
 * @property int $absent1
 * @property int $absent2
 * @property int $absent3
 * @property int $incomplete1
 * @property int $incomplete2
 * @property int $incomplete3
 * @property int $total_kehadiran
 * @property string $tahun_kehadiran1
 */
class TblMaklumatlain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.kontrak_tbl_maklumatlain';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kontrak_id', 'kredit_mengajar', 'pelajar', 'bil_geran_penyelidik_utama', 'bil_geran_penyelidik_bersama', 'jurnal', 'buku', 'bab_dalam_buku', 'penulis_utama', 'phd', 'master', 'perundingan', 'late1', 'late2', 'late3', 'absent1', 'absent2', 'absent3', 'incomplete1', 'incomplete2', 'incomplete3', 'total_kehadiran'], 'integer'],
            [['jumlah_geran_penyelidik_utama', 'jumlah_geran_penyelidik_bersama'], 'number'],
            [['tahun_kehadiran1'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kontrak_id' => 'Kontrak ID',
            'kredit_mengajar' => 'Kredit Mengajar',
            'pelajar' => 'Pelajar',
            'jumlah_geran_penyelidik_utama' => 'Jumlah Geran Penyelidik Utama',
            'jumlah_geran_penyelidik_bersama' => 'Jumlah Geran Penyelidik Bersama',
            'bil_geran_penyelidik_utama' => 'Bil Geran Penyelidik Utama',
            'bil_geran_penyelidik_bersama' => 'Bil Geran Penyelidik Bersama',
            'jurnal' => 'Jurnal',
            'buku' => 'Buku',
            'bab_dalam_buku' => 'Bab Dalam Buku',
            'penulis_utama' => 'Penulis Utama',
            'phd' => 'Phd',
            'master' => 'Master',
            'perundingan' => 'Perundingan',
            'late1' => 'Late1',
            'late2' => 'Late2',
            'late3' => 'Late3',
            'absent1' => 'Absent1',
            'absent2' => 'Absent2',
            'absent3' => 'Absent3',
            'incomplete1' => 'Incomplete1',
            'incomplete2' => 'Incomplete2',
            'incomplete3' => 'Incomplete3',
            'total_kehadiran' => 'Total Kehadiran',
            'tahun_kehadiran1' => 'Tahun Kehadiran1',
        ];
    }
}
