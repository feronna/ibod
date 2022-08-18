<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use kartik\popover\PopoverX;
?>

<style>

    .html-marquee {
        height: auto;
        /*background-color:#ffff33;*/
        /*font-family:Cursive;*/
        font-size:14px;
        color:red;
        /*border-width:4;*/
        /*border-style:dotted;*/
        /*border-color:#ff0000;*/
    }
</style>

<?php
$penerbitan = app\models\pengesahan\RequirementUmum1::penerbitan();
$persidangan = app\models\pengesahan\RequirementUmum1::persidangan();
$umum = app\models\pengesahan\RequirementUmum1::umum();
?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<?php echo $this->render('/pengesahan/_topmenu'); ?> 
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
        <div class="x_title">
            <h2><strong>Perhatian</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
        <div class="clearfix"></div>
        </div>
        <div class="x_content">     
        <li> Sila pastikan anda telah mengisi bahagian pendidikan SPM/Setaraf dalam profile anda.</li>
        <li> Anda adalah <strong>WAJIB</strong> untuk muat naik salinan Sijil Pelajaran Malaysia dan kemaskini gred subjek SPM Bahasa Melayu anda sebelum membuat permohonan.</li>
        <li>Kecuali bagi Gred 11 Memiliki Kepujian (sekurang-kurangnya Gred C) dalam subjek Bahasa Melayu pada peringkat Pentaksiran Tingkatan Tiga/Penilaian Menengah Rendah atau kelulusan yang diiktiraf setaraf dengannya oleh Kerajaan.</li>
        <li> Klik sini <?php echo Html::a('<i class="fa fa-edit"></i> ',['pendidikan/view'], ['class' => 'btn btn-success btn-sm','target'=>'_blank']); ?>untuk semak dan kemaskini.</li>
        <li> Jika anda memilih <strong>Skim Pencen</strong>, sila muat naik Borang Opsyen dan Borang Pemberian Taraf Berpencen yang anda telah anda isi dan lengkapkan.</li>
        <li> Jika anda memilih <strong>Skim Kumpulan Wang Simpanan Pekerja (KWSP)</strong>, sila muat naik Borang Opsyen yang anda telah anda isi dan lengkapkan.</li>
        <li> Abaikan ruangan tandatangan Ketua Jabatan pada Borang Opsyen dan Borang Pemberian Taraf Berpencen. </li>
        <li> <strong> Pastikan dokumen yang dimuat naik maklumat jelas dirujuk dan sesuai dicetak bagi memudahkan pihak Bahagian Sumber Manusia memproses urusan permohonan Pemberian taraf Berpencen ke Jabatan Perkhidmatan Awam. </strong></li>
        </div>
    </div>
</div> 
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
         <div class="x_title">
            <h2><strong>Syarat Pengesahan Dalam Perkhidmatan (Kakitangan Bukan Akademik)</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">                 
        <li> Memenuhi tempoh percubaan sekurang-kurangnya satu (1) sehingga tiga (3) tahun.</li>
 
        <li> Lulus peperiksaan Am Kerajaan atau lulus Program Transformasi Minda/Kursus Induksi yang ditetapkan.</li>
    
        <li> Diperakukan oleh Ketua Jabatan.</li>
    
        <li> Mempunyai kelulusan Bahasa Malaysia dengan Kepujian termasuk lulus Ujian Lisan di peringkat Sijil Pelajaran Malaysia atau yang setaraf dengannya.</li>

        <li> Lulus Peperiksaan Jabatan (jika ada).</li>

        <li> Markah Prestasi sekurang-kurangnya 80% dan ke atas sepanjang tempoh percubaan.</li>
            
            <br>
<span class="required" style="color:red;">*</span> Syarat ini berkuatkuasa kepada kakitangan lantikan TETAP sahaja.<br >  
            </div>
        </div> 
    </div>
</div>

