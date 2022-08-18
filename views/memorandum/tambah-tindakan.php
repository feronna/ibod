 
<?php

use yii\helpers\Html;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

error_reporting(0);
?>
<style>
th {
  background-color: #2290F0;
  color: white;
  text-align: center;
}

</style>
<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/memorandum/_menu');?>
</div>

<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
                 <p align="right" >
                    <?php echo Html::a('Kembali', ['senarai-memorandum'], ['class' => 'btn btn-primary btn-sm']); ?>  
               
                </p>
        <div class="x_title">
            <h2>Senarai Rekod Memorandum</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
               <div class="table-responsive">

    
             
             <table class="table table-sm table-bordered">
           
                            <tr>
                         <th>Bil.</th>
                         <th width="700px" align="center"><strong>MEMORANDUM</strong></th>
               
                         <th><strong>TINDAKAN PENYELIA</strong></th>
                          <th><strong>TINDAKAN PEGAWAI</strong></th>
<!--                         <th><strong>KEMASKINI</strong></th>-->
       
                         <th><strong>TAMBAH TINDAKAN</strong></th>
                          <th><strong>MAKLUMAN PEGAWAI</strong></th>
                          <th><strong>TAMBAH MAKLUMAN</strong></th>
                  
                    </tr>
                     <?php if($model) {
                   foreach ($model as $key=>$item){
                    
                ?>
                        <tr>
                            <td width="50px" align="center"><?= $key+1?></td>
                            <td>   <?= '<strong>'.$item->tblRekod->bil_jpu. $item->tblRekod->kali_ke. $item->tblRekod->perkara.'</strong>'.$item->perkara; ?> </td>

   

                 
                  
                      
                        
                          <td>   <?php echo $item->TindakanPenyeliaJafpib($item->id)?>  </td>
                          <td>     <?php echo $item->TindakanPerakuJafpib($item->id)?>  </td>
                     <td class="text-center"><?php echo \yii\helpers\Html::a('', ['tambah-tindakan-jafpib',  'id_rekod' => $item->id_rekod, 'id' => $item->id], ['class'=>'fa fa-plus', 'target' => '_blank']).
                             ' '. '|'. ' '. \yii\helpers\Html::a('', ['kemaskini-tindakan-jafpib',  'id_rekod' => $item->id_rekod, 'id' => $item->id], ['class'=>'fa fa-edit', 'target' => '_blank'])?></td>
                           
                           
<!--                              <td class="text-center">  strtoupper($item->TindakanJafpib2($item->id)); ?>
                           </td>-->
                               <td>     <?php echo $item->TindakanPemakluman($item->id)?>  </td>
                            <td class="text-center"><?php echo \yii\helpers\Html::a('', ['tambah-pemakluman',  'id_rekod' => $item->id_rekod, 'id' => $item->id], ['class'=>'fa fa-plus', 'target' => '_blank']) ?></td> 
                           
                        </tr>
                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
                        
                      </table>
            
            
        </div>
        </div>
        
        
        
    </div>
    </div>
    </div>
