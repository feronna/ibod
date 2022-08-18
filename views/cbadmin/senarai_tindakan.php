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
  <p align="right"><?= Html::a('Kembali', ['cbadmin/page-semak'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>



 <div class ="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->
    <div class="x_title">
        <h5><strong><i class="fa fa-search" style="color:green"></i> SENARAI MENUNGGU SEMAKAN</strong></h5>
            
            <div class="clearfix"></div>
        </div>
         <div class="x_content">
             
<?php
  echo Html::a(Yii::t('app','<i class="fa fa-address-card"></i> <span class="label label-info">PERMOHONAN BAHARU</span>'), ['cbadmin/senaraitindakan1'], ['class' => 'btn btn-default btn-lg']);
//  echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
//     echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/lkk-jfpiu'], ['class' => 'btn btn-default btn-lg']);

  echo Html::a(Yii::t('app','<i class="fa fa-list"></i> <span class="label label-info">LAIN - LAIN PERMOHONAN</span>'), ['cbadmin/senaraitindakanlain'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="glyphicon glyphicon-align-right"></i> <span class="label label-info">PELANJUTAN TEMPOH</span>'), ['cbadmin/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
//  echo Html::a(Yii::t('app','<i class="fa fa-suitcase"></i> <span class="label label-info">LAPOR DIRI</span>'), ['lapordiri/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);

?>

         </div>
    </div>
      </div>


 </div>
    
        <div class="row">
            <div class="col-md-12 col-xs-12"> 

                <div class="x_panel" id="rcorners2">
                    <h5><i class="fa fa-clock-o"></i> SENARAI PERMOHONAN PELANJUTAN TEMPOH</h5>

                    <hr>
                                 <?= $this->render('/lanjutancb/_senarai_menunggu', ['bil' => 1,  'icno' => $icno, 
                                     'senarai' => $senarai,'lulus'=>$lulus,'tolak'=>$tolak, 'kiv'=>$kiv,'title' => $title,])?><br>
                </div></div>
        </div>
 

