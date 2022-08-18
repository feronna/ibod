<?php

$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
    
?>

<?= $this->render('_menuAdmin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Penetapan Tahun Penilaian</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <p>
                    <?php $form = ActiveForm::begin([]); ?>
                    <?= Html::button('Tambah Tahun Penilaian', [
                'value' => Url::to(['elnpt/tambah-tahun-penilaian']), 
                'class' => 'btn btn-success modalButton']); ?>
                    <?php ActiveForm::end(); ?>
                </p>
                
                <?php
                    Modal::begin([
                        'header' => 'Tambah / Kemaskini Tahun Penilaian',
                        'id' => 'modal',
                        'size' => 'modal-md',
                    ]);
                    echo "<div id='modalContent'></div>";
                    Modal::end();
                ?>
                
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
//                                [
//                                    'class' => 'yii\grid\SerialColumn',
//                                    'header' => 'BIL',
//                                    'headerOptions' => ['class'=>'text-center'],
//                                    'contentOptions' => ['class'=>'text-center'],
//                                ],
                                [
                                    'attribute' => 'lpp_tahun',
                                    'label' => 'TAHUN',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                ],
                                [
                                   //'attribute' => 'CONm',
                                    'label' => 'STATUS',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return $model->lpp_aktif == 'Y' ? 'Y' : 'N';
                                    },
                                ],
                                [
                                   //'attribute' => 'CONm',
                                    'label' => 'TARIKH MULA PENGISIAN BORANG',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return is_null($model->lpp_trkh_hantar)? 
                                        '' : $model->lpp_trkh_hantar;
                                    },
                                ],
                                [
                                   //'attribute' => 'CONm',
                                    'label' => 'TARIKH TAMAT PENGISIAN BORANG',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return is_null($model->pengisian_PYD_tamat)? 
                                        '' : $model->pengisian_PYD_tamat;
                                    },
                                ],
                                [
                                   //'attribute' => 'CONm',
                                    'label' => 'TARIKH TAMAT PENILAIAN PPP',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return is_null($model->penilaian_PPP_tamat)? 
                                        '' : $model->penilaian_PPP_tamat;
                                    },
                                ],
                                [
                                   //'attribute' => 'CONm',
                                    'label' => 'TARIKH TAMAT PENILAIAN PPK',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return is_null($model->penilaian_PPK_tamat)? 
                                        '' : $model->penilaian_PPK_tamat;
                                    },
                                ],
                                [
                                   //'attribute' => 'CONm',
                                    'label' => 'TARIKH TAMAT PENILAIAN PEER',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'value' => function($model) {
                                        return is_null($model->penilaian_PEER_tamat)? 
                                        '' : $model->penilaian_PEER_tamat;
                                    },
                                ],            
                                [
                                   //'attribute' => 'CONm',
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'JANA BORANG',
                                    'headerOptions' => ['class'=>'text-center col-md-2'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'template' => '{reset}',
                                    'buttons' => [
                                        'reset' => function ($url, $model) {
                                            //Html::a('label', ['/controller/action'], ['class'=>'btn btn-primary'])
                                        
                                            $url = Url::to(['elnpt/generate-lpp', 'tahun' => $model->lpp_tahun]);
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
                                   //'attribute' => 'CONm',
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'JANA MARKAH',
                                    'headerOptions' => ['class'=>'text-center col-md-2'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'template' => '{reset}',
                                    'buttons' => [
                                        'reset' => function ($url, $model) {
                                            //Html::a('label', ['/controller/action'], ['class'=>'btn btn-primary'])
                                        
                                            $url = Url::to(['elnpt/generate-markah', 'tahun' => $model->lpp_tahun]);
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
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center'],
                                    'template' => '{update}',
                                    //'header' => 'TINDAKAN',
                                    'buttons' => [
                                        'update' => function ($url, $model) {
                                            $url = Url::to(['elnpt/kemaskini-tahun-penilaian', 'tahun' => $model->lpp_tahun]);
                                            return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-default btn-sm modalButton']);

                                        },
                                    ],
                                ],
                                             
                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>