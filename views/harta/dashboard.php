<?php

use yii\helpers\Html;
use dosamigos\highcharts\HighCharts;
use app\models\harta\TblHarta;
use yii\grid\GridView;

error_reporting(0);
?>


<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/harta/_menu');?> 
</div>

    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-list"></i>&nbsp;<strong>Statistik Periytiharan Harta</strong></h2>
                    <ul class="nav navbar-right panel_toolbox ">
                        <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
<div class="row text-center">
    <?php
    
 foreach (TblHarta::listofyear() as $i){
$average = TblHarta::averageindex($i->tahun);
     ?>
    <div class="col-md-3 col-sm-3 col-xs-12 col-lg-3" style="display:inline-block;float:none;text-align:left;">
    <div class="x_panel">
        <div class="x_title text-center">
       TAHUN <?= $i->tahun?> 
        </div>
        <div class="x_content">
             <span class="count_top"><i class="fa fa-book"></i>&nbsp;Jumlah Periytiharan Harta</span>
             <div class="text-center" style="font-size: 60px; color: #6495ED">
            <?= $average?>
            </div>
            <div class="text-center" style="font-size: 60px">
        
            </div>
      
            <ul><strong>STATUS ISTIHAR :</strong>
           
                <li><i class="green">TELAH ISYTIHAR : <strong><?= TblHarta::totalselesai($i->tahun) ?></strong></i></li>
           
            </ul>
        </div>
    </div></div>
    <?php
 

      } ?>
</div>

                </div>
            </div>
        </div>
    </div>


<?= $this->render('statistik', ['dataProvider'=> $dataProvider]);?>
    