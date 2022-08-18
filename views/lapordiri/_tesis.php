<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\kemudahan\Reftujuan;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\hronline\HubunganKeluarga;
use kartik\date\DatePicker;
use yii\helpers\Url;

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
    
    var datePickers = $(this).find("[data-krajee-kvdatepicker]");
        datePickers.each(function(index, el) {
//            $(this).parent().removeData().kvDatepicker("initDPRemove");
            $(this).parent().kvDatepicker(eval($(this).attr("data-krajee-kvdatepicker")));
        });
});
jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});
';

$this->registerJs($js);
error_reporting(0);
?>
<style>
    fieldset.scheduler-border {
        border: 1px groove #062f49 !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow: 0px 0px 0px 0px #000;
        box-shadow: 0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        width: inherit;
        /* Or auto */
        padding: 0 10px;
        /* To give a bit of padding on the left and right */
        border-bottom: none;
    }
</style>
<?php echo $this->render('/cutibelajar/_topmenu'); ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
<?php // $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<p align="right"><?= Html::a('Kembali', ['cutibelajar/senarai-borang'], ['class' => 'btn btn-primary btn-sm'])
?></p>
<!--<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">

<div class="x_panel">

        <div class="x_title">
            <h5><strong><i class='fa fa-clipboard'></i> SEKSYEN PENGEMBANGAN PROFESIONALISME | SEKTOR PENGURUSAN BAKAT</strong></h5>
            <div class="clearfix"></div>     
        </div>

</div></div>
</div>
-->
<!--    <div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">

<div class="x_panel">

        <div class="x_title">
            <h5 align="center"><strong> TUNTUTAN ELAUN TESIS</strong></h5>
            <div class="clearfix"></div>     
        </div>

</div></div>
</div>-->

<div class="x_panel">
    <style>
        .w3-table td,.w3-table th,.w3-table-all td,.w3-table-all th
        {padding:2px 2px;display:table-cell;text-align:left;vertical-align:top}
    </style>

    <div class="alert alert-info alert-dismissible fade in">
        <table class="w3-table w3-bordered" style="font-size: 14px; color:black">
            <h5 style="color:white">
                <i class="fa fa-question-circle" style="color:white"></i> 
                PANDUAN PERMOHONAN:<br><br>
                <div align="justify"><strong> 
                        <small style="color:white">- PERMOHONAN UNTUK MENDAPATKAN TUNTUTAN ELAUN TESIS.</small></strong><br> </div>
                <div align="justify" style="color:white"><strong>
                        <small style="color:white">- SILA LAMPIRKAN DOKUMEN YANG SEWAJARNYA. HANYA PERMOHONAN YANG LENGKAP SAHAJA AKAN DIPROSES.</small></strong><br> </div>



            </h5></table>




        </table>
    </div>
</div>
<!--<div class="x_panel">
        <div class="x_title">
            <h4><strong> PANDUAN PERMOHONAN</strong></h4>
            <div class="clearfix"></div>     
        </div>
        <div class="x_content"> 
            <div align="justify"><strong>o 
           PERMOHONAN UNTUK MENDAPATKAN TUNTUTAN ELAUN TESIS.</strong><br> </div>
            <div align="justify"><strong>o 
           SILA LAMPIRKAN DOKUMEN YANG SEWAJARNYA. HANYA PERMOHONAN YANG LENGKAP SAHAJA AKAN DIPROSES.</strong><br> </div>
            
           
        </div>
</div>-->
<div class="x_panel">  
    <div class="product_price"> 
        <h5 align="center" style="font-size:16px;font-weight: bold;"> 
            PERMOHONAN TUNTUTAN ELAUN TESIS</5> 
            <div class="clearfix"></div> 
    </div> 
</div>

