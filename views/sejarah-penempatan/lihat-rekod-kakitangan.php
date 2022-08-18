<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\hronline\Campus;
/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblrscoadminpost */

$this->title = 'Create Tblrscoadminpost';
$this->params['breadcrumbs'][] = ['label' => 'Tblrscoadminposts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
    <div class="x_title">
<!--            <ol class="breadcrumb">
                <li><php echo Html::a('<i class="fa fa-home"></i> Halaman Utama', ['halaman-utama']) ?></li>
                <li><= Html::a('Rekod Penempatan', Yii::$app->request->referrer) ?></li>
                <li><php echo Html::a('Rekod Penempatan', ['admin-view', 'id' => $biodata->ICNO]) ?></li>
                <li>Sejarah Penempatan</li>
            </ol>-->
            <h2><strong>Sejarah Penempatan</strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', ['halaman-utama'], ['class' => 'btn btn-primary']) ?></p>   
        <div class="clearfix"></div>
    </div>
        <div class="x_content">
            <div class="row text-center" >
                <div class="col-lg-1 col-sm-3 col-xs-12 text-center">
                    <div class="col-lg-1 col-md-1 col-xs-12 text-center" rowspan="6" valign="top"><span><img height='100px' width="80px" src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(hash('sha1', $biodata->ICNO)); ?>.jpeg"></span></div>
                </div>
                <div class="col-lg-11 col-sm-9 col-xs-12" >
                    <div class="row">
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>Nama:</b></div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 text-left" ><?= $biodata->gelaran->Title ." ". ucwords(strtolower($biodata->CONm)) ?></div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>No. KP / Paspot:</b></div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 text-left "><?= $biodata->ICNO ?></div>
                    </div>
                     <div class="row ">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jabatan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= ucwords(strtolower($biodata->department->fullname)) ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Kampus Cawangan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left " ><?= ucwords(strtolower($biodata->kampus->campus_name)) ?></div>
                    </div>                  
                    <div class="row">
                       <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>UMSPER:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $biodata->COOldID ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jawatan Disandang:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $biodata->jawatan->nama . " (" . $biodata->jawatan->gred . ")"; ?></div>
                    </div>
                    <div class="row ">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Sandangan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $biodata->statusSandangan->sandangan_name ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Sandangan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $biodata->displayStartSandangan ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Jawatan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $biodata->statusLantikan->ApmtStatusNm ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tempoh Lantikan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $biodata->displayStartLantik ?> hingga <?= $biodata->displayEndLantik ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Pekerja:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><span><?= $biodata->Status ? $biodata->serviceStatus->ServStatusNm : 'Not Set' ?></span></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Status:</b></div>
                                                <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $biodata->displayStartSandangan ?></div>
                    </div>
                </div>
            </div> <br>

    <div class="well well-lg"> 
        <div class="row ">            
        <div class="x_content"> 
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?php
                    $tambah_rekod = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'plus',
                                        'header' => 'Kemaskini Penempatan',
                                        'text' => 'Kemaskini Maklumat Penempatan',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($tambah_rekod, ['sejarah-penempatan/tambah-rekod-penempatan','ICNO' => $biodata->ICNO]);
                    ?>
                </div>
                
                <div style="background-color:lightblue" class="col-xs-12 col-md-6">
                <br>
                    <?php
                    $tambah_rekod = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Sejarah Penempatan',
                                        'text' => 'Sejarah Penempatan',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($tambah_rekod, ['sejarah-penempatan/lihat-rekod-kakitangan', 'ICNO' => $biodata->ICNO]);
                    ?>
                </div>
<!--                <div class="col-xs-12 col-md-4">
                    <php 
                    $kemaskini = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'edit',
                                        'header' => 'Perubahan Data',
                                        'text' => 'Perubahan Data',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($kemaskini, ['sejarah-penempatan/perubahan-data', 'ICNO' => $model->ICNO]);
                    ?>
                </div>-->
                
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
            <h2><strong>Sejarah Penempatan</strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', ['admin-view', 'id' => $biodata->ICNO], ['class' => 'btn btn-primary']) ?></p>   
        <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
      
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
<!--                    <th>ID</th>-->
<!--                    <th>ICNO</th>-->
                    <th class="text-center">Bil. </th>
                    <th class="text-center">Tarikh Mula</th>
                    <th class="text-center">JFPIB</th>
                    <th class="text-center">Kampus</th>
                    <th class="text-center">Sebab Perpindahan</th>
                    <th class="text-center">Catatan</th>
                    <th class="text-center">Tindakan</th> 
<!--                    <th class="text-center">Salinan Surat</th>-->
                </tr>
                </thead>
                <?php 
                
                $bil=1;
                
                if($model) {
                    
                   foreach ($model as $models) {
                    
                ?>
                  
                <tr>
<!--                    <td><?php //echo $models->id; ?></td>-->
<!--                    <td><?php //echo $models->ICNO; ?></td>-->
                    <td class="text-center" style="width:3%;"><?= $bil++; ?></td>
                    <td class="text-center" style="width:9%;"><?= $models->tarikhMula; ?></td>
                    <td class="text-center" style="width:12%;"><?= $models->department->fullname; ?></td>
                    <td class="text-center" style="width:7%;"><?= $models->campus->campus_name; ?></td>
                    <td class="text-center" style="width:9%;"><?= $models->reasonPenempatan->name; ?></td>
                    <td class="text-center" style="width:18%;"><?= $models->remark; ?></td>

                    <td class="text-center" style="width:5%;"><?php echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihat-rekod-maklumat-penempatan', 'id' => $models->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-rekod-penempatan', 'id' => $models->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $models->id], [
                         'data' => [
                                   'confirm' => 'Anda ingin membuang rekod ini?',
                                   'method' => 'post',
                                       ],
                                    ]) ?>
                    </td>  
<!--                    <td class="text-center" style="width:5%;">

                            <= \yii\helpers\Html::a('', ['sejarah-penempatan/surat-penempatan', 'id' => $models->id], ['class'=>'fa fa-download', 'target' => '_blank']) ?>

                                   
                    </td>-->
<!--                    <td class="text-center" style="width:10%;"><?= Html::a('    <td class="text-cen<i class="fa fa-eye" aria-hidden="true"></i>', ['lihat-rekod-penempatan', 'id' => $models->id]) ?> </td>  -->
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="10" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
        </div>
    </div>
</div>
</div>



