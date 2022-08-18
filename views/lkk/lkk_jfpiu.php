<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
//use app\assets\AppAsset;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


error_reporting(0);

//$bundle = yiister\gentelella\assets\Asset::register($this);
//AppAsset::register($this);

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
<!---- Hide previous modal screen ---->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#modal").on('hidden.bs.modal', function(){
        $('#modalContent').empty();
  });
    });
</script>
<!--- /Hide previous modal screen ---->
<!--<style>
a:link {
  color: green;
  background-color: transparent;
  text-decoration: none;
}
a:visited {
  color: indigo;
  background-color: transparent;
  text-decoration: none;
}
a:hover {
  color: red;
  background-color: transparent;
  text-decoration: underline;
}
a:active {
  color: yellow;
  background-color: transparent;
  text-decoration: underline;
}
</style>-->
<?php echo $this->render('/cutibelajar/_topmenu');?>
  <div class="x_content">
                
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
             <div class="x_title">
            <h2><strong>SENARAI MENUNGGU PERAKUAN</strong></h2>
            
            <div class="clearfix"></div>
        </div>
            
         <div class="x_content">
             
<?php
  echo Html::a(Yii::t('app','<i class="fa fa-address-card"></i> <span class="label label-info">PERMOHONAN BAHARU</span>'), ['cutisabatikal/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
    echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKP</span>'), ['lkk/lkk-jfpiu'], ['class' => 'btn btn-default btn-lg']);

  echo Html::a(Yii::t('app','<i class="fa fa-list"></i> <span class="label label-info">LAIN - LAIN PERMOHONAN</span>'), ['cblainlain/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
   echo Html::a(Yii::t('app','<i class="glyphicon glyphicon-align-right"></i> <span class="label label-info">PELANJUTAN TEMPOH</span>'), ['lanjutancb/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-suitcase"></i> <span class="label label-info">LAPOR DIRI</span>'), ['lapordiri/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);

?>
         </div>
        </div>
    </div>
</div>
  </div>
  <div class="x_content">

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">

<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
               [KLIK] SENARAI LAPORAN KEMAJUAN PENGAJIAN (LKP) YANG PERLU DISEMAK
                  <?= Html::a('LAPORAN KEMAJUAN KURSUS', ['lkk/senaraitindakan'], 
         ['class' => 'btn btn-danger btn-sm','target' => "_blank"]) ?> </strong> 
            </span> 
        </div>
</div>  </div></div></div>
            <div class="x_content">
                
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
<!--            <div class="x_title">
                <h2>Staf Pentadbiran</h2>
                <div class="clearfix"></div>
            </div>-->
            <div class="x_title">
                <h4>LAPORAN KEMAJUAN PENGAJIAN (LKP) STAF PENTADBIRAN</h4><div  class="pull-right">
            </div>
            
        </div>
            <div class="x_content">
               <?= 
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            //'filterModel' => $kursusJemputan,
                            'emptyText' => 'Tiada data ditemui.',
                            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                            'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                            'columns' => [
                                ['class' => 'kartik\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                ],
//                                [
//                                    'label' => 'Nama',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'left',
//                                    'format' => 'raw',
//                                    'value' => 'biodata.CONm',
//                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
//                                ],
                                [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA',
                            'headerOptions' => ['class'=>'column-title'],
//                             'filter' => Select2::widget([
//                            'name' => 'icno',
//                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPengajian::find()->where(['cb_tbl_pengajian.status'=>1])->joinWith('kakitangan.department')->all(), 'icno', 'kakitangan.CONm'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.
                                        '('.$model->kakitangan->jawatan->gred.')';
                            }, 
                                    
                                    'format' => 'html',
                        ],
//                                [
//                                    'label' => 'GRED',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'center',
//                                    'format' => 'raw',
//                                    'value' => 'kakitangan.jawatan.gred',
//                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//                                ],
                                    [
                        'label' => 'PERINGKAT PENGAJIAN',
                        'format' => 'raw',
                    
                            
                             'value'=>function ($model)  {
                    
                             if($model->HighestEduLevel)
                             {
                             return $model->HighestEduLevel;}
                             else
                             {
    return strtoupper($model->tahapPendidikan);
                             }
                },
                            
                     
                        'vAlign' => 'middle',
                'hAlign' => 'center', 
                     
                    ],
                                              
                              [
                                            'header' => 'LKP',
                                            'headerOptions' => ['class'=>'text-center'],
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{mohon}',
                                            'buttons' => [
                                                'mohon' => function($url, $model) 
                                                {
                                                        $ICNO = $model->icno;
                                                        $url = Url::to(['kj-view-lkk', 'id'=>$ICNO]);
                                                       return 
                                                        Html::a('<i class="fa fa-bar-chart fa-xs"></i>', $url, ['title' => 'Lihat Laporan']); 
                                                    
                                                },
                                                        
                                                
                                                
                                        ],
                                                
                                            'contentOptions' => ['class' => 'text-center'],
                                        ],
                                
                            ],
                        ]); ?> 
            </div> <!-- x_content -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
<!--            <div class="x_title">
                <h2>Staf Akademik</h2>
                <div class="clearfix"></div>
            </div>-->
            <div class="x_title">
                <h4>LAPORAN KEMAJUAN PENGAJIAN (LKP) STAF AKADEMIK</h4><div  class="pull-right">
           </div>
            <div class="clearfix"></div>
            
        </div>
            <div class="x_content">
               <?= 
                        GridView::widget([
                            'dataProvider' => $dataProvider2,
//                             'filterModel' => false,
//                    'summary' => '',
                            //'filterModel' => $kursusJemputan,
                            'emptyText' => 'Tiada data ditemui.',
                            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                            'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                            'columns' => [
                                ['class' => 'kartik\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                ],
//                                [
//                                    'label' => 'Nama',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'left',
//                                    'format' => 'raw',
//                                    'value' => 'biodata.CONm',
//                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
//                                ],
                                [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA',
                            'headerOptions' => ['class'=>'column-title'],
//                             'filter' => Select2::widget([
//                            'name' => 'icno',
//                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPengajian::find()->where(['cb_tbl_pengajian.status'=>1])->joinWith('kakitangan.department')->all(), 'icno', 'kakitangan.CONm'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.
                                        '('.$model->kakitangan->jawatan->gred.')';
                            }, 
                                    
                                    'format' => 'html',
                        ],
//                                [
//                                    'label' => 'GRED',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'center',
//                                    'format' => 'raw',
//                                    'value' => 'kakitangan.jawatan.gred',
//                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//                                ],
                                    [
                        'label' => 'PERINGKAT PENGAJIAN',
                        'format' => 'raw',
                    
                            
                             'value'=>function ($model)  {
                    
                             if($model->HighestEduLevel)
                             {
                             return $model->HighestEduLevel;}
                             else
                             {
    return strtoupper($model->tahapPendidikan);
                             }
                },
                            
                     
                        'vAlign' => 'middle',
                'hAlign' => 'center', 
                     
                    ],
                                              
                              [
                                            'header' => 'LKP',
                                            'headerOptions' => ['class'=>'text-center'],
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{mohon}',
                                            'buttons' => [
                                                'mohon' => function($url, $model) 
                                                {
                                                        $ICNO = $model->icno;
                                                        $url = Url::to(['kj-view-lkk', 'id'=>$ICNO]);
                                                       return 
                                                        Html::a('<i class="fa fa-bar-chart fa-xs"></i>', $url, ['title' => 'Lihat Laporan']); 
                                                    
                                                },
                                                        
                                                
                                                
                                        ],
                                                
                                            'contentOptions' => ['class' => 'text-center'],
                                        ],
//                              
                            ],
                        ]); ?> 
            </div> <!-- x_content -->
        </div>
    </div>
</div>

            </div> <!-- x_content -->
        </div>
    </div>
</div>