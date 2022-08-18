<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<style>
    .row i{
        color:green;
    }
    
    body .container.body .right_col{
        background: url(../images/myi.png) fixed;
        background-size: cover;color: black;
    }
    
</style>
<?= $this->render('_topmenu') ?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-10 center-margin">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Pengenalan / <i>Introduction</i></strong></h2>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <p align="center">
                <strong>MyIntegriti@UMS</strong>
            </p>
           <p>
1.	Soal selidik ini bertujuan untuk mengenal pasti tahap nilai integriti dalam kalangan kakitangan UMS dan tahap integriti organisasi di UMS. Hasil kajian ini dapat membantu dalam perancangan program-program pengukuhan dan pemantapan integriti organisasi.
<br><br>
2.	Anda dipohon untuk menjawab semua soalan dengan teliti dan jujur.
<br><br>
3.	Sebarang maklumat yang diperoleh akan dirahsiakan.
<br><br>
4.	Segala kerjasama daripada YBhg. Datuk/ Prof./ Dr. / Tuan/ Puan diucapkan terima kasih.

<br><br>	

Soal selidik ini dibahagian kepada Bahagian A & Bahagian B, Bahagian C dan 1 soalan umum.

<br><br>

<u>Bahagian A (69 Soalan) (anggaran 5 minit)</u>:-<br><br>

Tiap-tiap soalan diikuti oleh lima pilihan jawapan;<br><br>

1 - Tidak Tepat Dengan Diri Saya.<br>
2 - Kurang Tepat Dengan Diri Saya.<br>
3 - Hampir Tepat Dengan Diri Saya.<br>
4 - Tepat Dengan Diri Saya.<br>
5 - Sangat Tepat Dengan Diri Saya.<br><br>

<u>Bahagian B (41 Soalan) (anggaran 3 minit)</u>:-<br><br>

Tiap-tiap soalan diikuti oleh lima pilihan jawapan;<br><br>

1 - Sangat Tidak Setuju.<br>
2 - Tidak Setuju.<br>
3 - Agak Setuju.<br>
4 - Setuju.<br>
5 - Sangat Setuju.</i>
<br><br>

<u>Bahagian C (10 Soalan) (anggaran 2 minit)</u>:-<br><br>

Sila pilih sama ada YA atau TIDAK.
<br><br>

* Jawab semua soalan dengan memilih SATU jawapan mengikut kesesuaian dan bertepatan dengan situasi diri anda. Tiada jawapan yang betul atau salah.
</p>
<hr>
<p>
    <i>1. The purpose of this survey is to identify the level of integrity values amongst UMS staff and the level of organisational integrity in UMS. The findings from this survey will be useful for planning programmes on organisational integrity reinforcement and stabilisation. </i>
<br><br>
<i>2. You are requested to answer all questions carefully and honestly.</i>
<br><br>
<i>3. All information provided will be kept confidential.</i>
<br><br>
<i>4. Thank you for your cooperation.</i>
<br><br>

<i>This survey is divided into Part A, Part B, Part C and one general question.</i>

<br><br>

<u><i>Part A (69 questions) (estimate 5 minutes)</i></u>:-<br><br>

<i>Each question consists five answer options</i>;<br><br>

<i>1 - Not True to Myself.</i><br>
<i>2 - Less True to Myself</i><br>
<i>3 - Almost True to Myself</i><br>
<i>4 - True to Myself </i><br>
<i>5 - Very True to Myself </i><br><br>

<u><i>Part B (41 questions (estimate 3 minutes)</i></u>:-<br><br>

<i>Each question consists five answer options</i>;<br><br>

<i>1 - Strongly Disagree </i><br>
<i>2 - Disagree </i><br>
<i>3 - Somewhat Agree </i><br>
<i>4 - Agree </i><br>
<i>5 - Strongly Agree</i>
<br><br>

<u><i>Part C (10 questions) (estimate 2 minutes)</i></u>:-<br><br>

<i>Select YES or NO</i>
<br><br>

<i>* <i>Please answer all questions by selecting ONE answer based on the suitability and accuracy of your own situation. There is no right or wrong answer.</i></i>
</p>
            <?php if(!$haspending){?>
            <div class="ln_solid"></div>
            <div align="center">
                <?= Html::a('Mula Jawab / Start Answering', ['/myintegriti/bahagiana'], ['class'=>'btn', 'style' => 'background-color:green;color:white']) ?>
            </div><?php }?>
        </div>
    </div></div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-10 center-margin">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai soal selidik yang dijawab / <i>List of answered survey</i></strong></h2>
            
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
                            'header' => 'TAHUN / <i>YEAR</i>',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            //'attribute' => 'skor_d',
                            'value' => 'tahun',
                            'format' => 'html',
                        ],
                        [
                           //'attribute' => 'CONm',
                            'header' => 'TARIKH / <i>DATE</i>',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            //'attribute' => 'skor_d',
                            'value' => function($model){
                                return app\models\myintegriti\TblPenilaian::fdate($model->created_dt);
                            },
                            'format' => 'html',
                        ],
                        
                        [
                           //'attribute' => 'CONm',
                            'label' => 'STATUS',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center'],
                            //'attribute' => 'skor_d',
                            'value' => function ($model) {
                                $url = Url::to(['bahagiana', 'id' => $model->id,]);
                                $urlr = Url::to(['result', 'id' => $model->id,]);
                                if($model->status == 1){
                                    return $model->statuslabel.' '.Html::a('<i class="fa fa-edit fa-lg"></i>', $url, [
                                        'title' => 'Sambung Jawab / Continue Answering',
                                ]);}else{
                                    return $model->statuslabel.' '.Html::a('<i class="fa fa-info-circle fa-lg"></i>', $urlr, [
                                        'title' => 'Keputusan Penilaian / Assessment Result',
                                    ]);
                                }
                            },
                            'format' => 'html',
                        ],
                    ],
                ]);
            ?>    
        </div>
        </div>
    </div></div>
</div>