<div class="x_panel">
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">  
            <h5><i class='fa fa-user-circle'></i>
                MAKLUMAT PERIBADI</h5></legend> 
        <div class="x_content">
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NAMA:</th>
                        <td><?= strtoupper($model->kakitangan->displayGelaran) . ' ' . ucwords(strtoupper($model->kakitangan->CONm)); ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NO. KAD PENGENALAN:</th>
                        <td><?= $model->kakitangan->ICNO; ?></td> 
                    </tr>



                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">NO. TELEFON:</th>
                        <td><?= $model->kakitangan->COHPhoneNo; ?></td> 
                    </tr>

                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">EMEL:</th>
                        <td><?= $model->kakitangan->COEmail; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">ALAMAT:</th>
                        <td><?= $model->kakitangan->alamatTetap ? $model->kakitangan->alamat->alamatPenuh : '-'; ?></td> 
                    </tr>
                    <tr>
                        <th style="width:10%" align="right">PROGRAM:</th>
                        <td><?= ucwords(strtoupper($model->lapor->claim->tajaan->nama_tajaan)); ?></td> 
                    </tr>
                    <tr>
                        <th style="width:10%" align="right">PERINGKAT PENGAJIAN:</th>
                        <td> <?php
                            if ($model->claim->tahapPendidikan) {
                                echo strtoupper($model->claim->tahapPendidikan);
                            }
                            ?></td> 
                    </tr>

                    <tr> 

                        <th align="right">TEMPAT PENGAJIAN:</th>
                        <td style="width:60%">
                            <?php echo strtoupper($model->claim->InstNm); ?></td></tr>
                    <tr> 

                        <th align="right">TEMPOH PENAJAAN KPT:</th>
                        <td style="width:40%">
                            <?= strtoupper($model->claim->tarikhmula) ?> <b>HINGGA</b> 
                            <?= strtoupper($model->claim->tarikhtamat) ?> (<?= strtoupper($model->claim->tempohtajaan); ?>)</td></tr>
                    <tr> 

                        <th align="right">TAJUK TESIS:</th>
                        <td style="width:60%">
                            <?php 
                            if($model->studysemasa->tajuk_tesis)
                            {
                                echo strtoupper($model->studysemasa->tajuk_tesis);
                            }
                            else
                            {
                                echo '<i>Tidak Berkaitan</i>';
                            }
?></td></tr>
                    <tr> 

                        <th align="right">MOD PENGAJIAN</th>
                        <td>

                            <?php
                            if ($model->claim->modeID) {
                                echo strtoupper($model->claim->mod->studyMode);
                            } else {
                                echo "<i>Tiada Maklumat</i>";
                            }
                            ?></td></tr>
                </table>
            </div> 

        </div>
</div>


