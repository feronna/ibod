<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

error_reporting(0);
?>

<?php if($title == 'Senarai Menunggu Semakan'){?>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

<div class="row"> 
     <div class="col-xs-12 col-md-12 col-lg-12"> 
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" 
                        aria-expanded="true"><b>Pemakluman Semakan</b></a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" 
                 data-toggle="tab" aria-expanded="false"><b>Penerimaan Lapor Diri</b></a>
                </li>
                           
            
              
            </ul>
        </div>
        <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab_content1" aria-labelledby="home-tab">
        <div class="x_content">
            <div class="table-responsive">
             <?= GridView::widget([
        'dataProvider' => $senarai,
        'summary' => '',
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                 'options' => [
                'class' => 'table-responsive',
                    ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',
            ],
            [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                 
                        if($model->status_pengajian == 1){
return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/adminviewselesai", 'id' => $model->iklan_id, 'i'=>$model->laporID]).' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Hantar:'. $model->tarikh_mohon;                            }
                             else{
return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lapordiri/adminview", 'id' => $model->iklan_id, 'i'=>$model->laporID]).' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Hantar:'. $model->tarikh_mohon;
                             }
                                
                            }, 
                                    'format' => 'html',
                        ],
                                    
               [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS KETUA JABATAN/DEKAN',
                            'headerOptions' => ['class'=>'text-center'],
                             'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->id;
                                return '<strong>'.$model->statusjfpiu.'</strong><br>'
                                        .$model->app_date;
                            }, 
                                    'format' => 'html',
                                    
                                    
                        ],
                                    
                        [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS PENGAJIAN',
                            'headerOptions' => ['class'=>'column-title text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->laporID;
                             if ($model->study->status_pengajian)
                             {
                                return Html::a($model->study->status_pengajian);
                             }
                             else
                             {
                                 return $model->status_pengajian;
                             }
                                
                            }, 
                                    'format' => 'html',
                        ],
                                    
//                           [
//                           //'attribute' => 'CONm',
//                            'label' => 'PENGESAHAN PERKHIDMATAN',
//                            'headerOptions' => ['class'=>'column-title text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
//                            'value' => function($model) {
////                                $ICNO = $model->icno;
////                                $id = $model->laporID;
//                             return  
//                        Html::a('<i class="fa fa-edit fa-lg">', ["status-perkhidmatan/view?icno=$model->icno"]);
//                                
//                            }, 
//                                   
//                                    'format' => 'html',
//                        ],
                                    
//                        [
//                           //'attribute' => 'CONm',
//                            'label' => 'TARIKH MULA NOMINAL DAMAGES',
//                            'headerOptions' => ['class'=>'column-title text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
//                            'value' => function($model) {
////                                $ICNO = $model->icno;
////                                $id = $model->laporID;
//                             return  
//                        Html::a('<i class="fa fa-legal fa-lg">', ["status-perkhidmatan/view?icno=$model->icno"]);
//                                
//                            }, 
//                                   
//                                    'format' => 'html',
//                        ],
            [
                        'label'=>'PERINCIAN STATUS PENGAJIAN',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($data) use ($pengajian){
                        if($data->kakitangan->Status == 1 && in_array($data->HighestEduLevelCd, [202,1,20]))
                        {
                             return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['v_rekod', 'id' =>$data->laporID]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit fa-lg mapBtn']);
                        }
                        elseif($data->terima == NULL){
                        $ICNO = $data->icno;
                        
                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['lapordiri/view_2', 'id'=>$pengajian->id,'laporID' => $data->laporID]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-legal fa-lg mapBtn']);}
//                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
                       
                        else{
                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                        }
                      },
                           
                    ],
                              
//                    [
//                        'label'=>'SALINAN SURAT TAWARAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                         if ($data->checkUpload($data->laporID)){
//                         return  Html::a('', (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen)), ['class'=>'fa fa-check-square-o fa-lg', 'target' => '_blank']);}
//                        else{
//                          return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsuratlapor', 'id' => $data->laporID]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-upload fa-lg mapBtn']);
//                        }
//                      },
//             ],
              [
                        'label' => 'PEMAKLUMAN',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($data) {
                        if($data->status_bsm == 'Draft Diluluskan'){
                            $checked = 'checked';
                        }
                        if($data->status_bsm == 'Draft Ditolak'){
                            $checked1 = 'checked';
                        }
                        if($data->status_bsm == 'Diluluskan' || $data->status_bsm == 'Tidak Diluluskan'){
                            return $data->statusbsm;
                        }
                        return Html::a('<input type="radio" name="'.$data->laporID.'" value="y'.$data->laporID.'" '.$checked.'><i class="fa fa-check"></i>').'  '.Html::a('<input type="radio" name="'.$data->laporID.'" value="n'.$data->laporID.'" '.$checked1.'><i class="fa fa-remove"></i>');
                      },
                       
                    ],
            
                              
            
                    [        
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => function ($data) { 
                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
                        return ['disabled' => 'disabled'];
                            }
                            return ['value' => $data->laporID, 'checked'=> true];
                            },
                     ],
            
        ],
    ]); ?>
    </div>
        </div>
          <div class="col-md-12 col-sm-12 col-xs-12" align="right">  
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2']) ?>
                </div>
      <?php ActiveForm::end(); ?>
    </div>
        </div></div><?php }?>

