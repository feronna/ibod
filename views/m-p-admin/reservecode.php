<?php

use yii\helpers\Html;


$this->title = 'Passport dan Work Permit';
?>
<ul class="nav nav-tabs">
    <li class="nav-item active">
        <a class="nav-link " href="#paspot" data-toggle="tab">Passport</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#permit" data-toggle="tab">Work Permit</a>
    </li>

    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane fade in active " id="paspot">
        <br>
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= "Passport" ?></h2>

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <?= Html::a('Back', ['m-p-admin/index'], ['class' => 'btn btn-primary']) ?>
                    
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered jambo_table table-striped">
                            <thead>
                                <tr class="headings">
                                    <th>IC/KP</th>
                                    <th>Nama</th>
                                    <th>Sebab Notifikasi</th>
                                    <th>Tarikh Notifikasi</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <?php if ($paspot) {

                                foreach ($paspot as $p) {

                            ?>

                                    <tr>
                                        <td><?= $p->icno; ?></td>
                                        <td><?= $p->name; ?></td>
                                        <td><?= $p->reminder_reason; ?></td>
                                        <td><?= $p->entry_dt; ?></td>
                                        <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihatpasport', 'id' => $p->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['updatepasport', 'id' => $p->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['deletepaspot', 'id' => $p->id], [
                                                                                                                                                                                                                                                                                                                'data' => [
                                                                                                                                                                                                                                                                                                                    'confirm' => 'Do you wish to remove this data ?',
                                                                                                                                                                                                                                                                                                                    'method' => 'post',
                                                                                                                                                                                                                                                                                                                ],
                                                                                                                                                                                                                                                                                                            ]) ?></td>
                                    </tr>

                                <?php }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="5" class="text-center">No Record Found</td>
                                </tr>
                            <?php
                            } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane fade " id="permit">
        <br>
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= "Work Permit" ?></h2>

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <?= Html::a('Back', ['m-p-admin/index'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('New Work Permit', ['tambahpermitkerja'], ['class' => 'btn btn-primary']) ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered jambo_table table-striped">
                            <thead>
                                <tr class="headings">
                                    <th>IC/KP</th>
                                    <th>Nama</th>
                                    <th>Sebab Notifikasi</th>
                                    <th>Tarikh Notifikasi</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <?php
                            if ($permit) {

                                foreach ($permit as $pk) {
                            ?>

                                    <tr>
                                        <td><?= $pk->icno; ?></td>
                                        <td><?= $pk->name; ?></td>
                                        <td><?= $pk->reminder_reason; ?></td>
                                        <td><?= $pk->entry_dt; ?></td>
                                        <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihatpermitkerja', 'id' => $pk->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['updatepermitkerja', 'id' => $pk->id]) ?> | <?=
                                                                                                                                                                                                                                                                                                                    Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['deletepermit', 'id' => $pk->id], [
                                                                                                                                                                                                                                                                                                                        'data' => [
                                                                                                                                                                                                                                                                                                                            'confirm' => 'Do you wish to remove this data ?',
                                                                                                                                                                                                                                                                                                                            'method' => 'post',
                                                                                                                                                                                                                                                                                                                        ],
                                                                                                                                                                                                                                                                                                                    ])
                                                                                                                                                                                                                                                                                                                ?></td>
                                    </tr>

                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="5" class="text-center">No Record Found</td>
                                </tr>
                            <?php }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>