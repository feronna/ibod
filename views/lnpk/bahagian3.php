<?php
/* @var $this yii\web\View */

$this->registerCss("
    .form-horizontal .control-label{
        /* text-align:right; */
        text-align:left;
    }
    
    textarea {
      resize: none;
    }
    
    ::-webkit-input-placeholder {
    line-height:100px;
    text-align: center;
    }
    :-moz-placeholder {
        /* Firefox 18- */
        line-height:100px;
        text-align: center;
    }
    ::-moz-placeholder {
        /* Firefox 19+ */
        line-height:100px;
        text-align: center;
    }
    :-ms-input-placeholder {
        line-height:100px;
        text-align: center;
    }
    
    dt, dd { display: block; float: left; margin-top: 10px; }
    dt { clear: both; }

    ");

use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php
echo $this->render('_menuBorang', ['lnpk_id' => $lnpk->lnpk_id]);
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>ULASAN KESELURUHAN DAN PENGESAHAN OLEH PEGAWAI PENILAI<?= ($lnpk->isPP) ? '' : ' PERTAMA' ?></strong><?= $lnpk->isAdmin() ? '<sup> View as Admin</sup>' : '' ?><?= ' - ' . $lnpk->pyd->CONm ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['class' => 'form-horizontal']]); ?>

                    <div class="control-group">
                        <label class="control-label col-sm-6">1. Tempoh Pegawai Yang Dinilai bertugas di bawah pengawasan:</label>
                        <div class="col-md-2 col-sm-2 col-lg-2 col-xs-12">
                            <?=
                            $form->field($model, 'tempoh_PPP_bulan')->textInput(['class' => 'form-control', 'placeholder' => 'bulan', 'style' => 'text-align:center', 'disabled' => ($lnpk->isPYD() || $lnpk->isPPK() || !is_null($model->ulasan_PPP_tt))])->label(false);
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">2. Pegawai Penilai<?= ($lnpk->isPP) ? '' : ' Pertama' ?> hendaklah memberi ulasan terhadap prestasi keseluruhan Pegawai Yang Dinilai.</label>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                            <?=
                            $form->field($model, 'ulasan_PPP_prestasi')->textArea(['class' => 'form-control', 'rows' => 5, 'placeholder' => '------------------------- Tiada sebarang ulasan oleh ' . (($lnpk->isPP) ? 'PP' : 'PPP') . ' -------------------------', 'disabled' => ($lnpk->isPYD() || $lnpk->isPPK() || !is_null($model->ulasan_PPP_tt))])->label(false);
                            ?>
                        </div>
                    </div>


                    <?php if (is_null($model->ulasan_PPP_tt) and $lnpk->isPPP()) { ?>
                        <div class="clearfix"></div>
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                            <?= Html::submitButton('Simpan', [
                                'class' => 'btn-sm btn-success pull-right',
                                'data' => [
                                    'confirm' => 'Adakah anda pasti?',
                                ],
                            ])
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    <?php } ?>

                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="col-sm-2">Nama Pegawai Penilai</th>
                                    <td class="col-sm-4"><?= ($lnpk->pp->CONm ?? $lnpk->ppp->CONm) ?? null ?></td>
                                </tr>
                                <tr>
                                    <th>No. Kad Pengenalan</th>
                                    <td><?= ($lnpk->pp->ICNO ?? $lnpk->ppp->ICNO) ?? null ?></td>
                                </tr>
                                <tr>
                                    <th>Jawatan</th>
                                    <td><?= ($lnpk->gredPp->nama ?? $lnpk->gredPpp->nama) ?? null ?></td>
                                </tr>
                                <tr>
                                    <th>Kementerian / Jabatan</th>
                                    <td><?= ($lnpk->deptPp->fullname ?? $lnpk->deptPpp->fullname) ?? null ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div style="clear:both;"></div>

                    <div class="row">
                        <div class="col-md-6 col-xs-0">
                        </div>
                        <div class="col-md-3 col-xs-6">
                        </div>
                        <?php if (is_null($model->ulasan_PPP_tt) and $lnpk->isPPP()) { ?>
                            <div class="col-md-3 col-xs-6" style="text-align:center">
                                <?= Html::a(
                                    '<strong>Klik untuk tandatangan ' . ($lnpk->isPP ? 'PP' : 'PPP') . '</strong>',
                                    ['lnpk/tandatangan-ulasan-ppp', 'lnpk_id' => $lnpk->lnpk_id],
                                    [
                                        'data' => [
                                            'method' => 'post', // <- extra level
                                        ],
                                    ]
                                ) ?>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-3 col-xs-6">
                            </div>
                        <?php } ?>
                    </div>

                    <hr />

                    <div class="row">
                        <div class="col-md-3 col-xs-6 pull-left" style="text-align: center">
                            <?= Html::input('text', 'password1', (empty($model->ulasan_PPP_tt) ? '' : (($lnpk->pp->CONm ?? $lnpk->ppp->CONm) ?? null)), ['class' => 'form-control', 'disabled' => true, 'style' => 'text-align: center']) ?>
                            <br>Tandatangan <?= ($lnpk->isPP) ? 'PP' : 'PPP' ?>
                        </div>
                        <div class="col-md-3 col-xs-6 pull-right" style="text-align: center">
                            <?= Html::input('text', 'password1', (empty($model->ulasan_PPP_tt) ? '' : Yii::$app->formatter->asDateTime($model->ulasan_PPP_tt_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A")), ['class' => 'form-control', 'disabled' => true, 'style' => 'text-align: center']) ?>
                            <br>Tarikh
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>

<?php if (!($lnpk->isPP)) { ?>
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong>ULASAN KESELURUHAN DAN PENGESAHAN OLEH PEGAWAI PENILAI KEDUA</strong><?= $lnpk->isAdmin() ? '<sup> View as Admin</sup>' : '' ?></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['class' => 'form-horizontal']]); ?>

                        <div class="control-group">
                            <label class="control-label col-sm-6">1. Tempoh Pegawai Yang Dinilai bertugas di bawah pengawasan:</label>
                            <div class="col-md-2 col-sm-2 col-lg-2 col-xs-12">
                                <?=
                                $form->field($model, 'tempoh_PPK_bulan')->textInput(['class' => 'form-control', 'placeholder' => 'bulan', 'style' => 'text-align:center', 'disabled' => ($lnpk->isPYD() || $lnpk->isPPP() || !is_null($model->ulasan_PPK_tt))])->label(false);
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">2. Pegawai Penilai Kedua hendaklah memberi ulasan terhadap prestasi keseluruhan Pegawai Yang Dinilai.</label>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                <?=
                                $form->field($model, 'ulasan_PPK_prestasi')->textArea(['class' => 'form-control', 'rows' => 5, 'placeholder' => '------------------------- Tiada sebarang ulasan oleh ' . (($lnpk->isPP) ? 'PP' : 'PPP') . ' -------------------------', 'disabled' => ($lnpk->isPYD() || $lnpk->isPPP() || !is_null($model->ulasan_PPK_tt))])->label(false);
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-12 col-sm-12 col-xs-12">2. Pegawai Penilai Kedua hendaklah memberi ulasan penjelasan pemberian markah prestasi 90% dan ke atas (jika berkenaan).</label>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                <?=
                                $form->field($model, 'ulasan_PPK_prestasi_atas')->textArea(['class' => 'form-control', 'rows' => 5, 'placeholder' => '------------------------- Tiada sebarang ulasan oleh ' . (($lnpk->isPP) ? 'PP' : 'PPP') . ' -------------------------', 'disabled' => $lnpk->isPYD() || ($lnpk->isPPP() || !is_null($model->ulasan_PPK_tt))])->label(false);
                                ?>
                            </div>
                        </div>


                        <?php if (is_null($model->ulasan_PPK_tt) and $lnpk->isPPK()) { ?>
                            <div class="clearfix"></div>
                            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                <?= Html::submitButton('Simpan', [
                                    'class' => 'btn-sm btn-success pull-right',
                                    'data' => [
                                        'confirm' => 'Adakah anda pasti?',
                                    ],
                                ])
                                ?>
                            </div>
                            <div class="clearfix"></div>
                        <?php } ?>


                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="col-sm-2">Nama Pegawai Penilai</th>
                                        <td class="col-sm-4"><?= $lnpk->ppk->CONm ?? null ?></td>
                                    </tr>
                                    <tr>
                                        <th>No. Kad Pengenalan</th>
                                        <td><?= $lnpk->ppk->ICNO ?? null ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jawatan</th>
                                        <td><?= $lnpk->gredPpk->nama ?? null ?></td>
                                    </tr>
                                    <tr>
                                        <th>Kementerian / Jabatan</th>
                                        <td><?= $lnpk->deptPpk->fullname ?? null ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div style="clear:both;"></div>

                        <div class="row">
                            <div class="col-md-6 col-xs-0">
                            </div>
                            <div class="col-md-3 col-xs-6">
                            </div>
                            <?php if (is_null($model->ulasan_PPK_tt) and $lnpk->isPPK()) { ?>
                                <div class="col-md-3 col-xs-6" style="text-align:center">
                                    <?= Html::a(
                                        '<strong>Klik untuk tandatangan PPK</strong>',
                                        ['lnpk/tandatangan-ulasan-ppk', 'lnpk_id' => $lnpk->lnpk_id],
                                        [
                                            'data' => [
                                                'method' => 'post', // <- extra level
                                            ],
                                        ]
                                    ) ?>
                                </div>
                            <?php } else { ?>
                                <div class="col-md-3 col-xs-6">
                                </div>
                            <?php } ?>
                        </div>

                        <hr />

                        <div class="row">
                            <div class="col-md-3 col-xs-6 pull-left" style="text-align: center">
                                <?= Html::input('text', 'password1', (empty($model->ulasan_PPK_tt) ? '' : ($lnpk->ppk->CONm ?? null)), ['class' => 'form-control', 'disabled' => true, 'style' => 'text-align: center']) ?>
                                <br>Tandatangan PPK
                            </div>
                            <div class="col-md-3 col-xs-6 pull-right" style="text-align: center">
                                <?= Html::input('text', 'password1', (empty($model->ulasan_PPK_tt) ? '' : Yii::$app->formatter->asDateTime($model->ulasan_PPK_tt_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A")), ['class' => 'form-control', 'disabled' => true, 'style' => 'text-align: center']) ?>
                                <br>Tarikh
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php  } ?>