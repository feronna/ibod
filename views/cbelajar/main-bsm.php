<?php
$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
error_reporting(0);
$this->title = 'Halaman Utama';
?> 

 

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
       <?php echo $this->render('/cutibelajar/_topmenu'); ?>
    <div class="x_panel">
        <div class="x_title">
            <strong><h2>Halaman Utama</strong></h2><p align="right"><?= Html::a('Tambah Takwim', ['tambah-iklan'], ['class' => 'btn btn-primary btn-md']) ?></p>
            <div class="clearfix"></div>
        </div>
        <h2 align="center"> <strong>Senarai Takwim Mesyuarat Pengajian Lanjutan</strong></h2>
                  
    
             <div class="x_content">    
                                    <div class="table-responsive">
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $iklan_semasa,
                                            'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                                            'layout' => "{items}\n{pager}",
                                            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                                            'columns' => [
                                                ['class' => 'yii\grid\SerialColumn','header' => 'Bil.'],
                                                
                                                  [
                                            'label' => 'Nama Mesyuarat',
                                            'value' => function($model) {
                                               return 'Mesyuarat Jawatankuasa Kali Ke -' ." ". $model->kali_ke;
                                            },
                                        ],

                                        [
                                            'label' => 'Kategori',
                                            'value' => function($model) {
                                                if ($model->kategori->id == 1) {
                                                    return 'PENTADBIRAN';
                                                } else {
                                                    return 'AKADEMIK';
                                                }
                                            },
                                        ],

                                        [
                                            'label' => 'Tarikh Mesyuarat',
                                            'value' => function($model) {
                                               return $model->getTarikh($model->tarikh_mesyuarat);
                                            },
                                        ],
                                      
                                        [
                                            'label' => 'Tarikh Buka',
                                            'value' => function($model) {
                                                return $model->getTarikh($model->tarikh_buka);
                                            },
                                        ],
                                        [
                                            'label' => 'Tarikh Tutup',
                                            'value' => function($model) {
                                                return $model->getTarikh($model->tarikh_tutup);
                                            },
                                        ],
//                                                       [
//                                    'label' => 'Jumlah Permohonan',
//                                    'value' => function($model) { 
//                                        return '<b><u><a href=' . Url::to(['cutibelajar/senarai', 'id' => $model->id]) . '>' . $model->jumlahPermohonanbySemasa($model->id). '</span></b>';
//                                    },
//                                    'format' => 'raw',
//                                    'contentOptions' => ['class' => 'text-center'],
//                                ], 
                                           [
                                            'label' => 'Tindakan',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'value' => function($model) {

                                                $url = Url::to(['nyahaktif-takwim', 'id' => $model->id]);
                                                return Html::button('NYAHAKTIFKAN', ['value' => $url, 'class' => 'btn btn-danger btn-xs modalButton']);
                                            },
                                                    'format' => 'raw',
                                                    'contentOptions' => ['class' => 'text-center'],
                                                ],
                                                    
                                            

                                                                
                                                                    ],
                                                                ]);
                                                                ?>
                                                            </div>
                                                        </div>
</div>

                             <div class="x_panel">
                                <div class="x_title">
                                    <h2>Rekod Permohonan Keseluruhan</h2>
                     &nbsp;<?= Html::a('<i class="fa fa-book"></i> Statisik Data', ['cbadmin/admin/ringkasan_data'], ['class'=>'btn btn-danger btn-xs', 'target' => '_blank']) ?>
                                    <br/>
                                    <div class="clearfix"></div> <br/>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered jambo_table table-striped text-center">
                                           <tr> 
                                                <td width="40%" align="left">JUMLAH PERMOHONAN TAHUNAN</td>
                                                <td width="40%"><span class="required" style="color:red;"> <b><?= $jumlah_permohonan1; ?></b></span>
                                            </tr>
                                            
                                            <tr> 
                                                <td width="40%" align="left">JUMLAH PERMOHONAN SEMASA</td>
                                                <td width="40%"><span class="required" style="color:red;"> <b><?= $jumlah_permohonan; ?></b></span>
                                            </tr>

                                            <tr> 
                                                <td width="40%" align="left">JUMLAH PERMOHONAN DILULUSKAN</td>
                                                <td width="40%"><span class="required" style="color:red;"> <b><?= $jumlah_permohonan_berjaya; ?></b></span>
                                            </tr>

                                            <tr> 
                                                <td width="40%" align="left">JUMLAH PERMOHONAN DITOLAK</td>
                                                <td width="40%"><span class="required" style="color:red;"> <b><?= $jumlah_permohonan_gagal; ?></b></span>
                                            </tr>


                                        </table>
                                    </div>
                                    
                                </div>
                                 
                         

 
                                                    </div>
                                                </div>  
                                            </div>
                                         
                                        <?php
                                        Modal::begin([
                                            'header' => '<strong>KEMASKINI MESYUARAT PENGAJIAN LANJUTAN</strong>',
                                            'id' => 'modal',
                                            'size' => 'modal-lg',
                                        ]);
                                        echo "<div id='modalContent'></div>";
                                        Modal::end();
                                        ?>
