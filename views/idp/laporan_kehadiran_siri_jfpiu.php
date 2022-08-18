<?php
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\Pjax;
use app\models\myidp\BorangPenilaianLatihan;
use app\models\myidp\BorangPenilaianKeberkesanan;

/* @var $this yii\web\View */
/* @var $model app\models\Fruit */

error_reporting(0);

echo $this->render('/idp/_topmenu');

$dataProvider->pagination->pageParam = 'p-page';
$dataProvider->sort->sortParam = 'p-sort';

$dataProvider2->pagination->pageParam = 'a-page';
$dataProvider2->sort->sortParam = 'a-sort';

$gridColumns2 = [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions'=>['class'=>'kartik-sheet-style'],
                'width'=>'36px',
                'pageSummary'=>'Total',
                'pageSummaryOptions' => ['colspan' => 6],
                'header' => 'Bil',
                'headerOptions'=>['class'=>'kartik-sheet-style'],
//                                'header' => 'Bil',
//                                'vAlign' => 'middle',
//                                'hAlign' => 'center',
                
            ],
            [
                'label' => 'Nama',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtolower($data->peserta->displayGelaran)).' '.ucwords(strtolower($data->peserta->CONm));
                            }
            ],
////            [
////                'attribute' => 'CONm',
////                'contentOptions' => ['style' => 'width:400px;'],
////                'filterInputOptions' => [
////                    'class'  => 'form-control',
////                    'placeholder' => 'Cari...'
////                ],
////                'label' => 'Nama',
////                'value' => function ($data){
////                            return ucwords(strtolower($data->peserta->CONm));
////                            },
//////                'filter'    => ArrayHelper::map(Kehadiran::find()
//////                        ->joinWith('peserta')
//////                        ->where(['slotID' => $slotID])
//////                        ->all(), 'staffID', 'peserta.CONm'),
//////                'filterType' => GridView::FILTER_SELECT2,
////                'filterWidgetOptions' => [
////                    'pluginOptions' => ['allowClear' => true],
////                ],
////            ],
            [
                'label' => 'Jawatan Disandang',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtolower($data->peserta->jawatan->nama)).' ('.ucwords(strtoupper($data->peserta->jawatan->gred)).')';
                            }
            ],
            [
                'label' => 'JAFPIB',
                'format' => 'raw',
                'vAlign' => 'middle',
                'value' => function ($data){
                            return ucwords(strtoupper($data->peserta->department->shortname));
                            }
            ],
];

?>
<script>
    $(function(){
    
    $('.mapBtn').click(function (){
       $('#modal').modal('show')
               .find('#modalContent')
               .load($(this).attr('value'));
    });
    
    
    
});
</script>
<!--<style>
    .label{
        white-space: pre-wrap;
    }
</style>-->
<div class="row"> 
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h5>Semakan Kursus <h3><span class="label label-primary" style="color: white"><?= ucwords($model->sasaran3->tajukLatihan) ?></span></h3></h5>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">    
        <div class="x_title">
            <h5>Senarai
                <h3>
                    <span class="label label-success" style="color: white">Kehadiran</span>
                    
                    <?=
                    ExportMenu::widget([
                            'dataProvider' => $dataProvider2,
                            'columns' => $gridColumns2,
                            'filename' => 'Senarai Kehadiran Kursus '.ucwords(strtolower($model->sasaran3->tajukLatihan)).' Siri '.$model->siri.'',
                            'clearBuffers' => true,
                            'stream' => false,
                            'folder' => '@app/web/files/myidp/.',
                            'linkPath' => '/files/myidp/',
                            'batchSize' => 10,
                        ]); 
                    ?>
                
                </h3>
                
            </h5>
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php 
            Pjax::begin([
                    // PJax options
                ]);
            
            echo GridView::widget([
                    'dataProvider' => $dataProvider2,
                    //'filterModel' => $searchModel,
                    //'layout' => "{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Terakhir'
                    ],
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => $gridColumns2,
                ]);
            
            Pjax::end();
            ?>
        </div>
    </div>
</div>
</div>

