<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\dass\TblPenilaianDass21;
use kartik\date\DatePicker;
error_reporting(0);
?>
<div class="row">
<div class=col-xs-12 col-md-12 col-lg-12">
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
</div>
</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Cari Borang</h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php $form = ActiveForm::begin(['action' => ['carian-permohonan'], 'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => 1]]); ?>
                
                <div class="form-group nama">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CONm">Nama
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($searchModel, 'CONm')->textInput(['id' => 'CONm'])->label(false);
                        ?>
                    </div>
                </div>
               
                <div class="form-group tahun">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="senarai-tahun">Tahun</label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?=
                            $form->field($searchModel, 'tahun')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(\app\models\cbelajar\RekodCb::find()->orderBy(['tahun' => SORT_DESC])->all(), 'tahun', 'tahun'),
                                'options' => [
                                    'placeholder' => 'Pilih Tahun', 
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    //'selected'    => 2,
                                    'id' => 'senarai-tahun',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>
            
                
            
                <div class="ln_solid"></div>
            
                <div class="form-group">
                    <div class="pull-right">
                        <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div></div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>REKOD PENGAJIAN LANJUTAN - LAPOR DIRI</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <?=
                GridView::widget([
                    //'tableOptions' => [
                      //  'class' => 'table table-striped jambo_table',
                    //],
                    'emptyText' => 'Tiada Rekod',
                    'summary' => '',
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'header' => 'BIL',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                        ],
                         [
                           //'attribute' => 'CONm',
                            'label' => 'TAHUN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'attribute' => 'tahun'
                        ],
//                        [
//                           //'attribute' => 'CONm',
//                            'label' => 'NO. KAD PENGENALAN',
//                            'headerOptions' => ['class'=>'column-title'],
////                            'contentOptions' => ['class'=>'text-center'],
//                            'attribute' => 'icno'
//                        ],
                        
                        [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                return Html::a('<strong>'.$model->biodata->CONm.'</strong>').
                                        '<br><small>';
                            }, 
                                    'format' => 'html',
                        ],
//                        [
//                           //'attribute' => 'CONm',
//                            'label' => 'JSPIU',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
//                            'value' => function($model) {
//                                return $model->department->shortname;
//                            },
//                        ],
//                                 
                       
                                  
                        [
                           //'attribute' => 'CONm',
                            'label' => 'PERINGKAT PENGAJIAN',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'attribute' => 'HighestEduLevel'                       ],         
                                      
                      
                                     
                        [
                           //'attribute' => 'CONm',
                            'label' => 'INSTITUSI',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'attribute' => 'InstNm'                       ], 
                                    
                                        [
                           //'attribute' => 'CONm',
                            'label' => 'TARIKH MULA',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'attribute' => 'tarikh_mula'                       ], 
                                        [
                           //'attribute' => 'CONm',
                            'label' => 'TARIKH TAMAT',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'attribute' => 'tarikh_tamat'                       ], 
//                          
                                     [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS PENGAJIAN',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
                            'attribute' => 'status_pengajian'                       ],    
                        [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'TINDAKAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['bon','id' => $model->id,'ICNO' => $model->icno ]);
                                    return Html::button('<span class="	glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'mapBtn']);
                                    
                                },
                            ],
                        ], 
                          
//                                        [
//                        'label'=>'TINDAKAN',
//                        'format' => 'raw',
//                        'contentOptions' => ['class'=>'text-center'],                    
//                        'value'=>function ($data) {
//                       
//                        if($data->terima == NULL){
//                        $ICNO = $data->ICNO;
//                        
//                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['dass21/akses', 'id' => $data->icno]),'style'=>'background-color: transparent; 
//                        border: none;', 'class' => 'fa fa-edit fa-lg mapBtn']);}
////                        Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO]);}
//                        else{
//                            return Html::a('<i class="fa fa-info-circle fa-lg">', ["cbelajar/maklumat-pemohon", 'id' => $data->id, 'ICNO' => $ICNO ])|  Html::a('<i class="fa fa-info-circle fa-lg">', ["cutibelajar/tindakan-kj", 'id' => $data->id, 'ICNO' => $ICNO]);
//                        }
//                      },
//                    ],
                        /*[
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'PPK',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['lppums/penetapan-pegawai', 'lppid' => $model->lpp_id,]);
                                    return Html::a('<span class="glyphicon glyphicon-edit"></span>', $url, [
                                        'title' => 'Penetapan Pegawai',
                                    ]);
                                },
                            ],
                        ],*/
                    ],
                ]);
            ?>
            </div>
            
            </div> 
    </div></div>
    </div>