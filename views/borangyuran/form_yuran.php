<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\kemudahan\Refbadanprof;
use app\models\kemudahan\Tblyuran;
use kartik\number\NumberControl;
error_reporting(0); 
?>
<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,1295,1297,1299,1303], 'vars' => []]); ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'id' => 'dynamic-form']]); ?>
  
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel"> 
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
            1. Sila pastikan anda telah mengisi bahagian <strong>BADAN PROFESIONAL </strong>dalam profile anda. Anda adalah <strong>WAJIB</strong> untuk mengisi Bahagian Profesional. Klik sini <?php echo Html::a('<i class="fa fa-edit"></i> ',['badan-profesional/view'], ['class' => 'btn btn-success btn-sm','target'=>'_blank']); ?>untuk &nbsp;&nbsp;&nbsp;&nbsp;kemaskini.<br>
            2. Hanya permohonan kakitangan yang berkelayakan dan Lengkap sahaja akan dipertimbangkan. <strong>Pastikan maklumat Bahagian Profesional telah dikemaskini</strong> untuk 
        &nbsp;&nbsp;&nbsp;&nbsp;mengelakan permohonan ditolak.
            
        
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
                <th scope="col" colspan="6" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT YURAN KEAHLIAN BADAN PROFESIONAL/BADAN IKHTISAS</center></th>

                <tr>
                        <td valign="4">Nama Badan Professional:<span class="required" style="color:red;">*</span></td>
                        <td colspan="4">  
                         <?php
//                         $form->field($model, 'badan_prof')->label(false)->widget(Select2::classname(), [
//                        'data' => ArrayHelper::map(Refbadanprof::find()->all(), 'badanprof', 'badanprof'),
//                        'options' => ['placeholder' => 'Pilih Badan Profesional', 'class' => 'form-control col-md-7 col-xs-12'],
//                        'pluginOptions' => [
//                            'allowClear' => true
//                        ],
//                        ]);
                        ?>
                        <?=
                         $form->field($model, 'badan_prof')->widget(Select2::classname(), 
                            [
//                            'data' => ArrayHelper::map($fees, 'ProsfBodyCd', 'ProfBodyCd'), 
                            'data' => ArrayHelper::map($fees, 'ProfBodyOther', 'ProfBodyOther'),     // 'data' => ArrayHelper::map($fees, 'ProfBodyOther',  'ProfBodyOther' ),  => showing data tblprprofassoc //  'data' => ArrayHelper::map($fees, 'ProfBody',   'ProfBody' ) => showing data table professionalassociation   
                            'options' => [
                            'placeholder' => 'Badan Professional'],
                            ])->label(false); 
                        ?>
                            
                         <?php // $form->field($model, 'badan_prof')->textInput(['maxlength' => true]) ->label(false);?> 
                           
                        </td>
                </tr>
 
                <tr>
                        <td valign="4">Jumlah Tuntutan (RM):<span class="required" style="color:red;">*</span></td>
                        <td colspan="4"> 
                           <?=
                            $form->field($model, 'jumlah')->widget(NumberControl::classname(), [
                                 'name' => 'jumlah',
                                   'pluginOptions'=>[
                                   'initialize' => true,
                                                            ],
                                       'maskedInputOptions' => [
                                        'prefix' => 'RM',
                                     'rightAlign' => false
                                   ],

                                 'displayOptions' => [
                                 //   'placeholder' => 'Contoh: RM223437.04'
                                          ],
                                        ])->label(false);
                            ?>
                        </td>

                </tr> 

                <tr>
                        <td valign="4">Nombor Bil/Resit:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="4"> 
                             <?= $form->field($model, 'resit')->textInput(['maxlength' => true]) ->label(false);?>    
                        </div>
                          </td>

                </tr>
                <tr>
                        <td valign="4">Jenis Bayaran:<span class="required" style="color:red;">*</span></td>
                        <td colspan="4">
                             <?= $form->field($model, 'payment')->label(false)->widget(Select2::classname(), [
                                    'data' => ['Yuran Pendaftaran' => 'Yuran Pendaftaran', 
                                    'Yuran Keahlian' => 'Yuran Keahlian',
                                     
                                 ],
                                    'options' => [
                                            'placeholder' => 'Sila Pilih'],

                                ]); ?> 
                            
                        </td>
                </tr>
        </thead>
                          </table>
             <table class="table table-sm table-bordered" >
        <thead>
                <tr>
                    <td valign="4">Resit Pembayaran:<span class="required" style="color:red;">*</span></td>
                    <td colspan="4"> <?= $form->field($model, 'file')->fileInput()->label(false);?> </td>
                    <td valign="4">Dokumen Sokongan :<span class="required" style="color:red;">*</span></td>
                    <td colspan="4"> <?= $form->field($model, 'file2')->fileInput()->label(false);?> </td> 
                </tr>
        </thead>
             </table> 

        <div style="color: green; margin-top: 0px;">
                   <strong>  Sila pastikan maklumat tuntutan adalah tepat sebelum klik hantar. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini.</strong>
        </div>
        </div>
        <?= $form->field($model, 'jeniskemudahan')->hiddenInput(['jeniskemudahan' =>  $id = Yii::$app->request->get('id')])->label(false)?> 
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
        <div class="form-group">
        <div class="col-sm-11 text-center">

            <table>
                <tr>
                    <td class="col-sm-3 text-right">
                        <?php // $model->agree = 0; ?> 
                        <br><input type="checkbox"  id="checkbox1" class="default-input sale-text-req" onclick="checkTerms();"/>
                    </td>

                    <td class="col-sm-2 text-center">
                        <div style="width: 870px; height: 90px;border:2px solid burlywood">
                            <h5 style="color:black;" >&nbsp; Saya mengaku bahawa:<p> <br/>
                           &nbsp;Tuntutan ini dibuat mengikut kadar dan syarat seperti yang dinyatakan di bawah peraturan-peraturan yang berkuat kuasa sekarang.<p>
                            </h5> 
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
                    <br>
                    <?php // Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Hantar'), ['id'=> 'submitb', 'disabled'=> true, 'class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']])?>
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