<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\lppums\TblLppTahun;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            
            <div class="x_content">
                <div class="row">
                    <p>
                        <strong>Pastikan maklumat anda adalah tepat sebelum memohon borang Laporan Penilaian Prestasi</strong>
                        <br>
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td><strong>Nama PYD</strong></td>
                                <td><?= $bio->CONm; ?></td>
                            </tr>
                            <tr>
                                <td><strong>No. KP PYD</strong></td>
                                <td><?= $bio->ICNO; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Jawatan / Gred</strong></td>
                                <td><?= $bio->jawatan->nama; ?> / <?= $bio->jawatan->gred; ?></td>
                            </tr>
                            <tr>
                                <td><strong>JAFPIB</strong></td>
                                <td><?= $bio->department->fullname; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Jenis LPP</strong></td>
                                <td><?= $bio->jawatan->lppJenis->lpp_jenis; ?></td>
                            </tr>
                        </table>
                    </p>

                    <div class="ln_solid"></div>

                    <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
                    <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['data-pjax' => true]]); ?>


                    <div class="col-mo-12" align="center">
                    <div class="form-group form-inline">    
                    Berdasarkan ketetapan di atas, saya ingin mengisi borang Laporan Penilaian Prestasi bagi tahun penilaian 

                    <?= 
                        $form->field($model, 'gred_jawatan_id')->dropDownList(
                            //['a' => 'Item A', 'b' => 'Item B', 'c' => 'Item C'],
                            ArrayHelper::map(TblLppTahun::find()->orderBy(['lpp_tahun' => SORT_DESC])->all(),'lpp_tahun', 'lpp_tahun'),
                            [
                                'style' => 'width:100px !important',
                            ]
                    )->label(false); 
                    ?>

                    <br>

                    <?= $form->field($model, 'flag_pyd')->checkbox(['label' => 'Saya mengesahkan bahawa semua maklumat di atas adalah benar.']); ?>

                    <br>

                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>

                    </div>
                    </div>

                    <div class="ln_solid"></div>

                    <?php ActiveForm::end(); ?>
                    <?php yii\widgets\Pjax::end() ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>           