<?php if($title == 'Senarai Menunggu Perakuan'){?>
<div class="row"> 
     <div class="col-xs-12 col-md-12 col-lg-12"> 
    
        <div class="x_content">
            <div class="table-responsive">
             <?= GridView::widget([
        'dataProvider' => $senarai,
        'summary' => '',
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                 'options' => [
                'class' => 'table-responsive',
                    ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                ],
           [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong><br>').$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred.
                                    ' <br><small><strong>STATUS PENGAJIAN:</strong><strong> '. $model->study->status_pengajian.'</strong></small>';
                            }, 
                                    'format' => 'html',
                        ],
                                    [
                'label' => 'TARIKH MOHON',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>'tarikh_mohon',
            ],
              
           
           [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS KETUA JABATAN/DEKAN',
                            'headerOptions' => ['class'=>'text-center'],
                             'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->id;
                                return '<strong>'.$model->statusjfpiu.'</strong><br>'
                                        .$model->app_date;
                            }, 
                                    'format' => 'html',
                                    
                                    
                        ],
                                   [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS BSM',
                            'headerOptions' => ['class'=>'text-center'],
                             'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->id;
                                return '<strong>'.$model->statusbsm.'</strong><br>'
                                        .$model->ver_date;
                            }, 
                                    'format' => 'html',
                                    
                                    
                        ],
              
            [
                'label' => 'TINDAKAN',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($list) use ($iklan){
                                
                             if($list->status_pengajian == 1){
                        return Html::a('<i class="fa fa-edit">', ["tindakan-kj-selesai",  'i'=>$list->laporID]);
                            }
                             else{
                                                         return Html::a('<i class="fa fa-edit">', ["tindakan-kj", 'i'=>$list->laporID]);

                             }
//                            if($list->status_jfpiu === 'Tunggu Kelulusan'){
//                        return  
//                        Html::a('<i class="fa fa-edit">', ["tindakankj",  'id' => $list->iklan_id, 'i' => $list->laporID]);
//                            }
//                            else{
//                        return Html::a('<i class="fa fa-edit">', ["tindakan-kj", 'i'=>$list->laporID]);
//                            }
//                        
                      },
            ],
            
        ],
    ]); ?>
    </div>
        </div>
     
    </div>
</div><?php }?>
 <?php if($title == 'Senarai Menunggu Kelulusan'){?>
<div class="row"> 
     <div class="col-xs-12 col-md-12 col-lg-12"> 
    
        <div class="x_content">
            <div class="table-responsive">
             <?= GridView::widget([
        'dataProvider' => $senarai,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'summary' => '',
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                 'options' => [
                'class' => 'table-responsive',
                    ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',
                                ],
             [
                'label' => 'Nama Pemohon',
                'value' => 'kakitangan.CONm',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Jenis Permohonan',
                'value' => 'displayjenis.kemudahan',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Tarikh Mohon',
                'value' => 'entrydate',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
           
           
            [
                'label' => 'Status Ketua BSM',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>'status_jfpiu',
            ],
            [
                'label' => 'Tindakan',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($list){
                            if($list->status_kj == 'MENUNGGU TINDAKAN'   ){
                        return  
                        Html::a('<i class="fa fa-edit">', ["borangyuran/tindakan_kj", 'id' => $list->id]);
                            }
                            else{
                        return Html::a('<i class="fa fa-edit">', ["borangyuran/tindakan_kj", 'id' => $list->laporID]);
                            }
                        
                      },
            ],
            
        ],
    ]); ?>
    </div>
        </div>
     
    </div>
</div></div><?php }?></div>