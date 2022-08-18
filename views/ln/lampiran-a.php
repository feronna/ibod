<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
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
            <h2><strong>Lampiran A</strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?></p>      
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content"> 
                <?= GridView::widget([
                    'dataProvider' => $permohonan,
                    'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
                    'class' => 'table-responsive',
                    'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                    'columns' => [
                        ['class' => 'kartik\grid\SerialColumn',
                            'header' => 'BIL.',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',

                        ],
                        
                        [
                            'label' => 'TARIKH PERMOHONAN',
                            'value' => 'entrydate',
                            'format'=>'raw',
                            'hAlign' => 'center',
                        ],
                        
//                        [
//                            'label' => 'STATUS LN-1',
//                            'value' => 'statuss',
//                            'format'=>'raw',
//                            'hAlign' => 'center',
//                        ],
                        
                        [
                            'label' => 'STATUS LAMPIRAN A',
                            'value' => 'statuslampirana',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ], 
                        
                        [
                            'label'=>'TINDAKAN',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                                    
                            'value'=>function ($data) {
                            if($data->lampiran == '0'){
                            return Html::a('<i class="fa fa-edit">', ["lampiran", 'id' => $data->id]); 
                            }
                            if ($data->lampiran == '1') {
                            return Html::a('<a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                            href=" '.Url::to(Yii::$app->FileManager->DisplayFile($data->lampiran_a), true).'" target="_blank" >
                            <i class="fa fa-download"></i> Muat Turun Lampiran A</a>');
                            }
                            } 
                        ]
                                
                        ],
                    ]);
                    ?>
        </div> 

        <ul>
            <li><span class="label label-success">Selesai</span> : Lampiran A Berjaya Dihantar</li>
            <li><span class="label label-warning">Lampiran A Belum Dihantar</span> : Lampiran A Belum Dihantar</li> 
        </ul>
        
    </div>      
</div> 
</div>

