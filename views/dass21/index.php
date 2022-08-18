<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Pengenalan / Introduction</strong></h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <p align="center">
                <strong>Ujian Saringan Minda Sihat / Depression Anxiety Stress Scales (DASS-21)</strong>
            </p>
            <p>
                Ujian saringan minda sihat ini bertujuan untuk mengetahui tahap kesihatan minda kakitangan dari sudut tekanan, kebimbangan dan kemurungan.<br>

                Ujian saringan ini mengandungi 21 soalan sahaja.<br><br>

                Tiap-tiap soalan diikuti oleh empat pilihan jawapan;<br><br>

                0 - Tidak Pernah<br>
                1 - Jarang<br>
                2 - Kerap<br>
                3 - Sangat Kerap<br><br>

                Jawab semua soalan dengan memilih SATU jawapan mengikut kesesuaian dan bertepatan dengan situasi diri anda semenjak seminggu kebelakang termasuk hari ini. Tiada jawapan yang betul atau salah.
            </p>
            <p>
                <i>The assessment measures the three related states of depression, anxiety and stress.</i><br><br>
                
                <i>Each question is followed by four answer options;</i><br><br>

                <i>0 - Never</i><br>
                <i>1 - Sometimes</i><br>
                <i>2 - Often</i><br>
                <i>3 - Almost Always</i><br><br>

                <i>Answer all questions by choosing ONE answer that indicates how much the statement applied to you over the past week.</i>
            </p>
            <div class="ln_solid"></div>
            <div align="center">
                <?= Html::a('Seterusnya / Next', ['/dass21/assessment'], ['class'=>'btn btn-success']) ?>
            </div>
        </div>
    </div></div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Keputusan Penilaian Terdahulu / Past Assessment Results</strong></h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
        <?=
                GridView::widget([
                    //'tableOptions' => [
                      //  'class' => 'table table-striped jambo_table',
                    //],
                    'emptyText' => 'Tiada Rekod Dijumpai / No Record Found',
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
                            'label' => 'SKALA KEMURUNGAN / DEPRESSION SCALE',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            //'attribute' => 'skor_d',
                            'value' => function($model) use ($rubric) {
                                foreach(array_reverse($rubric->depression_scale) as $key){
                                    if($model->skor_d >= $key['score']) {
                                        return $key['status'];
                                        //break;
                                    }
                                }
                            },
                                    'format' => 'html',
                        ],
                        [
                           //'attribute' => 'CONm',
                            'label' => 'SKALA KEBIMBANGAN / ANXIETY SCALE',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            //'attribute' => 'skor_d',
                            'value' => function($model) use ($rubric) {
                                foreach(array_reverse($rubric->anxiety_scale) as $key){
                                    if($model->skor_a >= $key['score']) {
                                        return $key['status'];
                                        //break;
                                    }
                                }
                            },
                                    'format' => 'html',
                        ],
                        [
                           //'attribute' => 'CONm',
                            'label' => 'SKALA TEKANAN / STRESS SCALE',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            //'attribute' => 'skor_d',
                            'value' => function($model) use ($rubric) {
                                foreach(array_reverse($rubric->stress_scale) as $key){
                                    if($model->skor_s >= $key['score']) {
                                        return $key['status'];
                                        //break;
                                    }
                                }
                            },
                                    'format' => 'html',
                        ],
                        [
                           //'attribute' => 'CONm',
                            'label' => 'TAHUN / YEAR',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'attribute' => 'tahun',
                                    'format' => 'html',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            //'header' => 'PPK',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            'template' => '{view}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    $url = Url::to(['dass21/result', 'id' => $model->id,]);
                                    return Html::a('<i class="fa fa-info-circle fa-lg"></i>', $url, [
                                        'title' => 'Keputusan Penilaian / Assessment Result',
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]);
            ?>    
        </div>
        </div>
    </div></div>
</div>