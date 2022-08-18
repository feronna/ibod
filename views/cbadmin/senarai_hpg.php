<?php
 
use kartik\tabs\TabsX;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use kartik\date\DatePicker;
error_reporting(0);

?>
 
<?php echo $this->render('/cutibelajar/_topmenu');?>

<div class ="row">
       <p align="right"><?= Html::a('Kembali', ['cbadmin/page-tuntutan'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>
<div class="col-md-12 col-sm-12 col-xs-12"> 

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->
    <div class="x_title">
        <h5><strong><i class="fa fa-check-square" style="color:green"></i> SENARAI MENUNGGU SEMAKAN</strong></h5>
     
            <div class="clearfix"></div>
        </div>
         <div class="x_content">
             
<?php
  echo Html::a(Yii::t('app','<i class="fa fa-plane"></i> <span class="label label-info">TIKET PENERBANGAN</span>'), ['cbadmin/senaraitindakantuntutan'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-money"></i> <span class="label label-info">TUNTUTAN</span>'), ['cbadmin/senarai-tuntut-hpg'], ['class' => 'btn btn-default btn-lg']);

?>

         </div>
    </div>
      </div>
</div>

 </div>
<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12"> 


<div class="col-md-12 col-xs-12"> 
    
    <div class="x_panel">
      
          
      <div class="row">
            <div class="col-md-12 col-xs-12"> 

                <div class="x_panel" id="rcorners2">
                    <h5><i class="fa fa-money"></i> TUNTUTAN ELAUN & HADIAH PERGERAKAN GAJI</h5>

                    <hr>
                                 <?= $this->render('/lapordiri/_senarai_hpg', ['bil' => 1,  'icno' => $icno, 
                                     'senarai' => $senarai, 'title' => $title,'semak'=>$semak,'lulush'=>$lulush,
                                     'semakt'=>$semakt,'lulust'=>$lulust,'semakp'=>$semakp,
                                     'tolakp'=>$tolakp,'tolakw'=>$tolakw,'semaky'=>$semaky,'lulusy'=>$lulusy,
                                     'tolaky'=>$tolaky,'lulusp'=>$lulusp,'semaks'=>$semaks,'luluss'=>$luluss,'tolaks'=>$tolaks,
                                     'semakv'=>$semakv,'lulusv'=>$lulusv,'tolakv'=>$tolakv])?><br>
                </div></div>
        </div></div>
     
    </div> 
<!--            end of dropdownl link-->
  
    </div>
</div>

    

