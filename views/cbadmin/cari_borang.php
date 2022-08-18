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

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$tmp = 'carian-borang-lpp';
$title = 'Carian borang LPP';
?>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Cari Borang</h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php $form = ActiveForm::begin(['action' => ['carian-borang'], 'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => 1]]); ?>
                
                <div class="form-group nama">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_pyd">Nama
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($searchModel, 'icno')->textInput(['id' => 'nama_pyd'])->label(false);
                        ?>
                    </div>
                </div>
               
                
            
              
            
                <div class="form-group tahun">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="senarai-tahun">Tahun</label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?=
                            $form->field($searchModel, 'tahun')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TblPenilaianDass21::find()->orderBy(['tahun' => SORT_DESC])->all(), 'tahun', 'tahun'),
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
            <h2>Hasil Carian Borang</h2>
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
                            'label' => 'NAMA',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>', ['/dass21/view-assessment', 'id' => $model->id]).'<br><small>'.$model->kakitangan->department->fullname.'</small>'.
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.$model->kakitangan->jawatan->gred;
                            }, 
                                    'format' => 'html',
                        ],
                        [
                           //'attribute' => 'CONm',
                            'label' => 'JSPIU',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                return $model->kakitangan->department->shortname;
                            },
                        ],
//                        [
//                           //'attribute' => 'CONm',
//                            'label' => 'TARIKH / MASA',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
//                            'attribute' => 'created_dt'
//                        ],            
                        [
                           //'attribute' => 'CONm',
                            'label' => 'TAHUN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'attribute' => 'tahun'
                        ],
                        
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