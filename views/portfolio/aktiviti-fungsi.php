<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\helpers\Url;

?>
<style>
th {
  background-color: #2290F0;
  color: white;
  text-align: left;
}

</style>




<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/portfolio/_menu');?> 
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 ">
        <div class="x_content"> 

    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->

<?php
  echo Html::a(Yii::t('app','<i class="fa fa-users"></i> <span class="label label-info">MAKLUMAT UMUM</span>'), ['/portfolio/maklumat-bahagian','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-university"></i> <span class="label label-success">MAKLUMAT KHUSUS</span>'), ['/portfolio/carta-organ-staf','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-book"></i> <span class="label label-info">MAKLUMAT JD</span>'), ['/portfolio/deskripsi-tugas','id' => $deskripsi->id], ['class' => 'btn btn-default btn-lg']);


?>
         </div>
    </div>
     <div class="x_panel">
         <div class="x_content"> 
   
<?php
  echo Html::a(Yii::t('app','CARTA ORGANISASI'), ['/portfolio/carta-organ-staf','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','CARTA FUNGSI'), ['/portfolio/carta-fungsi','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','AKTIVITI FUNGSI'), ['/portfolio/aktiviti-fungsi','id' => $deskripsi->id], ['class' => 'btn btn-warning']);
 
  echo Html::a(Yii::t('app','PROSES KERJA'), ['/portfolio/proses-kerja','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','SENARAI UNDANG-UNDANG'), ['/portfolio/senarai-undang','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  
 echo Html::a(Yii::t('app','SENARAI BORANG'), ['/portfolio/senarai-borang','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','SENARAI JAWATANKUASA'), ['/portfolio/senarai-jawatankuasa','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app','PERAKUAN'), ['/portfolio/perakuan','id' => $deskripsi->id], ['class' => 'btn btn-success']);
 echo Html::a(Yii::t('app','JANA MYPORTFOLIO'), ['/portfolio/jana-portfolio','id' => $deskripsi->id], ['class' => 'btn btn-success']);
  ?>
         </div></div>


     <div class="x_panel">

   
        <div class="x_title">
            <strong><h2>AKTIVITI-AKTIVITI BAGI FUNGSI</h2></strong>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
          
                </div>
        <div class="x_content">


                 
               <div class="table-responsive">
                <table class="table table-sm table-bordered">
    
     <tr>
                        <th  <td style="width:50px; height: 20px">Bil.</strong></td></th>
                        <th <td style="width:200px; height: 20px">SEKSYEN</strong></td></th>
                         <th  <td style="width:200px; height: 20px">UNIT</strong></td></th>
                         <th <td style="width:500px; height: 20px">FUNGSI UNIT</strong></td></th>
                         <th <td style="width:500px; height: 20px">AKTIVITI BAGI FUNGSI</strong></td></th>
                               <th class="column-title">KEMASKINI/PADAM</th>
                               <th class="column-title" style="center">TAMBAH AKTIVITI</th>
                   
                         
                    </tr>
                               <?php if($fungsiUnit) {
                    
                   foreach ($fungsiUnit as $key=>$item){?>
                    <tr>
                            <td align="center"><?= $key+1?></td>
                              <td><?= ucwords(strtolower($item->fungsiUnit->sectionID->section_details))?> </td>
                            <td>
                            <?= ucwords(strtolower($item->fungsiUnit->unit_details))?> </td>
                             <td>
                            <?= $item->description ?> </td>
                             <td><?php echo ($item->AktivitiFungsi($item->id))?> </td>
          
                              <td> <?php echo ($item->AktivitiFungsi2($item->id))?> </td>
                              <td align="center"><?= \yii\helpers\Html::a('', ['portfolio/tambah-aktiviti-fungsi', 'id' => $deskripsi->id, 'unit_id' => $item->id], ['class'=>'fa fa-plus', 'target' => '_blank']) ?></td>
                                
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

        
         
        


   
