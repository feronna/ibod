<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\grid\GridView;
use kartik\form\ActiveForm;
?>

<div class="row"> 
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="row">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['cbelajar/halaman-utama-bsm']) ?></li>
        <li>Semakan Syarat Cuti Belajar</li>
    </ol>
</div>
        <div class="x_content">
             
                    <table class="table table-sm table-bordered">
                        
                <tr>
                    <td width="15%"><strong>Nama Pemohon</strong></td>
                    <td><?= $bio->CONm; ?></td>
                </tr>
                <tr>
                    <td><strong>No. Kad Pengenalan</strong></td>
                    <td><?= $bio->ICNO; ?></td>
                </tr>
                 <tr>
                    <td><strong>Umur</strong></td>
                    <td><?= $bio->umur." ". "Tahun"?></td>
                </tr>
                
                <tr>
                    <td><strong>Status Warganegara</strong></td>
                    <td><?= $bio->displayWarganegara; ?></td>
                </tr>
                 <tr>
                        <td><strong>Pengesahan Perkhidmatan</strong></td>
                        <td> <?php if(!empty($bio->confirmpengesahan->statusperkhidmatan)):?>
                                    <?php echo $bio->confirmpengesahan->statusperkhidmatan; ?></a>
                                          
                                            <?php endif;?></td>
                <tr>
                        <td><strong>Status Ketua Jabatan</strong></td>
                        <td><?= $permohonan->status_jfpiu;?></td>
                </tr>
                
                <tr>
                        <td><strong>Peringkat Pengajian</strong></td>
                    <td><?= $pengajian->pendidikanTertinggi->HighestEduLevel;?></td>
                </tr>
                
                <tr>
                        <td><strong>Tempoh Pengajian</strong></td>
                    <td><?= $pengajian->tempohpengajian;?></td>
                </tr>
                <tr>
             
                <td><strong>PNGK Ijazah Sarjana Muda</strong></td>
                <td><?= $akademik->gredKeseluruhan; ?></td>
                
                </tr> 
            </table>
           
            <hr>
            
            
            <?php 
                $form = ActiveForm::begin(['action' => ['semak-syarat'], 'method' => 'post', ]);
                
            ?>
            <div class="table-responsive">
            <?=
                GridView::widget([
                    'summary' => '',
                    //'emptyText' => 'Tiada rekod penetapan SKT',
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'label' => 'BIL',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:5%'],
                            'attribute' => 'id',
                        ],
                        [
                            'label' => 'PERKARA',
                            'headerOptions' => ['class'=>'text-center'],
                            //'contentOptions' => ['style'=>'width:75%'],
                            'attribute' => 'syarat',
                            'format' => 'html'
                                    
                        ],
                         
                        [
                            'label' => 'CATATAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:15%'],
                            'value' => function($model) use ($form, $model1) {
                                //return Html::radio('skor['.$model->id.']', false, ['value' => $model->id]);
                                $data = [0 => 'YA', 1 => 'TIDAK'];
                                return $form->field($model1, "q$model->id")->radioButtonGroup($data)->label(false);
                            },
                                    'format' => 'raw'
                        ],
                    ],
                ]);
            ?>
            </div>
            <div class="form-group pull-right">
                <div class="">
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div> 
    </div></div>
</div>