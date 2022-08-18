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
        <a class="nav-link " href="#degree" data-toggle="tab">Sarjana</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#diploma" data-toggle="tab">Diploma</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#sijil" data-toggle="tab">Sijil Kemahiran</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#spm" data-toggle="tab">SPM/Setaraf</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#pmr" data-toggle="tab">PMR/PT3/Setaraf</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#lainlain" data-toggle="tab">Lain-lain</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#publications" data-toggle="tab">Publications</a>
    </li>
</ul>
<div class="tab-content">
    <!-- start tab-->
    <div class="tab-pane fade in active " id="degree">
        <br>
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= "Sarjana" ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <?= Html::a('Tambah Pendidikan', ['tambahpendidikan'], ['class' => 'btn btn-primary']) ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered jambo_table table-striped">
                            <thead>
                                <tr class="headings">
                                    <th>Institut</th>
                                    <th>Tahap Pendidikan</th>
                                    <th>Major</th>
                                    <th>Nama Sijil (Malay)</th>
                                    <th>Tarikh Dianugerahkan</th>
                                    <th>Status Pengiktirafan</th>
                                    <th class="text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <?php if ($degree) {

                                foreach ($degree as $degrees) {

                            ?>
                                    <tr>
                                        <td><?= $degrees->namainstitut ?></td>
                                        <td><?= $degrees->tahapPendidikan ?></td>
                                        <td><?= $degrees->namamajor ?></td>
                                        <td><?= $degrees->EduCertTitle; ?></td>
                                        <td><?= $degrees->confermentDt ?></td>
                                        <td><?= $degrees->diiktiraf ?></td>
                                        <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihatpendidikan', 'id' => $degrees->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update', 'id' => $degrees->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $degrees->id], [
                                                                                                                                                                                                                                                                                        'data' => [
                                                                                                                                                                                                                                                                                            'confirm' => 'Anda ingin Membuang rekod ini?',
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
    <!-- start tab-->
    <div class="tab-pane fade " id="diploma">
        <br>
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= "Diploma/Setaraf" ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <?= Html::a('Tambah Pendidikan', ['tambahpendidikan'], ['class' => 'btn btn-primary']) ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered jambo_table table-striped">
                            <thead>
                                <tr class="headings">
                                    <th>Institut</th>
                                    <th>Tahap Pendidikan</th>
                                    <th>Major</th>
                                    <th>Nama Sijil (Malay)</th>
                                    <th>Tarikh Dianugerahkan</th>
                                    <th>Status Pengiktirafan</th>
                                    <th class="text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <?php if ($diploma) {

                                foreach ($diploma as $diplomas) {

                            ?>

                                    <tr>
                                        <td><?= $diplomas->namainstitut ?></td>
                                        <td><?= $diplomas->tahapPendidikan ?></td>
                                        <td><?= $diplomas->namamajor ?></td>
                                        <td><?= $diplomas->EduCertTitle; ?></td>
                                        <td><?= $diplomas->confermentDt ?></td>
                                        <td><?= $diplomas->diiktiraf ?></td>
                                        <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihatpendidikan', 'id' => $diplomas->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update', 'id' => $diplomas->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $diplomas->id], [
                                                                                                                                                                                                                                                                                        'data' => [
                                                                                                                                                                                                                                                                                            'confirm' => 'Anda ingin Membuang rekod ini?',
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
    <!-- start tab-->
    <div class="tab-pane fade " id="sijil">
        <br>
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= "Sijil Kemahiran" ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <?= Html::a('Tambah Pendidikan', ['tambahpendidikan'], ['class' => 'btn btn-primary']) ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered jambo_table table-striped">
                            <thead>
                                <tr class="headings">
                                    <th>Institut</th>
                                    <th>Tahap Pendidikan</th>
                                    <th>Major</th>
                                    <th>Nama Sijil (Malay)</th>
                                    <th>Tarikh Dianugerahkan</th>
                                    <th>Status Pengiktirafan</th>
                                    <th class="text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <?php if ($sijil) {

                                foreach ($sijil as $sijils) {

                            ?>

                                    <tr>
                                        <td><?= $sijils->namainstitut ?></td>
                                        <td><?= $sijils->tahapPendidikan ?></td>
                                        <td><?= $sijils->namamajor ?></td>
                                        <td><?= $sijils->EduCertTitle; ?></td>
                                        <td><?= $sijils->confermentDt ?></td>
                                        <td><?= $sijils->diiktiraf ?></td>
                                        <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihatpendidikan', 'id' => $sijils->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update', 'id' => $sijils->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $sijils->id], [
                                                                                                                                                                                                                                                                                    'data' => [
                                                                                                                                                                                                                                                                                        'confirm' => 'Anda ingin Membuang rekod ini?',
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
    <!-- start tab-->
    <div class="tab-pane fade " id="spm">
        <br>
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= "SPM/Setaraf" ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <?= Html::a('Tambah Pendidikan', ['tambahpendidikan'], ['class' => 'btn btn-primary']) ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered jambo_table table-striped">
                            <thead>
                                <tr class="headings">
                                    <th>Institut</th>
                                    <th>Tahap Pendidikan</th>
                                    <th>Major</th>
                                    <th>Nama Sijil (Malay)</th>
                                    <th>Tarikh Dianugerahkan</th>
                                    <th>Status Pengiktirafan</th>
                                    <th class="text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <?php if ($spm) {

                                foreach ($spm as $spms) {

                            ?>

                                    <tr>
                                        <td><?= $spms->namainstitut ?></td>
                                        <td><?= $spms->tahapPendidikan ?></td>
                                        <td><?= $spms->namamajor ?></td>
                                        <td><?= $spms->EduCertTitle; ?></td>
                                        <td><?= $spms->confermentDt ?></td>
                                        <td><?= $spms->diiktiraf ?></td>
                                        <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihatpendidikan', 'id' => $spms->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update', 'id' => $spms->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $spms->id], [
                                                                                                                                                                                                                                                                                'data' => [
                                                                                                                                                                                                                                                                                    'confirm' => 'Anda ingin Membuang rekod ini?',
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
    <!-- start tab-->
    <div class="tab-pane fade " id="pmr">
        <br>
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= "PMR/PT3/Setaraf" ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <?= Html::a('Tambah Pendidikan', ['tambahpendidikan'], ['class' => 'btn btn-primary']) ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered jambo_table table-striped">
                            <thead>
                                <tr class="headings">
                                    <th>Institut</th>
                                    <th>Tahap Pendidikan</th>
                                    <th>Major</th>
                                    <th>Nama Sijil (Malay)</th>
                                    <th>Tarikh Dianugerahkan</th>
                                    <th>Status Pengiktirafan</th>
                                    <th class="text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <?php if ($pmr) {

                                foreach ($pmr as $pmrs) {

                            ?>

                                    <tr>
                                        <td><?= $pmrs->namainstitut ?></td>
                                        <td><?= $pmrs->tahapPendidikan ?></td>
                                        <td><?= $pmrs->namamajor ?></td>
                                        <td><?= $pmrs->EduCertTitle; ?></td>
                                        <td><?= $pmrs->confermentDt ?></td>
                                        <td><?= $pmrs->diiktiraf ?></td>
                                        <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihatpendidikan', 'id' => $pmrs->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update', 'id' => $pmrs->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $pmrs->id], [
                                                                                                                                                                                                                                                                                'data' => [
                                                                                                                                                                                                                                                                                    'confirm' => 'Anda ingin Membuang rekod ini?',
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
    <div class="tab-pane fade " id="lainlain">
        <br>
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= "Lain-lain Pendidikan" ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                    <?= Html::a('Tambah Pendidikan', ['tambahpendidikan'], ['class' => 'btn btn-primary']) ?>
                        <table class="table table-sm table-bordered jambo_table table-striped">
                            <thead>
                                <tr class="headings">
                                    <th>Institut</th>
                                    <th>Tahap Pendidikan</th>
                                    <th>Major</th>
                                    <th>Nama Sijil (Malay)</th>
                                    <th>Tarikh Dianugerahkan</th>
                                    <th>Status Pengiktirafan</th>
                                    <th class="text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <?php if ($lainlain) {

                                foreach ($lainlain as $lainlains) {

                            ?>

                                    <tr>
                                        <td><?= $lainlains->namainstitut ?></td>
                                        <td><?= $lainlains->tahapPendidikan ?></td>
                                        <td><?= $lainlains->namamajor ?></td>
                                        <td><?= $lainlains->EduCertTitle; ?></td>
                                        <td><?= $lainlains->confermentDt ?></td>
                                        <td><?= $lainlains->diiktiraf ?></td>
                                        <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihatpendidikan', 'id' => $lainlains->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update', 'id' => $lainlains->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $lainlains->id], [
                                                                                                                                                                                                                                                                                            'data' => [
                                                                                                                                                                                                                                                                                                'confirm' => 'Anda ingin Membuang rekod ini?',
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
    <div class="tab-pane fade " id="publications">
        <br>
        <div class="col-md-12 col-sm-12 col-xs-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Publications</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?= Html::a('<i class="fa fa-plus-square"></i>&nbsp; New Publication', ['add-pub'], ['class' => 'btn btn-success']) ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered jambo_table table-striped">
                            <thead>
                                <tr class="headings">
                                    <th>Type</th>
                                    <th>URL Profile</th>
                                    <th class="text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <?php if ($publication) {
                                foreach ($publication as $publications) {
                            ?>
                                    <tr>
                                        <td><?= $publications->typeTxt ?></td>
                                        <td><?= Html::a($publications->url, $publications->url, ['target' => '_blank']) ?></td>
                                        <td class="text-center"><?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['update-pub', 'id' => $publications->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-pub', 'id' => $publications->id], [
                                                                                                                                                                                    'data' => [
                                                                                                                                                                                        'confirm' => 'Are you sure to remove this item?',
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