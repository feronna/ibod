<?php
use yii\helpers\Html;

use kartik\tabs\TabsX;
error_reporting(0);
?>
 <div class="col-md-12 col-xs-12"> 

<?php echo $this->render('/cutibelajar/_topmenu');?>


    
<div class="col-md-12 col-xs-12"> 
    <div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->
    <div class="x_title">
            <h2><strong>SENARAI MENUNGGU PERAKUAN</strong></h2>
            
            <div class="clearfix"></div>
        </div>
         <div class="x_content">
             
<?php
  echo Html::a(Yii::t('app','<i class="fa fa-address-card"></i> <span class="label label-info">PERMOHONAN BAHARU</span>'), ['cutisabatikal/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="glyphicon glyphicon-align-right"></i> <span class="label label-info">PELANJUTAN TEMPOH CUTI BELAJAR</span>'), ['lanjutancb/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-list"></i> <span class="label label-info">LAIN - LAIN PERMOHONAN</span>'), ['cblainlain/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKK</span>'), ['lkk/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-suitcase"></i> <span class="label label-info">LAPOR DIRI</span>'), ['lapordiri/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);

?>
         </div>
    </div>
</div>
</div>
</div>
</div>

 

