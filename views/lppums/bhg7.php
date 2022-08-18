<?php
/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$akses = app\models\lppums\TblStafAkses::find()
    ->where(['ICNO' => Yii::$app->user->identity->ICNO])
    ->andWhere(['IN', 'akses_id', [1]])
    ->exists();

?>

<?= $this->render('_menuBorang', ['lppid' => $lpp->lpp_id]); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Bahagian VII - Jumlah Markah Keseluruhan</strong> <?= (($lpp->PYD != Yii::$app->user->identity->ICNO)) ? '(' . $lpp->pyd->CONm . ' - ' . $lpp->tahun . ')' : '' ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <p>
                        Pegawai Penilai dikehendaki menyemak markah keseluruhan yang diperolehi oleh PYD dalam bentuk peratus (%) berdasarkan jumlah markah bagi setiap bahagian yang diberi markah.<br><br>
                        <i>Pengiraan markah Pegawai Penilai telah dikira bersama dengan ASPEK PENILAIAN AKTIVITI RASMI & LATIHAN.</i>
                    </p>

                    <?php $form = ActiveForm::begin(); ?>

                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">

                            <tr>
                                <th class="text-center col-md-2" rowspan="2">Markah Keseluruhan</th>
                                <th class="text-center col-md-2">PPP (%)</th>
                                <th class="text-center col-md-2">PPK (%)</th>
                                <th class="text-center col-md-2">Markah Purata (%)</th>
                            </tr>
                            <tr>

                                <td class="text-center"><?= ((($lpp->PPP == \Yii::$app->user->identity->ICNO or $lpp->PPK == \Yii::$app->user->identity->ICNO) && $model->markah_PPP >= 10) or $akses) ? $form->field($model, "markah_PPP")->textInput([
                                                            'class' => 'form-control', 'placeholder' => '0.00', 'style' => 'text-align:center', 'maxlength' => 2
                                                            //, 'onfocus' => "this.value=''"
                                                            , 'disabled' => true
                                                        ])->label(false) : 'PPP' ?></td>
                                <td class="text-center"><?= (($lpp->PPK == \Yii::$app->user->identity->ICNO && $model->markah_PPK >= 10) or $akses) ? $form->field($model, "markah_PPK")->textInput([
                                                            'class' => 'form-control', 'placeholder' => '0.0', 'style' => 'text-align:center', 'maxlength' => 2
                                                            //, 'onfocus' => "this.value=''"
                                                            , 'disabled' => true
                                                        ])->label(false) : 'PPK' ?></td>
                                <td class="text-center">
                                    <?php if (empty($lpp->markahSeluruh)) {
                                        echo 'N/A';
                                    } else {
                                        if ($lpp->PPP_sah == 1 and !is_null($lpp->PP_ALL)) {
                                            echo $lpp->markahSeluruh->markah_PP;
                                        } else if (
                                            ((($lpp->PPP_sah == 1 and $lpp->PPK_sah == 1) and $lpp->PYD == \Yii::$app->user->identity->ICNO)
                                                or $lpp->PPK == \Yii::$app->user->identity->ICNO or $lpp->PPP == \Yii::$app->user->identity->ICNO && $model->markah_PPP >= 10)
                                            or $akses
                                        ) {
                                            echo $lpp->markahSeluruh->markah_PP;
                                        } else {
                                            echo 'Menunggu Penilaian Selesai';
                                        }
                                    } ?>
                                </td>
                            </tr>

                        </table>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <p>
                        Sila <i>refresh</i> page dua kali untuk melihat jumlah markah purata.
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->render('_skalaPenilaianPrestasi'); ?>