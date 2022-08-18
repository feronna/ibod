<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><?= Html::a('Carian Profil', Url::to(['data-list'])) ?></li>
        <li class="breadcrumb-item active" aria-current="page">Perincian</li>
    </ol>
</nav>

<?= $this->render('_detail_staff', [
    'biodata' => $biodata,
]) ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-list"></i>&nbsp;<strong>Senarai maklumat</strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Kembali', ['data-list'], ['class' => 'btn btn-default']); ?>
                <!-- <div class="pull-right"> -->
                    <?= Html::a('<i class="fa fa-plus"></i>&nbsp;Maklumat Baharu', ['create-profile', 'icno' => $biodata->ICNO], ['class' => 'btn btn-success']); ?>
                <!-- </div> -->
                <table class="table table-striped table-sm jambo_table table-bordered">
                    <thead>
                        <tr class="headings">
                            <th class="text-center">Bil</th>
                            <th class="text-center">Jenis Lantikan</th>
                            <th class="text-center">Sumber Peruntukan</th>
                            <th class="text-center">Pusat Kos</th>
                            <th class="text-center">Status Kontrak</th>
                            <th class="text-center">Tarikh Mula</th>
                            <th class="text-center">Kemaskini</th>
                            <th class="text-center">Delete</th>
                        </tr>
                    </thead>
                    <?php if ($model) { ?>
                        <?php foreach ($model as $v) { ?>
                            <tr>
                                <td class="text-center" style="text-align:center"><strong><?= $bil++ ?></strong></td>
                                <td class="text-center"><strong><?= $v->jenis_lantikan ?></strong></td>
                                <td class="text-center"><strong><?= $v->labelSumberPeruntukan ?></strong></td>
                                <td class="text-center"><strong><?= $v->labelPusatKos ?></strong></td>
                                <td class="text-center"><strong><?= $v->labelStatusKontrak ?></strong></td>
                                <td class="text-center"><strong><?= $v->start_date ?></strong></td>
                                <td class="text-center" style="text-align:center"><?= Html::a('<i class="fa fa-pencil"></i>', ['update-profile', 'id' => $v->id], ['class' => 'btn btn-sm btn-primary']) ?></td>
                                <td class="text-center" style="text-align:center"><?= Html::a('<i class="fa fa-trash"></i>&nbsp', ['delete-profile', 'id' => $v->id], [
                                                                                        'class' => 'btn btn-sm btn-danger',
                                                                                        'data' => [
                                                                                            'confirm' => 'Anda pasti untuk buang?',
                                                                                            'method' => 'post',
                                                                                        ],
                                                                                    ]) ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="7" class="align-center text-center"><i>No Record Found!</i></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>