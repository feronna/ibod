<?php

use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Pending for Approval';
?>


<div class="row">

    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-list-alt"></i>&nbsp;<strong><?= Html::encode($this->title) ?></strong></h2>
            <ul class="nav navbar-right panel_toolbox ">
                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?php if ($model) { ?>

                <?php foreach ($model as $models) { ?>
                    <div class="tile-stats" style="padding: 10px">
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_content">
                                    <img src="https://hronline.ums.edu.my/picprofile/picstf/<?php echo strtoupper(sha1($models->icno)) ?>.jpeg" class="text-center" style="width: 90px">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_content">
                                    <p><strong>Nama / Name : </strong><?= $models->kakitangan->CONm; ?></p>
                                    <p><strong>Tarikh Bercuti / Leave Date : </strong><?= $models->full_date . ' (' . $models->jenisCuti->jenis_cuti_catatan . ')'; ?></p>
                                    <p><strong>Catatan / Remark : </strong><?= $models->remark; ?></p>

                                    </p>
                                    <br>
                                        <?= Html::button('<i class="fa fa-eye"></i> Detail ', ['value' => Url::to(['cuti/pegawai/cp-details-kj', 'id' => $models->id]), 'class' => 'mapBtn btn btn-sm btn-primary', 'id' => 'modalButton']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } elseif ($app) { ?>

                <?php foreach ($app as $models) { ?>
                    <div class="tile-stats" style="padding: 10px">
                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_content">
                                    <img src="https://hronline.ums.edu.my/picprofile/picstf/<?php echo strtoupper(sha1($models->icno)) ?>.jpeg" class="text-center" style="width: 90px">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_content">
                                    <p><strong>Nama / Name : </strong><?= $models->kakitangan->CONm; ?></p>
                                    <p><strong>Tarikh Bercuti / Leave Date : </strong><?= $models->full_date . ' (' . $models->jenisCuti->jenis_cuti_catatan . ')'; ?></p>
                                    <p><strong>Catatan / Remark : </strong><?= $models->remark; ?></p>

                                    </p>
                                    <br>
                                    <?= Html::button('<i class="fa fa-eye"></i> Detail ', ['value' => Url::to(['cuti/pegawai/cp-details-nc', 'id' => $models->id]), 'class' => 'mapBtn btn btn-sm btn-primary', 'id' => 'modalButton']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="tile-stats" style="padding: 10px">
                    <h3 class="text-center">No Record Found..</h3>
                </div>

            <?php } ?>


        </div>
    </div>

</div>