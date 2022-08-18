<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;

use app\models\gaji\TblStaffRoc;

?>

<?= $this->render('_menuUtama'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Laporan Pergerakan Gaji Biasa Tahunan</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <dl class="dl-horizontal">
                        <dt>Nama</dt>
                        <dd><?= $bio->gelaran->Title . ' ' . ucwords(strtolower($bio->CONm)) ?></dd>
                        <dt>Jabatan</dt>
                        <dd><?= $bio->department->fullname ?></dd>
                        <dt>UMSPER</dt>
                        <dd><?= $bio->COOldID ?></dd>
                        <dt>No. KP / Paspot</dt>
                        <dd><?= $bio->ICNO ?></dd>
                        <dt>Kampus Cawangan</dt>
                        <dd><?= ucwords(strtolower($bio->kampus->campus_name)) ?></dd>
                        <dt>Jawatan</dt>
                        <dd><?= $bio->jawatan->fname ?></dd>
                    </dl>
                </div>
                <hr>
                <div class="row">
                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'emptyText' => 'Tiada Rekod',
                            'summary' => '',
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                [
                                    'class' => 'kartik\grid\SerialColumn',
                                    'header' => 'Bil',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                //                                    [
                                //                                        'class' => 'kartik\grid\ExpandRowColumn',
                                //                                        'value' => function($model, $key, $index, $column) {
                                //                                            return GridView::ROW_COLLAPSED;
                                //                                        },
                                //                                        'detail' => function($model, $key, $index, $column) {
                                //                                            $searchModel = new TblStaffRoc();
                                //                                            $searchModel->SR_ENTRY_BATCH = $model->srb_batch_code;
                                //                                            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                                //                                            
                                //                                            return Yii::$app->controller->renderPartial('_elaun', [
                                //                                                'searchModel' => $searchModel,
                                //                                                'dataProvider' => $dataProvider,
                                //                                            ]);
                                //                                        },
                                //                                        'headerOptions' => ['class' => 'text-center'], 
                                //                                        'contentOptions' => ['class' => 'text-center'],         
                                //                                        'expandOneOnly' => true
                                //                                    ],
                                //                                    [
                                //                                        //'attribute' => 'SR_CHANGE_REASON',
                                //                                        'label' => 'Sebab Perubahan',
                                //                                        'headerOptions' => ['class' => 'text-center'], 
                                //                                        'contentOptions' => ['class' => 'text-center'],
                                //                                        'value' => function($model) {
                                //                                            return $model->reason->RR_REASON_DESC;
                                //                                        },
                                //                                        'format' => 'html',
                                //                                    ],
                                [
                                    'attribute' => 'srb_remarks',
                                    'label' => 'Catatan',
                                    'headerOptions' => ['class' => 'text-center'],
                                    //'contentOptions' => ['class' => 'text-center'],
                                    'format' => 'html',
                                ],
                                //                                    [
                                //                                        //'attribute' => 'SR_CHANGE_REASON',
                                //                                        'label' => 'JFPIU',
                                //                                        'headerOptions' => ['class' => 'text-center'], 
                                //                                        'contentOptions' => ['class' => 'text-center'],
                                //                                        'value' => function($model) {
                                //                                            return $model->department->dm_dept_desc;
                                //                                        },
                                //                                        'format' => 'html',
                                //                                    ],
                                [
                                    //'attribute' => 'SR_CHANGE_REASON',
                                    'label' => 'Tarikh Kuatkuasa',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        // return Yii::$app->formatter->asDate($model->srb_effective_date,'dd-MM-yyyy');
                                        return $model->staffRocSingle ? Yii::$app->formatter->asDate($model->staffRocSingle->SR_DATE_FROM, 'dd-MM-yyyy') : null;
                                    },
                                    'format' => 'html',
                                    'attribute' => 'srb_effective_date',
                                ],
                                [
                                    //'attribute' => 'SR_CHANGE_REASON',
                                    'label' => 'Tarikh Approve',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                        return Yii::$app->formatter->asDate($model->srb_approve_date, 'dd-MM-yyyy');
                                    },
                                    'format' => 'html',
                                    //'encodeLabel' => false,        
                                    'attribute' => 'srb_approve_date',
                                ],
                                [
                                    'attribute' => 'srb_status',
                                    'label' => 'Status',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'format' => 'html',
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Muat Turun',
                                    'headerOptions' => ['class' => 'text-center col-md-1'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'template' => '{print}',
                                    //'header' => 'TINDAKAN',
                                    'buttons' => [
                                        'print' => function ($url, $model) {
                                            $url = Url::to(['saraan/lpg-report', 'batch_code' => $model->srb_batch_code]);
                                            return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, [
                                                'title' => 'lpg', 'target' => '_blank',
                                            ]);
                                        },
                                    ],
                                ],
                                //                                    [
                                //                                       //'attribute' => 'CONm',
                                //                                        'label' => 'NAMA',
                                //                                        'headerOptions' => ['class'=>'column-title'],
                                //                                        'value' => function($model) {
                                //                                            return Html::a('<strong>'.$model->biodata->CONm.'</strong>', ['/dass21/view-assessment', 'id' => $model->id]).'<br><small>'.$model->department->fullname.'</small>'.
                                //                                                    '<br><small>'.$model->jawatan->nama.' '.$model->jawatan->gred;
                                //                                        }, 
                                //                                                'format' => 'html',
                                //                                    ],
                                //                                    [
                                //                                       //'attribute' => 'CONm',
                                //                                        'label' => 'JSPIU',
                                //                                        'headerOptions' => ['class'=>'text-center'],
                                //                                        'contentOptions' => ['class'=>'text-center'],
                                //                                        'value' => function($model) {
                                //                                            return $model->department->shortname;
                                //                                        },
                                //                                    ],
                                //                                    [
                                //                                       //'attribute' => 'CONm',
                                //                                        'label' => 'TARIKH / MASA',
                                //                                        'headerOptions' => ['class'=>'text-center'],
                                //                                        'contentOptions' => ['class'=>'text-center'],
                                //                                        'attribute' => 'created_dt'
                                //                                    ],            
                                //                                    [
                                //                                       //'attribute' => 'CONm',
                                //                                        'label' => 'TAHUN',
                                //                                        'headerOptions' => ['class'=>'text-center'],
                                //                                        'contentOptions' => ['class'=>'text-center'],
                                //                                        'attribute' => 'tahun'
                                //                                    ],
                                //                                    [
                                //                                       //'attribute' => 'CONm',
                                //                                        'label' => 'SKOR',
                                //                                        'headerOptions' => ['class'=>'text-center'],
                                //                                        //'contentOptions' => ['class'=>'text-center'],
                                //                                        'value' => function($model) use ($rubric){
                                //                                            foreach(array_reverse($rubric->depression_scale) as $key){
                                //                                                if($model->skor_d >= $key['score']) {
                                //                                                    $d_msg = $key['status'];
                                //                                                    break;
                                //                                                }
                                //                                            }
                                //
                                //                                            foreach(array_reverse($rubric->anxiety_scale) as $key){
                                //                                                if($model->skor_a >= $key['score']) {
                                //                                                    $a_msg = $key['status'];
                                //                                                    break;
                                //                                                }
                                //                                            }
                                //
                                //                                            foreach(array_reverse($rubric->stress_scale) as $key){
                                //                                                if($model->skor_s >= $key['score']) {
                                //                                                    $s_msg = $key['status'];
                                //                                                    break;
                                //                                                }
                                //                                            }
                                //
                                //                                            return '<ul><li>Depression : '.$model->skor_d.'/21 <b>'.$d_msg.'</b></li>'.
                                //                                                   '<li>Anxiety : '.$model->skor_a.'/21 <b>'.$a_msg.'</li>'.
                                //                                                   '<li>Stress : '.$model->skor_s.'/21 <b>'.$s_msg.'</b></li></ul>';
                                //                                        },
                                //                                                'format' => 'html',
                                //                                    ],
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