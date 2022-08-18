<?php

use app\models\cuti\Layak;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\View;

$this->title = 'Pending for Verification';
?>


<div class="row">
    <div class="col-md-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-pencil-square-o"></i>&nbsp;<strong>Menunggu Perakuan / <i><?= Html::encode($this->title) ?></i></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- <h4>Recent Activity</h4> -->

                <?php if (!$model) { ?>
                    <div class="tile-stats" style="padding: 1px">
                        <h4 class="text-center">Not available at the moment..</h4>
                    </div>

                <?php } else { ?>
                  
                    <?php foreach ($model as $models) { ?>
                        <ul class="messages">
                            <li>

                                <img src="https://hronline.ums.edu.my/picprofile/picstf/<?php echo strtoupper(sha1($models->icno)) ?>.jpeg" class="avatar">
                                <div class="message_date">
                                    <h3 class="date text-info"><?= $models->dayMohon; ?></h3>
                                    <p class="month"><?= $models->monthMohon; ?></p>
                                </div>
                                <div class="message_wrapper">
                                    <h4 class="heading"><?= $models->kakitangan->CONm; ?></h4>
                                    <p>
                                        <strong>Tarikh Bercuti/<i>Leave Date</i> : <?= $models->full_date . ' (' . $models->jenisCuti->jenis_cuti_catatan . ')'; ?></strong>
                                        <br>
                                        <strong>Catatan/ <i>Remark</i> : <?= $models->remark; ?></strong>
                                        <br>
                                        <strong>Tempoh / <i>Duration</i> : <?= $models->tempoh; ?></strong>
                                        <br>
                                        <strong>Baki Cuti / <i>Balance</i> : <?= Layak::getBakiLatest($models->icno); ?></strong>

                                    </p>

                                    <?php echo Html::a('<i class="fa fa-check-circle-o"></i> Verify', Url::to(['cuti/pegawai/peraku']), ['data-method' => 'POST', 'data-confirm' => 'Are you sure you?', 'data-params' => ['id' => $models->id], 'class' => 'btn btn-sm btn-success']) ?>
                                    <?= Html::button('<i class="fa fa-eye"></i> Detail ', ['value' => Url::to(['cuti/pegawai/leave-detail-peraku', 'id' => $models->id]), 'class' => 'mapBtn btn btn-sm btn-primary', 'id' => 'modalButton']); ?>

                                </div>
                            </li>

                        <?php } ?>
                       
                        </ul>

                    <?php } ?>

            </div>
        </div>
    </div>

    <div class="col-md-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-pencil-square"></i>&nbsp;<strong>Menunggu Kelulusan / <i>Pending for Approval</i></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <!-- <h4>Recent Activity</h4> -->

                <?php if (!$app) { ?>
                    <div class="tile-stats" style="padding: 1px">
                        <h4 class="text-center">Not available at the moment..</h4>
                    </div>

                <?php } else { ?>
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => ['class' => 'form-horizontal'],
                    ])
                    ?>
                    <button type="button" class="checkall btn btn-warning"><i class="fa fa-edit"></i>&nbsp;Select All</button>

                    <?= Html::submitButton('<i class="fa fa-paper-plane"></i>&nbsp;Approve', ['class' => 'btn btn-primary']) ?>
                    <?php foreach ($app as $apps) { ?>

                        <ul class="messages">
                            <li>
                                <td class="text-center" style="text-align:center"><?= $form->field($apps, 'id[]')->checkbox(['value' => $apps->id, 'label' => '', 'class' => 'checkId']); ?></td>

                                <img src="https://hronline.ums.edu.my/picprofile/picstf/<?php echo strtoupper(sha1($apps->icno)) ?>.jpeg" class="avatar">
                                <div class="message_date">
                                    <h3 class="date text-info"><?= $apps->dayMohon; ?></h3>
                                    <p class="month"><?= $apps->monthMohon; ?></p>
                                </div>
                                <div class="message_wrapper">
                                    <h4 class="heading"><?= $apps->kakitangan->CONm; ?></h4>
                                    <p>
                                        <strong>Tarikh Bercuti/<i>Leave Date</i> : <?= $apps->full_date . ' (' . $apps->jenisCuti->jenis_cuti_catatan . ')'; ?></strong>
                                        <br>
                                        <strong>Catatan/ <i>Remark</i> : <?= $apps->remark; ?></strong>
                                        <br>
                                        <strong>Tempoh / <i>Duration</i> : <?= $apps->tempoh; ?></strong>
                                        <br>
                                        <strong>Baki Cuti / <i>Balance</i> : <?= Layak::getBakiLatest($apps->icno); ?></strong>
                                        <br>
                                        <?php if ($apps->jenis_cuti_id == 20 || $apps->jenis_cuti_id == 21) { ?>
                                            <strong>Sijil Sakit/<i>Medical Certificate</i> : </strong><span class="badge" style="background-color :violet"><?= $apps->displayLink; ?></span>
                                            <a href="#" data-toggle="tooltip" title="Click File Name to Download!"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                                            </strong>
                                        <?php } ?>

                                        <strong>Jabatan / <i>Department</i> :<?= $apps->department->fullname; ?></strong>
                                        <br>
                                    </p>

                                    <?php echo Html::a('<i class="fa fa-check-circle"></i> Approve', Url::to(['cuti/pegawai/lulus']), ['data-method' => 'POST', 'data-confirm' => 'Are you sure you?', 'data-params' => ['id' => $apps->id], 'class' => 'btn btn-sm btn-success']) ?>
                                    <?= Html::button('<i class="fa fa-eye"></i> Detail ', ['value' => Url::to(['cuti/pegawai/leave-detail-lulus', 'id' => $apps->id]), 'class' => 'mapBtn btn btn-sm btn-primary', 'id' => 'modalButton']); ?>

                                </div>
                            </li>

                        <?php } ?>

                        </ul>
                        <?php ActiveForm::end() ?>
                    <?php } ?>

            </div>

        </div>
    </div>
</div>


<?php
$script = <<< JS
        
       $(document).ready(function () {
        
        var clicked = false;
        $(".checkall").on("click", function() {
          $(".checkId").prop("checked", !clicked);
          clicked = !clicked;
        });

    });

JS;
$this->registerJs($script, View::POS_END);
?>