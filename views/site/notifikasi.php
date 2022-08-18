<?php

use yii\helpers\Html;
?>

<div class="col-md-12">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['site/index']) ?></li>
        <li>Pusat Notifikasi</li>
    </ol>
</div>


<ul class="nav nav-tabs">
    <li class="active"><?= Html::a('<i class="fa fa-inbox"></i> Peti Masuk (Inbox)', ['site/notifikasi']) ?></li>
    <li><?= Html::a('<i class="fa fa-archive"></i> Arkib', ['site/archive']) ?></li>
</ul>
<br>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-inbox"></i> Peti Masuk (Inbox) </strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered jambo_table">
                        <thead>
                            <tr class="headings">
                                <th class="text-center column-title">Bil</th>
                                <th class="text-center column-title">Tajuk / Modul</th>
                                <!--<th class="text-center column-title">Kandungan</th>-->
                                <th class="text-center column-title">Tarikh / Masa</th>
                                <th class="text-center column-title">Baca</th>
                                <th class="text-center column-title">Simpan ke Archive</th>
                            </tr>
                        </thead>
                        <?php if ($model) { ?>
                            <?php foreach ($model as $ntf) { ?>
                                <tr>
                                    <td class="text-center"><?= $bil++ ?></td>
                                    <td class="text-center"><?= $ntf->title ?></td>
                                    <!--<td class="text-center"><?= $ntf->content ?></td>-->
                                    <td class="text-center"><?= $ntf->formattedntfdt ?></td>
                                    <td class="text-center"><?= $ntf->read ?></td>
                                    <td class="text-center"><?= Html::a('<i class="fa fa-arrow-right"></i><i class="fa fa-archive"></i>', ['site/send_arch', 'id' => $ntf->id]) ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td class="text-center" colspan="6"><i>Tiada notifikasi setakat ini.</i></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>