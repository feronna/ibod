<?php

$color1 = $color2 = $color3 = $color4 = $color5 = $color6 = $color7 = $color8 = $color9 = $color10 = $color11 = $color12 ='#2A3F54';

$action = Yii::$app->controller->action->id;

if($action == 'chief-details'){
   $color1 = 'green'; 
}elseif($action == 'section-details'){
   $color2 = 'green'; 
}elseif($action == 'unit-details'){
   $color3 = 'green'; 
}elseif($action == 'status-staf'){
   $color8 = 'green'; 
}
elseif($action == 'carta-organ'){
   $color4 = 'green'; 
}elseif($action == 'carta-fungsi-jabatan'){
   $color5 = 'green'; 
}elseif($action == 'tambah-section'){
   $color6 = 'green'; 
}elseif($action == 'tambah-unit'){
   $color7 = 'green'; 
}
elseif($action == 'tambah-fungsi-unit'){
   $color9 = 'green'; 
}
elseif($action == 'kelulusan-carta'){
   $color10 = 'green'; 
}
elseif($action == 'tambah-su'){
   $color11 = 'green'; 
}
elseif($action == 'tambah-peringkat'){
   $color12 = 'green'; 
}
?>

<div class="x_panel">
    <div class="x_title">
        <p style="font-size:15px;font-weight: bold;">MENU</p> 
        <div class="clearfix"></div>
    </div> 
    <div class="x_content"> 
        <strong><u>
                <ol type="1">
                                       <li><a href="kelulusan-carta" target="_blank" style="color: <?=$color10;?>;">KELULUSAN CARTA</a></li> 

                    <li><a href="tambah-section" style="color: <?=$color6;?>;">TAMBAH/KEMASKINI STRUKTUR   
                            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Nama Jabatan/Fakulti/Institut/Pusat/Bahagian/Sektor/Seksyen. 
                               Cth: Dekan Fakulti Kejuruteraan(untuk Ketua Jabatan)/Bahagian Pentadbiran dan Kewangan(untuk nama struktur)"
                               ></i> 
                </a></li>
                    <li><a href="tambah-unit" style="color: <?=$color7;?>;">TAMBAH/KEMASKINI UNIT
                      <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title=" Cth : Nama dan Fungsi Unit"></i> 
                </a></li>
                    <li><a href="chief-details" style="color: <?=$color1;?>;">PILIH KETUA JABATAN</a></li>
                    <li><a href="tambah-su" style="color: <?=$color11;?>;">PILIH SETIAUSAHA</a>
                       <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title=" 
                              Jika Tiada Boleh Skip"
                               ></i> </li>
                               
                               <li><a href="tambah-peringkat" style="color: <?=$color12;?>;">TAMBAH/KEMASKINI PERINGKAT</a>
                       <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title=" 
                              Tambah Peringkat seperti di dalam carta"
                               ></i> </li>

                    <li><a href="section-details" style="color: <?=$color2;?>;">PENETAPAN STRUKTUR CARTA</a></li>

                    <li><a href="status-staf" target="_blank" style="color: <?=$color8;?>;">STATISTIK KAKITANGAN</a></li>

                    <li><a href="carta-organ" target="_blank" style="color: <?=$color4;?>;">PAPAR CARTA ORGANISASI</a></li>
                    <li><a href="carta-fungsi-jabatan" target="_blank" style="color: <?=$color5;?>;">PAPAR CARTA FUNGSI</a></li> 
              
                </ol>
            </u></strong>
    </div> 
</div> 

