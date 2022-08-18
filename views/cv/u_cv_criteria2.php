<?php
//use yii\helpers\Html;
//use kartik\form\ActiveForm;
//use kartik\select2\Select2;
//use yii\helpers\ArrayHelper;
//use dosamigos\datepicker\DatePicker;
//use dosamigos\tinymce\TinyMce;
?> 
<?php echo $this->render('menu'); ?> 
<div class="x_panel"> 
    <div class="x_title">
        <h2>MAKLUMAT PERMOHONAN</h2> 
        <div class="clearfix"></div>
    </div> 
    <div class="x_content">  
        <div class="table-responsive">
            
<table class="table table-sm table-bordered jambo_table table-striped">
  <tr>
    <th colspan="2">MAKLUMAT CALON</th>
  </tr>
  <tr>
    <td>Gelaran</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>UMSPER</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jawatan</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>JFPIU Semasa</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Kampus Semasa</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>JFPIU Hakiki</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Umur</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Tempoh Perkhidmatan Keseluruhan</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Tempoh Perkhidmatan Jawatan Semasa</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Tarikh Lantikan Jawatan Semasa</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<table class="table table-sm table-bordered jambo_table table-striped">
  <tr>
    <th colspan="3">SYARAT    UMUM</th>
  </tr>
  <tr>
    <td>Telah disahkan dalam perkhidmatan</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="3">Purata LNPT sekurang-kurangnya 80% dan ke atas <br>
      (Pemberat 3 Tahun = 20%, 35%, 45%)<br>
    (Pemberat 2 Tahun = 40% , 60%)</td>
    <td>2020</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>2019</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>2018</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Diperakukan Ketua Jabatan</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Berjawatan Tetap</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Bebas tindakan tatatertib</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Sekurang-kurangnya 3 tahun sebagai Prof. Madya</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<table class="table table-sm table-bordered jambo_table table-striped">
  <tbody>
    <tr>
      <th rowspan="2" scope="col">KRITERIA</th>
      <th colspan="4" scope="col">BIDANG</th>
      <th rowspan="2" scope="col">Internal Data</th>
      <th rowspan="2" scope="col">Manual Entry</th>
    </tr>
    <tr>
      <th colspan="2">Sains dan Teknologi</th>
      <th colspan="2">Sains Sosial dan Kemanusiaan</th>
    </tr>
    <tr>
      <th rowspan="2" scope="row">Penyelidikan</th>
      <td colspan="2">Bil. penyelidikan sebagai penyelidik utama = 5 </td>
      <td colspan="2">Bil. penyelidikan sebagai penyelidik utama = 5 </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Jumlah	dana  penyelidikan	yang diperolehi	(sebagai penyelidik	utama dan penyelidik bersama) = RM 250,000 </td>
      <td colspan="2">Jumlah	dana  penyelidikan	yang diperolehi	(sebagai penyelidik	utama dan penyelidik bersama) = RM 125,000 </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th rowspan="7" scope="row">Penerbitan</th>
      <td rowspan="4"><p>Bilangan jurnal (termasuk bab	 dalam buku) berwasit = 25	 </p>
        <ul>
          <li>dalam bidang pengkhususan 	sendiri	 </li>
          <li>≥ 20 % adalah berindeks </li>
          <li>≥ 70 % adalah penerbitan jurnal </li>
          <li>≥ 50 % sebagai penulis utama </li>
      </ul></td>
      <td>Bil. Jurnal + Bab Dalam Buku (Berwasit)	 </td>
      <td rowspan="4"><p>Bilangan jurnal (termasuk bab	 dalam buku) berwasit = 20 </p>
        <ul>
          <li>dalam bidang pengkhususan 	sendiri </li>
          <li>≥ 20 % adalah berindeks = 4</li>
          <li>≥ 50 % adalah penerbitan jurnal = 10</li>
          <li>≥ 50 % sebagai penulis utama = 10</li>
        </ul></td>
      <td>Bil. Jurnal + Bab Dalam Buku (Berwasit) = 4</td>
      <td rowspan="4">&nbsp;</td>
      <td rowspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>Berindeks	 </td>
      <td>Berindeks = 4</td>
    </tr>
    <tr>
      <td>Bil. Jurnal	 </td>
      <td>Bil. Jurnal = 10</td>
    </tr>
    <tr>
      <td>Penulis Utama</td>
      <td>Penulis Utama = 10</td>
    </tr>
    <tr>
      <td colspan="2">Buku karya asli yang diterbitkan oleh penerbit yang diiktiraf = 1 </td>
      <td colspan="2">Buku karya asli yang diterbitkan oleh penerbit yang diiktiraf = 3</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Jumlah sitasi ≥ 50 (Scopus)</td>
      <td colspan="2">Jumlah sitasi ≥ 30 (Google Scholar)</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Bil. h-Indeks (Scopus)</td>
      <td colspan="2">Bil. h-Indeks (Google Scholar)</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th rowspan="2" scope="row">Pengajaran</th>
      <td colspan="2">Aktif dalam pengajaran Pra  Siswazah </td>
      <td colspan="2">Aktif dalam pengajaran Pra  Siswazah </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">Aktif dalam pengajaran Pasca  Siswazah </td>
      <td colspan="2">Aktif dalam pengajaran Pasca  Siswazah </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">Penyeliaan</th>
      <td colspan="2"><p>Telah mengijazahkan minimum (sebagai penyelia utama): </p>
        <ul>
          <li>PhD atau setara = 1 orang</li>
          <li>Sarjana = 2 orang </li>
        </ul></td>
      <td colspan="2"><p>Telah mengijazahkan minimum (sebagai penyelia utama): </p>
        <ul>
          <li>PhD atau setara = 1 orang</li>
          <li>Sarjana = 2 orang </li>
        </ul></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th rowspan="6" scope="row">Sanjungan Akademik &amp; Kepimpinan Akademik </th>
      <td colspan="2"><p>Editor jurnal berindeks, atau
        </p>
        <ul>
          <blockquote>&nbsp;            </blockquote>
      </ul></td>
      <td colspan="2"><p>Editor jurnal berindeks, atau </p>
        <ul>
          <blockquote>&nbsp; </blockquote>
        </ul></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><p>Penilai jurnal berindeks (5 artikel), atau            </p></td>
      <td colspan="2"><p>Penilai jurnal berindeks (5 artikel), atau </p></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><p>Penilai manuskrip buku (2 manuskrip), atau            </p></td>
      <td colspan="2"><p>Penilai manuskrip buku (2 manuskrip), atau </p></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><p>Penilai luar kenaikkan pangkat, atau            </p></td>
      <td colspan="2"><p>Penilai luar kenaikkan pangkat, atau </p></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><p>Penyampai ucap utama / plenari dalam persidangan luar, atau                  </p></td>
      <td colspan="2"><p>Penyampai ucap utama / plenari dalam persidangan luar, atau </p></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><p>Pemeriksa luar tesis pascasiswazah: </p>
        <ul>
          <li>PhD (2 orang) </li>
          <li>Sarjana (4 orang) </li>
        </ul>      </td>
      <td colspan="2"><p>Pemeriksa luar tesis pascasiswazah: </p>
        <ul>
          <li>PhD (2 orang) </li>
          <li>Sarjana (4 orang) </li>
        </ul></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">Khidmat kepada Universiti dan Masyarakat </th>
      <td colspan="2"><p>Keanggotaan Jawatankuasa (JK)</p>
        <ul>
          <li>1 peringkat kebangsaan; dan </li>
          <li>Kriteria-kriteria yang telah 	dinyatakan dalam Perkara 	21.0 (4.0) </li>
      </ul></td>
      <td colspan="2"><p>Keanggotaan Jawatankuasa (JK)</p>
        <ul>
          <li>1 peringkat kebangsaan; dan </li>
          <li>Kriteria-kriteria yang telah 	dinyatakan dalam Perkara 	21.0 (4.0) </li>
        </ul></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">Perundingan atau Jaringan Industri </th>
      <td colspan="2">Bilangan perundingan (dalam bidang kepakaran) yang dilakukan = 3 </td>
      <td colspan="2">Bilangan perundingan (dalam bidang kepakaran) yang dilakukan = 3 </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
<p><em>Note: Pencapaian yang disenaraikan adalah berciri kumulatif</em></p>

            
        </div> 
    </div>
</div>   
