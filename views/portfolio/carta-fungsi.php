<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use kongoon\orgchart\OrgChart;
?>
<style>
th {
  background-color: #2290F0;
  color: white;
  text-align: center;
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
  echo Html::a(Yii::t('app','CARTA FUNGSI'), ['/portfolio/carta-fungsi','id' => $deskripsi->id], ['class' => 'btn btn-warning']);
   echo Html::a(Yii::t('app','AKTIVITI FUNGSI'), ['/portfolio/aktiviti-fungsi','id' => $deskripsi->id], ['class' => 'btn btn-success']);

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
            <strong><h2>CARTA FUNGSI</h2></strong>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
          
                </div>
        
        
        
<style>
th {
  background-color: #008000;
  color: white;
  text-align: center;
}

</style>


<div class="row">
    <div class="x_panel">
            <div class="product_price">

        <center><h4> <span class="label label-success">CARTA FUNGSI <?= strtoupper($deskripsi->department->fullname);?></span></h4></center>
            </div>
  <?php  
  
  

echo OrgChart::widget([

    'data' => $model,

    ]) ?>

</div>
    
        
                  <div class="table-responsive">
                <table class="table table-sm table-bordered">
    
     <tr>
                        <th  <td style="width:50px; height: 20px">Bil.</strong></td></th>
                        <th <td style="width:200px; height: 20px">SEKSYEN</strong></td></th>
                         <th <td style="width:200px; height: 20px">UNIT</strong></td></th>
                         <th <td style="width:500px; height: 20px">FUNGSI UNIT</strong></td></th>
                   
                    </tr>
                               <?php if($fungsiUnit) {
                    
                   foreach ($fungsiUnit as $key=>$item){?>
                    <tr>
                            <td align="center"><?= $key+1?></td>
                            <td>
                            <?php if(($item->section_id == $item->cartaSection->section) || ($item->id == $item->cartaUnit->unit_staff)){
                             echo '<div style="background-color:yellow">'.ucwords(strtolower($item->sectionID->section_details)).'</div>';
                            }else{
                              echo ucwords(strtolower($item->sectionID->section_details));                         
                               }
                            ?>
                            </td>
                              <td>
                            <?php if(($item->section_id == $item->cartaSection->section) || ($item->id == $item->cartaUnit->unit_staff)){
                              echo '<div style="background-color:yellow">'.ucwords(strtolower($item->unit_details)).'</div>';
                      
                            }else{
                               echo ucwords(strtolower($item->unit_details));
                            }
                            ?>
                            </td>
           
                            <td>
                            <?php if (($item->section_id == $item->cartaSection->section) || ($item->id == $item->cartaUnit->unit_staff)){
                              echo '<div style="background-color:yellow">'.($item->TugasUtama2($item->id)).'</div>';
                      
                            }else{
                              echo ($item->TugasUtama2($item->id));
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
                    
                </table>
                  </div>
          </div>
              
</div>
   
            </div>
  
</div>

 

   
