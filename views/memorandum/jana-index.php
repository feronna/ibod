<?php
use yii\helpers\Html;
use yii\helpers\Url;

$statusLabel = [
        0 => 'STATUS BELUM SELESAI',
        1 => 'STATUS SELESAI'
   
];
error_reporting(0);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 20px" ALIGN="right">
    <br><b>SULIT</b>
   &nbsp; &nbsp;&nbsp;&nbsp; 
</div>


<div ALIGN="center">
    <br><b>INDEX MESYUARAT JAWATANKUASA PENGURUSAN UNIVERSITI (JPU) TAHUN <?= $model->tblRekod->tahun ?></b>
   &nbsp; &nbsp;&nbsp;&nbsp; 
</div>

<div  ALIGN="center" color="red">
    <strong>(<?= $statusLabel[$model->status] ?>)</strong>
</div>

<div  ALIGN="center" color="red">
    <strong>JPU BIL. <?= $model->tblRekod->bil_jpu . ' ' . '(' . $model->tblRekod->kali_ke . ')' . ' ' . strtoupper($model->tblRekod->tarikhRekod) ?></strong>
</div>


<div style="margin-bottom: 20px" text-align="justify" font-size="10px">


    <div class="responsive">
<table class="table table-bordered jambo_table" style="font-size:13px">
                
                    <thead> 
                     <tr class="headings">
                      
                         <td><strong>KEPUTUSAN MESYUARAT JPU BIL. <?= $model->tblRekod->bil_jpu . ' ' . '(' . $model->tblRekod->kali_ke . ')' . ' ' . strtoupper($model->tblRekod->tarikhRekod) ?> <br><center> PERKARA / MINIT</center></strong></td>
                         <td><strong><center>TINDAKAN</center></strong></td>
                         <td><strong><center>MAKLUMBALAS</center></strong></td>
                     </tr>
                    </thead>
                    
                    <tbody>
                    <?php 
                 //   $bil=1;
                    if($senarai){
                    foreach ($senarai as $senarai) { 
                        ?>
                        <tr>
            
                            <td style="text-align:justify"><?php echo $senarai->tblRekod->perkara. "<br>".'<br>'.$senarai->perkara.'<br>'.'<br>'.    Html::a(''  . $senarai->tblRekod->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $senarai->tblRekod->hashcode, $schema = true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]); ?></td>
                            <td><?=  $senarai->senaraiTindakan($senarai->id); ?></td>
                            <td><?php if($senarai->tblMaklumbalasPtj2->maklumbalas_ptj != null){
                                  echo $senarai->tblMaklumbalasPtj2->MaklumbalasJafpib($senarai->id);
                                   }else{
                                  echo 'TIADA MAKLUMBALAS';
                                  }
                                 ?>
                            </td>
                        </tr>
                     <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>  
                            
                          
                </tbody>
                    
                    
                    
 </table>
   </div>        
</div>