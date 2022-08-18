<?php
//use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url; 
?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">     
        <div class="x_title">
            <h2><strong>Sejarah Permohonan Papan Tanda</strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?></p>
<!--                <p align="right"><= \yii\helpers\Html::a('Kembali', ['halaman-utama-papan-tanda'], ['class' => 'btn btn-primary']) ?></p>      -->
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
                            'label' => 'STATUS',
                            'value' => 'statusss',
                            'format'=>'raw',
                            'hAlign' => 'center',
                        ],
                        
                        [
                        'label' => 'TINDAKAN',
                        'value' => function($model) {
                            if ($model->status == 'LULUS' && $model->status_surat == '1') {
                            return Html::a('<a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                            href=" '.Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen->dokumen), true).'" target="_blank" >
                            <i class="fa fa-download"></i> Muat Turun Surat</a>').Html::a('<i class="fa fa-eye"></i> Lihat Permohonan LN-1</a>', ["lihat-permohonan-ln1", 'id' => $model->id]);
                            } 
                            
                            else if ($model->status == 'TIDAK LULUS' && $model->status_surat == '2') {
                            return Html::a('<a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" 
                            href=" '.Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen->dokumen), true).'" target="_blank" >
                            <i class="fa fa-download"></i> Muat Turun Surat</a>');
                            }
                            
                            else if ($model->status == 'LULUS' && $model->status_surat == '2') {
                            return '-';
                            }
                            
                            else if ($model->status == 'TIDAK LULUS' && $model->status_surat == '1') {
                            return '-';
                            }
                            
                            },
                                'format' => 'raw',
                                'hAlign' => 'center',
                        ],

                        ],
                    ]);
                    ?>
        </div> 
        
        <ul>
            <li><span class="label label-info">Dalam Tindakan KJ</span> : Menunggu perakuan dari Ketua Jabatan</li>
            <li><span class="label label-primary">Dalam Tindakan CANSELORI</span> : Menunggu kelulusan dari Canselori</li>
            <li><span class="label label-warning">Dalam Tindakan NC</span> : Menunggu kelulusan dari Naib Canselor</li>
            <li><span class="label label-success">Diluluskan</span> : Diluluskan</li> 
            <li><span class="label label-danger">Tidak Diluluskan</span> : Tidak Diluluskan</li>
        </ul>
        
    </div>      
</div> 
</div>

