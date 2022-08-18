<?php
use yii\helpers\Html;
?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Rekod Lantikan</strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', ['halaman-utama'], ['class' => 'btn btn-primary']) ?></p>   
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
                    
                    <div class="row">
                       <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jawatan Semasa:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->jawatan->nama . " (" . $model->jawatan->gred . ")"; ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jawatan Pentadbiran:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?php
                                    if ($model->adminpos) {
                                        echo $model->adminpos->adminpos->position_name;
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                        </div>
                    </div>
                    
                    <div class="row ">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jabatan Semasa:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= ucwords(strtolower($model->department->fullname)) ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jabatan Pentadbiran:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left " ><?php
                                    if ($model->adminpos) {
                                        echo $model->adminpos->dept->fullname;
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                        </div>
                    </div> 
                    
                    <div class="row ">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Lantikan Semasa:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->displayStartSandangan ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Lantikan Pentadbiran:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?php
                                    if ($model->adminpos) {
                                        echo $model->adminpos->tarikhmula;
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                        </div>
                    </div>
                    
                    <div class="row ">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Sandangan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->statusSandangan->sandangan_name ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Jawatan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->statusLantikan->ApmtStatusNm ?></div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Pekerja:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><span><?= $model->Status ? $model->serviceStatus->ServStatusNm : 'Not Set' ?></span></div>
                    </div> 
                </div>
            </div> <br>
            
<!--            <div class="x_panel">     
            <div class="col-md-3 col-sm-3  profile_left"> 
                <div class="profile_img">
                    <div id="crop-avatar"> <br/><br/>
                        <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($model->ICNO)); ?>.jpeg" width="150" height="180"></center>
                    </div>
                </div> 
                <br/> 
            </div>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <div class="col-md-12 col-sm-12 col-xs-12">   
                    <table class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center">
                                    <h5><?= strtoupper($model->gelaran->Title) ." ". strtoupper($model->CONm) ?><h5>
                                </th>
                            </tr>  
                        </thead>
                        <tbody>
                            <tr> 
                                <th style="width:20%">ICNO</th>
                                <td style="width:20%"><?= $model->ICNO; ?></td> 
                                <th>STATUS PEKERJA</th>
                                <td><?= strtoupper($model->Status ? $model->serviceStatus->ServStatusNm : 'Not Set') ?></td>
                            </tr>
                            <tr> 
                                <th style="width:20%">JAWATAN SEMASA</th>
                                <td style="width:20%"><?= \strtoupper($model->jawatan->nama . " (" . $model->jawatan->gred . ")"); ?></td>
                                <th width="20%">JAWATAN PENTADBIRAN</th>
                                <td><?php
                                        if ($model->adminpos) {
                                            echo strtoupper($model->adminpos->adminpos->position_name);
                                        } else {
                                            echo '-';
                                        }
                                    ?>
                                </td> 
                            </tr>
                            <tr> 
                                <th style="width:20%">JABATAN SEMASA</th>
                                <td style="width:20%"><?= strtoupper($model->department->fullname);?></td>
                                <th width="20%">JABATAN PENTADBIRAN</th>
                                <td>
                                    <?php
                                        if ($model->adminpos) {
                                            echo strtoupper($model->adminpos->dept->fullname);
                                        } else {
                                            echo '-';
                                        }
                                    ?>
                                </td> 
                            </tr>
                            <tr> 
                                <th style="width:20%">TARIKH LANTIKAN SEMASA</th>
                                <td style="width:20%"><?= strtoupper($model->displayStartSandangan); ?></td>
                                <th width="20%">TARIKH LANTIKAN PENTADBIRAN</th>
                                <td>
                                    <?php
                                        if ($model->adminpos) {
                                            echo strtoupper($model->adminpos->tarikhmula);
                                        } else {
                                            echo '-';
                                        }
                                    ?>
                                </td> 
                            </tr>
                            <tr>
                                <th style="width:20%">STATUS SANDANGAN</th>
                                <td style="width:20%"><?= strtoupper($model->statusSandangan->sandangan_name) ?></td> 
                                <th>STATUS JAWATAN</th>
                                <td><?= strtoupper($model->statusLantikan->ApmtStatusNm) ?></td>  
                            </tr>
                        </tbody>
                    </table> 
                </div> 
            </div>
            </div> -->

    <div class="well well-lg"> 
        <div class="row ">            
        <div class="x_content"> 
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?php
                    $tambah_rekod = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'plus',
                                        'header' => 'TAMBAH LANTIKAN',
                                        'text' => 'Tambah Rekod Lantikan Baru',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($tambah_rekod, ['tblrscoadminpost/tambah-rekod-lantikan', 'ICNO' => $model->ICNO]);
                    ?>
                </div>
                
                <div class="col-xs-12 col-md-6">
                    <?php
                    $tambah_rekod = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'plus',
                                        'header' => 'TAMBAH REKOD',
                                        'text' => 'Tambah Rekod Lantikan Lama',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($tambah_rekod, ['tblrscoadminpost/tambah-rekod-lantikan-lama', 'ICNO' => $model->ICNO]);
                    ?>
                </div>
                
                <div class="col-xs-12 col-md-6">
                    <?php
                    $rekod_lantikan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'REKOD LANTIKAN',
                                        'text' => 'Senarai Rekod Lantikan',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($rekod_lantikan, ['tblrscoadminpost/lihat-rekod-kakitangan', 'ICNO' => $model->ICNO]);
                    ?>
                </div>
                
<!--                <div class="col-xs-12 col-md-4">
                    <php
                    $perubahan_data = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'edit',
                                        'header' => 'Perubahan Data',
                                        'text' => 'Perubahan Data',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($perubahan_data, ['tblrscoadminpost/perubahan-data', 'ICNO' => $model->ICNO]);
                    ?>
                </div>-->
<!--                <div class="col-xs-12 col-md-6">-->

                <div class="col-xs-12 col-md-6">
                    <?php
                    $tambah_allowance = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'address-card',
                                        'header' => 'LIHAT PROFIL',
                                        'text' => 'Lihat Profil Lantikan',
                                        'number' => '4',
                                    ]
                    );
                    echo Html::a($tambah_allowance, ['tblrscoadminpost/view-rekod-staf', 'id' => $model->ICNO]);
                    ?>
                </div>

<!--                <div class="col-xs-12 col-md-6">
                    <php
                    $tambah_allowance = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'plus',
                                        'header' => 'Tambah Allowance',
                                        'text' => 'Tambah Rekod Allowance',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($tambah_allowance, ['tblrscoadminpost/tambah-allowance', 'ICNO' => $model->ICNO]);
                    ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <php
                    $rekod_allowance = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Rekod Allowance',
                                        'text' => 'Senarai Rekod Allowance',
                                        'number' => '4',
                                    ]
                    );
                    echo Html::a($rekod_allowance, ['tblrscoadminpost/lihat-rekod-allowance', 'ICNO' => $model->ICNO]);
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