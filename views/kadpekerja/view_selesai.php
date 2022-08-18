<?php

use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;   
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\DetailView;
  
?> 
<?= $this->render('menu') ?> 
<div class="form-horizontal form-label-left"> 
    <div class="x_panel">
        <div class="x_title">
           <h2><strong><i class="fa fa-list"></i> Menunggu Pengambilan Kad Pekerja</strong></h2>
           <div class="form-group text-right">
            <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
            </div>
            <div class="clearfix"></div>
        </div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
    <div class="row"> 
     <div class="table-responsive col-md-6 col-sm-6 col-xs-6">
                <?=
                DetailView::widget([
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                    'model' => $kadPekerja,
                    'attributes' => [
                        [
                            'attribute' => 'biodata.CONm',
                            'value' => function($data) {
                                return ucwords(strtolower($data->biodata->gelaran->Title).' '.strtolower($data->biodata->CONm));
                            },
                        ],
                        [
                            'attribute' => 'biodata.ICNO',
                            'contentOptions' => ['style' => 'width:30%'],
                            'captionOptions' => ['style' => 'width:15%'],
                        ],
                        'biodata.COOldID',
                        [
                            'attribute' => 'biodata.COHPhoneNo',
                            
                        ],
                        [
                            'label' => 'No. UC',
                            'attribute' => 'biodata.COOUCTelNo',
                            
                        ],
                        [
                            'attribute' => 'biodata.COEmail',
                            
                        ],
                        [
                            'attribute' => 'biodata.statLantikan',
                             'value' => function($data) {
                                return ucwords(strtolower($data->biodata->displayStatusLantikan));
                            },
                        ],
                        [
                            'label' => 'Kampus Cawangan',
                             'value' => function($data) {
                                return ucwords(strtolower($data->biodata->kampus->campus_name));
                            },
                        ],
                        [
                            'attribute' => 'Jawatan',
                            'value' => function($data) {
                                return ucwords(strtolower($data->biodata->jawatan->nama).' ('.strtoupper($data->biodata->jawatan->gred).')');
                            },
                        ],
                        [
                            'label' => 'JFPIB',
                            'value' => function($data) {
                                return ucwords(strtolower($data->biodata->department->fullname));
                            },
                        ],
                      
                        
                        
                    ],
                ])
                ?>

            </div>
        <div class="table-responsive col-md-6 col-sm-6 col-xs-6">
                <?=
                DetailView::widget([
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                    'model' => $kadPekerja,
                    'attributes' => [
                      
                        [
                            'label' => 'Jenis Kad',
                            'value' => function($data) {
                                return ucwords(strtolower($data->kadPekerja->card_type));
                            }, 
                        ],
                        
                        [
                            'label' => 'Tarikh Mohon',
                            'value' => function($data) {
                                return ucwords(strtolower($data->entryDt));
                            }, 
                        ],
                        [
                            'label' => 'Tarikh/ Masa pengambilan',
                            'value' => function($data) {
                                return ucwords(strtolower($data->masa_ambil));
                            }, 
                        ],
                      
                        
                        
                    ],
                ])
                ?>

            </div>
        <div class="table-responsive col-md-6 col-sm-6 col-xs-6">
                <?=
                DetailView::widget([
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                    'model' => $resit,
                    'attributes' => [
                      
                        [
                            'label' => 'No. Resit',
                            'value' => function($data) {
                                return ucwords(strtolower($data->no_resit));
                            }, 
                        ],
                        
                        [
                            'label' => 'Pengemaskini',
                            'value' => function($data) {
                                return ucwords(strtolower($data->biodata->CONm));
                            }, 
                        ],
                        [
                            'label' => 'Tarikh Diluluskan',
                            'value' => function($data) {
                                return ucwords(strtolower($data->updater_dt));
                            }, 
                        ],
                      
                        
                        
                    ],
                ])
                ?>

            </div>
         
         

      
         
     
    </div></div></div>

     

    <?php ActiveForm::end(); ?> 

</div> 
</div>  
 