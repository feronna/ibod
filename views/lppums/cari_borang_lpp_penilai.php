<?php


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
$tmp = 'carian-borang-lpp-penilai';
$title = 'Carian borang LPP';
?>

<?= $this->render('_menuAdmin'); ?>

<?= $this->render('_carian_borang', ['model' => $searchModel, 'tmp' => $tmp, 'title' => $title]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Hasil Carian Borang LPP: Senarai Pegawai Pentadbiran <?= is_null($searchModel->tahun) ? '' : 'Bagi Tahun Penilaian '.$searchModel->tahun ;?></strong></h2>
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
                                'pager' => [
                                    'class' => \kop\y2sp\ScrollPager::className(),
                                    'container' => '.grid-view tbody',
                                    'triggerOffset' => 10,
                                    'item' => 'tr',
                                    'paginationSelector' => '.grid-view .pagination',
                                    'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
                                ],
                                'summary' => '',
                                'dataProvider' => $dataProvider,
                                'columns' => [
//                                    [
//                                        'class' => 'yii\grid\SerialColumn',
//                                        'header' => 'BIL',
//                                        'headerOptions' => ['class'=>'text-center'],
//                                        'contentOptions' => ['class'=>'text-center'],
//                                    ],
                                    [
                                       //'attribute' => 'CONm',
                                        'label' => 'ID BORANG',
                                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model) {
                                            return $model->lpp_id;
                                        },
                                    ],
                                    [
                                       //'attribute' => 'CONm',
                                        'label' => 'NAMA',
                                        'headerOptions' => ['class'=>'text-center'],
                                        //'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model) {
                                            return $model->pyd->CONm.'<br>'.$model->department->fullname.'</small>'.
                                                    '<br><small>'.$model->gredJawatan->nama.' '.$model->gredJawatan->gred;
                                        }, 
                                                'format' => 'html',
                                    ],
//                                    [
//                                       //'attribute' => 'CONm',
//                                        'label' => 'JAFPIB',
//                                        'headerOptions' => ['class'=>'text-center'],
//                                        'contentOptions' => ['class'=>'text-center'],
//                                        'value' => function($model) {
//                                            return $model->department->shortname;
//                                        },
//                                    ],
                                    [
                                       //'attribute' => 'CONm',
                                        'label' => 'TAHUN',
                                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model) {
                                            return $model->tahun;
                                        },
                                    ],            
                                    [
                                       //'attribute' => 'CONm',
                                        'label' => 'PPP',
                                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model) {
                                            return is_null($model->ppp) ? '-' : Html::a('<strong>'.$model->ppp->CONm.'</strong>', ['/lppums/bahagian1', 'lpp_id' => $model->lpp_id, 'icno' => $model->PPP], ['data-pjax' => 0, 'target' => '_blank']);
                                        },
                                                'format' => 'raw',
                                    ],
                                    [
                                       //'attribute' => 'CONm',
                                        'label' => 'PPK',
                                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model) {
                                            return is_null($model->ppk) ? '-' : Html::a('<strong>'.$model->ppk->CONm.'</strong>', ['/lppums/bahagian1', 'lpp_id' => $model->lpp_id, 'icno' => $model->PPK], ['data-pjax' => 0, 'target' => '_blank']);
                                        },
                                                'format' => 'raw',
                                    ],
                                    [
                                       //'attribute' => 'CONm',
                                        'label' => 'PP',
                                        'headerOptions' => ['class'=>'text-center'],
                                        'contentOptions' => ['class'=>'text-center'],
                                        'value' => function($model) {
                                            return is_null($model->ppAll) ? '-' : Html::a('<strong>'.$model->ppAll->CONm.'</strong>', ['/lppums/bahagian1', 'lpp_id' => $model->lpp_id, 'icno' => $model->PP_ALL], ['data-pjax' => 0, 'target' => '_blank']);
                                        },
                                                'format' => 'raw',
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
            </div>
        </div>
    </div>
</div>