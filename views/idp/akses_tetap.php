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

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<?= $this->render('/idp/_topmenu'); ?>

<?= $this->render('_carian_akses', ['model' => $searchModel]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">  
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Hasil Carian PYD: Senarai Kakitangan Pentadbiran (Aktif)</strong></h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
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
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                        ],
                        [
                           'attribute' => 'CONm',
                            'label' => 'NAMA',
                            'headerOptions' => ['class'=>'column-title'],
                        ],
                        [
                           //'attribute' => 'CONm',
                            'label' => 'JSPIU',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                return $model->department->shortname;
                            },
                        ],
                        [
                           //'attribute' => 'CONm',
                            'label' => 'AKSES',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'value' => function($model) {
                                return empty($model->staffAkses->akses_id) ? '-' : $model->staffAkses->akses_id;
                            },
                        ],
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
                                    $url = Url::to(['lppums/kemaskini-akses-pegawai', 'ICNO' => $model->ICNO]);
                                    return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);
                                    
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
                        'header' => '<strong>Kemaskini Akses Pegawai</strong>',
                        'id' => 'modal',
                        'size' => 'modal-lg',
                    ]);
                    echo "<div id='modalContent'></div>";
                    Modal::end();
                ?>
            </div> 
        </div>
    </div>
</div>    