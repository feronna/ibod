<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblpraddress */

$this->title = 'Pendidikan';

?>
<br>
<div class="form-group">
    <?= Html::a('Kembali', ['biodata/userview'], ['class' => 'btn btn-primary']) ?>
</div>
<br>
<ul class="nav nav-tabs">
    <li class="nav-item active">
        <a class="nav-link " href="#certificate" data-toggle="tab">Sijil Klinikal/Perubatan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#membership" data-toggle="tab">Keahlian</a>
    </li>
</ul>
<div class="tab-content">
    <!-- start tab-->
    <div class="tab-pane fade in active " id="certificate">
        <br>
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= "Sijil Klinikal/Perubatan" ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?= Html::a('Tambah Sijil', ['add-cl-cert'], ['class' => 'btn btn-primary']) ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered jambo_table table-striped">
                            <thead>
                                <tr class="headings">
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Certificate No.</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Awarded By</th>
                                    <th>Telah Disahkan</th>
                                    <th class="text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <?php if ($cert) {

                                foreach ($cert as $cert) {

                            ?>
                                    <tr>
                                        <td><?= $cert->title ?></td>
                                        <td><?= $cert->certType ?  $cert->certType->certType : '<span style="background-color:yellow;color:black;">Sila kemaskini.</span>' ?></td>
                                        <td><?= $cert->certNo ?></td>
                                        <td><?= Yii::$app->MP->Tarikh($cert->startDt) ?></td>
                                        <td><?= Yii::$app->MP->Tarikh($cert->endDt) ?></td>
                                        <td><?= $cert->awardBy ?></td>
                                        <td><?= $cert->isverified ?></td>
                                        <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['view-cc', 'id' => $cert->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update-cc', 'id' => $cert->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-cc', 'id' => $cert->id], []) ?></td>
                                    </tr>

                                <?php }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="10" class="text-center">Tiada Rekod</td>
                                </tr>
                            <?php
                            } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end tab-->
    <!-- start tab-->
    <div class="tab-pane fade " id="membership">
        <br>
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= "Keahlian Perubatan" ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?= Html::a('Tambah Keahlian', ['tambah-keahlian-perubatan'], ['class' => 'btn btn-primary']) ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered jambo_table table-striped">
                            <thead>
                                <tr class="headings">
                                    <th>Nama </th>
                                    <th>Peringkat</th>
                                    <th>No. Keahlian</th>
                                    <th>Tarikh Mula Menyertai</th>
                                    <th>Tarikh Tamat Menyertai</th>
                                    <th>Yuran Dikenakan</th>
                                    <th>Telah Disahkan</th>
                                    <th class="text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <?php if ($profBody) {

                                foreach ($profBody as $profBody) {

                            ?>

                                    <tr>
                                        <td><?= $profBody->nambadanprofesional ?></td>
                                        <td><?= $profBody->peringkat ? $profBody->peringkat->LvlNm : '<span style="background-color:yellow;color:black;">Sila kemaskini peringkat Kelab/Persatuan/Institusi/Kesatuan ini.</span>' ?></td>
                                        <td><?= $profBody->membershipNo ?></td>
                                        <td><?= $profBody->tarikhmula ?></td>
                                        <td><?= $profBody->tarikhakhir; ?></td>
                                        <td><?= $profBody->staaktif ?></td>
                                        <td><?= $profBody->stasah ?></td>
                                        <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['view-bp', 'id' => $profBody->profId]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update-bp', 'id' => $profBody->profId]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-bp', 'id' => $profBody->profId], [
                                                                                                                                                                                                                                                                                                                                            'data' => [
                                                                                                                                                                                                                                                                                                                                                'confirm' => 'Anda ingin membuang rekod ini?',
                                                                                                                                                                                                                                                                                                                                                'method' => 'post',
                                                                                                                                                                                                                                                                                                                                            ],
                                                                                                                                                                                                                                                                                                                                        ]) ?></td>
                                    </tr>

                                <?php }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="10" class="text-center">Tiada Rekod</td>
                                </tr>
                            <?php
                            } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end tab-->
</div>