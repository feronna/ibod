<?php

namespace app\models\elnpt\elnpt2;

class TblHijau
{
    public $tblhijau;

    function setTbl($bhg9)
    {
        $this->tblhijau = array(
            array(
                array(
                    array("Julat bil pelajar" => "0", "Syarahan" => 0.0, "Tutorial" => 0.0, "Amali/ Lain" => 0.0),
                    array("Julat bil pelajar" => "1 - 30", "Syarahan" => 1.0, "Tutorial" => 0.5, "Amali/ Lain" => 0.5),
                    array("Julat bil pelajar" => "31 - 40", "Syarahan" => 1.0, "Tutorial" => 0.5, "Amali/ Lain" => 1.0),
                    array("Julat bil pelajar" => "41 - 50", "Syarahan" => 1.0, "Tutorial" => 1.0, "Amali/ Lain" => 1.0),
                    array("Julat bil pelajar" => "51 - 60", "Syarahan" => 1.5, "Tutorial" => 1.0, "Amali/ Lain" => 1.0),
                    array("Julat bil pelajar" => "61 - 70", "Syarahan" => 1.5, "Tutorial" => 1.0, "Amali/ Lain" => 1.5),
                    array("Julat bil pelajar" => "71 - 80", "Syarahan" => 1.5, "Tutorial" => 1.0, "Amali/ Lain" => 1.5),
                    array("Julat bil pelajar" => "81 - 90", "Syarahan" => 1.5, "Tutorial" => 1.5, "Amali/ Lain" => 1.5),
                    array("Julat bil pelajar" => "91 - 100", "Syarahan" => 1.5, "Tutorial" => 1.5, "Amali/ Lain" => 2.0),
                    array("Julat bil pelajar" => "> 100", "Syarahan" => 2.0, "Tutorial" => 2.0, "Amali/ Lain" => 2.0)
                ),
                array(
                    array("JULAT PURATA PK07" => "0", "SKOR" => 0.00),
                    array("JULAT PURATA PK07" => "0.1 - 2.0", "SKOR" => 0.50),
                    array("JULAT PURATA PK07" => "2.1 - 3.0", "SKOR" => 0.80),
                    array("JULAT PURATA PK07" => "3.1 - 4.0", "SKOR" => 0.90),
                    array("JULAT PURATA PK07" => "> 4.0", "SKOR" => 1.00)
                ),

                array(
                    array("STATUS Smartv3" => "FAIL", "SKOR" => 0.0),
                    array("STATUS Smartv3" => "PASS", "SKOR" => 1.0)
                ),
                array(
                    array("STATUS FAIL PEMBELAJARAN" => "ADA - LENGKAP", "SKOR" => 1.0),
                    array("STATUS FAIL PEMBELAJARAN" => "ADA - TIDAK LENGKAP", "SKOR" => 0.5),
                    array("STATUS FAIL PEMBELAJARAN" => "TIADA", "SKOR" => 0.0)
                ),


            ),
            array(
                array(
                    array("TAHAP PENYELIAAN" => "PhD (Penyelidikan)", "SEBAGAI PENYELIA UTAMA/ PENGERUSI - BELUM PERLANJUNTAN" => 2.000, "SEBAGAI PENYELIA UTAMA/ PENGERUSI - TELAH PERLANJUTAN (2 SEMESTER ATAU KURANG)" => 1.800, "SEBAGAI PENYELIA UTAMA/ PENGERUSI - TELAH PERLANJUTAN (LEBIH 2 SEMESTER)" => 0.900, "SEBAGAI PENYELIA BERSAMA/ AHLI - BELUM PERLANJUNTAN" => 1.000, "SEBAGAI PENYELIA BERSAMA/ AHLI - TELAH PERLANJUTAN (2 SEMESTER ATAU KURANG)" => 0.900, "SEBAGAI PENYELIA BERSAMA/ AHLI - TELAH PERLANJUTAN (LEBIH 2 SEMESTER)" => 0.450),
                    array("TAHAP PENYELIAAN" => "Sarjana (Penyelidikan)", "SEBAGAI PENYELIA UTAMA/ PENGERUSI - BELUM PERLANJUNTAN" => 1.000, "SEBAGAI PENYELIA UTAMA/ PENGERUSI - TELAH PERLANJUTAN (2 SEMESTER ATAU KURANG)" => 0.900, "SEBAGAI PENYELIA UTAMA/ PENGERUSI - TELAH PERLANJUTAN (LEBIH 2 SEMESTER)" => 0.450, "SEBAGAI PENYELIA BERSAMA/ AHLI - BELUM PERLANJUNTAN" => 0.500, "SEBAGAI PENYELIA BERSAMA/ AHLI - TELAH PERLANJUTAN (2 SEMESTER ATAU KURANG)" => 0.450, "SEBAGAI PENYELIA BERSAMA/ AHLI - TELAH PERLANJUTAN (LEBIH 2 SEMESTER)" => 0.225),
                    array("TAHAP PENYELIAAN" => "DrPH (Doctor of Public Health)", "SEBAGAI PENYELIA UTAMA/ PENGERUSI - BELUM PERLANJUNTAN" => 1.500, "SEBAGAI PENYELIA UTAMA/ PENGERUSI - TELAH PERLANJUTAN (2 SEMESTER ATAU KURANG)" => 1.350, "SEBAGAI PENYELIA UTAMA/ PENGERUSI - TELAH PERLANJUTAN (LEBIH 2 SEMESTER)" => 0.675, "SEBAGAI PENYELIA BERSAMA/ AHLI - BELUM PERLANJUNTAN" => 0.750, "SEBAGAI PENYELIA BERSAMA/ AHLI - TELAH PERLANJUTAN (2 SEMESTER ATAU KURANG)" => 0.675, "SEBAGAI PENYELIA BERSAMA/ AHLI - TELAH PERLANJUTAN (LEBIH 2 SEMESTER)" => 0.338),
                    array("TAHAP PENYELIAAN" => "Sarjana (Kerja Kursus)", "SEBAGAI PENYELIA UTAMA/ PENGERUSI - BELUM PERLANJUNTAN" => 0.500, "SEBAGAI PENYELIA UTAMA/ PENGERUSI - TELAH PERLANJUTAN (2 SEMESTER ATAU KURANG)" => 0.450, "SEBAGAI PENYELIA UTAMA/ PENGERUSI - TELAH PERLANJUTAN (LEBIH 2 SEMESTER)" => 0.225, "SEBAGAI PENYELIA BERSAMA/ AHLI - BELUM PERLANJUNTAN" => 0.250, "SEBAGAI PENYELIA BERSAMA/ AHLI - TELAH PERLANJUTAN (2 SEMESTER ATAU KURANG)" => 0.225, "SEBAGAI PENYELIA BERSAMA/ AHLI - TELAH PERLANJUTAN (LEBIH 2 SEMESTER)" => 0.113),
                    array("TAHAP PENYELIAAN" => "Sarjana Muda (Projek Tahun Akhir/ Latihan Industri/ Latihan Amali/ Praktikum)", "SEBAGAI PENYELIA UTAMA/ PENGERUSI - BELUM PERLANJUNTAN" => 0.250, "SEBAGAI PENYELIA UTAMA/ PENGERUSI - TELAH PERLANJUTAN (2 SEMESTER ATAU KURANG)" => 0.225, "SEBAGAI PENYELIA UTAMA/ PENGERUSI - TELAH PERLANJUTAN (LEBIH 2 SEMESTER)" => 0.113, "SEBAGAI PENYELIA BERSAMA/ AHLI - BELUM PERLANJUNTAN" => 0.125, "SEBAGAI PENYELIA BERSAMA/ AHLI - TELAH PERLANJUTAN (2 SEMESTER ATAU KURANG)" => 0.113, "SEBAGAI PENYELIA BERSAMA/ AHLI - TELAH PERLANJUTAN (LEBIH 2 SEMESTER)" => 0.056)
                )
            ),
            array(
                array(
                    array("PERANAN" => "AHLI", "SKOR" => 0.25),
                    array("PERANAN" => "KETUA", "SKOR" => 1),
                    array("PERANAN" => "MENTOR", "SKOR" => 0.75)
                ), array(
                    array("TAHAP" => "GERAN KEBANGSAAN", "SKOR" => 0.9),
                    array("TAHAP" => "GERAN LUAR (ANTARABANGSA/ INDUSTRI)", "SKOR" => 1.2),
                    array("TAHAP" => "GERAN LUAR (TEMPATAN)", "SKOR" => 1),
                    array("TAHAP" => "GERAN UNIVERSITI", "SKOR" => 0.8)
                ),
                array(
                    array("STATUS GERAN" => "SEDANG BERJALAN & BELUM PERLANJUTAN", "SKOR" => 1),
                    array("STATUS GERAN" => "SEDANG BERJALAN & TELAH PERLANJUTAN", "SKOR" => 0.5),
                    array("STATUS GERAN" => "TAMAT SETELAH PERLANJUTAN", "SKOR" => 0.5),
                    array("STATUS GERAN" => "TAMAT TANPA PERLANJUTAN", "SKOR" => 1)
                ),
                array(
                    array("JULAT AMAUN GERAN" => "RM0 - RM4999", "SKOR (SAINS)" => 0.0, "SKOR (SASTERA)" => 0.0),
                    array("JULAT AMAUN GERAN" => "RM5000 - RM19999", "SKOR (SAINS)" => 0.0, "SKOR (SASTERA)" => 70.0),
                    array("JULAT AMAUN GERAN" => "RM20,000 - RM199,999", "SKOR (SAINS)" => 60.0, "SKOR (SASTERA)" => 80.0),
                    array("JULAT AMAUN GERAN" => "RM200,000 - RM299,999", "SKOR (SAINS)" => 70.0, "SKOR (SASTERA)" => 90.0),
                    array("JULAT AMAUN GERAN" => "RM300,000 - RM399,999", "SKOR (SAINS)" => 80.0, "SKOR (SASTERA)" => 100.0),
                    array("JULAT AMAUN GERAN" => "RM400,000 - RM499,999", "SKOR (SAINS)" => 90.0, "SKOR (SASTERA)" => 100.0),
                    array("JULAT AMAUN GERAN" => "RM500,000 dan ke atas", "SKOR (SAINS)" => 100.0, "SKOR (SASTERA)" => 100.0)
                ),
                array(
                    array("PERANAN" => "1 PERMOHONAN", "SKOR" => 0.1)
                )
            ),
            array(
                array(
                    array("JENIS PENERBITAN" => "BUKU-BAB DALAM BUKU", "SKOR" => 0.50),
                    array("JENIS PENERBITAN" => "BUKU-BUKU (HIMPUNAN ESEI PERSENDIRIAN)", "SKOR" => 0.50),
                    array("JENIS PENERBITAN" => "BUKU-BUKU (ILMIAH)", "SKOR" => 1.30),
                    array("JENIS PENERBITAN" => "BUKU-BUKU (KARYA SUNTINGAN)", "SKOR" => 0.50),
                    array("JENIS PENERBITAN" => "BUKU-BUKU MEWAH", "SKOR" => 0.40),
                    array("JENIS PENERBITAN" => "BUKU-BUKU TEKS (AKADEMIK)", "SKOR" => 0.50),
                    array("JENIS PENERBITAN" => "BUKU-BUKU UMUM (BIDANG KEPAKARAN)", "SKOR" => 1.00),
                    array("JENIS PENERBITAN" => "BUKU-LAPORAN TEKNIKAL / KLINIKAL", "SKOR" => 0.40),
                    array("JENIS PENERBITAN" => "BUKU-MODUL", "SKOR" => 0.50),
                    array("JENIS PENERBITAN" => "BUKU-MONOGRAF", "SKOR" => 1.00),
                    array("JENIS PENERBITAN" => "BUKU-PORTFOLIO", "SKOR" => 0.40),
                    array("JENIS PENERBITAN" => "BUKU-TRANSLATION/ADAPTATION", "SKOR" => 0.40),
                    array("JENIS PENERBITAN" => "DOKUMEN AUTHORITATIF-KERTAS POLISI (DITERIMA)", "SKOR" => 1.30),
                    array("JENIS PENERBITAN" => "JURNAL-ARTIKEL JURNAL BERINDEKS", "SKOR" => 1.00),
                    array("JENIS PENERBITAN" => "JURNAL-ARTIKEL JURNAL TIDAK BERINDEKS", "SKOR" => 0.70),
                    array("JENIS PENERBITAN" => "KURSUS MOOC (MULTIMEDIA-INTERACTIVE)", "SKOR" => 1.10),
                    array("JENIS PENERBITAN" => "PENULISAN KREATIF-BUKU (ANTALOGI CERPEN / PUISI)", "SKOR" => 0.40),
                    array("JENIS PENERBITAN" => "PENULISAN KREATIF-BUKU (KUMPULAN CERPEN)", "SKOR" => 0.70),
                    array("JENIS PENERBITAN" => "PENULISAN KREATIF-BUKU (NOVEL)", "SKOR" => 0.70),
                    array("JENIS PENERBITAN" => "PENULISAN KREATIF-CERPEN", "SKOR" => 0.40),
                    array("JENIS PENERBITAN" => "PENULISAN KREATIF-LAGU (DITERBITKAN)", "SKOR" => 0.40),
                    array("JENIS PENERBITAN" => "PENULISAN KREATIF-PUISI ", "SKOR" => 0.40),
                    array("JENIS PENERBITAN" => "PENULISAN KREATIF-KARYA KREATIF/ GUBAHAN/ CIPTAAN ASLI", "SKOR" => 0.50),
                    array("JENIS PENERBITAN" => "PENULISAN KREATIF-SKRIP DRAMA", "SKOR" => 0.50),
                    array("JENIS PENERBITAN" => "PENULISAN POPULAR-ARTIKEL DALAM AKHBAR, BULETIN, BULETIN PENGEMBANGAN, MAJALAH)", "SKOR" => 0.40),
                    array("JENIS PENERBITAN" => "PROSIDING-PROSIDING (ABSTRACT)", "SKOR" => 0.40),
                    array("JENIS PENERBITAN" => "PROSIDING-PROSIDING (FULL PAPER)", "SKOR" => 0.50),
                    array("JENIS PENERBITAN" => "PROSIDING-PROSIDING BERINDEKS", "SKOR" => 0.70)
                ),
                array(
                    array("STATUS PENULIS" => "CHIEF EDITOR", "SKOR" => 1.20),
                    array("STATUS PENULIS" => "COLLABORATIVE AUTHOR", "SKOR" => 0.80),
                    array("STATUS PENULIS" => "CORRESPONDING AUTHOR", "SKOR" => 1.00),
                    array("STATUS PENULIS" => "EDITOR", "SKOR" => 1.00),
                    array("STATUS PENULIS" => "FIRST AUTHOR", "SKOR" => 1.00),
                    array("STATUS PENULIS" => "TRANSLATOR", "SKOR" => 0.50)
                ),
                array(
                    array("STATUS INDEKS" => "INDEXED BY OTHERS", "SKOR" => 0.50),
                    array("STATUS INDEKS" => "INDEXED BY SCOPUS, WOS, ERA WITH IMPACT FACTOR", "SKOR" => 1.20),
                    array("STATUS INDEKS" => "INDEXED BY SCOPUS, WOS, ERA WITHOUT IMPACT FACTOR", "SKOR" => 1.00),
                    array("STATUS INDEKS" => "NON-INDEXED", "SKOR" => 0.25),
                    array("STATUS INDEKS" => "MALAYSIAN CITATION (MyCite)", "SKOR" => 0.50)
                ),
                array(
                    array("STATUS PENERBITAN" => "PAPER ACCEPTED", "SKOR" => 0.40),
                    array("STATUS PENERBITAN" => "PAPER PUBLISHED", "SKOR" => 1.00)
                )
            ),
            array(
                array(
                    array("KATEGORI" => "KOLOKIUM", "SKOR" => 1),
                    array("KATEGORI" => "PERSIDANGAN", "SKOR" => 1),
                    array("KATEGORI" => "SEMINAR", "SKOR" => 1)
                ),
                array(
                    array("PERANAN" => "AHLI", "SKOR" => 0.5),
                    array("PERANAN" => "INVITED SPEAKER", "SKOR" => 1.1),
                    array("PERANAN" => "KEYNOTE SPEAKER", "SKOR" => 1.2),
                    array("PERANAN" => "PANEL", "SKOR" => 1),
                    array("PERANAN" => "PEMBENTANG", "SKOR" => 1),
                    array("PERANAN" => "PENGERUSI SESI", "SKOR" => 0.8),
                    array("PERANAN" => "PESERTA", "SKOR" => 0.5),
                    array("PERANAN" => "PLENARY SPEAKER", "SKOR" => 1.3)
                ),
                array(
                    array("TAHAP PENYERTAAN" => "ANTARABANGSA", "SKOR" => 1.20),
                    array("TAHAP PENYERTAAN" => "KEBANGSAAN", "SKOR" => 1.00),
                    array("TAHAP PENYERTAAN" => "NEGERI", "SKOR" => 0.70),
                    array("TAHAP PENYERTAAN" => "UNIVERSITI", "SKOR" => 0.50),
                    array("TAHAP PENYERTAAN" => "FAKULTI", "SKOR" => 0.50)
                )
            ), array(
                array(
                    array("KATEGORI OUTREACHING" => "ANUGERAH", "SKOR" => 1),
                    array("KATEGORI OUTREACHING" => "KHIDMAT MASYARAKAT", "SKOR" => 1),
                    array("KATEGORI OUTREACHING" => "PERUNDINGAN", "SKOR" => 1),
                    array("KATEGORI OUTREACHING" => "SANJUNGAN DAN KEPAKARAN", "SKOR" => 1)
                ),
                array(
                    array("PERANAN" => "AHLI - BERJAWATAN", "SKOR" => 0.80),
                    array("PERANAN" => "AHLI - BIASA", "SKOR" => 0.50),
                    array("PERANAN" => "EDITOR/GUEST EDITOR", "SKOR" => 1.00),
                    array("PERANAN" => "KETUA", "SKOR" => 1.00),
                    array("PERANAN" => "KEYNOTE SPEAKER/PANEL", "SKOR" => 1.00),
                    array("PERANAN" => "PANEL PENILAI", "SKOR" => 1.00),
                    array("PERANAN" => "PEMBENTANG", "SKOR" => 1.00),
                    array("PERANAN" => "PENCERAMAH", "SKOR" => 1.00),
                    array("PERANAN" => "PENERIMA ANUGERAH (PENGAJARAN/PENYELIAAN/PENYELIDIKAN/PENERBITAN/PERSIDANGAN & INOVASI)", "SKOR" => 1.00),
                    array("PERANAN" => "PENGERUSI JAWATANKUASA", "SKOR" => 1.20),
                    array("PERANAN" => "PENGERUSI VIVA VOCE (PASCASISWAZAH)", "SKOR" => 1.20),
                    array("PERANAN" => "PENILAI KENAIKAN PANGKAT AKADEMIK", "SKOR" => 1.00),
                    array("PERANAN" => "PENILAI TESIS DALAM (INTERNAL)", "SKOR" => 1.00),
                    array("PERANAN" => "PENILAI TESIS LUAR (EXTERNAL)", "SKOR" => 1.20),
                    array("PERANAN" => "PERUNDING", "SKOR" => 0.50),
                    array("PERANAN" => "PESERTA", "SKOR" => 0.50),
                    array("PERANAN" => "REVIEWER (INDEXED JOURNAL BY SCOPUS, WOS, ERA)", "SKOR" => 1.20),
                    array("PERANAN" => "REVIEWER (NON-INDEXED JOURNAL)", "SKOR" => 0.80),
                    array("PERANAN" => "TIMBALAN PENGERUSI/SETIAUSAHA/BENDAHARI/TIMBALAN SETIAUSAHA", "SKOR" => 0.80)
                ),
                array(
                    array("TAHAP" => "ANTARABANGSA", "SKOR" => 1.20),
                    array("TAHAP" => "DAERAH", "SKOR" => 0.60),
                    array("TAHAP" => "KEBANGSAAN", "SKOR" => 1.00),
                    array("TAHAP" => "KOMUNITI SETEMPAT", "SKOR" => 0.60),
                    array("TAHAP" => "NEGERI", "SKOR" => 0.80),
                    array("TAHAP" => "SEKOLAH", "SKOR" => 0.20),
                    array("TAHAP" => "UNIVERSITI", "SKOR" => 0.40),
                    array("TAHAP PENYERTAAN" => "FAKULTI", "SKOR" => 0.40)
                ), array(
                    array("JULAT JUMLAH AMAUN " => "RM0 - RM1999", "SKOR" => 0.0),
                    array("JULAT JUMLAH AMAUN " => "RM2000 - RM4999", "SKOR" => 80.0),
                    array("JULAT JUMLAH AMAUN " => "RM5000 - RM24999", "SKOR" => 90.0),
                    array("JULAT JUMLAH AMAUN " => "≥RM25000 ", "SKOR" => 100.0)
                )
            ),
            array(
                array(
                    array("KATEGORI" => "BADAN BUKAN KERAJAAN (AKADEMIK)", "SKOR" => 0.70),
                    array("KATEGORI" => "BADAN PROFESIONAL (AKADEMIK)", "SKOR" => 0.90),
                    array("KATEGORI" => "PENGANJURAN PROGRAM AKADEMIK (PERSIDANGAN, BENGKEL, ETC.)", "SKOR" => 0.90),
                    array("KATEGORI" => "PENGANJURAN PROGRAM BUKAN AKADEMIK", "SKOR" => 0.70),
                    array("KATEGORI" => "PENTADBIRAN (LANTIKAN NC & KE ATAS)", "SKOR" => 1.00),
                    array("KATEGORI" => "PENTADBIRAN (LANTIKAN TNC/ DEKAN/ PENGARAH)", "SKOR" => 0.8)
                ), array(
                    array("PERANAN" => "AHLI", "SKOR" => 0.70),
                    array("PERANAN" => "JAWATAN BERELAUN DI UNIVERSITI", "SKOR" => 1.20),
                    array("PERANAN" => "PENASIHAT", "SKOR" => 0.90),
                    array("PERANAN" => "PENGERUSI/TIMBALAN/SETIAUSAHA/BENDAHARI/KETUA", "SKOR" => 1.00),
                    array("PERANAN" => "PENYELARAS", "SKOR" => 0.80)
                ),
                array(
                    array("TAHAP" => "ANTARABANGSA", "SKOR" => 1.20),
                    array("TAHAP" => "DAERAH", "SKOR" => 0.70),
                    array("TAHAP" => "FAKULTI/INSTITUT/PUSAT", "SKOR" => 0.50),
                    array("TAHAP" => "KEBANGSAAN", "SKOR" => 1.00),
                    array("TAHAP" => "NEGERI", "SKOR" => 0.80),
                    array("TAHAP" => "UNIVERSITI", "SKOR" => 0.60)
                )
            ),
            array(
                array(
                    array("KATEGORI " => "COPYRIGHT", "SKOR" => 0.4),
                    array("KATEGORI " => "PERTANDINGAN INOVASI", "SKOR" => 0.4),
                    array("KATEGORI " => "INDUSTRIAL DESIGN", "SKOR" => 0.5),
                    array("KATEGORI " => "PATENT", "SKOR" => 1),
                    array("KATEGORI " => "PEMFAILAN PATENT", "SKOR" => 0.8),
                    array("KATEGORI " => "TRADE SECRET", "SKOR" => 0.4),
                    array("KATEGORI " => "TRADEMARK", "SKOR" => 0.6)
                ),
                array(
                    array("PERANAN" => "AHLI", "SKOR" => 0.50),
                    array("PERANAN" => "AJK TERTINGGI", "SKOR" => 0.60),
                    array("PERANAN" => "KETUA", "SKOR" => 1.00),
                    array("PERANAN" => "PENOLONG KETUA", "SKOR" => 0.70)
                ),
                array(
                    array("TAHAP" => "ANTARABANGSA", "SKOR" => 1.20),
                    array("TAHAP" => "KEBANGSAAN", "SKOR" => 1.00),
                    array("TAHAP" => "NEGERI", "SKOR" => 0.80),
                    array("TAHAP" => "UNIVERSITI", "SKOR" => 0.70)
                ),
                array(
                    array("BILANGAN INDIVIDU" => "TIADA ", "SKOR" => 0.0),
                    array("BILANGAN INDIVIDU" => " 1 - 30 ORANG", "SKOR" => 0.6),
                    array("BILANGAN INDIVIDU" => "31 - 60 ORANG", "SKOR" => 0.8),
                    array("BILANGAN INDIVIDU" => "> 60 ORANG", "SKOR" => 1.0)
                ),
                array(
                    array("JULAT AMAUN" => "RM0.00", "SKOR" => 0.0),
                    array("JULAT AMAUN" => "RM20,000 - RM39,999", "SKOR" => 60.0),
                    array("JULAT AMAUN" => "RM40,000 - RM59,999", "SKOR" => 70.0),
                    array("JULAT AMAUN" => "RM60,000 - RM79,999", "SKOR" => 80.0),
                    array("JULAT AMAUN" => "RM80,000 - RM99,999", "SKOR" => 90.0),
                    array("JULAT AMAUN" => "LEBIH RM100,000", "SKOR" => 100.0)
                )
            ),
            array(array(
                array("BILANGAN KEPIMPINAN" => "0", "GRED DS45" => 0.00, "DG41/ DG44" => 0.00, "DG48" => 0.00, "GRED DS51/DS52/DG52/DU51/DU52" => 0.00, "GRED DS53/DS54/DG54/DU54/DU56" => 0.00, "GRED VK" => 0.00),
                array("BILANGAN KEPIMPINAN" => "1 KEPIMPINAN", "GRED DS45" => 1.00, "DG41/ DG44" => 1.00, "DG48" => 0.90, "GRED DS51/DS52/DG52/DU51/DU52" => 0.90, "GRED DS53/DS54/DG54/DU54/DU56" => 0.90, "GRED VK" => 0.80),
                array("BILANGAN KEPIMPINAN" => "2 KEPIMPINAN", "GRED DS45" => 1.00, "DG41/ DG44" => 1.00, "DG48" => 1.00, "GRED DS51/DS52/DG52/DU51/DU52" => 1.00, "GRED DS53/DS54/DG54/DU54/DU56" => 1.00, "GRED VK" => 0.90),
                array("BILANGAN KEPIMPINAN" => ">2 KEPIMPINAN", "GRED DS45" => 1.00, "DG41/ DG44" => 1.00, "DG48" => 1.00, "GRED DS51/DS52/DG52/DU51/DU52" => 1.00, "GRED DS53/DS54/DG54/DU54/DU56" => 1.00, "GRED VK" => 1.00)
            )),
            array(array(
                array("PENILAI" => "PPP", "PEMBERAT" => isset($bhg9) ? 0.6 : 0.40),
                array("PENILAI" => "PPK", "PEMBERAT" => isset($bhg9) ? 0.6 : 0.40),
                array("PENILAI" => "PEER", "PEMBERAT" => isset($bhg9) ? 0.3 : 0.20),
            ),),
            array(
                array(
                    array("Julat jam" => "0 jam setahun", "SKOR" => 0),
                    array("Julat jam" => "Kurang daripada 80 jam setahun", "SKOR" => 0.5),
                    array("Julat jam" => "81 - 140  jam setahun", "SKOR" => 0.6),
                    array("Julat jam" => "141 - 200 jam setahun", "SKOR" => 0.7),
                    array("Julat jam" => "201 - 260 jam setahun", "SKOR" => 0.8),
                    array("Julat jam" => "261 - 320 jam setahun", "SKOR" => 0.9),
                    array("Julat jam" => "Lebih daripada 320 jam setahun", "SKOR" => 1)
                ),
                // array(
                //     array("Julat jam" => "0 jam setahun", "SKOR" => 0),
                //     array("Julat jam" => "Kurang daripada 40 jam setahun", "SKOR" => 0.75),
                //     array("Julat jam" => "41 - 70  jam setahun", "SKOR" => 0.8),
                //     array("Julat jam" => "71 - 100 jam setahun", "SKOR" => 0.85),
                //     array("Julat jam" => "101 - 130 jam setahun", "SKOR" => 0.9),
                //     array("Julat jam" => "131 - 160 jam setahun", "SKOR" => 0.95),
                //     array("Julat jam" => "Lebih daripada 160 jam setahun", "SKOR" => 1)
                // ),

                array(
                    array("APC" => "TIDAK", "SKOR" => "0"),
                    array("APC" => "YA", "SKOR" => "1")
                )
            )
        );
    }

    function getTable($bhg_no, $bhg9 = null)
    {
        $this->setTbl($bhg9);
        return $this->tblhijau[$bhg_no];
    }

    function Bhg11or1($bahagian)
    {
        if ($bahagian->id == 11) {
            $bhgg = 11;
        } else if ($bahagian->id == 1) {
            $bhgg = 1;
        } else {
            $bhgg = null;
        }

        return $bhgg;
    }
}
