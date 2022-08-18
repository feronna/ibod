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
    <br><b>INDEX MESYUARAT JAWATANKUASA PENGURUSAN UNIVERSITI (JPU) TAHUN <?= $model->tahun ?></b>
   &nbsp; &nbsp;&nbsp;&nbsp; 
</div>

<div  ALIGN="center" color="red">
    <strong>(<?= $statusLabel[$model->status] ?>)</strong>
</div>

<div  ALIGN="center" color="red">
    <strong>JPU BIL. <?= $model->bil_jpu . ' ' . '(' . $model->kali_ke . ')' . ' ' . strtoupper($model->tarikhRekod) ?></strong>
</div>

<br>

<div style="margin-bottom: 20px" text-align="justify" font-size="10px">


    <div class="responsive">
<table class="table table-bordered jambo_table" style="font-size:13px">
                
                    <thead> 
                     <tr class="headings">
                      
                         <td><strong>KEPUTUSAN MESYUARAT JPU BIL. <?= $model->bil_jpu . ' ' . '(' . $model->kali_ke . ')' . ' ' . strtoupper($model->tarikhRekod) ?> <br><center> PERKARA / MINIT</center></strong></td>
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
            
                            <td style="text-align:justify"><?php echo $senarai->perkara2->tblRekod->perkara. "<br>".'<br>'.$senarai->perkara2->perkara.'<br>'.'<br>'.    Html::a(''  . $senarai->tblRekod->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $senarai->tblRekod->hashcode, $schema = true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]); ?></td>
                            <td><?=  $senarai->perkara2->senaraiTindakan($senarai->perkara2->id); ?></td>
                            <td><?php if($senarai->perkara2->tblMaklumbalasPtj2->maklumbalas_ptj != null){
                                  echo $senarai->perkara2->tblMaklumbalasPtj2->MaklumbalasJafpib($senarai->perkara2->id);
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