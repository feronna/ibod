<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\number\NumberControl;
use app\models\kemudahan\Reftujuan;
use kartik\date\DatePicker;
//use wbraganca\dynamicform\DynamicFormWidget;
//use app\models\hronline\HubunganKeluarga;



$tujuan = ArrayHelper::map(Reftujuan::find()->all(), 'id', 'tujuan');
error_reporting(0); 
?>
<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,157,1295,1297,1299,1303], 'vars' => []]); ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'id' => 'dynamic-form']]); ?>
 
<style>
textarea {
  /*resize: none;*/
  width: 100%;
}
</style>
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> Permohonan Tuntutan Kemudahan Elaun Perpindahan Rumah (LPPSA)</strong></h2>
            <div class="clearfix"></div>
        </div> 
        
    <div class="row"> 
        <div class="x_panel">
        <div class="x_title">
             <h2><strong>Perhatian</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
<!--                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>-->
             <li>  <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">     
            1. Sila pastikan anda telah mengemaskini bahagian <strong>Alamat </strong>dalam profile anda. Adalah <strong>WAJIB</strong> untuk anda mengemaskini Alamat. Klik sini <?php echo Html::a('<i class="fa fa-edit"></i> ',['alamat/view'], ['class' => 'btn btn-success btn-sm','target'=>'_blank']); ?>untuk mengemaskini.<br>
            2. Pastikan maklumat Alamat anda adalah yang<strong> TERKINI </strong> untuk mengelakan permohonan ditolak.
            
        
        </div> 
        </div>
       
        <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Pemohon</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