<div class="x_panel"> 
    <div class="clearfix"></div> 
    <div class="x_content">    

        <div class="x_panel">  
            <div class="x_title">
                <h2>KRITERIA UMUM</h2>  
                <div class="clearfix"></div>
            </div> 

            <div class="table-responsive">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <center> 
                        <table class="table table-sm table-bordered jambo_table table-striped" style="width:80%"> 
                            <tr>   
                                <th>TEMPOH PERKHIDMATAN</th>  
                                <td colspan="2"><?= $model->kakitangan->servPeriodPermanent; ?></td> 
                            </tr>
                            <tr>   
                                <th>STATUS PTM</th>  
                                <td colspan="2">
                                    <?php 
                                    $status_ptm = '';
                                        if ($model->kakitangan->ptm){
                                            echo $model->kakitangan->ptm->status;
                                        } else {
                                        echo '-';
                                    }
                                    ?></td> 
                            </tr>
                            <tr>   
                                <th style="width:40%">STATUS BM</th>  
                                <td colspan="2">                                   
<!--                                    <php 
                                    $status_bm = '';
                                        if ($subjek->gred){
                                            echo $subjek->gred;
                                             $status_bm = "YA";
                                        } else {
                                        echo '-';
                                    }
                                    ?>-->
                                    
                                    <?php if ($model->kakitangan->jawatan->gred_no != "11"){
                                    $status_spm = '';
                                        if ($subjekspm->gred){
                                            echo $subjekspm->gred;
                                             $status_spm = "YA";
                                        } else  if ($subjekspm2->gred){
                                            echo $subjekspm2->gred;
                                             $status_spm = "YA";
                                        } else {
                                            echo '-';
                                    }
                                    }
                                    
                                    else if ($model->kakitangan->jawatan->gred_no == "11"){
                                        $status_pmr = '';
                                        if ($subjekpmr->gred){
                                            echo $subjekpmr->gred;
                                             $status_pmr = "YA";
                                        } else {
                                            echo '-';
                                    }  
                                    }
                                    ?>
                                </td> 
                            </tr> 
                            <tr>   
                                <th rowspan="50">LNPT <br/>
                                </th> 
