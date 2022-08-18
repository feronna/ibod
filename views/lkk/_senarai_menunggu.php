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
                                $ICNO = $model->icno;
                                $id = $model->reportID;
                                return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ["lkk/adminview", 'id'=>$model->reportID]).' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikh_mohon;
                            }, 
                                    'format' => 'html',
                        ],
            [
                        'label'=>'RINGKASAN KEPUTUSAN',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($data) {
                       
                        if($data->terima == NULL){
                        $ICNO = $data->icno;
                        
                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['cbadmin/tindakan_bsmlkk', 'id' => $data->reportID]),'style'=>'background-color: transparent; 
                        border: none;', 'class' => 'fa fa-edit fa-lg mapBtn']);}
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
//                         if ($data->checkUpload($data->reportID)){
//                         return  Html::a('', (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen_sokongan2)), ['class'=>'fa fa-check-square-o fa-lg', 'target' => '_blank']);}
//                        else{
//                          return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsurat', 'id' => $data->reportID]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-upload fa-lg mapBtn']);
//                        }
//                      },
//             ],
              [
                        'label' => 'PEMAKLUMAN KEPUTUSAN',
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
                        return Html::a('<input type="radio" name="'.$data->reportID.'" value="y'.$data->reportID.'" '.$checked.'><i class="fa fa-check"></i>').'  '.Html::a('<input type="radio" name="'.$data->reportID.'" value="n'.$data->reportID.'" '.$checked1.'><i class="fa fa-remove"></i>');
                      },
                       
                    ],
            
                              
            
                    [        
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => function ($data) { 
                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
                        return ['disabled' => 'disabled'];
                            }
                            return ['value' => $data->reportID, 'checked'=> true];
                            },
                     ],
            
        ],
    ]); ?>
    </div>
        </div>
          <div class="col-md-12 col-sm-12 col-xs-12" align="right">  
                    <?= Html::a('<i class="fa fa-book"></i> Statisik Data', ['ringkasan_data'], ['class'=>'btn btn-danger', 'target' => '_blank']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2']) ?>
                </div>
      <?php ActiveForm::end(); ?>
    </div>
</div><?php }?>

<?php if($title == 'Senarai Menunggu Perakuan'){?>
<div class="row"> 
     <div class="col-xs-12 col-md-12 col-lg-12"> 
         <p align="right"> <?= Html::a('SENARAI KESELURUHAN', ['cbadmin/lkk-report-fakulti'], 
                 ['class' => 'btn btn-primary btn-sm','target' => "_blank"]) ?></p>
        <div class="x_content">
            <div class="table-responsive">
             <?= GridView::widget([
                    'pager' => [
        'firstPageLabel' => 'First',
        'lastPageLabel'  => 'Last'
    ],
        'dataProvider' => $senarai,
//        'summary' => '',
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                 'options' => [
                'class' => 'table-responsive',
                    ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL',
                                ],
            
            [
                'label' => 'SEMESTER/SESI',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                 'value'=>function ($list)
                            {
                                return $list->semester. ' / '. $list->session;
                 }
            ],
              
           [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred;
                            }, 
                                    'format' => 'html',
                        ],
                                    [
                'label' => 'TARIKH HANTAR',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>'tarikh_hantar',
            ],
                                    
            [
                'label' => ' STATUS PENYELIA',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($list) 
                {
                                return $list->statuspenyelia.'<br>'.$list->r_dt;
                }
            ],
           [
                'label' => 'STATUS DEKAN/PENGARAH',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($list) 
                {
                if($list->status_r == "DONE" || $list->status_r == "BYPASS")
                {
                                return $list->statusjfpiu.'<br>'.$list->verify_dt;
                }
                else
                {
                    return '-';
                }
                }
            ],
                    [
                'label' => 'STATUS BSM',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($list) 
                {
                if($list->verify_dt)
                {
                                return $list->statusbsm.'<br>'.$list->ver_date;
                }
                else
                {
                    return '-';
                }
                }
            ],
              
            [
                'label' => 'LKP',
                'format' => 'raw',
                            'headerOptions' => ['style' => 'width:10%','class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($list) use ($iklan){
                            if($list->status_jfpiu === 'Tunggu Kelulusan'){
                        return  
                        Html::a('<i class="fa fa-bar-chart">', ["tindakankj",  'i' => $list->reportID]);
                            }
                            elseif($list->HighestEduLevelCd == 210)
                            {
                                                     return Html::a('<i class="fa fa-bar-chart">', ["pengesahan-kj-ir", 'id'=>$list->reportID ]);
   
                            }
                            else{
                        return Html::a('<i class="fa fa-bar-chart">', ["tindakan-kj", 'i'=>$list->reportID ]);
                            }
                        
                      },
            ],
                              
                              [
                'label' => 'OVERALL PERFORMANCE',
                'format' => 'raw',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                'value'=>function ($list) 
                {
                       
                     $c = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID,'idKriteria'=>5])->one();
                     $b = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID,'idKriteria'=>7])->one();
                     $a = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID,'idKriteria'=>6])->one();
                     $d = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID,'idKriteria'=>4])->one();
                     $e = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID,'idKriteria'=>3])->one();
                     $f = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID,'idKriteria'=>2])->one();
                      $g = \app\models\cbelajar\Rating::find()->where(['idLkk' => $list->reportID,'idKriteria'=>1])->one();

                     if($list->status_r == "DONE")
                {
                        $total = 0;
                         $total = ($a->p_komen + $b->p_komen + $c->p_komen + $d->p_komen
                                  + $e->p_komen + $f->p_komen + $g->p_komen);
                     return '<strong style="color:red">'.round(( $total / 56) * 100).'%'
                                    .'</strong>';
                     
//                       return '<strong style="color:red">'.(( $c->p_komen  / 8) * 100).'%'
//                                    .'</strong>';
                }
                else
                {
                    return '-';
                }
                }
            ],
                              
//           [
//                'label' => 'COMPLETED BY DEAN/DIRECTOR',
//                'format' => 'raw',
//                'headerOptions' => ['class'=>'text-center'],
//                                'contentOptions' => ['class'=>'text-center'],
//                'value'=>function ($list) use ($iklan){
//                            if($list->status_jfpiu === 'Tunggu Kelulusan'){
//                        return  
//                        Html::a('<i class="fa fa-edit">', ["tindakankj",  'i' => $list->reportID]);
//                            }
//                            elseif ($list->pengajian->HighestEduLevelCd == 1){
//                        return Html::a('<i class="fa fa-edit">', ["kj-achievement-phd?i=".$list->reportID.'&id='.$list->icno ]);
//                            }
//                            else
//                            {
//                            return Html::a('<i class="fa fa-edit">', ["kj-achievement-master?i=".$list->reportID.'&id='.$list->icno ]);
// 
//                            }
//                        
//                      },
//            ],
            
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
</div><?php }?>