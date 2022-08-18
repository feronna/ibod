<?php
//use yii\helpers\Html;
//use yii\widgets\ActiveForm;
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
            <h2><strong>Laporan Bertugas Rasmi Di Luar Negara (LN-2)</strong></h2>
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
                        
                        [
                            'label' => 'STATUS LN-2',
                            'value' => 'statusln2',
                            'format'=>'raw',
                            'hAlign' => 'center',
                        ],
                                    
                        [
                            'label'=>'TINDAKAN',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                                    
                            'value'=>function ($data) {
                            if($data->hantar == 0){
                            return Html::a('<i class="fa fa-edit"></i> Kemaskini Laporan LN-2</a>', ["mohon2", 'id' => $data->id]);
                            }
                            elseif($data->hantar == 1){
                            return Html::a('<i class="fa fa-eye"></i> Lihat Laporan LN-2</a>', ["lihat-laporan-ln2", 'id' => $data->id]);
                            }
                            } 
                        ]   
                                    
                        ],
                    ]);
                    ?>
        </div> 

        <ul>
            <li><span class="label label-success">Selesai</span> : Laporan Berjaya Dihantar</li>
            <li><span class="label label-warning">Laporan Belum Dihantar</span> : Laporan Belum Dihantar</li> 
        </ul>
        
    </div>      
</div> 
</div>

