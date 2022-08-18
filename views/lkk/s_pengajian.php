<?php
$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);
use kartik\export\ExportMenu;
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\web\JsExpression;

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

error_reporting(0);
?>
<?= $this->render('/cutibelajar/_topmenu') ?>
<!-- $this->render('/lkk/menu_jumlah')-->
 <?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

   
<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->
    <div class="x_title">
            <h5><strong>LAPORAN KEMAJUAN PENGAJIAN (LKP)</strong></h5>
            
            <div class="clearfix"></div>
        </div>
         <div class="x_content">
             
<?php
  echo Html::a(Yii::t('app','<i class="fa fa-address-card"></i> <span class="label label-info">REKOD KESELURUHAN</span>'), ['cbadmin/search-lkk'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-calendar"></i> <span class="label label-info">LKP BULANAN</span>'), ['cbadmin/lkk-report'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">SEMAKAN LKP</span>'), ['lkk/senaraisemakan'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-book"></i> <span class="label label-success">LAPORAN AKHIR</span>'), ['lkk/laporan-akhir'], ['class' => 'btn btn-default btn-lg']);


?>
         </div>
    </div>
      </div>

</div>


<?php if($title == 'Senarai Menunggu Semakan'){?>
<div class="x_panel">
<div class="row"> 
    
<div class="col-md-12 col-xs-12"> 
         <div class="x_title">
            <h5><strong><i class="fa fa-check-circle fa-lg" style="color:green"></i> SENARAI KAKITANGAN YANG MENGHANTAR LAPORAN AKHIR</strong></h5>
            <i style="color:green">Rekod ini hanya merangkumi peringkat pengajian bagi Pos Doktoral, Cuti Sabatikal, Sub Kepakaran, Pra Warta, Latihan Penyelidikan,Program Sangkutan dan Latihan Industri (IR).
               </i>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
             <?= GridView::widget([
                 'pager' => [
        'firstPageLabel' => 'First',
        'lastPageLabel'  => 'Last'
    ],
        'dataProvider' => $senarai,
                         'filterModel' => true,

//        'summary' => '',
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                 'options' => [
                'class' => 'table-responsive',
                    ],
        'columns' => [
//            ['class' => 'kartik\grid\SerialColumn',
//            'header' => 'No',
//            'vAlign' => 'middle',
//            'hAlign' => 'center',
//            ],
            ['class' => 'kartik\grid\SerialColumn',
             'header' => 'BIL',
             'contentOptions' => ['class'=>'text-center'],
              'vAlign' => 'middle',
            'hAlign' => 'center',
            ],
             [
                'label' => 'GRED SEMASA',
                'format' => 'raw',
                                              'options' => ['style' => 'width:20%'],

//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
                        'value' => function($model) {                                        
                                 return '<small>'. strtoupper($model->jawatancb->fname).'</small>';
                                
 },
            ],
         [
                'label' => 'PERINGKAT PENGAJIAN',
                'format' => 'raw',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
                        'value' => function($model) {                                        
                                 return '<small>'. strtoupper($model->tahapPendidikan).'</small>';
                                
 },
            ],
           
             
              
           [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA',
                            'headerOptions' => ['class'=>'column-title'],
                               'filter' => Select2::widget([
                            'name' => 'icno',
                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\TblLkk::find()->all(), 'icno', 'kakitangan.CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred;
                            }, 
                          
                                    'format' => 'html',
                        ],
                                    
                                    [
                'label' => 'STATUS PENGAJIAN',
                'format' => 'raw',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
                        'value' => function($model) {                                        
                                if ($model->lapor->study->status_pengajian && $model->lapor->agree == 1) {
                                        return '<span class="label label-success">' . ($model->lapor->study->status_pengajian) . '</span><br><small><b>'
                                        . strtoupper($model->lapor->dt_lapordiri) . '</small></b>';
                                    } 
                                    elseif ($model->lapor->status_a == "MANUAL") {
                                        return '<span class="label label-success">' . ($model->lapor->status_pengajian) . '</span><br><small><b>'
                                        . strtoupper($model->lapor->dt_lapordiri) . '</small></b>';
                                    } 
                                
 },
            ],
         
          [
                'label' => 'LAPORAN AKHIR',
                'format' => 'raw',
  'headerOptions' => ['class' => 'text-center'],
          'contentOptions' => ['class' => 'text-center'],
                        'value' => function($model) {
   if ($model->lapor->upload->dokumen5) {
    return Html::a('', (Yii::$app->FileManager->DisplayFile($model->lapor->upload->dokumen5)), ['class' => 'fa fa-download fa-lg', 'target' => '_blank']);

    
                                
 }
 else{
     return '<small><i>TIADA REKOD</small></i>';
                        }},
            ],
                                    
                                    

           
                                  


                    
               
                                                                                 

        ],
                 'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],  
                'resizableColumns' => false,
                'responsive' => false,
                'responsiveWrap' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
    ]); ?>
    </div>
        </div>
     
    </div>
</div></div><?php }?>
 