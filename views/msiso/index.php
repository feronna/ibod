<?php
 
use kartik\tabs\TabsX;
use kartik\grid\GridView;
use yii\helpers\Html;

error_reporting(0);
?>
<?= $this->render('menu') ?> 

<div class="row">
<div class="col-md-12 col-xs-12"> 
    <!-- <div class="x_panel">
        <div class="x_title">
            <h2><strong><?php echo $title;?></strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
        
              <?php

                // $items = [
                // [
                //     'label' => '<i class="fa fa-list"></i>&nbsp;Audit Plan',
                //     'content' =>  $this->render('view_senarai_audit_plan', ['model' => $model,  'dataProvider' => $dataProvider, 'bil' => 1,]),  
                //     'active' => true
                    
                    
                // ], 
                // [
                //     'label' => '<i class="fa fa-list"></i>&nbsp;Notification Letter', 
                //     'content' => '<p style="color: red"> </p>',
                //     'url' =>  ['msiso/index-letter'],
                    
                    
                // ],  
                // ];
                // echo TabsX::widget(['items' => $items, 'position' => TabsX::POS_ABOVE, 'bordered' => true, 'encodeLabels' => false, 'align' => TabsX::ALIGN_LEFT]);
            ?>                                              
   
            <br> 
        </div>
    </div> -->
            
    <div class="x_panel"> 
    <div class="x_title">
            <h2><i class="fa fa-list "></i><strong> <?php echo $title;?></strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                </li>
            </ul>  
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
              
     <?= GridView::widget([
                    'dataProvider' => $dataProvider, 
                    'summary' => '',
                    'showFooter' => true,
                    // 'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],  
                    'options' => [
                            'class' => 'table-responsive',
                                ],
                    'columns' => [
                        // ['class' => 'yii\grid\SerialColumn',
                        //                 'header' => '#',
                        //     'headerOptions' => ['class'=>'text-center'],
                        //                     'contentOptions' => ['class'=>'text-center'], 
                        //                     ],  
                        [
                            'label' => 'Tahun',
                            'format' => 'raw',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value'=> 'year',
                        ], 
                        [
                            'label' => 'Audit Plan',
                            'format' => 'raw',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value'=>function ($list){   
                               return Html::a( ' '.$list->title , Yii::$app->FileManager->DisplayFile($list->audit_plan), ['class'=>'fa fa-download', 'target' => '_blank']);  
                            },
                        ], 
                            
                    ],
                            
                ]); ?>

         <br>
            
     </div>
            </div> 

            <div class="x_panel"> 
    <div class="x_title">
            <h2><i class="fa fa-list "></i><strong> <?php echo $titles;?></strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                </li>
            </ul>  
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
              
        <?= GridView::widget([
                   'dataProvider' => $senarai,
                    'summary' => '',
                    'showFooter' => true,
                    // 'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],  
                    'options' => [
                            'class' => 'table-responsive',
                                ],
                    'columns' => [
                        // ['class' => 'yii\grid\SerialColumn',
                        //                 'header' => '#',
                        //     'headerOptions' => ['class'=>'text-center'],
                        //                     'contentOptions' => ['class'=>'text-center'], 
                        //                     ],  
                        [
                            'label' => 'JAFPIB',
                            'format' => 'raw',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => 'dept',
                        ], 
                        [
                            'label' => 'Tarikh Audit',
                            'format' => 'raw',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => 'auditDt',
                        ], 
                        [
                            'label' => '',
                            'format' => 'raw', 
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'], 
                            'value'=>function ($list){
                            return Html::a('', ['msiso/paparan-notification', 'id' => $list->id], ['class' => 'btn btn-primary fa fa-eye '])
                            .Html::a(' ', ['msiso/makluman', 'id' => $list->id], ['class'=>'btn btn-primary fa fa-download', 'target' => '_blank']) ; 
                           
                      }, 
                        ],
 
                    ], 
                ]); ?> 
         <br> 
        </div>
        </div> 
  
    </div>
</div>
</div>
  
