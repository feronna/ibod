<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
error_reporting(0);
\yii\web\YiiAsset::register($this);
?>

<!--<div class="row">
<div class="col-md-12">
    <php echo $this->render('/ptm/_topmenu2'); ?> 
</div>
</div>-->

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Rekod Kursus</strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', ['halaman-utama'], ['class' => 'btn btn-primary']) ?></p>   
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            <div class="row text-center" >
                <div class="col-lg-1 col-sm-3 col-xs-12 text-center">
                    <div class="col-lg-1 col-md-1 col-xs-12 text-center" rowspan="6" valign="top"><span><img height='100px' width="80px" src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(hash('sha1', $model2->ICNO)); ?>.jpeg"></span></div>
                </div>
                <div class="col-lg-11 col-sm-9 col-xs-12" >
                    <div class="row">
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>Nama:</b></div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 text-left" ><?= $model2->gelaran->Title ." ". ucwords(strtolower($model2->CONm)) ?></div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>No. KP / Paspot:</b></div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 text-left "><?= $model2->ICNO ?></div>
                    </div>
                     <div class="row ">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jabatan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= ucwords(strtolower($model2->department->fullname)) ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Kampus Cawangan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left " ><?= ucwords(strtolower($model2->kampus->campus_name)) ?></div>
                    </div>                  
                    <div class="row">
                       <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>UMSPER:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model2->COOldID ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jawatan Disandang:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model2->jawatan->nama . " (" . $model2->jawatan->gred . ")"; ?></div>
                    </div>
                    <div class="row ">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Sandangan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model2->statusSandangan->sandangan_name ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Sandangan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model2->displayStartSandangan ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Jawatan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model2->statusLantikan->ApmtStatusNm ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tempoh Lantikan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model2->displayStartLantik ?> hingga <?= $model2->displayEndLantik ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Pekerja:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><span><?= $model2->Status ? $model2->serviceStatus->ServStatusNm : 'Not Set' ?></span></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Status:</b></div>
                                                <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model2->displayStartSandangan ?></div>
                    </div>
                </div>
            </div> <br>

           <div class="well well-lg"> 
                <div class="row ">            
                <div class="x_content"> 
                    <div class="row">
                        <div class="col-xs-12 col-md-4">
                            <?php
                            $tambah_rekod = \yiister\gentelella\widgets\StatsTile::widget(
                                            [
                                                'icon' => 'list',
                                                'header' => 'Rekod PTM',
                                                'text' => 'Rekod Kursus PTM',
                                                'number' => '1',
                                            ]
                            );
                            echo Html::a($tambah_rekod, ['lihat-rekod-ptm', 'id'=>$model2->ICNO]);
                            ?>
                        </div>
                        <div style="background-color:lightblue" class="col-xs-12 col-md-4">
                            <br>
                            <?php
                            $rekod_lantikan = \yiister\gentelella\widgets\StatsTile::widget(
                                            [
                                                'icon' => 'list',
                                                'header' => 'Rekod P&P',
                                                'text' => 'Rekod Kursus P&P',
                                                'number' => '2',
                                            ]
                            );
                            echo Html::a($rekod_lantikan, ['lihat-rekod-pnp', 'id'=>$model2->ICNO]);
                            ?>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <?php
                            $perubahan_data = \yiister\gentelella\widgets\StatsTile::widget(
                                            [
                                                'icon' => 'list',
                                                'header' => 'Rekod Metodologi Penyelidikan',
                                                'text' => 'Rekod Kursus Metodologi Penyelidikan',
                                                'number' => '3',
                                            ]
                            );
                            echo Html::a($perubahan_data, ['lihat-rekod-penyelidikan', 'id'=>$model2->ICNO]);
                            ?>
                        </div>
                        <div class="col-xs-12 col-md-4">
                            <?php
                            $perubahan_data = \yiister\gentelella\widgets\StatsTile::widget(
                                            [
                                                'icon' => 'list',
                                                'header' => 'Rekod BITK',
                                                'text' => 'Rekod Kursus Bayaran Insentif Tugas Kewangan',
                                                'number' => '4',
                                            ]
                            );
                            echo Html::a($perubahan_data, ['lihat-rekod-bitk', 'id'=>$model2->ICNO]);
                            ?>
                        </div>

                    </div>
                </div>
                </div> <!-- div for row-->
            </div> <!-- div for well-->
            
        </div>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
         <div class="x_title">
            <h2><strong>Rekod Kursus P&P</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php
                if ($model == array(NULL)){

                //if ($model->status !=0 ) {
                echo Html::button('Tambah Rekod <i class="fa fa-plus" aria-hidden="true"></i>', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['tambah-pnp?ICNO='.$id]),'class' => 'btn btn-primary mapBtn']) ?>

                <?php }
                
//                else {
//                    echo Html::button('Kemaskini Maklumat <i class="fa fa-pencil" aria-hidden="true"></i>', 
//                    ['id' => 'modalButton', 
//                    'value' => \yii\helpers\Url::to(['kemaskini-rekod-pnp', 'id' => $model->ICNO]),
//                     'class' => 'btn btn-primary mapBtn']); 
//                }
                
                else {
                    
                echo Html::button('Kemaskini Maklumat <i class="fa fa-pencil" aria-hidden="true"></i>', 
                ['id' => 'modalButton', 
                'value' => \yii\helpers\Url::to(['kemaskini-rekod-pnp', 'id' => $model->ICNO]),
                 'class' => 'btn btn-primary mapBtn']); 
                    
                echo Html::a('Padam Rekod <i class="fa fa-trash" aria-hidden="true"></i>', ['delete-pnp', 'id' => $model->ICNO], [
                'class' => 'btn btn-danger',
                'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                        ],
                ]);
            
                }
            ?>
            
            <p>
<!--            <= Html::a('Kembali', ['index', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>-->
<!--            <= Html::a('Kemaskini', ['update3', 'id' => $model->ICNO], ['class' => 'btn btn-primary']) ?>-->

<!--            <= Html::button('Kemaskini', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['update3', 'id' => $model2->ICNO]),'class' => 'btn btn-primary mapBtn']) ?>-->

<!--            <= Html::a('Padam', ['delete', 'id' => $model->ICNO], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>-->
            </p>
            
            <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
//                'ICNO',
//                [
//                           'label' => 'ICNO',
//                           'attribute' => 'ICNO',
//                       ],
//                'kakitangan.CONm',

                [
                           'label' => 'Tarikh Kursus',
                           'attribute' => 'tarikhpnp',
                       ],
                [
                           'label' => 'Tempat Kursus',
                           'attribute' => 'tempatPnp',
                       ],
                [
                           'label' => 'Keputusan',
                           'attribute' => 'keputusan',
                       ],
                [
                           'label' => 'Status',
                           'attribute' => 'status',
                       ],
                [
                           'label' => 'Tarikh Kelulusan TNC(A)',
                           'attribute' => 'tarikhkelulusan',
                       ],

           ],
            ]) ?>

        </div>
    </div>
</div>
</div>

