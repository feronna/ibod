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

if ($lpp->PPP == \Yii::$app->user->identity->ICNO) {
    if (is_null($model->ulasan_PPP_tt)) {
        $acc = false;
    } else {
        $acc = true;
    }
} else {
    $acc = true;
}

?>

<?= $this->render('_menuBorang', ['lppid' => $lpp->lpp_id]); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Bahagian VIII - Ulasan Keseluruhan Dan Pengesahan Oleh Pegawai Penilai Pertama</strong> <?= (($lpp->PYD != Yii::$app->user->identity->ICNO)) ? '(' . $lpp->pyd->CONm . ' - ' . $lpp->tahun . ')' : '' ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>

                    <div class="control-group">
                        <label class="control-label col-sm-4">1. Tempat PYD bertugas di bawah pengawasan (bulan):</label>
                        <?php if ($acc) {
                            echo '<label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12"></label><br><div class="col-md-12 col-sm-12 col-lg-12 col-xs-12"><p>' . $model->tempoh_PPP_bulan . '</p></div>';
                        } else { ?>
                            <div class="col-md-1 col-sm-1 col-lg-1 col-xs-12">

                                <?=
                                $form->field($model, 'tempoh_PPP_bulan')->textInput(['class' => 'form-control', 'placeholder' => '0', 'style' => 'text-align:center'])->label(false);
                                ?>

                            </div>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">2. Penilai Pertama hendaklah memberi ulasan keseluruhan pencapaian prestasi PYD</label>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">i. Prestasi kemajuan</label>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                            <?php if ($acc) {
                                echo '<p>' . $model->ulasan_PPP_prestasi . '</p>';
                            } else { ?>
                                <?=
                                $form->field($model, 'ulasan_PPP_prestasi')->textArea(['class' => 'form-control', 'rows' => 5, 'placeholder' => '------------------------- Tiada sebarang ulasan oleh PPP -------------------------', 'disabled' => $acc])->label(false);
                                ?>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">i. Kemajuan kerjaya</label>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                            <?php if ($acc) {
                                echo '<p>' . $model->ulasan_PPP_kemajuan . '</p>';
                            } else { ?>
                                <?=
                                $form->field($model, 'ulasan_PPP_kemajuan')->textArea(['class' => 'form-control', 'rows' => 5, 'placeholder' => '------------------------- Tiada sebarang ulasan oleh PPP -------------------------', 'disabled' => $acc])->label(false);
                                ?>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">iii. Penjelasan pemberian markah prestasi 90% dan ke atas (jika berkenaan)</label>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                            <?php if ($acc) {
                                echo '<p>' . $model->ulasan_PPP_markah . '</p>';
                            } else { ?>
                                <?=
                                $form->field($model, 'ulasan_PPP_markah')->textArea(['class' => 'form-control', 'rows' => 5, 'placeholder' => '------------------------- Tiada sebarang ulasan Oleh PPP -------------------------', 'disabled' => $acc])->label(false);
                                ?>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">3. Adalah disahkan bahawa prestasi pegawai ini telah dimaklumkan kepada PYD</label>
                    </div>

                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th class="col-md-2">Nama PPP</th>
                                <td><?= is_null($lpp->PPP) ? '' : $lpp->pppName ?></td>
                            </tr>
                            <tr>
                                <th class="col-md-2">Jawatan</th>
                                <td><?= is_null($lpp->PPP) ? '' : strtoupper($lpp->pppGredJawatan) ?></td>
                            </tr>
                            <tr>
                                <th class="col-md-2">JAFPIB</th>
                                <td><?= is_null($lpp->PPP) ? '' : $lpp->pppDept ?></td>
                            </tr>
                            <tr>
                                <th class="col-md-2">No. KP</th>
                                <td><?= is_null($lpp->PPP) ? '' : $lpp->PPP ?></td>
                            </tr>
                        </table>
                    </div>

                    <div style="clear:both;"></div>

                    <?php if (is_null($model->ulasan_PPP_tt)) { ?>
                        <?php if (($lpp->PPP == \Yii::$app->user->identity->ICNO)) { ?>
                            <div class="row form-group">
                                <?= Html::submitButton('Simpan', [
                                    'class' => 'btn btn-success pull-right',
                                    'data' => [
                                        'confirm' => 'Adakah anda pasti?',
                                    ],
                                ])
                                ?>
                            </div>
                        <?php } ?>
                    <?php } ?>

                    <hr>

                    <div class="row">
                        <div class="col-md-6 col-xs-0">
                        </div>
                        <div class="col-md-3 col-xs-6">
                        </div>
                        <?php if (!($model->isNewRecord) and is_null($model->ulasan_PPP_tt) and $lpp->PPP == Yii::$app->user->identity->ICNO) { ?>
                            <div class="col-md-3 col-xs-6" style="text-align:center">
                                <?= Html::a(
                                    'Klik untuk tandatangan PPP',
                                    ['lppums/tandatangan-bahagian8', 'lpp_id' => $_GET['lpp_id']],
                                    [
                                        'class' => 'btn btn-default btn-primary',
                                        'data' => [
                                            'confirm' => 'Adakah anda pasti dengan tindakan ini?',
                                            'method' => 'post',
                                        ],
                                    ]
                                ) ?>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-3 col-xs-6">
                            </div>
                        <?php } ?>
                    </div><br>

                    <div class="row">
                        <div class="col-md-3 col-xs-6">
                            <?= Html::input('text', 'password1', (empty($model->ulasan_PPP_tt) ? '' : $lpp->pppName), ['class' => 'form-control', 'disabled' => true, 'style' => 'text-align: center']) ?>
                        </div>
                        <div class="col-md-6 col-xs-0">
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <?= Html::input('text', 'password1', (empty($model->ulasan_PPP_tt) ? '' : Yii::$app->formatter->asDateTime($model->ulasan_PPP_tt_datetime . ' Asia/Kuala_Lumpur', "php:d/m/Y  h:i A")), ['class' => 'form-control', 'disabled' => true, 'style' => 'text-align: center']) ?>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-md-3 col-xs-6" style="text-align: center">
                            Tandatangan PPP
                        </div>
                        <div class="col-md-6 col-xs-0">
                        </div>
                        <div class="col-md-3 col-xs-6" style="text-align: center">
                            Tarikh
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>