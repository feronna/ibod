<?php

use yii\helpers\Html;
use dosamigos\highcharts\HighCharts;
use app\models\memorandum\TblRekod;
use yii\grid\GridView;

error_reporting(0);
?>


<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/memorandum/_menu');?> 
</div>

    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-list"></i>&nbsp;<strong>Rekod Memorandum Keseluruhan</strong></h2>
                    <ul class="nav navbar-right panel_toolbox ">
                        <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
<div class="row text-center">
    <?php
 foreach (TblRekod::listofyear() as $i){
$average = TblRekod::averageindex($i->tahun);
     ?>
    <div class="col-md-3 col-sm-3 col-xs-12 col-lg-3" style="display:inline-block;float:none;text-align:left;">
    <div class="x_panel">
        <div class="x_title text-center">
       TAHUN <?= $i->tahun?> 
        </div>
        <div class="x_content">
             <span class="count_top"><i class="fa fa-book"></i>&nbsp;Jumlah Memorandum</span>
             <div class="text-center" style="font-size: 60px; color: #6495ED">
            <?= $average?>
            </div>
            <div class="text-center" style="font-size: 60px">
        
            </div>
      
            <ul><strong>STATUS INDEX MEMORANDUM :</strong>
           
                <li><i class="green">INDEX SELESAI : <strong><?= TblRekod::totalselesai($i->tahun) ?></strong></i></li>
                <li><i class="red">INDEX BELUM SELESAI : <strong><?= TblRekod::totalbelumselesai($i->tahun) ?></strong></i></li>
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


<!--
    <div class="x_panel">
        <div class="x_title">
            <h6><i class="fa fa-briefcase"></i> Jumlah Memorandum Mengikut JAFPIB</h6>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <div class="table-responsive">
                <GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'header' => 'Bil.',
                            'headerOptions'=>['style'=>'max-width: 50px;width: 50px;'],
                            'footerOptions' => [
                                'style' => 'display: ;',
                            ],
                        ],
                        [
                            'header' => 'JAFPIB',
                     //       'headerOptions'=>['style'=> 'text-decoration: underline;'],
                            'value' =>function($model)use ($params){
                                return Html::a(strtoupper($model->department->fullname), ['senarai-memorandum','k'=>$params['k'],'s'=>$params['s'],'p'=>$model->dept_id], ['class'=>'no-pjax', 'style'=> 'text-decoration: underline']);
                            
                               
                            },
                            'footer' => '<b>JUMLAH</b>',
                            'footerOptions' => [
                                'colspan' => '1',
                            ],
                            'format' => 'raw',
                        ],
                        [
                            'header' => 'INDEX SELESAI',
//                            'value' => '_totalCount',
//                            'value' => function ($model, $key, $index, $obj) {
//                                $obj->footer += $model->_totalCount;
//                                return $model->_totalCount;
//                            },
                        ],
                                    
                         [
                            'header' => 'INDEX BELUM SELESAI',
                        
                         
                        ],
                                    
                       [
                            'header' => 'JUMLAH INDEX',
                          
                        ],
                    ],
                    'showFooter' => TRUE,
                ]) ?>
            </div>

        </div>
    </div>-->

<?= $this->render('statistik', ['dataProvider'=> $dataProvider]);?>

    