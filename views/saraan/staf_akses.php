<?php


$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
    $('.modalButton1').on('click', function () {
    $('#modal1').modal('show')
            .find('#modalContent1')
            .load($(this).attr('value'));
});
js;
$this->registerJs($js);

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\elnpt\Department;
use app\models\elnpt\Tblprcobiodata;
use yii\grid\CheckboxColumn;

use app\models\elnpt\testing\RefUserAccess;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<?= $this->render('_menuAdmin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Penetapan Staf Akses</strong></h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php $form = ActiveForm::begin(['action' => ['penetapan-staf-akses'], 'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => 1]]); ?>
            
                <div class="form-group nama">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kp_paspot">Staff
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                            $form->field($searchModel, 'staf_akses_icno')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(\app\models\hronline\Tblprcobiodata::find()->orderBy(['CONm' => SORT_ASC])->all(), 'ICNO', 'CONm'),
                                'options' => [
                                    'placeholder' => 'Carian ...', 
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    //'selected'    => 2,
                                    //'id' => 'senarai',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="senarai">Jenis Akses</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                            $form->field($searchModel, 'staf_akses_id')->label(false)->widget(Select2::classname(), [
//                                'data' => ['1' => 'ADA', '2' => 'TIDAK ADA'],
//                                'data' => ArrayHelper::map(RefUserAccess::find()->orderBy(['id' => SORT_ASC])->all(), 'id', 'desc'),
                                'data' => [
                                    '99' => 'ALL',
                                    '88' => 'INSERT, UPDATE, DELETE, VER_STATUS',
                                    '77' => 'INSERT, UPDATE, DELETE, APP_STATUS',
                                    '60' => 'INSERT, UPDATE, DELETE',
                                    '50' => 'VIEW ONLY',
                                ],
                                'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'Carian ...', 
                                    'class' => 'form-control col-md-7 col-xs-12',
                                    //'selected'    => 2,
                                    //'id' => 'senarai',
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
            <h2><strong>Hasil Carian</strong></h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <?= Html::button('Tambah Akses', ['value' => Url::to(['saraan/tambah-akses']), 'class' => 'btn-success btn-sm modalButton1']); ?>
            </div>
            
            <div class="row">
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
                            'headerOptions' => ['class'=>'text-center col-md-1'],
                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        [
                           //'attribute' => 'CONm',
                            'label' => 'NAMA',
                            'headerOptions' => ['class'=>'column-title'],
                            'value' => function($model) {
                                return '<strong>'.$model->biodata->CONm.'</strong><br><small>'.$model->biodata->department->fullname.'</small>'.
                                                '<br><small>'.$model->biodata->jawatan->nama.' '.$model->biodata->jawatan->gred;
                            },
                                    'format' => 'html'
                        ],
                        [
                           //'attribute' => 'CONm',
                            'label' => 'JSPIU',
                            'headerOptions' => ['class'=>'text-center col-md-2'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                return $model->biodata->department->shortname;
                            },
                        ],
                        [
                           //'attribute' => 'CONm',
                            'label' => 'AKSES',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                return $model->akses;
                            },
                            //'attribute' => 'test'
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'TINDAKAN',
                            'headerOptions' => ['class'=>'text-center col-md-1'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update} {delete}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['saraan/kemaskini-akses', 'ICNO' => $model->staf_akses_icno]);
                                    return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
                                },
                                'delete' => function ($url, $model) {
                                    $url2 = Url::to(['saraan/padam-akses', 'ICNO' => $model->staf_akses_icno]);
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url2, [
                                        'class' => 'btn btn-default btn-sm',
                                        'data' => [
                                                    'confirm' => 'Adakah anda ingin membuang rekod ini?',
                                                    'method' => 'post',
                                                ],
                                        ]);
                                    //Html::button('<span class="glyphicon glyphicon-trash"></span>', ['value' => $url2, 'class' => 'btn btn-default btn-sm']);
                                },         
                            ],
                        ],
                    ],
                ]);
            ?>
            </div>
            </div>
            <?php
                Modal::begin([
                    'header' => '<strong>Kemaskini Akses</strong>',
                    'id' => 'modal',
                    'size' => 'modal-lg',
                ]);
                echo "<div id='modalContent'></div>";
                Modal::end();
            ?>  
            
            <?php
                Modal::begin([
                    'header' => '<strong>Tambah Akses</strong>',
                    'id' => 'modal1',
                    'size' => 'modal-xs',
                ]);
                echo "<div id='modalContent1'></div>";
                Modal::end();
            ?>  
        </div> 
    </div></div>
    </div>