<!--                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>-->
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
        <div class="col-md-10 col-sm-10 col-xs-12">
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penuh <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <?= $form->field($model->kakitangan, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                  
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No Kad Pengenalan <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <?= $form->field($model->kakitangan, 'ICNO')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS-PER <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COOldID')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                     
                </div>
            </div>
                
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan dan Gred <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                 <?= $form->field($model->kakitangan->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                 
            </div>
             <div class="form-group">
                 
                <label class="control-label col-md-3 col-sm-3 col-xs-12">J/ F/ P/ I/ B <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                <?= $form->field($model->kakitangan->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                
            </div>
            <div class="form-group">
                
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Taraf Jawatan <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                <?= $form->field($model->kakitangan->statusLantikan, 'ApmtStatusNm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
              
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Emel <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COEmail')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Taraf Perkahwinan <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                 <?= $form->field($model->kakitangan, 'displayTarafPerkahwinan')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Telefon <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COOffTelNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Ext  <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                <?= $form->field($model->kakitangan, 'COOffTelNoExtn')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div> 
            </div>
        </div> 
        </div> 
        </div>
        
       <div class ="row"> 
       <div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-user"></i> PERMOHONAN PEGAWAI</strong></h2>
                <div class="clearfix"></div>
            </div> 
        <div class="container">
        <div class="table-responsive">
        <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan="6" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT PERPINDAHAN RUMAH</center></th>

                <tr>
                        <td valign="4">Tarikh Pepindahan Rumah:<span class="required" style="color:red;">*</span></td>
                        <td colspan="4">  
                             <?= $form->field($model, 'tarikh_pindah')->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd',
                                                 'startDate'=>date('tarikh_pindah'),
                                                'minDate'=>'0',
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>
                           
                           
                        </td>
                </tr>
                <tr>
                        <td valign="4">Alamat Rumah Baru:<span class="required" style="color:red;">*</span></td>
                        
                        <td colspan="4"> 
                           <?php if ($model->alamat->addr2 == 'NULL' || $model->alamat->addr2 == '-' || $model->alamat->addr3 == '-' || $model->alamat->addr3 == 'NULL'){
                                 
                                    echo '<textarea disabled rows="3" cols="1" id= "new_add">'.$model->alamat->addr1.'</textarea>' ;  
                            }else{ 
                               echo '<textarea disabled rows="3" cols="1" id= "new_add">'.$model->alamat->addr1.' '.$model->alamat->addr2.' '.$model->alamat->addr3.'.</textarea>';

                            } 
                        ?>
                           
                          <div style="color: green; margin-top: 0px;"> Pastikan alamat adalah alamat terbaru anda. Klik sini <?php echo Html::a('<i class="fa fa-edit"></i> ',['alamat/view'], ['class' => 'btn btn-success btn-sm','target'=>'_blank']); ?>untuk mengemaskini alamat anda yang terbaru.
                        </div>
                        </div>
                        </td>
                          
                </tr>
                
                <tr>
                        <td valign="4">Alamat Rumah Lama:<span class="required" style="color:red;">*</span></td>
                        <td colspan="4"> 
                             <?= $form->field($model, 'old_add')->textArea(['maxlength' => true]) ->label(false);?> 
                        </td> 
                </tr>  
                <tr>
                        <td valign="4">Jumlah Tuntutan (RM):<span class="required" style="color:red;">*</span></td>
                        <td colspan="4">
                             <?=
                    $form->field($model, 'jumlah_tuntutan')->widget(NumberControl::classname(), [
                         'name' => 'jumlah',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         
                         'displayOptions' => [
                            'placeholder' => 'Contoh: RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
                        </td>
                </tr>
        </thead>
                          </table>
             <table class="table table-sm table-bordered" >
        <thead>
                <tr>
                    <td valign="4">Dokumen Sokongan 1:<span class="required" style="color:red;">*</span></td>
                    <td colspan="4"> <?= $form->field($model, 'file')->fileInput()->label(false);?> </td>
                    <td valign="4">Dokumen Sokongan 2:<span class="required" style="color:red;">*</span></td>
                    <td colspan="4"> <?= $form->field($model, 'file2')->fileInput()->label(false);?> </td>
                     
                    
                </tr>
                

                            </thead>
                        </table> 


                    </div>

        </div>
       </div>
           <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> PENGAKUAN PEGAWAI</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div> 
        <div class="x_content">
         <table>
             <tr>
             

<!--             <td class="col-sm-3 text-left">
                   Saya mengaku bahawa:<p>  <?php // $form->field($model, 'pengakuan')->checkbox(['value' => 1])->label(false); ?>
                             
                            <br>
                            a. Perjalanan pada tarikh tersebut adalah benar;<p>
                            b. Tuntutan ini dibuat mengikut kadar dan syarat seperti yang dinyatakan di bawah peraturan-peraturan bagi pegawai berpindah rumah yang berkuat kuasa semasa ; dan <p>
c. Butir-butir seperti yang dinyatakan di atas adalah benar dan saya bertanggungjawab terhadapnya 
            </td>   -->
        </tr>
    </table>
            
            <div class="form-group">
 <div class="col-sm-12 text-center">
    
    <table>
        <tr>
            <td class="col-sm-3 text-right">
               <br><input type="checkbox"  id="checkbox1" class="default-input sale-text-req" onclick="checkTerms();"/>
            </td>
 
            <td class="col-sm-4 text-justify">
                <div style="width: 950px; height: 190px;border:2px solid burlywood">
                    <h5 style="color:black;" >&nbsp; Saya mengaku bahawa:<p> <br/>
                   &nbsp;a. Perjalanan pada tarikh tersebut adalah benar;<p>
                   &nbsp;b. Tuntutan ini dibuat mengikut kadar dan syarat seperti yang dinyatakan di bawah peraturan-peraturan bagi pegawai berpindah rumah 
                   yang berkuat <br>  &nbsp; <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;kuasa semasa ; dan <p>
                   &nbsp;c. Butir-butir seperti yang dinyatakan di atas adalah benar dan saya bertanggungjawab terhadapnya  </h5>
                    <strong><p style="color:black;"><center>Tarikh Mohon: <?php echo $model->entrydate;?></p><br/> </strong></center>
                      
            </div>
            </td>
        </tr>
    </table>
 </div>
</div>
             
        <div class="customer-form">  
                <div class="form-group" align="center">
                <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2"> 
                    <?= $form->field($model, 'jeniskemudahan')->hiddenInput(['jeniskemudahan' =>  $id = Yii::$app->request->get('id')])->label(false)?> 
                     
                    <?php // Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Hantar'), ['id'=> 'submitb', 'disabled'=> true,'class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']])?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
                </div>
            </div>   
        </div> 
        </div> 
            
         </div>
         
        
        
        <?php ActiveForm::end(); ?>
        </div> 
    </div>
    </div>
</div>
</div>
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
 