<!--                               <php
                            if ($markah) {
                                foreach ($markah as $markah) {
                                    $record = \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markah->lpp_id])->one();

                                    if ($record) {
                                        if ($record->markah_PP != '0' || $record->markah_PP != '') {
                                            ?>
                                            <tr>
                                                <td><= '<b>' . $markah->tahun . ' :</b> ' . $record->markah_PP; ?></td></tr>

                                            <php
                                        }
                                    }
                                }
                            }
                            ?> -->
                                            
                            <?php
                                $icno=Yii::$app->user->getId();   
                                for ($t=$tahunstarttetap; $t < date('Y') ; $t++){

                                $markah = \app\models\lppums\Lpp::find()->where(['PYD' => $icno, 'tahun' => $t])->one(); // yang telah disahkan sahaja

                                $record = \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markah->lpp_id])->one();                                    
                                if ($record) {
                                    $allrecord0 = $allrecord0 + $record->markah_PP;

                                        if ($record->markah_PP != '0' || $record->markah_PP != '') {
                                            ?>
                                            <tr>
                                                <td><?= '<b>' . $t . ' :</b> ' . $record->markah_PP; ?></td></tr>
                                            <?php
                                        }
                                    }
                                }
                            
                            ?> 
                            <tr>
                                <td colspan="2">   
                                    Purata Markah:
                                <?php
                                    $yearOld = $tahunstarttetap;
                                    $yearNow = date('Y');
                                    $year = $yearNow - $yearOld;
                                    $allrecord = number_format($allrecord0 / $year, 2, '.', '');
                                    echo $allrecord;
                                ?>
                                </td> 
                            </tr> 
                        </table>
                    </center>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <center>
                        <table class="table table-sm table-bordered jambo_table table-striped" style="width:80%"> 
                            <tr>   
                                <th colspan="5" class="text-center" style="background-color:#20c997; color:white;">KRITERIA</th>   
                            </tr>
                            <?php
                            $totalUmum = 0;
                            foreach ($umum as $p) {
                                ?>
                                <tr>      
                                    <th colspan="3"><?= $p->requirement; ?></th>  
                                    <th><?php
                                    if ($p->info) {
                                        echo PopoverX::widget([
                                            'header' => '<span style="color:black;">Maklumat</span>',
                                            'type' => PopoverX::TYPE_SUCCESS,
                                            'placement' => PopoverX::ALIGN_BOTTOM,
                                            'content' => $p->info,
                                            'toggleButton' => ['label' => '<i class="fa fa-info-circle" aria-hidden="true"></i></button>', 'class' => 'btn btn-success'],
                                        ]);
                                    }
                                    ?></th> 
                                    <?php
                                    if ($p->id == 1) {
                                        if ($model->kakitangan->servPeriodPermanent >= $p->ans_no) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
                                    else if ($p->id == 2) {
                                        if (($model->kakitangan->ptm->status == $p->ans_char) || ($model->kakitangan->ptm->status == $p->ans_char2)) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
//                                    else if ($p->id == 3) {
//                                        if (($status_bm == $p->ans_char) && ($model->sijilspm->filename != NULL)) {
//                                            $s = 1;
//                                            $totalUmum++;
//                                        } else {
//                                            $s = 0;
//                                        }
//                                    }
                                    
//                                    else if ($p->id == 3) {
//                                        if ($model->kakitangan->jawatan->gred_no != "11"){
//                                        if (($status_spm == $p->ans_char) && ($model->sijilspm->filename != NULL)) {
//                                            $s = 1;
//                                            $totalUmum++;
//                                        } else {
//                                            $s = 0;
//                                        }
//                                    }
//                                    
//                                    else if ($model->kakitangan->jawatan->gred_no == "11"){
//                                        if (($status_pmr == $p->ans_char2) && ($model->sijilpmr->filename != NULL)) {
//                                            $s = 1;
//                                            $totalUmum++;
//                                        } else {
//                                            $s = 0;
//                                        }
//                                    }
//                                    }
                                    
                                    else if ($p->id == 3) {
                                        if ($model->kakitangan->jawatan->gred_no != "11"){
                                        if (($subjekspm->Grade_id <= '14') && ($subjekspm->Grade_id != NULL) && ($model->sijilspm->filename != NULL)) {
                                            $s = 1;
                                            $totalUmum++;
                                        } 
                                        else if (($subjekspm2->Grade_id <= '14') && ($subjekspm2->Grade_id != NULL) && ($model->sijilspm->filename != NULL)) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
                                    
                                    else if ($model->kakitangan->jawatan->gred_no == "11"){
                                        if (($subjekpmr->Grade_id <= '14') && ($subjekpmr->Grade_id != NULL) && ($model->sijilpmr->filename != NULL)) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
                                    }
                                    
//                                       else if ($p->id == 4) {
//                                        if (($allrecord >= $p->ans_no)) {
//                                            $s = 1;
//                                            $totalUmum++;
//                                        } else {
//                                            $s = 0;
//                                        }
//                                    } 
                                    
                                    else if ($p->id == 4) {
                                        for ($t = $tahunstarttetap; $t < date('Y'); $t++) {
                                            
                                            $markah = \app\models\lppums\Lpp::find()->where(['PYD' => $icno, 'tahun' => $t])->one(); // yang telah disahkan sahaja

                                            $record = \app\models\lppums\TblMarkahKeseluruhan::find()->where(['lpp_id' => $markah->lpp_id])->one();
                                            if ($record) {
                                                if (($record->markah_PP >= $p->ans_no) || ($allrecord >= $p->ans_no)) {
                                                    $allKri++;
                                                } 
                                            }
                                        }
                                        
                                        if($allKri==$year){
                                            $totalUmum++;
                                            $s = 1;
                                        }else{
                                            $s = 0;
                                        }
                                    }

                                    if ($s == 1) {
                                        $color = "#20c997";
                                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                    } else if ($s == 0) {
                                        $color = "red";
                                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                    } 

                                    ?>
                                    <td colspan="2" style="background-color:<?= $color; ?>" class="text-center">  
                                        <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                      
                         
                        </table>
                    </center>
                </div>
            </div> 
        </div>   

    </div> 
</div>  

    <?php
        if ($totalUmum == 4) {
            $umum = 1; //pass all kriteria umum
        } else {
            $umum = 0;
        }
        ?>

    <?php
        if ($umum == 1) {
            $checking = 1;
        } else {
            $checking = 0;
        }
        ?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Permohonan Pengesahan Dalam Perkhidmatan</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
        <div class="clearfix"></div>
        </div>
    <div class="x_content">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Borang Opsyen :<span class="required"></span>
                </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="col-md-12 col-sm-12 col-xs-12" style="color: green;">
                    <a href="<?php echo Url::to('@web/'.'uploads/BORANG OPSYEN.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br> 
                Borang ini perlu dimuat turun dan diisi oleh pekerja warganegara Malaysia yang memilih Skim Pencen atau Skim Kumpulan Wang Simpanan Pekerja (KWSP).
            </div>
            </div>
        </div>
         <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Borang Pemberian Taraf Berpencen :<span class="required"></span>
                </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               <div class="col-md-12 col-sm-12 col-xs-12" style="color: green;">
                    <a href="<?php echo Url::to('@web/'.'uploads/BORANG BERPENCEN.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br> 
                Borang ini hanya perlu dimuat turun dan diisi oleh pekerja warganegara Malaysia yang memilih Skim Pencen.
               </div>
            </div>
        </div>
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Adakah anda memilih Skim Kumpulan Wang Simpanan Pekerja (KWSP) atau Skim Pencen?<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'skim')->label(false)->widget(Select2::classname(), [
                        'data' => ['Skim Kumpulan Wang Simpanan Pekerja (KWSP)' => 'Skim Kumpulan Wang Simpanan Pekerja (KWSP)', 'Skim Pencen' => 'Skim Pencen'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                        'onchange' => 'javascript:if ($(this).val() == "Skim Kumpulan Wang Simpanan Pekerja (KWSP)"){
                        $("#file2").show();
                        }
                        else{
                        $("#file2").show();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>     
                </div>  
        </div>
        <div class="form-group" id="file2">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muat Naik Dokumen: <span class="required" style="color:red;">*</span>
            </label>
            <span data-toggle="tooltip" ><i class="fa fa-info-circle fa-lg"></i></span>
             <div class="col-md-3">
                <?= $form->field($model, 'dokumen_sokongan2')->fileInput()->label(false) ?>
<!--                <div class="col-md-12 col-sm-12 col-xs-12" style="color: green; margin-top: -15px;">
                Sila muat naik Borang Opsyen dan Borang Pemberian Taraf Berpencen yang anda telah anda isi dan lengkapkan beserta salinan Kad Pengenalan jika anda memilih skim Berpencen atau muat naik Borang Opsyen yang anda telah anda isi dan lengkapkan beserta salinan Kad Pengenalan jika anda memilih Skim Kumpulan Wang Simpanan Pekerja (KWSP).
                </div>--> 
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lulus Program Transformasi Minda/Kursus Induksi:<span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php if(($model->kakitangan2->tarikhPtm!= NULL)||($model->tarikh_lulus_ptm!= NULL)){?>
                <?= $form->field($model->kakitangan2, 'tarikhptm')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                <?php }else{
                    echo  $form->field($model, 'tarikh_lulus_ptm')->widget(DatePicker::className(),
                ['clientOptions' => 
                    ['changeMonth' => true,
                    'yearRange' => '1996:2099',
                    'changeYear' => true, 
                    'format' => 'yyyy-mm-dd', 
                    'autoclose' => true],
                'options' => 
                    [ 'placeholder' => 'Pilih Tarikh ', 
                    'required' => TRUE,
                    'onchange' => 'cal()', 
                    'id' => 'tarikh_lulus_ptm']
                ]) ->label(false);
                } ?>
            </div>
        </div> 

        <div class="form-group" id="file">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muat Naik Dokumen: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'dokumen_sokongan')->fileInput()->label(false) ?>
                <div class="col-md-12 col-sm-12 col-xs-12" style="color: green; margin-top: -15px;">
                Sila muat naik salinan Sijil Lulus Program Transformasi Minda/Kursus Induksi anda.  
                </div>
            </div>
        </div>
        
        <div class="form-group" id="file5">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muat Naik Dokumen: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'dokumen_sokongan5')->fileInput()->label(false) ?>
                <div class="col-md-12 col-sm-12 col-xs-12" style="color: green; margin-top: -15px;">
                Sila muat naik salinan Kad Pengenalan anda.  
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ketua Jabatan :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="tblprcobiodata-enddatelantik" class="form-control" name="Tblprcobiodata[endDateLantik]" value="<?= $model->ketuajfpiu?>" disabled="disabled">
            </div>
        </div>
        
<!--        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ketua Jabatan :</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" class="form-control" 
                value="
                    <php if (\app\models\cuti\SetPegawai::find()->where(['pemohon_icno' => $icno])){
                        echo $model->kakitangan->rujukan->pelulus->CONm; 
                    }
                    else if ($pegawai2->pelulus_icno == NULL){

                        echo '-';
                    }
                    ?>" disabled="disabled">
            </div>
        </div>-->

        <p style="color: green">
                Sila pastikan maklumat permohonan adalah tepat sebelum klik hantar. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini.
        </p>
        
        <div class="ln_solid"></div>    
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?php if(($checking==1) || ($icno == '870703495628')){?>
<!--                <php if($checking==1){?>-->
                <button class="btn btn-primary" type="reset">Reset</button>
                <?= Html::submitButton('Hantar Permohonan',['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Please Wait..' , 'confirm'=>'Sila pastikan maklumat permohonan adalah tepat. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini. Teruskan?']]) ?>
                <?php }else{
                   echo Yii::$app->session->setFlash('alert', ['title' => 'Haraf Maaf', 'type' => 'error', 'msg' => 'Anda belum memenuhi kriteria yang diperlukan untuk pengesahan dalam perkhidmatan.']);
                } ?>
<!--                <= Html::submitButton('Hantar Permohonan',['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Please Wait..' , 'confirm'=>'Sila pastikan maklumat permohonan adalah tepat. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini. Teruskan?']]) ?>-->
            </div>
        </div>
            <?php ActiveForm::end();?>
    </div>
    </div>
</div>
</div>

<div id="alert" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Perhatian!</h4>
            </div>
            <div class="modal-body">
                <b>Permohonan masih <mark>ditutup</mark>. Permohonan boleh dilakukan mulai <?= $options['date']['date_open']." hingga ".$options['date']['date_close']  ?></b>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script type="text/javascript">

    $(document).ready(function(){

        function checker(){
            var is_open = <?= $options['open'] ?>

            if(is_open === false){
               $("button[type='submit']").prop("disabled",true);
                $("#alert").modal('show');
            }
        }

        $( "#application-reason").keypress(function() {
            checker();
        });

        checker();
    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip({
            placement: 'right',
            title : "<p><li>Sila muat naik Borang Opsyen dan Borang Pemberian Taraf Berpencen yang anda telah anda isi dan lengkapkan jika anda memilih Skim Pencen.</li>\n\
                        <li>Sila muat naik Borang Opsyen yang anda telah anda isi dan lengkapkan jika anda memilih Skim Kumpulan Wang Simpanan Pekerja (KWSP).</li></p>",
            html : true
        });
    });
</script>



