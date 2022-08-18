<?php
use yii\bootstrap\Alert;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$inovasi = array();
$sidang = array();

if(!empty($data)) {
    foreach($data as $dd) {
        if($dd['Bilangan_Persidangan_dan_Inovasi'] == 'PERSIDANGAN') {
            array_push($sidang, $dd);
        }else  if($dd['Bilangan_Persidangan_dan_Inovasi'] == 'PERTANDINGAN INOVASI') {
            array_push($inovasi, $dd);
        }
    }
} 

?>

<?php
//echo Alert::widget([
//    'options' => ['class' => 'alert-warning'],
//    'body' => '<font color="black">
//                    <strong>INFO</strong><br>
//                    <p>
//                        Bagi Persidangan & Inovasi, PPP & PPK tidak perlu membuat pemarkahan. Markah yang di bahagian ini mengambil kira markah yang telah auto-generated.
//                    </p>
//                </font>',
//]);
?>

<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Persidangan</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Inovasi</a></li>
</ul>

<br>

<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
        
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">BIL.</th>
                    <th class="text-center">KATEGORI</th>
                    <th class="text-center">NAMA PERSIDANGAN</th>
                    <th class="text-center">PERANAN</th>
                    <th class="text-center">TAHAP PENYERTAAN</th>
                </tr>
                <?php if(empty($sidang)) { ?>
                <tr>
                    <td colspan="6">Tiada rekod dijumpai.</td>
                </tr>
                <?php }else{ 
                    foreach ($sidang as $ind => $dt) { ?>
                <tr>
                    <td class="text-center col-md-1"  style="text-align:center"><?= $ind+1; ?></td>
                    <td class="col-md-1 text-center"  ><?= $dt['Bilangan_Persidangan_dan_Inovasi']; ?></td>
                    <td class="col-md-5"  ><?= $dt['ConferenceTitle']; ?></td>
                    <td class="col-md-1 text-center"  style="text-align:center"><?= $dt['Peranan_dalam_projek_Inovasi']; ?></td>
                    <td class="col-md-1 text-center"><?= $dt['Tahap_penyertaan']; ?></td>
                </tr>
                <?php }} ?>
            </table>
        </div>
        
    </div>
    
    <div role="tabpanel" class="tab-pane" id="profile">
    
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tr>
                    <th class="text-center">BIL.</th>
                     <th class="text-center">KATEGORI</th>
                    <th class="text-center">NAMA INOVASI</th>
                    <th class="text-center">PERANAN</th>
                    <th class="text-center">TAHAP PENYERTAAN</th>
                    <th class="text-center">AMAUN PENGKOMERSIALAN</th>
                </tr>
                <?php if(empty($inovasi)) { ?>
                <tr>
                    <td colspan="6">Tiada rekod dijumpai.</td>
                </tr>
                <?php }else{ 
                    foreach ($inovasi as $ind => $dt) { ?>
                <tr>
                    <td class="text-center col-md-1"  style="text-align:center"><?= $ind+1; ?></td>
                    <td class="col-md-3 text-center"  style="text-align:center"><?= $dt['Bilangan_Persidangan_dan_Inovasi']; ?></td>
                    <td class="col-md-5"  ><?= $dt['ConferenceTitle']; ?></td>
                    <td class="col-md-1 text-center"  style="text-align:center"><?= $dt['Peranan_dalam_projek_Inovasi']; ?></td>
                    <td class="col-md-1 text-center"><?= $dt['Tahap_penyertaan']; ?></td>
                    <td class="col-md-1 text-center"><?= $dt['Amaun_pengkomersialan']; ?></td>
                </tr>
                <?php }} ?>
            </table>
        </div>
        
    </div>
</div>

