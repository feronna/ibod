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
            <h2><strong><?php echo $title;?></strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a></li>-->
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <?= GridView::widget([
            //'dataProvider' => $dataProvider,
            'dataProvider' => $senarai,
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
                //'entry_date',
                [
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
                            //'attribute' => 'status_jfpiu',
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
                            'label' => 'Status Semakan Canselori',
                            'value' => 'statussemakan',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                //'ulasan_semakan:ntext',
                //'lulus_by',
                //'lulus_date',
                //'status_nc',
                [
                            'label' => 'Status Kelulusan NC',
                            'value' => 'statusnc',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                //'ulasan_nc:ntext',
                [
                    'label' => 'Tindakan',
                    'format' => 'raw',
                    'value'=>function ($data) use($title){
                           if($title == 'Senarai Menunggu Semakan'){
                              return 
                            Html::a('<i class="fa fa-edit">', ["tindakan-canselori", 'id' => $data->id], ['target' => '_blank']);
                        }  
                    },
                ],
                //['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        </div>
     </div>
</div>
</div>
