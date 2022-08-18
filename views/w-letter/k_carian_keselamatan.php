<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?> 
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel"> 
        <div class="x_content">
            <?php $form = ActiveForm::begin(); ?>

            <div class="col-md-3 col-sm-3 col-xs-3 col-md-offset-4 col-sm-offset-4 col-xs-offset-4">
                <?=
                $form->field($search, 'ICNO')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                    'options' => ['placeholder' => 'Nama Staff'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
            </div>

            <div class="col-md-1 col-sm-1 col-xs-1">
                <div class="form-group">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <?php if ($biodata) { ?>
        <div class="x_panel"> 
            <div class="x_title">
                <h2>Maklumat Pegawai</h2> 
                <div class="clearfix"></div>
            </div>
            <div class="x_content"> 

                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped"> 
                        <tr>
                            <th rowspan="7" class="col-md-3 col-sm-3 col-xs-12">
                        <div class="profile_img">
                            <div id="crop-avatar"> <br/>
                                <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($biodata->ICNO)); ?>.jpeg" width="150" height="180"></center>
                            </div>
                        </div>
                        </th> 
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama Pegawai</th>
                        <td><?= $biodata->gelaran->Title . " " . ucwords(strtolower($biodata->CONm)); ?></td> 
                        </tr>
                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan</th>
                            <td><?= $biodata->ICNO; ?></td> 
                        </tr>  
                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12">UMSPER</th>
                            <td><?= $biodata->COOldID; ?></td> 
                        </tr>
                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12">Jabatan</th>
                            <td><?= $biodata->department->fullname; ?></td> 
                        </tr>
                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                            <td><?= $biodata->jawatan->nama; ?> (<?= $biodata->jawatan->gred; ?>)</td> 
                        </tr> 

                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12">Kampus</th>
                            <td><?= $biodata->kampus->campus_name; ?> </td> 
                        </tr> 

                        <tr>
                            <th class="col-md-3 col-sm-3 col-xs-12">Ketua Jabatan</th>
                            <td><?php
                                if ($biodata->department->chief == $biodata->ICNO) {
                                    echo 'Taufiq Yap Yun Hin';
                                } else {
                                    echo $biodata->department ? ucwords(strtolower($biodata->department->k_jabatan->CONm)) : 'Tiada Maklumat';
                                }
                                ?></td> 
                        </tr>
                    </table>
                </div> 
            </div>
        </div>
    <?php } ?>

    <?php if ($biodata != null) { ?>
        <div class="x_panel"> 
            <div class="x_title">
                <h2>Rekod Permohonan Semasa</h2>  
                <div class="clearfix"></div>
            </div>
            <div class="x_content"> 
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <thead>
                            <tr class="headings">
                                <th>Bil</th>
                                <th>Tarikh Mula</th>
                                <th>Tarikh Tamat</th> 
                                <th>Senarai Tugas</th>
                            </tr>
                        </thead>
                        <?php
                        if ($permohonan) {
                            $counter = 0;
                            foreach ($permohonan as $permohonan) {
                                $counter = $counter + 1;

                                if (($permohonan->StartDate >= date("Y-m-d")) && (date("Y-m-d") <= $permohonan->StartDate )) {
                                    $bg = "#FFC0CB";
                                } else {
                                    $bg = "#FFFFFF";
                                }
                                ?>

                                <tr>
                                    <td bgcolor=<?= $bg; ?>><?= $counter; ?></td>
                                    <td bgcolor=<?= $bg; ?>><?= $permohonan->biodata->getTarikh($permohonan->StartDate); ?></td>
                                    <td bgcolor=<?= $bg; ?>><?= $permohonan->biodata->getTarikh($permohonan->EndDate); ?></td>  
                                    <td bgcolor=<?= $bg; ?>><?= $permohonan->tugas; ?></td>  
                                </tr> 
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="4" class="text-center">Tiada Rekod</td>                     
                            </tr>
                        <?php }
                        ?>
                    </table>
                </div>
            </div>
        </div>  
    <?php } ?>


    <?php if ($biodata != null) { ?>
        <div class="x_panel"> 
            <div class="x_title">
                <h2>Rekod Kemasukan Kerja</h2>  
                <p align="right">
                    <?= Html::a('<i class="fa fa-plus"></i>  Check In', ['check-in', 'icno' => $biodata->ICNO], ['class' => 'btn btn-success']); ?>  
                </p>
                <div class="clearfix"></div>
            </div>
            <div class="x_content"> 
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <thead>
                            <tr class="headings">
                                <th>Bil</th>
                                <th>Nama</th>
                                <th>Tarikh</th> 
                                <th>Masa</th> 
                                <th>Dikemaskini Oleh</th>
                            </tr>
                        </thead>
                        <?php
                        if ($checkIn) {
                            $counter = 0;
                            foreach ($checkIn as $checkIn) {
                                $counter = $counter + 1;

                                if (date('Y-m-d',strtotime($checkIn->datetime)) == date("Y-m-d")) {
                                    $bg = "#FFC0CB";
                                } else {
                                    $bg = "#FFFFFF";
                                }
                                ?>

                                <tr>
                                    <td bgcolor=<?= $bg; ?>><?= $counter; ?></td>
                                    <td bgcolor=<?= $bg; ?>><?= $checkIn->biodata->CONm; ?></td>
                                    <td bgcolor=<?= $bg; ?>><?= $checkIn->biodata->getTarikh($checkIn->datetime); ?></td>  
                                    <td bgcolor=<?= $bg; ?>><?= date('h:i A',strtotime($checkIn->datetime)); ?></td> 
                                    <td bgcolor=<?= $bg; ?>><?= $checkIn->biodataKeselamatan->CONm; ?></td>  
                                </tr>  
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5" class="text-center">Tiada Rekod</td>                     
                            </tr>
                        <?php }
                        ?>
                    </table>
                </div>
            </div>
        </div>  
    <?php } ?>
</div>  

