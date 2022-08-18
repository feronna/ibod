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

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<?= $this->render('_menuBorang', ['lppid' => $lpp->lpp_id]); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Bahagian III - Laporan dan Ulasan Keseluruhan Pencapaian Sasaran Kerja Tahunan Pada Akhir Tahun Oleh PYD dan PPP</strong> <?= (($lpp->PYD != Yii::$app->user->identity->ICNO)) ? '(' . $lpp->pyd->CONm . ' - ' . $lpp->tahun . ')' : '' ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>
                    <?= $form->errorSummary($model); ?>
                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">1. Laporan / Ulasan Oleh PYD</label>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                            <?php if (is_null($model->skt_ulasan_tt_pyd) and $lpp->PYD == \Yii::$app->user->identity->ICNO and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat . ' 23:59:59') or ($lpp->PYD == \Yii::$app->user->identity->ICNO and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) { ?>
                                <?=
                                $form->field($model, 'skt_ulasan_pyd')->textArea(['class' => 'form-control', 'rows' => 5, 'placeholder' => '------------------------- Tiada sebarang Laporan / Ulasan Oleh PYD -------------------------'])->label(false);
                                ?>
                            <?php } else {
                                echo '<p>' . $model->skt_ulasan_pyd . '</p>';
                            } ?>
                        </div>
                    </div>

                    <?php if (is_null($model->skt_ulasan_tt_pyd) and $lpp->PYD == \Yii::$app->user->identity->ICNO and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat . ' 23:59:59') or ($lpp->PYD == \Yii::$app->user->identity->ICNO and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) { ?>

                        <div class="form-group  pull-right">
                            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                            </div>
                        </div>

                    <?php } ?>

                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12">2. Laporan / Ulasan Oleh PPP</label>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                            <?php if (is_null($model->skt_ulasan_tt_ppp) and $lpp->PPP == \Yii::$app->user->identity->ICNO) { ?>
                                <?=
                                $form->field($model, 'skt_ulasan_ppp')->textArea(['class' => 'form-control', 'rows' => 5, 'placeholder' => '------------------------- Tiada sebarang Laporan / Ulasan Oleh PPP -------------------------'])->label(false);
                                ?>
                            <?php } else {
                                echo '<p>' . $model->skt_ulasan_ppp . '</p>';
                            } ?>
                        </div>
                    </div>

                    <?php if (is_null($model->skt_ulasan_tt_ppp) and $lpp->PPP == \Yii::$app->user->identity->ICNO) { ?>

                        <div class="form-group  pull-right">
                            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
                                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                            </div>
                        </div>

                    <?php } ?>

                    <?php ActiveForm::end(); ?>
                </div>
                <hr>
                <div class="row">

                    <div class="row">
                        <?php if (is_null($model->skt_ulasan_tt_pyd) and $lpp->PYD == Yii::$app->user->identity->ICNO and (date('Y-m-d H:i:s') <= $tahun->pengisian_PYD_tamat . ' 23:59:59') or ($lpp->PYD == \Yii::$app->user->identity->ICNO and (is_null($req) ? null : $req->ICNO == Yii::$app->user->identity->ICNO))) { ?>
                            <div class="col-md-3 col-xs-6" style="text-align:center">
                                <?= Html::a(
                                    'Klik untuk tandatangan PYD',
                                    ['lppums/skt-bahagian3', 'lpp_id' => $_GET['lpp_id']],
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
                        <div class="col-md-6 col-xs-0">
                        </div>
                        <?php if (is_null($model->skt_ulasan_tt_ppp) and $lpp->PPP == Yii::$app->user->identity->ICNO) { ?>
                            <div class="col-md-3 col-xs-6" style="text-align:center">
                                <?= Html::a(
                                    'Klik untuk tandatangan PPP',
                                    ['lppums/skt-bahagian3', 'lpp_id' => $_GET['lpp_id']],
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
                            <?= Html::input('text', 'password1', (is_null($model->skt_ulasan_tt_pyd) ? '' : $model->pyd->CONm), ['class' => 'form-control', 'disabled' => true, 'style' => 'text-align: center']) ?>
                        </div>
                        <div class="col-md-6 col-xs-0">
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <?= Html::input('text', 'password1', (is_null($model->skt_ulasan_tt_ppp) ? '' : $model->pppDetails), ['class' => 'form-control', 'disabled' => true, 'style' => 'text-align: center']) ?>
                        </div>
                    </div><br>

                    <div class="row" style="margin-bottom: 5px;">
                        <div class="col-md-3 col-xs-6" style="text-align: center">
                            Tandatangan PYD
                        </div>
                        <div class="col-md-6 col-xs-0">
                        </div>
                        <div class="col-md-3 col-xs-6" style="text-align: center">
                            Tandatangan PPP
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-xs-6">
                            Tarikh: <?= is_null($model->skt_ulasan_tt_pyd) ? '' : $model->su_tt_pyd_datetime; ?>
                        </div>
                        <div class="col-md-6 col-xs-0">
                        </div>
                        <div class="col-md-3 col-xs-6">
                            Tarikh: <?= is_null($model->skt_ulasan_tt_ppp) ? '' : $model->su_tt_ppp_datetime; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>