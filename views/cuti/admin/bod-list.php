<?php

use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Pending for substitute approval';
?>

<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-list-alt"></i>&nbsp;<strong>Menunggu Persetujuan Pengganti/<i><?= Html::encode($this->title) ?></i></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php if (!$model) { ?>
            <div class="tile-stats" style="padding: 10px">
            <h3 class="text-center">No Record Found..</h3>
            </div>

        <?php } else { ?>
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
                                <p><strong>Nama/<i>Name </i> : </strong><?= $models->kakitangan->CONm; ?></p>
                                <p><strong>Tarikh Kembali Bertugas/<i>Back on Duty </i>: </strong><?= $models->full_date . ' (' . $models->jenisCuti->jenis_cuti_catatan . ')'; ?></p>
                                <p><strong>Catatan/<i>Remark </i>: </strong><?= $models->remark; ?></p>
                                <?= Html::a('<i class="fa fa-check-circle-o"></i> Click to Agree', Url::to(['cuti/individu/ganti']), ['data-method' => 'POST', 'data-confirm' => 'Are you sure you?', 'data-params' => ['id' => $models->id], 'class' => 'btn btn-success btn-sm pull-right']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>


    </div>
</div>