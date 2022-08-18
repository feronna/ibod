<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Ln1Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<?php echo $this->render('/ln/_topmenu'); ?> 
</div>
</div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
     <div class="x_panel">
         <div class="x_title">
            <h2><strong>Rekod Permohonan Bertugas Rasmi Di Luar Negara</strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?></p>   
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'class' => 'table-responsive',
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn',
                    'header' => 'Bil.',
                    'vAlign' => 'middle',
                    'hAlign' => 'center',
                ],

            //'id',
            [
                        'label' => 'ICNO',
                        'value' => 'icno',
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
            //'icno',
            'kakitangan.CONm',
            //'tujuan',
            //'nama_tempat',
            //'negara',
            //'date_from',
            //'date_to',
            //'days',
            //'bil_peserta',
            //'perbelanjaan',
            //'dokumen_sokongan:ntext',
            //'entrydate',
            [
//                        'attribute' => 'status_jfpiu',
                        'label' => 'Tarikh Mohon',
                        'value' => 'entrydate',
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
            //'status',
            //'app_by',
            //'app_date',
            //'status_jfpiu',
             [
//                        'attribute' => 'status_jfpiu',
                        'label' => 'Status Perakuan Ketua Jabatan',
                        'value' => 'statusjfpiu',
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
            //'ulasan_jfpiu:ntext',
            //'ver_by',
            //'ver_date',
            //'status_semakan',
             [
//                        'attribute' => 'status_jfpiu',
                        'label' => 'Status Semakan Canselori',
                        'value' => 'statussemakan',
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
            //'ulasan_bsm:ntext',
            //'status_nc',
            [
//                        'attribute' => 'status_jfpiu',
                        'label' => 'Status Kelulusan NC',
                        'value' => 'statusnc',
                        'format' => 'raw',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
            //'ulasan_nc:ntext',
            //'tambang',
            //'elaun_makan',
            //'elaun_hotel',
            //'yuran',
            //'transport',
            //'dll',
            //'jumlah',

            [
                'class' => 'yii\grid\ActionColumn'],
            //['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'], 
        ],
    ]); ?>
        </div>
     </div>
</div>
</div>
