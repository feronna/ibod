<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url; 
use yii\widgets\ActiveForm;

error_reporting(0);
?>

<?php echo $this->render('/cutibelajar/_topmenu'); ?>  

<?php if($title == 'PROSES PEMBAYARAN ELAUN'){?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<div class="x_panel">
<div class="row"> 
     <div class="col-xs-12 col-md-12 col-lg-12">
         <div class="x_title">
        <h2><strong>PROSES PEMBAYARAN ELAUN</strong></h2>
        <div class="clearfix"></div>
    </div>
    
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
                            'label' => 'NAMA PEMOHON',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                $id = $model->id;
                                return Html::a('<u><strong>'.$model->kakitangan->CONm.'</u></strong>', ['/cutisabatikal/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id'=>$model->iklan_id]).' <br><small><b>UMSPER ('.$model->kakitangan->COOldID.')</b></small>'.'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred. '<br>Tarikh Mohon:'. $model->tarikhmohon;
                            }, 
                                    'format' => 'html',
                        ],
                        [
                        'label'=>'JENIS ELAUN',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($nilai) {
                                
                        if($nilai->terima == NULL){
                          
                           
                        $ICNO = $nilai->icno;
                        return Html::a('<i class="fa fa-list fa-lg">', 
                        ["/cutibelajar/semakan-syarat", 'id' => $nilai->id, 'ICNO' => $ICNO, 'takwim_id'=>$nilai->iklan_id]);
                        }
                        else{
                            return Html::a('<i class="fa fa-check fa-lg">', ["/cbelajar/view-semakan-syarat", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
                        }
                      },
                   
                    ],    
                       [
//                     'attribute' => 'status_jfpiu',
                        'label' => 'SEMAKAN ELAUN',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value' => ' ',
                        'format' => 'raw',
                      
                    ],
                       
//            [
//                        'label'=>'RINGKASAN KEPUTUSAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->icno;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['cutibelajar/tindakan_bsm', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-edit fa-lg mapBtn']);}
////                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
//                        else{
//                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
//                        }
//                      },
//                           
//                    ],
//                              
//                    [
//                        'label'=>'SALINAN SURAT TAWARAN',
//                        'format' => 'raw',
//                        'headerOptions' => ['class'=>'text-center'],
//                        'contentOptions' => ['class'=>'text-center'],
//                        'value'=>function ($data) {
//                         if ($data->checkUpload($data->id)){
//                         return  Html::a('', (Yii::$app->FileManager->DisplayFile($data->dokumen->dokumen)), ['class'=>'fa fa-check-square-o fa-lg', 'target' => '_blank']);}
//                        else{
//                          return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['uploadsurat', 'id' => $data->id]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-upload fa-lg mapBtn']);
//                        }
//                      },
//             ],
//              [
//                        'label' => 'PEMAKLUMAN KEPUTUSAN',
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
//                        return Html::a('<input type="radio" name="'.$data->id.'" value="y'.$data->id.'" '.$checked.'><i class="fa fa-check"></i>').'  '.Html::a('<input type="radio" name="'.$data->id.'" value="n'.$data->id.'" '.$checked1.'><i class="fa fa-remove"></i>');
//                      },
//                       
//                    ],
            
                              
            
                    [        
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => function ($data) { 
                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
                        return ['disabled' => 'disabled'];
                            }
                            return ['value' => $data->id, 'checked'=> true];
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