<?php if ($model->lapor->claim->tajaan->jenisCd == 3) { ?>
    <div class="x_panel">
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                <h5><i class='fa fa-th-list'></i>
                    MAKLUMAT PERMOHONAN</h5></legend> 

            <i>Dokumen: Lengkapkan permohonan anda dan pastikan muatnaik lampiran yang sewajarnya</i>
            <br>

            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped"> 
                        <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>ELAUN TESIS - KPT</center></th>





                        <tr class="headings">
                            <th class="col-md-3 col-sm-3 col-xs-12">1. Surat Senat/ Skrol/ Transkrip penuh untuk pengesahan Jam Kredit > 6 jam bagi Sarjana:<br>

                            </th>
                            <td class="text-justify"><?= $form->field($model, 'file')->fileInput()->label(false); ?> </td>



                        </tr>

                        <tr class="headings">
                            <th class="col-md-6 col-sm-6 col-xs-12">2. Penyata Bank (yang tertera nama, nama bank, nombor akaun)
                                :<br>

                            </th>
                            <td class="text-justify"><?= $form->field($model, 'file2')->fileInput()->label(false); ?> </td>



                        </tr>


                        <th class="col-md-6 col-sm-6 col-xs-12">
                            3. Salinan muka hadapan tesis yang disahkan oleh penyelia 
                        </th>
                        <td class="text-justify"><?= $form->field($model, 'file3')->fileInput()->label(false); ?> </td>

                        <tr>     

                            <th class="col-md-6 col-sm-6 col-xs-12">
                                4. Satu salinan soft copy PDF dalam bentuk CD / pen drive                                 
                        <p style="color:red;"> ** Tuntutan hendaklah dibuat dalam tempoh 3 tahun dari tarikh mula penajaan bagi peringkat Sarjana dan 6
                            tahun dari tarikh mula penajaan bagi peringkat PhD atau Sarjana Perubatan.</p>

                        <td  class="text-left" rowspan="2" style="color: green;"> <small><b>
                                    HARDCOVER TESIS PERLU DIHANTAR KE BSM (PN. DAYANG NOORANIZAH) UNTUK TUJUAN DIHANTAR
                                    KE LIBRARY UMS BERSAMA BORANG TUNTUTAN ELAUN TESIS
                                    (KPT) YANG DITANDATANGANI</b></small><br><br>
                            <div class="table-responsive">

                                <table class="table table-sm jambo_table table-striped">

                                    <tr>
                                        <th style="color: red;font-size: 10px;">BORANG TUNTUTAN TESIS KPT </th>
                                        <td style="color: green;font-size: 10px;"><a href="<?php echo Url::to('@web/' . 'uploads-cutibelajar/cbelajar/dokumen/Borang Tuntutan Elaun Tesis 2022.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br> 
                                        </td>

                                    </tr>
                                </table>
                            </div></td>

                    </table>
                    <p>** Sila pastikan dokumen di atas dikemukakan bersama borang tuntutan dan surat tuntutan rasmi daripada UA selaku
                        majikan.</p>
                </div>  </div>  </div><?php } else {
    ?>
    <div class="x_panel">
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">  
                <h5><i class='fa fa-th-list'></i>
                    MAKLUMAT PERMOHONAN</h5></legend> 

            <i>Dokumen: Lengkapkan permohonan anda dan pastikan muatnaik lampiran yang sewajarnya</i>
            <br>

            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table table-striped"> 
                        <th scope="col" colspan=12"  style="background-color:lightseagreen;color:white"><center>ELAUN TESIS - KPT</center></th>





                        <tr class="headings">
                            <th class="col-md-3 col-sm-3 col-xs-12">1. Surat Senat/ Skrol/ Transkrip penuh untuk pengesahan Jam Kredit > 6 jam bagi Sarjana:<br>

                            </th>
                            <td class="text-justify"><?= $form->field($model, 'file')->fileInput()->label(false); ?> </td>



                        </tr>




                        <th class="col-md-6 col-sm-6 col-xs-12">
                            2. Salinan muka hadapan tesis yang disahkan oleh penyelia 
                        </th>
                        <td  class="text-left" rowspan="2" style="color: green;"> <small><b>
                                    DIHANTAR KE BSM (PN. DAYANG NOORANIZAH)</b></small><br><bR>
                            <div class="table-responsive">


                            </div></td>

                        <p style="color:red;"> ** Tuntutan hendaklah dibuat dalam tempoh 3 tahun dari tarikh mula penajaan bagi peringkat Sarjana dan 6
                            tahun dari tarikh mula penajaan bagi peringkat PhD atau Sarjana Perubatan.</p>



                    </table>
                    <p>** Sila pastikan dokumen di atas dikemukakan </p>
                </div>  </div>  </div>
<?php }
?>
<div class="x_panel">
    <fieldset class="scheduler-border">
        <legend class="scheduler-border">  
            <h5><i class='fa fa-check-square'></i>
                PERAKUAN KAKITANGAN</h5></legend> 
        <div class="form-group">
            <div class="col-sm-12 text-center">

                <table>
                    <tr>
                        <td class="col-sm-3 text-right">
                            <?php // $model->agree = 1;  ?>
                            <br><input type="checkbox"  id="checkbox1" class="default-input sale-text-req" onclick="checkTerms();"/>

<!--                <br>//<?= $form->field($model, 'agree')->checkbox()->label(false); ?> <p>&nbsp;&nbsp;</p>-->
                        </td>

                        <td> 
                            <div class="product_price"   style="width: 650px; height: 80px;"> 

                                <p style="color:black;font-family:'Arial';font-size: 12px;text-align: center;" >Saya <?= $model->kakitangan->CONm ?>
                                    No. Kad Pengenalan: <u><?= $model->kakitangan->ICNO; ?></u>
                                mengaku segala maklumat dan dokumen yang disertakan adalah benar. 
                                </p>

                                <p style="color:black;text-align:center">Tarikh Mohon: <?php echo $model->tarikh_m; ?></p><br/>

                            </div>
                        </td>
                    </tr>
                </table>
                <br/>
                <div>

                    <div class="col-md-12 col-sm-12 col-xs-12" align="center"> 
                        <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['id' => 'submitb', 'disabled' => true, 'class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_1']) ?>

                        <?= Html::a('Keluar', ['cutibelajar/halaman-pemohon'], ['class' => 'btn btn-danger ']); ?>

                    </div>
                </div>
            </div>
        </div>
</div>





<?php ActiveForm::end(); ?>



<script>
    function checkTerms() {
        // Get the checkbox
        var checkBox = document.getElementById("checkbox1");

        // If the checkbox is checked, display the output text
        if (checkBox.checked === true) {
            document.getElementById("submitb").disabled = false;
        } else {
            document.getElementById("submitb").disabled = true;
        }
    }
</script>