<?php

namespace app\models\lppums\v2;

use Yii;

/**
 * This is the model class for table "hrm.lppums_v2_ref_aspek".
 *
 * @property int $id
 * @property int $bahagian_id
 * @property int $aspek_order
 * @property string $aspek_label
 * @property string $aspek_desc
 */
class RefAspek extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrm.lppums_v2_ref_aspek';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bahagian_id', 'aspek_order'], 'integer'],
            [['aspek_label'], 'string', 'max' => 100],
            [['aspek_desc'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bahagian_id' => 'Bahagian ID',
            'aspek_order' => 'Aspek Order',
            'aspek_label' => 'Aspek Label',
            'aspek_desc' => 'Aspek Desc',
        ];
    }

    static public function aspekInfo($id)
    {
        switch ($id) {
            case 1:
                return '<p><strong>OUTPUT 1 : </strong><strong>SISTEM MAKLUMBALAS OPERASI UMS (SMO-UMS)</strong></p>
                <ol>
                <li>Tindakan penambahbaikan ke atas maklumbalas di dalam SMO-UMS.</li>
                </ol>
                <p><strong>OUTPUT 2 : PENETAPAN KPI DARI SEGI </strong><strong>JUMLAH, BILANGAN, KADAR DAN KEKERAPAN</strong></p>
                <ol>
                <li>Nyatakan sasaran KPI yang telah dipersetujui bersama PPP dan PPK.</li>
                
                </ol>
                <p><strong>DOKUMEN SOKONGAN :</strong></p>
                <ul>
                <li>Laporan Output Bulanan Unit/ Seksyen/ Sektor/ Bahagian (format adalah mengikut keperluan dan kelulusan Ketua Jabatan).</li>
                </ul>';
            case 2:
                return '<p><strong>OUTPUT 1 : </strong><strong>SISTEM MAKLUMBALAS OPERASI UMS (SMO-UMS)</strong></p>

                <ol>
                
                <li>Tindakan penambahbaikan ke atas maklumbalas di dalam SMO-UMS.</li>
                
                </ol>
                
                <p><strong>OUTPUT 2 : LAPORAN PERSIAPAN AUDIT (APO/ EKSA/ MQA/ OSHA/ ISO dan LAIN-LAIN)</strong></p>
                
                <ol>
                
                <li>Nyatakan status/ maklumat berkaitan seperti: mesyuarat, penyediaan dokumen, tindakan ke atas laporan audit lepas, dan lain-lain.</li>
                
                <li>Tindakan ke atas laporan/ teguran audit lepas.</li>
                
                
                
                </ol>
                
                <p><strong>DOKUMEN SOKONGAN:</strong></p>
                
                <ul>
                
                <li>Laporan audit lepas berserta tindakan penambahbaikan.</li>
                
                <li>Minit mesyuarat yang berkaitan.</li>
                
                <li>Dokumen lain yang berkaitan.</li>
                
                </ul>
                
                <p><strong>OUTPUT 3 : PENGIKTIRAFAN</strong></p>
                
                <ol>
                
                <li>Nyatakan sebarang bentuk pengiktirafan yang diterima. Contoh: anugerah, penghargaan, jemputan penceramah, dll.</li>
                
                
                
                </ol>
                
                <p><strong>DOKUMEN SOKONGAN:</strong></p>
                
                <ul>
                
                <li>Surat lantikan/ surat jemputan/ sijil penghargaan.</li>
                
                <li>Dokumen lain yang berkaitan.</li>
                
                </ul>';
            case 13:
                return '<p><strong>OUTPUT 1 : </strong><strong>SISTEM MAKLUMBALAS OPERASI UMS (SMO-UMS)</strong></p>
                <ol>
                <li>Tindakan penambahbaikan ke atas maklumbalas di dalam SMO-UMS.</li>
                </ol>
                <p><strong>OUTPUT 2 : INISIATIF</strong></p>
                <ol>
                <li>Sebarang inisiatif yang memberi kesan positif kepada kecekapan perkhidmatan PTJ PYD (contoh: penubuhan JK, taskforce, soal selidik, kajian, kemaskini TOR/garis panduan, penerbitan dokumen (tidak bersifat pertandingan).</li>
                
                </ol>
                <p><strong>DOKUMEN SOKONGAN:</strong></p>
                <ul>
                <li>Surat lantikan/ minit mesyuarat/ laporan.</li>
                <li>Dokumen lain yang berkaitan.</li>
                </ul>';
            case 4:
                return '<p><strong>OUTPUT 1 : </strong><strong>SISTEM MAKLUMBALAS OPERASI UMS (SMO-UMS)</strong></p>

                <ol>
                
                <li>Tindakan penambahbaikan ke atas maklumbalas di dalam SMO-UMS.</li>
                
                </ol>
                
                <p><strong>OUTPUT 2 : PENCAPAIAN PIAGAM PELANGGAN</strong></p>
                
                <ol>
                
                <li>Tugasan utama yang perlu dilaksanakan mengikut tempoh masa yang ditetapkan di dalam piagam pelanggan.</li>
                
                <li>Tugasan lain yang perlu dilaksanakan mengikut tempoh masa yang diarahkan oleh Ketua Jabatan dan/ atau pihak pengurusan.</li>
                
                
                
                </ol>
                
                <p><strong>DOKUMEN SOKONGAN:</strong></p>
                
                <ul>
                
                <li>Laporan pencapaian piagam pelanggan.</li>
                
                <li>Surat arahan melaksanakan tugas.</li>
                
                <li>Dokumen lain yang berkaitan.</li>
                
                </ul>';
            case 5:
                return '<p><strong>OUTPUT 1 : </strong><strong>SISTEM MAKLUMBALAS OPERASI UMS (SMO-UMS)</strong></p>
                <ol>
                <li>Tindakan penambahbaikan ke atas maklumbalas di dalam SMO-UMS.</li>
                </ol>
                <p><strong>OUTPUT 2 : </strong><strong>MAKLUMBALAS KETUA JABATAN DAN PELANGGAN</strong></p>
                <ol>
                <li>Tindakan ke atas aduan dalam laporan JK Pemantau Aduan.</li>
                <li>Tindakan ke atas maklumbalas dalam laporan JK Pengurusan Pelanggan.</li>
                
                </ol>
                <p><strong>DOKUMEN SOKONGAN:</strong></p>
                <ul>
                <li>Laporan penambahbaikan/ minit mesyuarat.</li>
                <li>Dokumen lain yang berkaitan.</li>
                </ul>
                <p><strong>OUTPUT 3 : </strong><strong>PENCAPAIAN KRA</strong></p>
                <ol>
                <li>Sasaran dan pencapaian <em>Performance Indicator</em> (PI) dalam KRA-UMS (yang berkaitan dengan tugas PYD).</li>
                
                </ol>
                <p><strong>DOKUMEN SOKONGAN:</strong></p>
                <ul>
                <li>Dokumen KRA yang berkaitan.</li>
                <li>Dokumen lain yang berkaitan.</li>
                </ul>';
            case 10:
                return '<p><strong>OUTPUT 1 : </strong><strong>SISTEM MAKLUMBALAS OPERASI UMS (SMO-UMS)</strong></p>
                <ol>
                <li>Tindakan penambahbaikan ke atas maklumbalas di dalam SMO-UMS.</li>
                </ol>
                <p><strong>OUTPUT 2 : </strong><strong>PENGISIAN DAN PENILAIAN BESA UMS (PENGURUSAN &amp; PROFESIONAL)</strong></p>
                <p><em>Ringkasan nota : Data akan ditarik daripada sistem BESA UMS pada bulan Disember.</em></p>
                <ol>
                <li>Penilaian minimum:<br />Gred 41-44 = tahap 3<br />Gred 48 = tahap 3 <span>(leadership)</span><br />Gred 52-54 = tahap 4 <span>(leadership)</span></li>
                </ol>
                <p><strong>DOKUMEN SOKONGAN:</strong></p>
                <ul>
                <li>Laporan penilaian BESA UMS.</li>
                </ul>
                <br/>
                <p style="color:red;"><strong><em>(UNTUK KUMPULAN PELAKSANA)</em></strong></p>
                <p></p>
                <p><strong>OUTPUT 1 : </strong><strong>SISTEM MAKLUMBALAS OPERASI UMS (SMO-UMS)</strong></p>
                <ol>
                <li>Tindakan penambahbaikan ke atas maklumbalas di dalam SMO-UMS.</li>
                </ol>
                <p></p>
                <p><strong>OUTPUT 2 : </strong><strong>LAPORAN KEBERKESANAN MENGHADIRI KURSUS (PENILAIAN KETUA JABATAN)</strong></p>
                <p><em>Ringkasan nota : Data akan ditarik daripada sistem MyIDP pada bulan Disember.</em></p>
                <ol>
                <li>Mendapat skala 4 atau 5 dalam penilaian oleh Ketua Jabatan selepas menghadiri kursus.</li>
                </ol>
                <p><strong>DOKUMEN SOKONGAN:</strong></p>
                <ul>
                <li>Laporan selepas menghadiri kursus.</li>
                </ul>';
            case 11:
                return '<p><strong>OUTPUT 1 : </strong><strong>SISTEM MAKLUMBALAS OPERASI UMS (SMO-UMS)</strong></p>

                <ol>
                
                <li>Tindakan penambahbaikan ke atas maklumbalas di dalam SMO-UMS.</li>
                
                </ol>
                
                <p><strong>OUTPUT 2 : LAPORAN KE-TAKAKURAN OUTPUT</strong></p>
                <p><em>Ringkasan nota : Data akan ditarik daripada sistem Laporan Ke-Takakuran Kakitangan.</em></p>
                
                <ol>
                
                <li>Laporan NCR semua jenis audit universiti.</li>
                
                <li>Pemberian NCR kepada individu.</li>
                
                <li>Surat teguran.</li>
                
                </ol>
                
                <p><strong>DOKUMEN SOKONGAN:</strong></p>
                
                <ul>
                
                <li>Laporan/ minit mesyuarat/ surat teguran.</li>
                
                <li>Dokumen lain yang berkaitan.</li>
                
                </ul>';
            case 12:
                return '<p><strong>OUTPUT 1 : </strong><strong>SISTEM MAKLUMBALAS OPERASI UMS (SMO-UMS)</strong></p>
                <ol>
                <li>Tindakan penambahbaikan ke atas maklumbalas di dalam SMO-UMS.</li>
                </ol>
                <p><strong>OUTPUT 2 : INFOGRAFIK BERKENAAN FUNGSI PYD</strong></p>
                <ol>
                <li>Penghasilan poster dan infografik berkaitan fungsi PYD.</li>
                <li>Slide taklimat yang dihasilkan berkaitan fungsi PYD.</li>
                </ol>
                <p><strong>DOKUMEN SOKONGAN:</strong></p>
                <ul>
                <li>Poster/ infografik/ slide pembentangan.</li>
                <li>Dokumen lain yang berkaitan.</li>
                </ul>';

            case 3:
                return '<p><strong>OUTPUT 1 : </strong><strong>SISTEM MAKLUMBALAS OPERASI UMS (SMO-UMS)</strong></p>

                <ol>
                
                <li>Tindakan penambahbaikan ke atas maklumbalas di dalam SMO-UMS.</li>
                
                </ol>
                
                <p><strong>OUTPUT 2 : PERANCANGAN DAN HALATUJU</strong></p>
                
                <ol>
                
                <li>Usaha penambahbaikan penyampaian perkhidmatan yang berkaitan dengan fungsi dan skop tugas PYD.</li>
                
                </ol>
                
                <p><strong>DOKUMEN SOKONGAN:</strong></p>
                
                <ul>
                
                <li>Slide pembentangan/ laporan cadangan penambahbaikan.</li>
                
                <li>Dokumen lain yang berkaitan.</li>
                
                </ul>';
            case 6:
                return '<p><strong>OUTPUT 1 : </strong><strong>SISTEM MAKLUMBALAS OPERASI UMS (SMO-UMS)</strong></p>
                <ol>
                <li>Tindakan penambahbaikan ke atas maklumbalas di dalam SMO-UMS.</li>
                </ol>
                <p><strong>OUTPUT 2 : </strong><strong>PENGURUSAN ASET/ FASILITI/ PENYELENGGARAAN/ KEWANGAN/ SUMBER MANUSIA/ PERKHIDMATAN.</strong></p>
                <ol>
                <li>Nyatakan sebarang inisiatif yang akan dilaksanakan bagi menunjukkan kebolehan mengelola sumber.</li>
                <li>Laporan JK yang berkaitan dengan fungsi dan skop tugas PYD.</li>
                <li>JK Pemantau Aduan.</li>
                <li>JK Pengurusan Pelanggan.</li>
                <li>JK Audit Ruang UMS.</li>
                <li>JK Pengurusan Aset Universiti.</li>
                </ol>
                <p><strong>DOKUMEN SOKONGAN:</strong></p>
                <ul>
                <li>Slide pembentangan/ laporan cadangan penambahbaikan.</li>
                <li>Laporan JK yang berkaitan.</li>
                <li>Dokumen lain yang berkaitan.</li>
                </ul>
                <p><strong>OUTPUT 3 : </strong><strong>PENGURUSAN PROJEK</strong></p>
                <ol>
                <li>Keurusetiaan (peranan dan tahap penglibatan) dalam pelaksanaan sebarang projek atau aktiviti.</li>
                <li>Membuat penilaian keberkesanan pelaksanaan projek atau aktiviti.</li>
                </ol>
                <p><strong>DOKUMEN SOKONGAN:</strong></p>
                <ul>
                <li>Surat lantikan/ surat arahan bertugas.</li>
                <li>Laporan post-mortem projek atau aktiviti.</li>
                <li>Dokumen lain yang berkaitan.</li>
                </ul>';
            case 7:
                return '<p><strong>OUTPUT 1 : </strong><strong>SISTEM MAKLUMBALAS OPERASI UMS (SMO-UMS)</strong></p>
                <ol>
                <li>Tindakan penambahbaikan ke atas maklumbalas di dalam SMO-UMS.</li>
                </ol>
                <p><strong>OUTPUT 2 : </strong><strong>PEMATUHAN PERATURAN</strong></p>
                <p><em>Ringkasan nota : Data akan ditarik daripada sistem STARS UMS, rekod saman keselamatan dan sistem Laporan Ke-Takakuran Kakitangan.</em></p>
                <ol>
                <li>Rekod kehadiran daripada sistem STARS UMS.</li>
                <li>Rekod saman daripada Bahagian Keselamatan UMS.</li>
                <li>Surat teguran/ peringatan</li>
                <li>Rekod kesalahan tatatertib.</li>
                </ol>
                <p><strong>DOKUMEN SOKONGAN:</strong></p>
                <ul>
                <li>Dokumen yang berkaitan.</li>
                </ul>
                <p><strong>NOTA:</strong></p>
                <ol>
                <li>Rekod kesalahan tatatertib &ndash; jika disabitkan kesalahan tatatertib dan mahkahmah (kesalahan jenayah sahaja), secara automatik PYD tidak mendapat sebarang markah untuk kategori DISIPLIN.</li>
                <li>Surat teguran/ peringatan/ tunjuk sebab berkaitan disiplin (yang disabitkan bersalah) tolak 1 markah.</li>
                <li>PTJ mengemukakan kepada BSM untuk memuat naik sebarang surat teguran/ peringatan/ tunjuk sebab berkaitan disiplin.</li>
                <li>Setiap saman tidak dapat diselesaikan dalam tempoh yang ditetapkan tolak 0.5 markah (saman UMS sahaja).</li>
                <li>Rekod kehadiran daripada sistem STARS UMS - <em>Rekod kehadiran bertugas ditetapkan berdasarkan Sistem Warna Kad Perakam Waktu dalam Garis Panduan Merekod Kehadiran Bekerja Melalui Sistem Kehadiran Atas Talian atau Staff Recording Attendance System (STARS) Universiti Malaysia Sabah (UMS) Tahun 2019:</em></li>
                </ol>
                <table class="table table-sm table-bordered text-center align-middle" width="779">
                <tbody>
                <tr>
                <td width="156" >
                <p><strong>Warna Kad</strong></p>
                </td>
                <td width="156">
                <p><strong>Cemerlang</strong></p>
                </td>
                <td width="156">
                <p><strong>Memuaskan</strong></p>
                </td>
                <td width="156">
                <p><strong>Tidak Memuaskan</strong></p>
                </td>
                <td width="156">
                <p><strong>Sangat Tidak Memuaskan</strong></p>
                </td>
                </tr>
                <tr>
                <td width="156" class="warning">
                <p><strong>Kuning</strong></p>
                </td>
                <td width="156">
                <p>12 kali</p>
                </td>
                <td width="156"></td>
                <td width="156"></td>
                <td width="156"></td>
                </tr>
                <tr>
                <td width="156" class="success">
                <p><strong>Hijau</strong></p>
                </td>
                <td width="156"></td>
                <td width="156">
                <p>1 - 2 kali</p>
                </td>
                <td width="156">
                <p>3 kali atau lebih</p>
                </td>
                <td width="156"></td>
                </tr>
                <tr>
                <td width="156" class="danger">
                <p><strong>Merah</strong></p>
                </td>
                <td width="156"></td>
                <td width="156"></td>
                <td width="156"></td>
                <td width="156">
                <p>1 kali atau lebih</p>
                </td>
                </tr>
                </tbody>
                </table>
                <table class="table table-sm table-bordered text-center align-middle">
                <tbody>
                <tr>
                <td colspan="2" width="421">
                <p><strong>JADUAL RUBRIK PEMBERIAN MARKAH</strong></p>
                </td>
                </tr>
                <tr>
                <td width="251" class="col-md-2">
                <p><strong>PRESTASI KEHADIRAN</strong></p>
                </td>
                <td width="170">
                <p><strong>MARKAH</strong></p>
                </td>
                </tr>
                <tr>
                <td width="251">
                <p>Cemerlang</p>
                </td>
                <td width="170">
                <p>5</p>
                </td>
                </tr>
                <tr>
                <td width="251">
                <p>Memuaskan</p>
                </td>
                <td width="170">
                <p>4</p>
                </td>
                </tr>
                <tr>
                <td width="251">
                <p>Tidak Memuaskan</p>
                </td>
                <td width="170">
                <p>2</p>
                </td>
                </tr>
                <tr>
                <td width="251">
                <p>Sangat Tidak Memuaskan</p>
                </td>
                <td width="170">
                <p>1</p>
                </td>
                </tr>
                </tbody>
                </table>';
            case 8:
                return '<p><strong>OUTPUT 1 : </strong><strong>SISTEM MAKLUMBALAS OPERASI UMS (SMO-UMS)</strong></p>

                <ol>
                
                <li>Tindakan penambahbaikan ke atas maklumbalas di dalam SMO-UMS.</li>
                
                </ol>
                
                <p><strong>OUTPUT 2 : </strong><strong>PENYERTAAN DALAM PERTANDINGAN BERSIFAT INOVASI</strong></p>
                
                <ol>
                
                <li>Penyertaan dalam pertandingan bersifat inovasi (peringkat PTJ/ Universiti/ Negeri/ Kebangsaan/ Antarabangsa).</li>
                
                <li>Contoh penyertaan - LEAN, KIK Horizon Baharu, Team Excellence, DIY, PEREKA, APO, EKSA, AISA, i-SAS, dan lain-lain.<br /><br /></li>
                
                </ol>
                
                <p><strong>DOKUMEN SOKONGAN:</strong></p>
                
                <ul>
                
                <li>Slide pembentangan.</li>
                
                <li>Sijil/ surat penyertaan.</li>
                
                <li>Sijil/ surat penghargaan.</li>
                
                <li>Dokumen lain yang berkaitan.</li>
                
                </ul>';
            case 9:
                return '<p><strong>OUTPUT 1 : </strong><strong>SISTEM MAKLUMBALAS OPERASI UMS (SMO-UMS)</strong></p>
                <ol>
                <li>Tindakan penambahbaikan ke atas maklumbalas di dalam SMO-UMS.</li>
                </ol>
                <p><strong>OUTPUT 2 : </strong><strong>PENYERTAAN DALAM AKTIVITI RASMI UNIVERSITI</strong></p>
                <p><em>Ringkasan nota : Data akan ditarik daripada sistem MyIDP dalam kategori UMUM.</em></p>
                <ol>
                <li>Penglibatan dalam aktiviti bersifat <em>bonding, engagement, synergy</em> (contoh: sukan, riadah, aktiviti rasmi universiti, <em>townhall,</em> jerayawara, hari bertemu pelanggan, <em>team building</em>, gotong royong, aktiviti kerohanian dan lain-lain).</li>
                <li>Aktiviti hendaklah yang didaftarkan dalam sistem MyIDP UMS (kategori UMUM).</li>
                </ol>
                <p><strong>DOKUMEN SOKONGAN:</strong></p>
                <ul>
                <li>Maklumat diperoleh daripada Sistem MyIDP UMS.</li>
                </ul>';
            default:
                return '';
        };
    }
}
