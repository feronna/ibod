<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>

<div class="row"> 
    <div class="x_panel"> 
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Peribadi</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama</th>
                        <td><?= ucwords(strtolower($model->kakitangan->CONm)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan</th>
                        <td><?= $model->kakitangan->ICNO; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">UMS-PER</th>
                        <td><?= $model->kakitangan->COOldID; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan & Gred</th>
                        <td><?= $model->kakitangan->jawatan->fname; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">JFPIU</th>
                        <td><?= $model->kakitangan->department->fullname; ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Taraf Jawatan</th>
                        <td><?= $model->kakitangan->statusLantikan->ApmtStatusNm; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Gaji Pokok</th>
                        <td>RM <?= $model->gajipokok; ?></td> 
                    </tr>
                </table>
            </div> 

        </div>
    </div>
</div>

<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Permohonan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jenis Penamatan</th>
                        <td><?= $model->jenisPenamatan->jenis; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Permohonan</th>
                        <td><?= $model->tarikh_mohon; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Tarikh Terakhir Bekerja</th>
                        <td><?= $model->tarikh_terakhirbekerja; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Sebab Penamatan</th>
                        <td><?= $model->sebab; ?></td> 
                    </tr>
                </table>
            </div> 
           </div>
    </div>
</div>
            <?php ActiveForm::end(); ?>


