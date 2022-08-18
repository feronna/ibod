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
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
?>
<script src="/pace/pace.js"></script>
<link href="/pace/themes/pace-theme-barber-shop.css" rel="stylesheet" />
<?php
error_reporting(0); 
?>
<div class="row">

<?= $this->render('/cutibelajar/_topmenu') ?>
    <?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

    <?php 

$gridColumns = [
    
                        ['class' => 'yii\grid\SerialColumn',
                            'header' => 'BIL',],

                        [
                'label' => 'SEMESTER/SESI',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
//                 'contentOptions' => ['class'=>'text-center'],
                 'value'=>function ($list)
                            {
                                return
                    '<small>: '.strtoupper($list->semester. ' / '. $list->session).'</small>';
                 }
                 
                 
            ],
                        [   
                            
                            'label' => 'NAMA KAKITANGAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->kakitangan->CONm));
                            },
                            'format' => 'raw'
                            
                        ],
                                    
                             [   
                            
                            'label' => 'NO KAD PENGENALAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->icno));
                            },
                            'format' => 'raw'
                            
                        ],
                         [
                'label' => 'JFPIB',
                'value'=>function ($data) {
                    return $data->kakitangan->department->shortname;
                },
                
                                            'format' => 'raw'

                          
            ],
                         [   
                            
                            'label' => 'INSTITUT/UNIVERSITI',
                            'value' => function ($data) {
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->pengajian->InstNm));
                            },
                            'format' => 'raw'
                            
                        ],
                                    
                                 
                        [   
                            
                            'label' => 'NEGARA',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return strtoupper($data->pengajian->negara->Country);
                            },
                            'format' => 'raw'
                            
                        ],
                                    
                           [   
                            
                            'label' => 'BIDANG',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                              
                                if(($data->pengajian->MajorCd == NULL) && ($data->pengajian->MajorMinor != NULL))
                        {
                                return  strtoupper($data->pengajian->MajorMinor);
                        }
                        elseif (($data->pengajian->MajorCd != NULL) && ($data->pengajian->MajorMinor != NULL))  {
                            return   strtoupper($data->pengajian->MajorMinor);

                        }
                        else
                        {
                          return   strtoupper($data->pengajian->major->MajorMinor);
                        }
                            },
                            'format' => 'raw'
                            
                        ],
                        
                         [   
                            
                            'label' => 'TARIKH PENGAJIAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return strtoupper($data->pengajian->tarikhmula).' HINGGA '.strtoupper($data->pengajian->tarikhtamat);
                            },
                            'format' => 'raw'
                            
                        ],   
                        [   
                            
                            'label' => 'LANJUTAN 01',
                            'value' => function ($data){
                                
//                             if($data->lanjutan->idLanjutan == 1)
//                             {
//                                 return $data->lanjutan->stlanjutan;
//                             }
                       
                             return strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno'=>$data->pengajian->icno,'idLanjutan'=>1])->one()->stlanjutan)
                             . ' HINGGA '.strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno'=>$data->pengajian->icno,'idLanjutan'=>1])->one()->ndlanjutan) ;
                     
                             
                    
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
//                                return  $data->tajaan->penajaan->penajaan.' - '.strtoupper($data->tajaan->nama_tajaan);

                            },
                            'format' => 'raw'
                            
                        ],
                                     [   
                            
                            'label' => 'LANJUTAN 02',
                            'value' => function ($data){
                                
//                             if($data->lanjutan->idLanjutan == 1)
//                             {
//                                 return $data->lanjutan->stlanjutan;
//                             }
                       
                             return strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno'=>$data->pengajian->icno,'idLanjutan'=>2])->one()->stlanjutan)
                             . ' HINGGA '.strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno'=>$data->pengajian->icno,'idLanjutan'=>2])->one()->ndlanjutan) ;
                       
                             
                    
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
//                                return  $data->tajaan->penajaan->penajaan.' - '.strtoupper($data->tajaan->nama_tajaan);

                            },
                            'format' => 'raw'
                            
                        ],
                                    [   
                            
                            'label' => 'LANJUTAN 03',
                            'value' => function ($data){
                                
//                             if($data->lanjutan->idLanjutan == 1)
//                             {
//                                 return $data->lanjutan->stlanjutan;
//                             }
                        
                             return strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno'=>$data->pengajian->icno,'idLanjutan'=>3])->one()->stlanjutan)
                             . ' HINGGA '.strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno'=>$data->pengajian->icno,'idLanjutan'=>3])->one()->ndlanjutan) ;
                        
                    
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
//                                return  $data->tajaan->penajaan->penajaan.' - '.strtoupper($data->tajaan->nama_tajaan);

                            },
                            'format' => 'raw'
                            
                        ],          
                        [   
                            
                            'label' => 'TARIKH AKHIR HANTAR LKP',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return strtoupper ($data->dt)
                                  ;
                            },
                            'format' => 'raw'
                            
                        ],   
                        
                        [
                        'label' => 'STATUS',
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function($list) {
                        if($list->status == NULL)
                        {
                               return 'BELUM HANTAR';
                        }
                        elseif ($list->status == "MANUAL UPLOAD")
                        {
                            return "<strong><small>TELAH DIHANTAR</small></strong><br>".  '<br> ['.$list->tarikh_hantar. ']';
                                  
                        }
                          elseif ($list->tarikh_mohon)
                        {
                            return "<strong><small>TELAH DIHANTAR</small></strong><br>".
                               '<br> ['.$list->tarikh_mohon. ']';
                        }
                        else {
                            return "<strong><small>BELUM BUAT PENGESAHAN</small></strong><br>";
                        }
                        }
                        ,
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                                 [
                        'label' => 'STATUS PENYELIA',
                        'attribute' => 'statuspenyelia',
                        'format' => 'raw',
                        'value' => function($model) {
                            if($model->status_r == "DONE")
                            {
                       return $model->statuspenyelia.'<br> ['.
                               $model->r_dt.' ]';
                            }
                            else
                            {
                                return 'MENUNGGU SEMAKAN';
                            }
                        }
                        ,
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                                [
                        'label' => 'STATUS KETUA JABATAN',
                        'attribute' => 'statuspenyelia',
                        'format' => 'raw',
                        'value' => function($model) {
                            if($model->status_r == "DONE" && $model->status_jfpiu == "Diperakukan")
                            {
                       return $model->statusjfpiu.'<br> ['.
                               $model->verify_dt.' ]';
                            }
                            else
                            {
                                return 'MENUNGGU SEMAKAN';
                            }
                        }
                        ,
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                                [
                        'label' => 'STATUS PENGHANTARAN LKP',
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function($model) {
                        if(($model->status == "DALAM TINDAKAN KETUA JABATAN" ) ||
                            ($model->status == "DALAM TINDAKAN BSM" ) || ($model->status == "TELAH DISEMAK" ))
                        {
                               return "<strong><small>ATAS TALIAN</small></strong>";
                        }
                        elseif ($model->status == "MANUAL UPLOAD")
                        {
                            return "<strong><small>MANUAL UPLOAD</small></strong><br>";
                        }
                        else
                        {
                            return "-";
                        }
                        }
                        ,
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                                       
                       [
                        'label' => 'GOT - PROPOSAL DEFENCE',
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function($model) {
                            if($model->got->result == 1)
                            {
                                return 'YES';
                            }
                            elseif ($model->got->result == 2)
                            {
                                return 'NO';
                            }
                            else
                            {
                                return 'NO RECORD';
                            }
                           
                        }
                        ,
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],   
                       [
                        'label' => 'KERJA KURSUS/CAMPURAN',
                        'attribute' => 'cw_gpa',
                        'format' => 'raw',
                        'value' => function($model) {
                            if($model->cw_gpa)
                            {
                           return $model->cw_gpa;
                            }
                            else
                            {
                                return '-';
                            }
                           
                        }
                        ,
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],   
                        
                        
                    ];


?>
    <div class="col-md-12 col-sm-12 col-xs-12 ">
    <p align="right">  <?= Html::a('Kembali', ['cbadmin/search-lkk'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
    
      </div>
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
    echo Html::a(Yii::t('app','<i class="fa fa-bar-chart"></i> <span class="label label-info">LKP</span>'), ['/cbadmin/lkk-report-fakulti'], ['class' => 'btn btn-default btn-lg']);

  echo Html::a(Yii::t('app','<i class="fa fa-list"></i> <span class="label label-info">LAIN - LAIN PERMOHONAN</span>'), ['cblainlain/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
   echo Html::a(Yii::t('app','<i class="glyphicon glyphicon-align-right"></i> <span class="label label-info">PELANJUTAN TEMPOH</span>'), ['lanjutancb/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);
  echo Html::a(Yii::t('app','<i class="fa fa-suitcase"></i> <span class="label label-info">LAPOR DIRI</span>'), ['lapordiri/senaraitindakan'], ['class' => 'btn btn-default btn-lg']);

?>
         </div>
        </div>
    </div>
</div>
  </div>
   


    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h5><strong><i class="fa fa-bar-chart"></i> LAPORAN KEMAJUAN PENGAJIAN KAKITANGAN AKADEMIK </strong></h5>
<!--                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>-->
<p align ="left">  <?=
                    ExportMenu::widget([
                            'dataProvider' => $dataProvider2,
                            'columns' => $gridColumns,
                            'filename' => 'LAPORAN PENGHANTARAN LKP BULANAN '.' '.$my,
                            'clearBuffers' => true,
                            'stream' => false,
                            'folder' => '@app/web/files/cb/.',
                            'linkPath' => '/files/cb/',
                            'batchSize' => 10,
                        ]); 
                ?></p>
            </div>
       
<!--             <h5>Senarai Kakitangan Akademik - Tidak Aktif Bergaji Penuh</h5>-->
            
            <div class="x_content">
                

                <?=
                GridView::widget([
                    
//                'options' => [
//                'class' => 'table-responsive',
//                    ],
                    'pager' => [
        'firstPageLabel' => 'First',
        'lastPageLabel'  => 'Last'
    ],
                    
                    'dataProvider' => $dataProvider2,
//                    'filterModel' => false,
//                 //        'summary' => '',
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                 'options' => [
                'class' => 'table-responsive',
                    ],
                    'columns' => [
                            ['class' => 'kartik\grid\SerialColumn',
                                'header' => 'BIL',
                                'vAlign' => 'middle',
                        'hAlign' => 'center',
                                ],
                        [
                'label' => 'SEMESTER/SESI',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
//                 'contentOptions' => ['class'=>'text-center'],
                 'value'=>function ($list)
                            {
                                return
                    '<small><strong>'.strtoupper($list->pengajian->tahapPendidikan).'</small></strong>'
                    .'<small>: '.strtoupper($list->semester. ' / '. $list->session).'</small>';
                 }
                 
                 
            ],
                    [
                        'label' => 'NAMA ',

                        'format' => 'raw',
                        'filter' => Select2::widget([
                            'name' => 'icno',
                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
                            'data' => ArrayHelper::map(\app\models\cbelajar\TblLkk::find()->where(['status_form'=>1])->all(), 'icno', 'kakitangan.CONm'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                        'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->laporID;
                                 return Html::a('<u><strong>'.$model->kakitangan->CONm.'</strong></u>', ['/lkk/kj-view-lkk?id='.$model->icno]).'</small>'.' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')';
                            }, 
                     
//                        'contentOptions' => ['style' => 'text-decoration: underline;'],
                        'vAlign' => 'middle',
//                        'hAlign' => 'center',
                         'group' => true,
                    ],
//                        [
//                        'label' => 'NAMA ',
//
//                        'format' => 'raw',
////                        'filter' => Select2::widget([
////                            'name' => 'icno',
////                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
////                            'data' => ArrayHelper::map(\app\models\cbelajar\TblLkk::find()->where(['status_form'=>1])->all(), 'icno', 'kakitangan.CONm'),
////                            'options' => ['placeholder' => ''],
////                            'pluginOptions' => [
////                                'allowClear' => true
////                            ],
////                        ]),
//                        'value' => function($model) {
////                                $ICNO = $model->icno;
////                                $id = $model->laporID;
//                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').
//                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.'('.$model->kakitangan->jawatan->gred.')';
//                            }, 
//                     
////                        'contentOptions' => ['style' => 'text-decoration: underline;'],
//                        'vAlign' => 'middle',
////                        'hAlign' => 'center',
//                         'group' => true,
//                    ],
//                        [
//                        'label' => 'JAWATAN',
//                        'value' => 'kakitangan.jawatan.fname',
////                        'filter' => Select2::widget([
////                            'name' => 'jawatan',
////                            'value' => isset(Yii::$app->request->queryParams['jawatan'])? Yii::$app->request->queryParams['jawatan']:'',
////                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPermohonan::find()->where(['jenis_user_id' => '1'])->all(), 'kakitangan.jawatan.id', 'kakitangan.jawatan.fname'),
////                            'options' => ['placeholder' => ''],
////                            'pluginOptions' => [
////                                'allowClear' => true
////                            ],
////                        ]),
//                        'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                             
//                            
//                    ],
//                         [
//                'label' => 'JFPIB',
//                'headerOptions' => ['style' => 'width:15%'],
//
//                'value'=>function ($data) {
//                    return $data->kakitangan->department->shortname;
//                },
////                'filter' => Select2::widget([
////                            'name' => 'jfpiu',
////                            'value' => $jfpiu,
////                            'data' => ArrayHelper::map(app\models\hronline\Department::find()->where(['isActive'=>1])->all(), 'id', 'shortname'),
////                            'options' => ['placeholder' => ''],
////                            'pluginOptions' => [
////                                'allowClear' => true
////                            ],
////                    
////                        ]),
//                 
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
//                        'group'=>true,
//                          
//            ],
                        
                   
                    
                                
//                                     
//                   
////                      'value' => 'HighestEduLevel',
//                      'vAlign' => 'middle',
//                      'hAlign' => 'center',
//                    ], 
//                    [
//                      'label' => 'Tarikh Tamat Pengajian',
//                      'value' => 'study.tarikhtamat',
//                   
////                      'value' => 'HighestEduLevel',
//                      'vAlign' => 'middle',
//                      'hAlign' => 'center',
//                    ],     
                    
//                    [
//                        'label' => 'Universiti',
//                        'value' => 'study.InstNm',
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                    ], 
                       
//                        [
//                         'attribute' => 'tarikh_m',
//                            'value' => 'tarikhmohon',
//                        'label' => 'Tarikh Mohon',
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                    ],
//                        [
//                'label' => 'TARIKH HANTAR LKK',
//                'value'=>function ($data) {
////                                          $year = date('m', strtotime($data->effectivedt));
//
//                    return $data->effectivedt;
//                },
//                'filter' => Select2::widget([
//                    
//                            'name' => 'effectivedt',
//                            'value' => $effectivedt,
//                            'data' => 
////        [
////                                1 => 'JANUARI', 2 => 'FEBRUARI', 3=>'MAC'],
//                    ArrayHelper::map(\app\models\cbelajar\TblLkk::find()->groupBy($year)->all(), 'effectivedt', 'effectivedt'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                    
//                        ]),
//                 
//                'vAlign' => 'middle',
//                'hAlign' => 'center',
//                          
//            ],
                        [
                        'label' => 'TARIKH AKHIR HANTAR LKP',
                        'attribute' => 'dt',
                        'format' => 'raw',
                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
                    ],
                        
                    [
                        'label' => 'STATUS',
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function($model) {
                        if($model->status == NULL)
                        {
                           return ' <i class="fa fa-upload  fa-xs" aria-hidden="true" style="color: blue"></i>';
                        }
                        elseif ($model->status == "MANUAL UPLOAD")
                        {
                            return '<strong><small>TELAH DIHANTAR</small></strong><br> '. 
                                    $model->tarikh_hantar;
                        }
                          elseif ($model->tarikh_mohon)
                        {
                            return '<strong><small>TELAH DIHANTAR</small></strong><br>'. 
                                    $model->tarikh_mohon;
                        }
                        else {
                            return "<strong><small>BELUM BUAT PENGESAHAN</small></strong><br>";
                        }
                        }
                        ,
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                              [
                        'label' => 'STATUS PENGHANTARAN LKP',
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function($model) {
                        if(($model->status == "DALAM TINDAKAN KETUA JABATAN" ) ||
                            ($model->status == "DALAM TINDAKAN BSM" ) || ($model->status == "TELAH DISEMAK" ))
                        {
                               return "<strong><small>ATAS TALIAN</small></strong>";
                        }
                        elseif ($model->status == "MANUAL UPLOAD")
                        {
                            return "<strong><small>MANUAL UPLOAD</small></strong><br>";
                        }
                        else
                        {
                            return "-";
                        }
                        }
                        ,
                            'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
//                                [
//                        'header' => 'TARIKH HANTAR',
//                        'attribute' => 'agree',
//                        'format' => 'raw',
//                        'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                         'filter' => Select2::widget([
//                            'name' => 'agree',
//                            'value' => $agree,
//                            'data' => ['1'=>'<span class="label label-warning">VERIFIED</span>',
//                                " " => '<span class="label label-success">NOT YET</span>',
//                               ],
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true,
//                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
//                            ],
//                        ]),
//                      'value' => function($model) {                                         
//                                 if($model->agree == 1)
//                                 {
//                                     return '<i class="fa fa-check-circle fa-xs" style="color:green"></i> ' . $model->tarikh_mohon;
//                                 }
//                                 else
//                                 {
//                                     return '<i class="fa fa-exclamation-triangle fa-xs" style="color:red"></i> '. "Not Verify Yet";
//                                 }
// },
//                    ], 
                                
//                                [
//                        'label' => 'TINDAKAN ADMIN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                        if($data->status_bsm == 'Draft Diluluskan'){
//                            $checked = 'checked';
//                        }
//                        if($data->status_bsm == 'Draft Ditolak'){
//                            $checked1 = 'checked';
//                        }
//                        if($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan'){
//                            return $data->statusbsm;
//                        }
//                        return Html::a('<input type="radio" name="'.$data->reportID.'" value="y'.$data->reportID.'" '.$checked.'><i class="fa fa-check"></i>').'  '.Html::a('<input type="radio" name="'.$data->reportID.'" value="n'.$data->reportID.'" '.$checked1.'><i class="fa fa-remove"></i>');
//                      },
//                       
//                    ],
//                        [
//                                            'label' => 'STATUS BORANG',
//                                            'headerOptions' => ['class' => 'text-center'],
//                                            'value' => function($model) {
//
//                                                $url = Url::to(['nyahaktif-lkk', 'id' => $model->reportID]);
//                                                return Html::button('<i class="fa fa-power-off fa-xs"></i>', ['value' => $url, 'class' => 'btn btn-primary btn-xs modalButton']);
//                                            },
//                                                    'format' => 'raw',
//                                                    'contentOptions' => ['class' => 'text-center'],
//                                                ],
//                        [
//                        'label'=>'Tindakan',
//                        'format' => 'raw',
//                            'vAlign' => 'middle',
//                        'hAlign' => 'center',
//                        'value'=>function ($data) {
//                        //return Html::a('<i class="fa fa-edit">', ["kontrak/tindakan_bsm", 'id' => $data->id]);
//                        if($data->status!='5' && $data->status!='4'){
//                       return
//                        Html::a('<i class="fa fa-edit">', ["status-perkhidmatan/view", 'icno' => $data->icno], ['target' => '_blank',  'data-toggle'=>'tooltip', 
//                        'title'=>'Ubah Status Perkhidmatan']);}
//                        else{
// 
//                            return Html::a('<i class="fa fa-edit">', ["kontrak/permohonankontrak", 'id' => $data->id], ['target' => '_blank']);
//                        }
//                      },
//             ],
                    [
                                            'header' => 'LKP',
                                            'headerOptions' => ['class'=>'text-center'],
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{mohon}',
                                            'buttons' => [
                                                'mohon' => function($url, $model) 
                                                {
                                                        $ICNO = $model->icno;
                                                        if($model->status == NULL)
                        {
                               return ' <i class="fa fa-exclamation fa-md" aria-hidden="true" style="color: blue"></i>';
                        }
                                                        elseif ($model->status == "MANUAL UPLOAD")
                                                        {
                                                           $url = Url::to(['lkk/lihat-borang-kj', 'id'=>$model->reportID]);
                                                       return 
                                                        Html::a('<i class="fa fa-bar-chart  fa-md" aria-hidden="true" style="color: green"></i>', $url, ['title' => 'Lihat LKP']);   
                                                        }
                                                        else
                                                        {
                                                        $url = Url::to(['lkk/tindakan-kj', 'i'=>$model->reportID]);
                                                       return 
                                                        Html::a('<i class="fa fa-bar-chart  fa-md" aria-hidden="true" style="color: green"></i>', $url, ['title' => 'Lihat LKP']); 
                                                        }
                                                },
                                                        
                                                
                                                
                                        ],
                                                
                                            'contentOptions' => ['class' => 'text-center'],
                                        ],
//                                        [
//                                            'header' => 'MANUAL',
//                                            'headerOptions' => ['class'=>'text-center'],
//                                            'class' => 'yii\grid\ActionColumn',
//                                            'template' => '{mohon}',
//                                            'buttons' => [
//                                                'mohon' => function($url, $model) 
//                                                {
//                                                        $ICNO = $model->icno;
//                                             
//                                                        if($model->status == NULL)
//                         {
//                                                           $url = Url::to(['lkk/borang-sokongan', 'id'=>$model->reportID]);
//                                                       return 
//                                                        Html::a('<i class="fa fa-upload  fa-md" aria-hidden="true" style="color: blue"></i>',$url, ['title' => 'Upload Manual','target' => '_blank']);   
//                                                        }
//                                                       
//                                                      
//                                                        else
//                                                        {
//                                                           return ' <i class="fa fa-check-circle" aria-hidden="true" style="color: green"></i>';
//                                                        }
//                                                },
//                                                        
//                                                
//                                                
//                                        ],
//                                                
//                                            'contentOptions' => ['class' => 'text-center'],
//                                        ],
//                              [
//                'class' => 'yii\grid\CheckboxColumn',
//                'checkboxOptions' => function ($data) { 
//                if(($data->status_bsm=='4' ||$data->status_bsm=='5')){
//                return ['disabled' => 'disabled'];
//                }
//                return ['value' => $data->id, 'checked'=> true];
//                },
//            ],
                ],
                
                'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                'resizableColumns' => true,
                'responsive' => false,
                'responsiveWrap' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
                ]);
                ?>
                
                 
            </div>
         

        </div>
    </div>
</div>
