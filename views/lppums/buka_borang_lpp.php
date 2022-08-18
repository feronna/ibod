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
use app\models\hronline\Tblprcobiodata;
use yii\db\Expression;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$tmp = 'reset-borang-lpp';
//$title = 'Carian borang LPP untuk direset';
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">NAMA PEMOHON</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                        $form->field($searchModel, 'ICNO')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Tblprcobiodata::find()
                                     ->select(new Expression('CONCAT(CONm, \' - \', ICNO) as CONm, ICNO'))
                                    ->orderBy(['CONm' => SORT_ASC])->all(), 'ICNO', 'CONm'),
    //                        'data' => ['0' => 'TIADA', '1' => 'ADA'],
                            'hideSearch' => false,
                            'options' => [
                                'placeholder' => 'Carian Nama', 
                                'class' => 'form-control col-md-7 col-xs-12',
                                //'selected'    => 2,
                                //'id' => 'senarai',
                                ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
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
                <h2><strong>Senarai Borang Untuk Dibuka</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p>* Rekod akan auto-padam setelah tarikh tutup sudah lepas.</p>
                    <?= Html::button('Tambah Rekod', ['value' =>  Url::to(['lppums/buka-borang']), 'class' => 'btn btn-success btn-sm modalButton'])?>
                    <div class="table-responsive">
                    <?=
                        GridView::widget([
                            //'tableOptions' => [
                              //  'class' => 'table table-striped jambo_table',
                            //],
                            'emptyText' => 'Tiada Rekod',
                            'summary' => '',
                            'pager' => [
                                'class' => \kop\y2sp\ScrollPager::className(),
                                'container' => '.grid-view tbody',
                                'triggerOffset' => 10,
                                'item' => 'tr',
                                'paginationSelector' => '.grid-view .pagination',
                                'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
                             ],
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
                                    'label' => 'ID BORANG',
                                    'headerOptions' => ['class'=>'column-title text-center col-md-1'],
                                    'contentOptions' => ['class'=>'text-center'],
//                                    'value' => function($model) {
//                                        return Html::a('<strong>'.$model->pyd->CONm.'</strong>', ['/lppums/bahagian1', 'lpp_id' => $model->lpp_id]).'<br><small>'.$model->department->fullname.'</small>'.
//                                                '<br><small>'.$model->gredJawatan->nama.' '.$model->gredJawatan->gred;
//                                    }, 
                                    'value' => function($model){
                                        return $model->lpp_id;
                                    },
                                            'format' => 'html',
                                ],
                                [
                                   //'attribute' => 'CONm',
                                    'label' => 'NAMA PEMOHON',

                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'col-md-4'],

                                    'value' => function($model) {
                                        return isset($model->pemohon->CONm) ? $model->pemohon->CONm : $model->ICNO;

                                    },
                                ],
                                [
                                   //'attribute' => 'CONm',
                                    'label' => 'TARIKH TUTUP',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center col-md-2'],
                                    'value' => function($model) {
//                                        return 'PYD : '.(is_null($model->PYD_sah_datetime) ? '<i>Belum Sah</i>' : $model->PYD_sah_datetime.' <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>').'<br>'
//                                                .'PPP : '.(is_null($model->PPP_sah_datetime) ? '<i>Belum Sah</i>' : $model->PPP_sah_datetime.' <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>').'<br>'
//                                                .'PPK : '.(is_null($model->PPK_sah_datetime) ? '<i>Belum Sah</i>' : $model->PPK_sah_datetime.' <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>').'<br>';
                                        return $model->close_date;
                                    },
                                            'format' => 'raw',
                                ],
                                [
                                   //'attribute' => 'CONm',
                                    'label' => 'TINDAKAN',
                                    'headerOptions' => ['class'=>'text-center'],
                                    'contentOptions' => ['class'=>'text-center col-md-2'],
                                    'value' => function($model) {
//                                        $url = Url::to(['lppums/kemaskini-buka-borang', 'id' => $model->id]);
                                        return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => Url::to(['lppums/kemaskini-buka-borang', 'id' => $model->id]), 'class' => 'btn btn-default btn-sm modalButton']).
                                                Html::a('<span class="glyphicon glyphicon-trash"></span>', ['lppums/padam-buka-borang', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']);
                                    },
                                            'format' => 'raw',
                                ],            
//                                [
//                                    'class' => 'yii\grid\ActionColumn',
//                                    'header' => 'BUKA PENGISIAN BORANG',
//                                    'headerOptions' => ['class'=>'text-center col-md-1'],
//                                    'contentOptions' => ['class'=>'text-center'],
//                                    'template' => '{create}',
//                                    //'header' => 'TINDAKAN',
//                                    'buttons' => [
//                                        'create' => function ($url, $model) {
//                                            if(!is_null($model->requestLog)) {
//                                                return 'Sedang dibuka';
//                                            }else {
//                                                $url = Url::to(['lppums/buka-pengisian-borang', 'lppid' => $model->lpp_id,]);
//                                                return Html::a('<span class="glyphicon glyphicon-plus-sign"></span>', $url, [
//                                                    'title' => 'Buka borang',
//                                                ]);
//                                            }
//                                        },
//                                    ],
//                                ],
                            ],
                        ]);
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
                            Modal::begin([
                                'header' => 'Buka Borang LPP',
                                'id' => 'modal',
                                'size' => 'modal-md',
                            ]);
                            echo "<div id='modalContent'></div>";
                            Modal::end();
                    ?>