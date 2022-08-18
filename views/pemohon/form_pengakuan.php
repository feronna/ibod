<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $iklan app\iklans\ejobs\Iklan */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="x_panel">
    <div class="x_title">
        <h2>Maklumat Peribadi</h2> 
        <div class="clearfix"></div>
    </div>

    <div class="x_content">   
        <div class="table-responsive">
            <table class="table table-sm jambo_table table-striped"> 
                <tr>
                    <th class="col-md-2 col-sm-3 col-xs-12 text-right">Nama: </th><td><?= $biodata->gelaran->Title . " " . ucwords(strtolower($biodata->CONm)) ?></td> 
                </tr>
                <tr>
                    <th class="col-md-2 col-sm-3 col-xs-12 text-right">Alamat: </th><td><?php
                        if ($biodata->alamatTetap) {
                            echo $biodata->alamat->alamatPenuh;
                        } else if ($biodata->alamatSuratmenyurat) {
                            echo $biodata->alamat->alamatPenuh;
                        } else {
                            echo 'Tiada Maklumat';
                        }
                        ?></td> 
                </tr>
                <tr>
                    <th class="col-md-2 col-sm-3 col-xs-12 text-right">No. Telefon: </th><td><?= $biodata->COHPhoneNo; ?></td> 
                </tr>
                <tr>
                    <th class="col-md-2 col-sm-3 col-xs-12 text-right">Emel: </th><td><?= $biodata->COEmail; ?></td> 
                </tr> 
            </table>
        </div>
    </div>
