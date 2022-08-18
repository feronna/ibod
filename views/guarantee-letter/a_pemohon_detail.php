
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
?>  
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="x_panel"> 
    <div class="x_title">
        <h2>Maklumat Pegawai</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">Nama Pegawai</th>
                    <td><?= $permohonan->biodata->displayGelaran . ' ' . ucwords(strtolower($permohonan->biodata->CONm)); ?></td> 
                </tr>
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan</th>
                    <td><?php
                        if ($permohonan->biodata->NatStatusCd == 1) {
                            echo $permohonan->ICNO;
                        } else {
                            echo $permohonan->biodata->latestPaspot;
                        }
                        ?></td> 
                </tr>
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">Gred Gaji</th>
                    <td><?= $permohonan->biodata->jawatan->gred; ?></td> 
                </tr>
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">Gaji Pokok</th>
                    <td>RM <?= $permohonan->biodata->gajiBasic; ?></td> 
                </tr>
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                    <td><?= $permohonan->biodata->jawatan->nama; ?></td> 
                </tr>
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">Kelayakan Kelas Wad</th>
                    <td><?= ucwords(strtolower($permohonan->kelasWad->nama)); ?></td> 
                </tr>
                <tr>
                    <th class="col-md-3 col-sm-3 col-xs-12">Alamat Pejabat</th>
                    <td>
                        <?= $permohonan->biodata->department->fullname; ?>,
                        Universiti Malaysia Sabah
                        <?php
                        if ($permohonan->biodata->campus_id == 1) {
                            echo ", Jalan Universiti Malaysia Sabah, 88400 Kota Kinabalu";
                        } else if ($permohonan->biodata->campus_id == 2) {
                            echo " Labuan International Campus, Jln. Sungai Pagar, 87000 Labuan";
                        } else if ($permohonan->biodatacampus_id == 3) {
                            echo ", Locked Bag No. 3, 90509 Sandakan";
                        }
                        ?>
                    </td> 
                </tr>  
            </table>
        </div> 

    </div>
</div>

<div class="x_panel"> 
    <div class="x_title">
        <h2>Butiran Permohonan</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    

        <?php if ($permohonan->biodata->NatCd == "MYS") { ?> 
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama</th>
                        <td><?= ucwords(strtolower($permohonan->gl_nama)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan</th>
                        <td><?= $permohonan->gl_ICNO; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Perhubungan Pekerja</th>
                        <td><?= $permohonan->gl_hubungan; ?></td> 
                    </tr>
                </table>
            </div>
        <?php } else { ?> 
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama Pegawai</th>
                        <td><?= $permohonan->biodata->displayGelaran . ' ' . ucwords(strtolower($permohonan->biodata->CONm)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan</th>
                        <td><?= $permohonan->biodata->latestPaspot; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Perhubungan Pekerja</th>
                        <td><?= $permohonan->gl_hubungan; ?></td> 
                    </tr>
                </table>
            </div>
        <?php } ?> 

    </div>
</div>   

<?php ActiveForm::end(); ?> 


