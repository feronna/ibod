
<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid black;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>
<center><i style="color:red">--- This email is auto generate ---</i></center>

<p>Salam Sejahtera,<br/>
    
    <br>Dr./Tuan/Puan,<br>
  Dengan segala hormatnya saya di arah untuk merujuk kepada perkara di atas.<br>
<p>
    Mengikut rekod Unit Pengembangan Profesionalisme, Seksyen Kemajuan Kerjaya, Bahagian Sumber Manusia,
    Jabatan Pendaftar, tempoh cuti belajar tuan/puan akan tamat pada: <br>
    
    <b>
        <?php if($model->la)
        {
            echo  strtoupper($model->la->ndlanjutan);
        }
        else
        {
            echo strtoupper($model->tarikhtamat);
        }?>


   
</p>

<br>
<p>
   02. Berdasarkan rekod, tuan/puan adalah tidak diluluskan pelanjutan tempoh cuti belajar dan  
       Sehubungan itu, tuan adalah dikehendaki melapor diri bertugas pada 
       <b> <?php
       $tamat = date('Y-m-d', strtotime("+1 days", strtotime($model->tarikh_tamat)));
       echo $tamat;?> </b>
       
       Mohon Lapor diri dengan Ketua Jabatan JFPIB dan isi borang lapor diri secara atas talian seperti berikut:
</p>

<br>
  1. <a href="https://registrar.ums.edu.my/staff/web">
    LOGIN HRv4</a>
    <br>
    
   2. Klik <a href="https://registrar.ums.edu.my/staff/web/cutibelajar/halaman-pemohon">
      Pengajian Lanjutan</a>
   <br>
   3. Klik <a href="https://registrar.ums.edu.my/staff/web/cutibelajar/senarai-borang-lapor">
      Menu Lapor Diri Kembali Bertugas</a> untuk tindakan selanjutnya. 
<br>


   
Sekiranya ada pertanyaan mengenai sistem, jangan ragu untuk 
hubungi kami di maklumat yang tertera di bawah:
<br>

<p align="center"><b>Encik Goraid J. John</b><br>
    Pembantu Tadbir (P/O) <br>
    <a href=mailto:<nowiki> goraidj.john@ums.edu.my</a> <br/>
<b>Cik Nor Fazleenawana binti Awang Latiff</b><br>
    Penolong Pegawai Teknologi Maklumat<br>
    <a href=mailto:<nowiki> norfazleenawana@ums.edu.my</a></p>

    
  Terima Kasih.
