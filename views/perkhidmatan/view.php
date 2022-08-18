<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;

error_reporting(0);

Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">...</h4>',
]);

Modal::end();



$this->title = 'Maklumat Dan Rekod Perkhidmatan';
$statusLabel = [
    0 => 'Baru',
    1 => 'Kemaskini',
    2 => 'Buang',
];
?>
<div class="col-md-12 col-sm-12 col-xs-12 ">
    <p align="right">  <?= Html::a('Kembali', ['perkhidmatan/index'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Maklumat Dan Rekod Perkhidmatan </strong><?= Html::a('<i style="color:Green" class="fa fa-black-tie"></i>', ['tree-stat', 'id' => $model->ICNO], [
                                                    'data-toggle' => "modal",
                                                    'data-target' => "#myModal",
                                                    'data-title' => "Timeline Stat (Perkhidmatan Info)",
                                                ]) ?></h2>
            <ul class="nav navbar-right panel_toolbox">

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row text-center">
                <div class="col-lg-1 col-sm-3 col-xs-12 text-center">
                    <div class="col-lg-1 col-md-1 col-xs-12 text-center" rowspan="6" valign="top"><span><img height='100px' width="80px" src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(hash('sha1', $model->ICNO)); ?>.jpeg"></span></div>
                </div>
                <div class="col-lg-11 col-sm-9 col-xs-12">
                    <div class="row">
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>Nama:</b></div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 text-left"><?= $model->gelaran->Title . " " . ucwords(strtolower($model->CONm)) ?></div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 text-right"><b>No. KP / Paspot:</b></div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 text-left "><?= $model->ICNO ?></div>
                    </div>
                    <div class="row ">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jabatan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= ucwords(strtolower($model->department->fullname)) ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Kampus Cawangan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left "><?= ucwords(strtolower($model->kampus->campus_name)) ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>UMSPER:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->COOldID ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Jawatan Disandang:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->jawatan->nama . " (" . $model->jawatan->gred . ")"; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Jawatan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->statusSandangan->sandangan_name ?></div>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tarikh Mula Sandangan:</b></div>
                        <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStartSandanganPerkhidmatan ?>   <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Mula Kenaikan Gred Semasa / Tarikh Mula Lantikan Kontrak"></i>  </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Lantikan:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><?= $model->statusLantikan->ApmtStatusNm ?></div>
                        
                        <?php if ($model->statusSandangan->sandangan_id == 1) {?>
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tempoh Lantikan:</b></div>
                       <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->lantikanPerkhidmatan->tarikhMulaLantikan ?>   <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Lantikan Tetap Pertama di UMS / Tarikh Lantikan Kontrak"></i>  hingga <?= $model->tarikhbersara ?>    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Persaraan / Tarikh Tamat Kontrak"></i></div>
                   <?php }else{ ?>
                      <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Tempoh Lantikan:</b></div>
                     <div class="col-lg-4 col-sm-6 col-xs-6 text-left"><?= $model->displayStartLantikPerkhidmatan  ?>   <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Lantikan Tetap Pertama di UMS / Tarikh Lantikan Kontrak"></i>  hingga <?= $model->tarikhbersara ?>    <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Tarikh Persaraan / Tarikh Tamat Kontrak"></i></div>
                 
                       
                  <?php } ?>
                    
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-sm-6 col-xs-6 text-right"><b>Status Pekerja:</b></div>
                        <div class="col-lg-3 col-sm-6 col-xs-6 text-left"><span><?= $model->Status ? $model->serviceStatus->ServStatusNm : 'Not Set' ?></span></div>
                       
                    </div>
                </div>
            </div> </br>

            <div class="well well-lg">
                <div class="row ">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <table>
                            <tr>
                                <td class="text-center"><i class="fa fa-user" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Status Lantikan', ['status-lantikan/view', 'icno' => $model->ICNO]) ?></td>

                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-address-card-o" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Status Sandangan', ['status-sandangan/view', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-mortar-board" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Status Perkhidmatan', ['status-perkhidmatan/view', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-user-circle" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Pihak Berkuasa Melantik', ['pihak-berkuasa/view', 'icno' => $model->ICNO]) ?></td>
                            </tr <tr>
                            <td class="text-center"><i class="fa fa-balance-scale" aria-hidden="true"></i></td>
                            <td>&nbsp;<?= Html::a('Beban Perkhidmatan', ['beban-perkhidmatan/view', 'icno' => $model->ICNO]) ?></td>
                            </tr>

                        </table>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <table>

                            <tr>
                                <td class="text-center"><i class="fa fa-clock-o" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Waktu Bekerja', ['waktu-bekerja/view', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-list" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Status Pengesahan', ['status-pengesahan/view', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-clock-o" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Tempoh Percubaan', ['tempoh-percubaan/view', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-dollar" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Jenis Gaji', ['jenis-gaji/view', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Skim Saraan', ['jenis-perkhidmatan/view', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                        </table>
                    </div>


                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <table>


                            <tr>
                                <td class="text-center"><i class="fa fa-exchange" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Pergerakan Gaji', ['pergerakan-gaji/view', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-files-o" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Fail Perkhidmatan', ['fail-perkhidmatan/view', 'icno' => $model->ICNO]) ?></td>
                            </tr>

                            <tr>
                                <td class="text-center"><i class="fa fa-bar-chart" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Status Pencen', ['status-pencen/view', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-eye" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Mata Gaji', ['mata-gaji/view', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                        </table>
                    </div>


                    <div class="col-lg-3 col-md-6  col-sm-6 col-xs-12">
                        <table>


                            <tr>
                                <td class="text-center"><i class="fa fa-user" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Pihak Berkuasa Pencen', ['pihak-berkuasa-pencen/view', 'icno' => $model->ICNO]) ?></td>
                            </tr>
                            <tr>
                                <td class="text-center"><i class="fa fa-hourglass" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Umur Bersara', ['umur-bersara/view', 'icno' => $model->ICNO]) ?></td>
                            </tr>

                            <tr>
                                <td class="text-center"><i class="fa fa-history" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Sejarah Penempatan', ['sejarah-penempatan/view', 'icno' => $model->ICNO]) ?></td>
                            </tr>


                            <tr>
                                <td class="text-center"><i class="fa fa-cog" aria-hidden="true"></i></td>
                                <td>&nbsp;<?= Html::a('Perubahan Data', ['perubahan-data/view', 'usern' => $model->ICNO]) ?></td>
                            </tr>
                        </table>
                    </div>

                </div> <!-- div for row-->
            </div> <!-- div for well-->

        </div>
    </div>
    <?php
$this->registerJs("
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title') 
        var href = button.attr('href') 
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        })
");

?>
</div>


<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Perubahan Data</strong></h2>
            <ul class="nav navbar-right panel_toolbox">

            </ul>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">


            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <thead>
                        <tr class="headings">
                            <th>Bahagian</th>
                            <th>Aktiviti</th>
                            <th>Tarikh Dikemaskini</th>
                            <th>Pengkemaskini</th>

                        </tr>
                    </thead>
                    <?php


                    foreach ($provider->getModels() as $alamatkakitangan) : ?>

                        <tr>
                            <td><?= $alamatkakitangan->namaBahagian->nama ?></td>
                            <td><?= $statusLabel[$alamatkakitangan->COActivity] ?></td>
                            <td><?= $alamatkakitangan->tarikhKemaskini ?></td>
                            <td><?= $alamatkakitangan->namaPengemaskini ? $alamatkakitangan->namaPengemaskini->CONm: $alamatkakitangan->COUpdateCompUser;  ?></td>
                        </tr>


                    <?php endforeach;
                    ?>

                </table>
            </div>


            <?= LinkPager::widget([
                'pagination' => $provider->pagination,

            ]) ?>
        </div>
    </div>
  
</div>

