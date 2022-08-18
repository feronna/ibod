<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Maklumat Dan Rekod Kakitangan';
?>
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <p align="right">  <?= Html::a('Kembali', ['cbadmin/index'], ['class' => 'btn btn-primary btn-sm']) ?></p>

            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            <div class="row text-center" >
                <div class="col-lg-1 col-sm-3 col-xs-12 text-center">
                    <div class="col-lg-1 col-md-1 col-xs-12 text-center" rowspan="6" valign="top"><span><img height='100px' width="80px" src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(hash('sha1', $model->ICNO)); ?>.jpeg"></span></div>
                </div>
                <div class="col-lg-11 col-sm-9 col-xs-12" >
                    <div class="row">
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>Nama:</b></div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 text-left" ><?= $model->gelaran->Title ." ". ucwords(strtolower($model->CONm)) ?></div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>No. KP / Paspot:</b></div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 text-left "><?= $model->ICNO ?></div>
                    </div>
                    <div class="row ">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jabatan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= ucwords(strtolower($model->department->fullname)) ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Kampus Cawangan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left " ><?= ucwords(strtolower($model->kampus->campus_name)) ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>UMSPER:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->COOldID ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jawatan Disandang:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->jawatan->nama . " (" . $model->jawatan->gred . ")"; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Sandangan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->statusSandangan->sandangan_name ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Sandangan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStartSandangan ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Jawatan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->statusLantikan->ApmtStatusNm ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tempoh Lantikan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStartLantik ?> hingga <?= $model->tarikhbersara?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Pekerja:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><span><?= $model->Status ? $model->serviceStatus->ServStatusNm : 'Not Set' ?></span></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Status:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStartDateStatus ?></div>
                    </div>
                </div>
            </div> </br>

            <div class="well well-lg"> 
                <div class="row ">
                
<div class="x_content"> 


            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <?php
                    $resume = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'address-card',
                                        'header' => 'Rekod',
                                        'text' => 'Permohonan Baharu Pengajian Lanjutan',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($resume, ['view-data-pemohon?ICNO='.$model->ICNO]);
        
                    ?>

                </div>
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'clock-o',
                                        'header' => 'Rekod ',
                                        'text' => 'Tempoh Cuti Belajar',
                                        'number' => '2',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['tiketpenerbangan/borang-permohonan']);
                    ?>
                </div>

                 <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'book',
                                        'header' => 'Rekod',
                                        'text' => 'Laporan Kemajuan Kursus (LKK)',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($semakan, ['permohonan-semasa']);
                    ?>
           </div>
                
            
                
               
       </div>
<div class="row">
                <div class="col-xs-12 col-md-4">
                    <?php
                    $resume = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'th-list',
                                        'header' => 'Rekod',
                                        'text' => 'Lain - Lain Permohonan',
                                        'number' => '4',
                                    ]
                    );
                    echo Html::a($resume, ['view-data-pemohon?ICNO='.$model->ICNO]);
        
                    ?>

                </div>
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'plane',
                                        'header' => 'Rekod',
                                        'text' => 'Permohonan Tempahan Tiket Penerbangan',
                                        'number' => '5',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['tiketpenerbangan/borang-permohonan']);
                    ?>
                </div>

                 <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'suitcase',
                                        'header' => 'Rekod',
                                        'text' => 'Lapor Diri',
                                        'number' => '6',
                                    ]
                    );
                    echo Html::a($semakan, ['permohonan-semasa']);
                    ?>
           </div>
                
            
                
               
       </div>
                


        </div>
                </div> <!-- div for row-->
            </div> <!-- div for well-->

        </div>
    </div>
</div>