</div>
<?php if ($bmSpm) { ?>
    <div class="x_panel">
        <div class="x_title">
            <h2>Syarat Kelayakan</h2> 
            <div class="clearfix"></div>
        </div>

        <div class="x_content text-center">    
            <?php
            // "<u><a href=" . Url::to(['pemohon/iklan', 'id' => $iklan->id]) . "> " . $iklan->jawatan->fname . "</u></a> "; 
            ?>    

            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="text-center">Bil</th>
                        <th class="text-center">Jawatan</th>
                        <th class="text-center">Pendidikan Tertinggi</th>
                        <?php if ($biodata->NatCd == 'MYS') { ?>
                            <th class="text-center">B.Melayu SPM (CREDIT)</th>
                            <th class="text-center">B.Melayu PMR (CREDIT)</th>
                        <?php } ?>
                        <th class="text-center">Status Kelayakan</th>    
                    </tr> 
                    <?php
                    if ($iklan) {

                        $arr = app\models\ejobs\TblpPermohonan::find()->where(['ICNO' => Yii::$app->user->getId()])->all();
                        $Existpermohonan = array();
                        foreach ($arr as $arr) {
                            $Existpermohonan[] = $arr->iklan_id;
                        }
                        $counter = 0;
                        foreach ($iklan as $iklan) {
                            if (!in_array($iklan->id, $Existpermohonan)) {
                            $counter = $counter + 1;

                            $pass = 'fa fa-check';
                            $failed = 'fa fa-times';
                            $optional = 'fa fa-ban';

                            //check pendidikan tertinggi 
                            if ($biodata->pendidikan->HighestEduLevelRank <= $iklan->pendidikanTertinggi->HighestEduLevelRank) {
                                $statusPendidikan = $pass;
                                $check1 = 1;
                            } else {
                                $statusPendidikan = $failed;
                                $check1 = 0;
                            }

                            if ($biodata->NatCd == 'MYS') {

                                $statusPmr = $optional;
                                $check2 = 1;
                                //check pmr
                                if (($iklan->min_bm_pmr == 1)) {
                                    if (($bmPmr != null)) {
                                        if ($bmPmr->Grade_id <= 14) {
                                            $statusPmr = $pass;
                                            $check2 = 1;
                                        } else {
                                            $statusPmr = $failed;
                                            $check2 = 0;
                                        }
                                    } else {
                                        $statusPmr = $failed;
                                        $check2 = 0;
                                    }
                                } else {
                                    $statusPmr = $optional;
                                    $check2 = 1;
                                }

                                //check spm
                                if (($iklan->min_bm_spm == 1)) {
                                    if (($bmSpm != null)) {
                                        if ($bmSpm->Grade_id <= 14) {
                                            $statusSpm = $pass;
                                            $check3 = 1;
                                        } else {
                                            $statusSpm = $failed;
                                            $check3 = 0;
                                        }
                                    } else {
                                        $statusSpm = $failed;
                                        $check3 = 0;
                                    }
                                } else {
                                    $statusSpm = $optional;
                                    $check3 = 1;
                                }
                            }

                            if ($biodata->NatCd == 'MYS') {
                                if ($check1 == 1 && $check2 == 1 && $check3 == 1) {
                                    $status = 'Memenuhi Syarat';
                                } else {
                                    $status = 'Tidak Memenuhi Syarat';
                                }
                            } else {
                                if ($check1 == 1) {
                                    $status = 'Memenuhi Syarat';
                                } else {
                                    $status = 'Tidak Memenuhi Syarat';
                                }
                            }
                            ?>

                            <tr>
                                <td><?= $counter; ?></td>
                                <td><?= $iklan->jawatan->fname; ?></td>
                                <td><?= $biodata->pendidikan->HighestEduLevel; ?> <i class="<?= $statusPendidikan; ?>" aria-hidden="true"></i></td>  
                                <?php if ($biodata->NatCd == 'MYS') { ?>
                                    <td><?= $bmSpm ? $bmSpm->gred : 'Tiada Maklumat'; ?> <i class="<?= $statusSpm; ?>" aria-hidden="true"></i></td> 
                                    <td><?= $bmPmr ? $bmPmr->gred : 'Tiada Maklumat'; ?> <i class="<?= $statusPmr; ?>" aria-hidden="true"></i></td>  
                                <?php } ?>
                                <td><?= $status; ?></td>  
                            </tr>

                            <?php
                        }
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="7" class="text-center">Tiada Rekod</td>                     
                        </tr>
                    <?php }
                    ?>
                </table>
            </div>
        </div>
    </div>
<?php } ?>

<div class="x_panel">
    <div class="x_content">  
        <span class="required" style="color:red;">  
            <strong>
                <?=
                strtoupper('Sila pastikan anda memilih jawatan yang memenuhi syarat kelayakan sahaja.');
                ?>
            </strong>
        </span> 
    </div>
</div>


<div class="x_panel">
    <div class="x_title">
        <h2>Perakuan Pemohon</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
        <?= $form->field($model, 'pengakuanTxt')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?> 
        <div class="form-group"> 

            <br/>
            <div class="col-sm-12 text-center">
                <table><tr><td class="col-sm-3 text-right">
                            <?php $model->agree = 0; ?>
                            <?= $form->field($model, 'agree')->checkbox()->label(false); ?>
                        </td>
                        <td> 
                            Saya akui bahawa semua maklumat yang diberikan adalah benar. 
                            Sekiranya maklumat itu didapati palsu, <br/>
                            saya boleh didakwa dan permohonan saya akan dibatalkan. 
                        </td></tr>
                </table>
            </div>
        </div>
        <br/>

        <div class="form-group"> 
            <div class="col-sm-12 text-center">
                <?php echo Html::a('Batal', ['pemohon/halaman-utama'], ['class' => 'btn btn-danger']); ?>
                <?= Html::submitButton('Mohon', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?= $form->field($model, 'ICNO')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 
        <?= $form->field($model, 'tarikh_mohon')->hiddenInput(['value' => date('Y-m-d')])->label(false); ?> 
        <?= $form->field($model, 'tarikh_tutup')->hiddenInput(['value' => date('Y-m-d', strtotime('+3 month'))])->label(false); ?>  

        <?php ActiveForm::end(); ?>

    </div>
</div> 