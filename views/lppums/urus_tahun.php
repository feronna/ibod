<?php

$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use yii\bootstrap\Modal;

?>

<?= $this->render('_menuAdmin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Pengurusan Tahun Penilaian</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    
                    <?= Html::button('Tambah Tahun Penilaian', ['value' =>  Url::to(['lppums/tambah-tahun-penilaian']), 'class' => 'btn btn-success btn-sm modalButton'])?>
                    
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
                                        'attribute' => 'lpp_tahun',
                                        'label' => 'TAHUN',
                                        'headerOptions' => ['class'=>'text-center col-md-1'],
                                        'contentOptions' => ['class'=>'text-center'],
                                    ],
                                    [
                                       //'attribute' => 'CONm',
                                        'label' => 'STATUS',
                                        'headerOptions' => ['class'=>'text-center col-md-1'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model) {
                                            return $model->lpp_aktif == 'Y' ? 'Y' : 'N';
                                        },
                                    ],
                                    [
                                       //'attribute' => 'CONm',
                                        'label' => 'TARIKH PENETAPAN SKT',
                                        'headerOptions' => ['class'=>'text-center col-md-3'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model) {
                                            return is_null($model->tetap_skt_mula) && is_null($model->tetap_skt_tamat) ? 
                                            '' : Yii::$app->formatter->asDate($model->tetap_skt_mula, 'dd/MM/yyyy').' - '.Yii::$app->formatter->asDate($model->tetap_skt_tamat, 'dd/MM/yyyy');
                                        },
                                    ],
                                    [
                                       //'attribute' => 'CONm',
                                        'label' => 'TARIKH TAMBAH / GUGUR SKT',
                                        'headerOptions' => ['class'=>'text-center col-md-3'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model) {
                                            return is_null($model->kajian_skt_mula) && is_null($model->kajian_skt_tamat) ? 
                                            '' : Yii::$app->formatter->asDate($model->kajian_skt_mula, 'dd/MM/yyyy').' - '.Yii::$app->formatter->asDate($model->kajian_skt_tamat, 'dd/MM/yyyy');
                                        },
                                    ],
                                    [
                                       //'attribute' => 'CONm',
                                        'label' => 'TARIKH PENGESAHAN PYD',
                                        'headerOptions' => ['class'=>'text-center col-md-3'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model) {
                                            return is_null($model->pengisian_PYD_tamat)? 
                                            '' : Yii::$app->formatter->asDate($model->pengisian_PYD_tamat, 'dd/MM/yyyy');
                                        },
                                    ],
                                    [
                                       //'attribute' => 'CONm',
                                        'label' => 'TARIKH PENILAIAN PPP',
                                        'headerOptions' => ['class'=>'text-center col-md-3'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model) {
                                            return is_null($model->penilaian_PPP_tamat)? 
                                            '' : Yii::$app->formatter->asDate($model->penilaian_PPP_tamat, 'dd/MM/yyyy');
                                        },
                                    ],
                                    [
                                       //'attribute' => 'CONm',
                                        'label' => 'TARIKH PENILAIAN PPK',
                                        'headerOptions' => ['class'=>'text-center col-md-3'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model) {
                                            return is_null($model->penilaian_PPK_tamat)? 
                                            '' : Yii::$app->formatter->asDate($model->penilaian_PPK_tamat, 'dd/MM/yyyy');
                                        },
                                    ],            
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => 'JANA LAPORAN',
                                        'headerOptions' => ['class'=>'text-center col-md-2'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'template' => '{jana}',
                                        'buttons' => [
                                            'jana' => function ($url, $model) {
                                                //Html::a('label', ['/controller/action'], ['class'=>'btn btn-primary'])
                                                $url = Url::to(['lppums/generate-lpp', 'tahun' => $model->lpp_tahun]);
                                                return ($model->lpp_aktif == 'Y') ? 
                                                Html::a('<span class="glyphicon glyphicon-cog"></span>', 
                                                        $url,
                                                        [
                                                            'class' => 'btn btn-default btn-sm',
                                                        ]) : '';

                                            },
                                        ],
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => 'JANA MARKAH',
                                        'headerOptions' => ['class'=>'text-center col-md-2'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'template' => '{jana}',
                                        'buttons' => [
                                            'jana' => function ($url, $model) {
                                                //Html::a('label', ['/controller/action'], ['class'=>'btn btn-primary'])
                                                $url = Url::to(['lppums/generate-markah', 'tahun' => $model->lpp_tahun]);
                                                return ($model->lpp_aktif == 'Y') ? 
                                                Html::a('<span class="glyphicon glyphicon-cog"></span>', 
                                                        $url,
                                                        [
                                                            'class' => 'btn btn-default btn-sm',
                                                        ]) : '';

                                            },
                                        ],
                                    ],                
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                       //'attribute' => 'CONm',
                                        'header' => 'TINDAKAN',
                                        'headerOptions' => ['class'=>'text-center col-md-1'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'template' => '{update}',
                                        //'header' => 'TINDAKAN',
                                        'buttons' => [
                                            'update' => function ($url, $model) {
                                                $url = Url::to(['lppums/kemaskini-tahun-penilaian', 'tahun' => $model->lpp_tahun]);
                                                return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);

                                            },
                                        ],
                                    ],
                                ],
                            ]);
                        ?>
                    </div>
                    <?php
                            Modal::begin([
                                'header' => 'Tambah/Kemaskini Tahun Penilaian',
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
</div>