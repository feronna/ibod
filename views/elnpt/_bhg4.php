<?php
use yii\bootstrap\Alert;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<?php 
//echo Alert::widget([
//    'options' => ['class' => 'alert-warning'],
//    'body' => '<font color="black">
//                    <strong>INFO</strong><br>
//                    <p>
//                        Bagi Penerbitan, PPP & PPK tidak perlu membuat pemarkahan. Markah yang di bahagian ini mengambil kira markah yang telah auto-generated.
//                    </p>
//                </font>',
//]);
?>

<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <tr>
            <th class="text-center">BIL.</th>
            <th class="text-center">JENIS PENERBITAN</th>
            <th class="text-center">TAJUK</th>
            <th class="text-center">TAHUN TERBIT</th>
            <th class="text-center">STATUS PENULIS</th>
            <th class="text-center">STATUS INDEKS</th>
            <th class="text-center">STATUS PENERBITAN</th>
        </tr>
        <?php if(empty($data)) { ?>
        <tr>
            <td colspan="9">Penerbitan yang tidak tersenarai sila semak dengan pihak PPPI.</td>
        </tr>
        <?php }else{
          foreach ($data as $ind => $dt) {?>
                <tr>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $ind + 1 ?></td>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $dt['Bilangan_penerbitan'] ?></td>
                    <td class="col-md-2" ><?= $dt['Title'] ?></td>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $dt['PublicationYear'] ?></td>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $dt['Status_penulis'] ?></td>
                    <td class="col-md-1 text-center" style="text-align:center"><?= $dt['Status_indeks'] ?></td>
                    <td class="col-md-1 text-center" style="text-align:center"><?php 
                        echo $dt['Status_penerbitan'];
                    ?></td>
                    
                </tr>
          <?php }} ?>           
    </table>
</div>