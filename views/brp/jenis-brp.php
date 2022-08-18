<?php

use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;


error_reporting(0);
/* * * for popover PENCERAMAH & INFO **** */
$js = <<< 'SCRIPT'
/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});
/* To initialize BS3 popovers set this below */
$(function () { 
   $("[data-toggle='popover']").popover();
//    $("[data-trigger='focus']").popover();
//    $('.popover-dismiss').popover({
//        trigger: 'focus'
//        })
});
//$(function() {
//    // use the popoverButton plugin
//    $('#kv-btn-1').popoverButton({
//        placement: 'left', 
//        target: '#myPopover5'
//    });
//});
$(function() {
    $('#testHover').popoverButton({
        trigger: 'hover focus',
        target: '#myPopover6'
    });
});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);
?>



<div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
              
            </div>
            <div class="x_content">
                
                <?php
                $form = ActiveForm::begin([
                    'action' => ['jenis-brp'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>
  
                  <?=
                            $form->field($searchModel, 'brpTitle')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(\app\models\brp\Brp::find()->all(), 'brpTitle', 'brpTitle'),
                             // 'data' => [1 => 'KEPIMPINAN', 0 => 'BUKAN KEPIMPINAN'],
                             'options' => ['placeholder' => 'Pilih Jenis Brp', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]); 
                ?>
                        
                
                        <?=
                            $form->field($searchModel, 'brpBottomDesc')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(\app\models\brp\Brp::find()->all(), 'brpBottomDesc', 'brpBottomDesc'),
                             // 'data' => [1 => 'KEPIMPINAN', 0 => 'BUKAN KEPIMPINAN'],
                             'options' => ['placeholder' => 'Pilih Keterangan Brp', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]); 
                ?>
 
                
                  
                
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                  
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            </div>
        </div>
    </div>

   <div class="x_panel">

        
        <div class="x_content">

         <?= Html::a('Tambah Jenis BRP', ['tambah-jenis-brp'], ['class' => 'btn btn-warning']);?> 
         <?= Html::a('Kembali', ['/brp/index'], ['class' => 'btn btn-primary']); ?>  
        </div>
    </div>



<div class="row">
<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2>Jenis Brp</h2>
        
            <div class="clearfix"></div>
        </div>
        
        <div class="table-responsive">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    
                     [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'JENIS BRP',
                        'value' => 'brpTitle'
                    ],
                                
                      [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'KETERANGAN BRP',
                        'value' => 'brpBottomDesc'
                      
                    ],
   
                [
                        'class' => 'yii\grid\DataColumn',
                        'label' => 'TINDAKAN',
                        'value' => function ($data) {
                            return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['padam-jenis-brp', 'id' => $data->brpCd], ['class' => 'btn btn-default',
                                        'data' => [
                                            'confirm' => 'Anda yakin ingin padam?',
                                            'method' => 'post',
                                ]]) . ' ' . Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['kemaskini-jenis-brp', 'id' => $data->brpCd], ['class' => 'btn btn-default']);
                        },
                                'format' => 'raw',
                                'contentOptions' => ['class' => 'text-center','width' => '130px'],
                            ],
                        ],
                                
                           'pager' => [
                           'firstPageLabel' => 'Halaman Pertama',
                           'lastPageLabel'  => 'Halaman Terakhir'
    ],
                    ]);
         
                    ?> 
            
            


        </div>
    </div>
</div>
</div>
