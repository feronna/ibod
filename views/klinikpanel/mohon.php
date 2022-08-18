<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$this->registerCss("
.alert {
    padding: 20px;
    background-color: #FF9900; /* Red */
    color: black;
    margin-bottom: 15px;
    font-size: 15px;
  }
  
  /* The close button */
  .closebtn {
    margin-left: 15px;
    color: black;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
  }
  
  /* When moving the mouse over the close button */
  .closebtn:hover {
    color: black;
  }

");
// echo '<script>alert("Welcome to Geeks for Geeks")</script>';
?>
<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  Permohonan penambahan peruntukan adalah tertakluk pada ketetapan seperti berikut:
  <br>
  1. Penambahan Kali Pertama = 50% daripada Jumlah Kelayakan Tahunan
  <br>
  2. Penambahan Kali Kedua = 25% daripada Jumlah Kelayakan Tahunan
  <br>
  <br> <strong> "Garis Panduan Perkhidmatan Dan Kemudahan Klinik Panel Tahun 2016 dan Mesyuarat Jawatankuasa Tadbir Urus Kemudahan Perubatan (JKTUKP) <br>
  Bil.1 Tahun 2021(Kali ke 11)"
  </strong>
</div>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="col-md-12">
</div>


<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> Permohonan Baru</strong></h2>
            <div class="clearfix"></div>
        </div>

        <div class="col-md-12 col-xs-12"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-user"></i> Maklumat Pemohon</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="col-md-10 col-sm-10 col-xs-12">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penuh <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?= $form->field($model->kakitangan->kakitangan, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">No Kad Pengenalan <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?= $form->field($model, 'icno')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS-PER <span class="required"></span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?= $form->field($model->kakitangan->kakitangan, 'COOldID')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan dan Gred <span class="required"></span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?= $form->field($model->kakitangan->kakitangan->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Taraf Lantikan <span class="required"></span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?= $form->field($model->kakitangan->kakitangan->statusLantikan, 'ApmtStatusNm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">J/ F/ P/ I/ B <span class="required"></span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?= $form->field($model->kakitangan->kakitangan->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                            </div>               
                        </div>
                        <div class="form-group">  
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Emel <span class="required"></span>
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <?= $form->field($model->kakitangan->kakitangan, 'COEmail')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Telefon <span class="required"></span>
                            </label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <?= $form->field($model->kakitangan->kakitangan, 'COOffTelNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                            </div>


                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ext  <span class="required"></span>
                            </label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <?= $form->field($model->kakitangan->kakitangan, 'COOUCTelNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled' => 'disabled'])->label(false); ?>
                                <?php // $form->field($model->rekod, 'destinasi')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                            </div>      
                        </div>
                    </div>
                </div>
            </div>
        </div>
 <div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
       
        <div class="x_title">
            <h2><i class="fa fa-book"></i><strong> Butiran Permohonan - <?php if($model->entry_id == 1){echo "Kali Pertama";}else {echo 'Kali Kedua';}?></strong></h2>
            
            

        <div class="clearfix"></div>   
        </div>
        <div class="container">
        <div class="table-responsive">
        <table class="table table-sm table-bordered">
        <thead>
            <th scope="col" colspan=6" style="background-color:lightseagreen; color:white;"  ><center><h5><strong>MAKLUMAT PERUNTUKAN MYHEALTH TAHUN <?= date('Y') ?></strong></h5></center></th>
        <tr>
            <td valign="4" width="30%">Jumlah Peruntukan Tahunan (RM):<span class="required" style="color:red;">*</span></td>
            <td colspan="4">
                <div class="col-md-12 col-sm-12 col-xs-10">                
                    <?= $form->field($model->kakitangan, 'max_tuntutan')->textArea(['maxlength' => true, 'rows' => 4, 'disabled' => TRUE])->textInput(['disabled' => 'disabled'])->label(false); ?>
                </div>
            </td>
        </tr>     
        <tr>
            <td valign="4">Baki Peruntukan (RM):<span class="required" style="color:red;">*</span></td>
            <td colspan="4">
        <div class="col-md-12 col-sm-12 col-xs-10">   
                 <?= $form->field($model->kakitangan, 'current_balance')->textArea(['maxlength' => true, 'rows' => 4,'disabled' =>TRUE])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </td>
        </tr>
        <tr>
        <td valign="4">Rekod Penambahan Peruntukan(RM):<span class="required" style="color:red;">*</span></td> 
                <td colspan="4">
                <div class="col-md-12 col-sm-12 col-xs-10">
                 <?= $form->field($model->kakitangan, 'topup_max')->textArea(['maxlength' => true, 'rows' => 4,'disabled' =>TRUE])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
        </td>
        </tr>
        <tr> 
                <td valign="4">Jumlah Tuntutan Klinik Panel (RM):<span class="required" style="color:red;">*</span></td>
                <td colspan="4">
        <div class="col-md-12 col-sm-12 col-xs-10">
                 <?= $form->field($model->kakitangan, 'tuntutan')->textArea(['maxlength' => true, 'rows' => 4,'disabled' =>TRUE])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                </td>
        </tr>
        <tr> 
                <td valign="4">Jumlah Tuntutan Klinik Bukan Panel (RM):<span class="required" style="color:red;">*</span></td>
                <td colspan="4">
                <div class="col-md-12 col-sm-12 col-xs-10">
                 <?= $form->field($model->kakitangan, 'tuntutan_bukan_panel')->textArea(['maxlength' => true, 'rows' => 4,'disabled' =>TRUE])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </td>
        </tr>
        <tr> 
                <td valign="4">Jumlah Tuntutan PKU HUMS:<span class="required" style="color:red;">*</span></td>
                <td colspan="4">
                <div class="col-md-12 col-sm-12 col-xs-10">
                 <?= $form->field($model->kakitangan, 'jumlah')->textArea(['maxlength' => true, 'rows' => 4,'disabled' =>TRUE])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                </td>
        </tr>
        <tr> 
                <td valign="5">Jumlah Dipohon (RM):<span class="required" style="color:red;">*</span></td>
                <td colspan="5">
                <div class="col-md-12 col-sm-12 col-xs-10">
                 <?= $form->field($model, 'jumlah_mohon')->textArea(['maxlength' => true, 'rows' => 4,'disabled' =>TRUE])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                </td>
        </tr>
        <tr>
         <td valign="4">Bilangan Tanggungan:<span class="required" style="color:red;">*</span></td>
                <td colspan="4">
                <div class="col-md-4 col-sm-4 col-xs-4">
                 <?= $form->field($model->kakitangan, 'tanggungan')->textArea(['maxlength' => true, 'rows' => 4,'disabled' =>TRUE])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2">
                <?= Html::button('<i class="fa fa-search"></i>  ', ['value' => Url::to(['klinikpanel/family-list']), 'class' => 'mapBtn btn btn-success']); ?> 
                 
            
            </div>

        </div>
            </td>
        </tr>
        <tr>
        <td valign="4">Justifikasi Permohonan:<span class="required" style="color:red;">*</span></td>
                <td colspan="4">
                <div class="col-md-12 col-sm-12 col-xs-10">
                 <?= $form->field($model, 'entry_remarks')->textArea(['maxlength' => true, 'rows' => 8])->label(false); ?>
                </div>
            </td>
        </tr>
        <tr>
        <td valign="4">Pegawai Peraku:</td>
                <td colspan="4">
                <div class="col-md-12 col-sm-12 col-xs-10">
                    <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo ($kj->chief == $model->icno) ? 'Professor Madya Dr. RAMAN B. NOORDIN' : $kj->chiefBiodata->CONm; ?>" disabled />
                </div>
                </td>
        </tr>

            <tr>
        <td valign="4">Pegawai Pelulus:</td>
                <td colspan="4">
                <div class="col-md-12 col-sm-12 col-xs-10">
                    <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" value="<?php echo ($approver->pelulus_icno) ? $approver->pelulus->CONm : 'Terus kepada Pegawai Pelulus'; ?>" disabled />
                </div>
                </td>
            </tr>
        </table>
        <div class="form-group">
               <table>
                <tr>
                    <td class="col-sm-1 text-center">
                        <?= $form->field($model, 'status')->checkBox(['label' => '','data-size'=>'small', 'class'=>'bs_switch','margin-bottom:4px;', 'id'=>'checkbox1', 'onclick' =>"checkTerms()"]) ?>
                    </td>

                    <td class="text-center">
                        <div style="width: 800px; height: 120px;border:2px solid burlywood">
                            <h5 style="color:black;" ><br> 
                           &nbsp;Saya mengesahkan bahawa permohonan yang dibuat adalah benar dan mematuhi jenis rawatan yang dilindungi
sahaja seperti yang dinyatakan dalam Pekeliling Pendaftar Bil. 1 Tahun 2016 : Garis Panduan Perkhidmatan dan
Kemudahan Klinik Panel Kepada Pekerja Universiti Malaysia Sabah (Pindaan 2016).<p>
                            </h5> 
                            <strong><p style="color:black;"><center>Tarikh Mohon: <?php echo date('Y-m-d H:i:s'); ?> </p><br/> </strong></center>
                    </div>
                    </td>
                </tr>
            </table>
        
                   </div>

                   <div class="ln_solid"></div>

<div class="customer-form">  
<div class="form-group" align="center">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
   <br>
   <?php // Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
   <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Hantar'), ['id'=> 'submitb', 'disabled'=> true,'class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']])?>
   <button class="btn btn-primary" type="reset">Reset</button>
</div>
</div>
</div>

            <?php ActiveForm::end(); ?>
            
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script>
    document.getElementById("foo").onchange = function() {
        if (this.selectedIndex!==0) {
            window.location.href = this.value;
        }        
    };
</script>

<script>
                 function checkTerms() {
                   // Get the checkbox
                   var checkBox = document.getElementById("checkbox1");
 
                   // If the checkbox is checked, display the output text
                   if (checkBox.checked === true){
                     document.getElementById("submitb").disabled = false;
                   } else {
                     document.getElementById("submitb").disabled = true;
                   }
                 }
                     </script>



