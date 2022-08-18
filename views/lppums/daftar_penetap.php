<?php

$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
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
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\lppums\TblLppTahun;

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
            <h2><strong>Carian Borang</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php $form = ActiveForm::begin(['id' => 'search',  'method' => 'get', 'options' => ['class' => 'form-horizontal form-label-left']]); ?>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">J/F/P/I/U</label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <?=
                            $form->field($searchModel, 'dept_id')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Department::find()->orderBy(['fullname' => SORT_ASC,])->all(), 'id', 'fullname'),
                                'hideSearch' => false,
                                'options' => [
                                    'placeholder' => 'Cari JFPIU', 
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    //'id' => 'jenis_carian',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun</label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <?=
                            $form->field($searchModel, 'tahun')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_ASC,])->all(), 'lpp_tahun', 'lpp_tahun'),
                                'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'Pilih Tahun', 
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    //'id' => 'jenis_carian',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-push-3 col-sm-6 col-xs-12">
                        <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">  
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Pendaftaran Penetap Penilai LNPT (Pentadbiran) Mengikut Tahunan</strong></h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                
            <?= Html::button('Tambah Penetap Penilai', ['value' =>  Url::to(['lppums/tambah-penetap-penilai']), 'class' => 'btn btn-success btn-sm modalButton'])?>    
                
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
                            'label' => 'TAHUN',
                            'headerOptions' => ['class'=>'text-center col-md-1'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                return $model->tahun;
                            }
                        ],
                        [
                           //'attribute' => 'CONm',
                            'label' => 'JFPIU',
                            'headerOptions' => ['class'=>'text-center col-md-3'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                return $model->department->fullname;
                            }
                        ],
                        [
                           //'attribute' => 'CONm',
                            'label' => 'PENETAP PENILAI',
                            'headerOptions' => ['class'=>'text-center'],
                            //'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                return '<strong>'.$model->penetap->CONm.'</strong><br><small>'
                                        .$model->penetapDept->fullname.
                                        '</small><br><small>'.$model->penetapGred->fname.'</small>';
                            },
                            'format' => 'html'
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                           //'attribute' => 'CONm',
                            'header' => 'TINDAKAN',
                            'headerOptions' => ['class'=>'text-center col-md-2'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{update} {delete}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    $url = Url::to(['lppums/kemaskini-penetap-penilai', 'id' => $model->id]);
                                    return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
                                },
                                'delete' => function ($url, $model) {
                                            $url2 = Url::to(['lppums/remove-penetap-penilai', 'id' => $model->id]);
                                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url2, ['class' => 'btn btn-default btn-sm']);
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
                        'header' => '<strong>Tambah / Kemaskini Akses Pegawai</strong>',
                        'id' => 'modal',
                        'size' => 'modal-xs',
                    ]);
                    echo "<div id='modalContent'></div>";
                    Modal::end();
                ?>
            </div> 
        </div>
    </div>
</div>    