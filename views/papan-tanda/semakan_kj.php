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
<?php echo $this->render('/papan-tanda/_topmenu'); ?> 
</div>
</div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
     <div class="x_panel">
         <div class="x_title">
            <h2><strong><?php echo $title;?></strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <?= GridView::widget([
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
                [
                            'label' => 'Tarikh Mohon',
                            'value' => 'entrydate',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                [
                            //'attribute' => 'status_jfpiu',
                            'label' => 'Status Perakuan Ketua Jabatan',
                            'value' => 'statuskj',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                [
                    'label' => 'Tindakan',
                    'format' => 'raw',
                    'value'=>function ($data) use($title){
                           if($title == 'Senarai Menunggu Perakuan'){
                              return 
                            Html::a('<i class="fa fa-edit">', ["tindakan-kj", 'id' => $data->id], ['target' => '_blank']);
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
