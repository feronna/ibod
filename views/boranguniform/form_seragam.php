<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper; 
use app\models\kemudahan\Reftujuan;
use kartik\date\DatePicker;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use app\models\kemudahan\RefJenisSeragam;

//use wbraganca\dynamicform\DynamicFormWidget;
//use app\models\hronline\HubunganKeluarga;



$tujuan = ArrayHelper::map(Reftujuan::find()->all(), 'id', 'tujuan');
error_reporting(0); 
?>
<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,1295,1297,1299,1303], 'vars' => []]); ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'id' => 'dynamic-form']]); ?>
<?php // $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<div class="col-md-12 col-xs-12"> 
 
</div>

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel"> 
    <div class="row"> 

        <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Pemohon</strong></h2>
            <ul class="nav navbar-right panel_toolbox"> 
               
            <li><p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p></li>
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
        
        <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> PERMOHONAN PEGAWAI</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
        <div class="clearfix"></div>
        </div>
        <div class="table-responsive">
        <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=8" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT KASUT DAN PAKAIAN SERAGAM</center></th>

                <tr>
                        <td valign="4">Permohonan :<span class="required" style="color:red;">*</span></td>
                        <td colspan="5"> 
                            <div class="col-md-7 col-sm-7 col-xs-10"> 
                                 <?php
//                                $form->field($model, 'jenis_seragam')->label(false)->widget(Select2::classname(), [
//                                    'data' => [
//                                        'KASUT' => 'KASUT',
//                                        'PAKAIAN SERAGAM' => 'PAKAIAN SERAGAM',
//                                        'PAKAIAN SERAGAM KHAS' => 'PAKAIAN SERAGAM KHAS'],
//                                    'options' => [
//                                         'placeholder' => 'Kategori Permohonan'],
//                               ]); 
                                ?>
                         <?=
                           $form->field($model, 'jenis_seragam')->widget(Select2::classname(), [
                            'name' => 'jenis_seragam',
                            'data' => \yii\helpers\ArrayHelper::map(RefJenisSeragam::find()->all(),'id', 'jenis_seragam'),
                             'options' => ['placeholder' => 'Pilih Jenis Permohonan', 'class' => 'form-control col-md-7 col-xs-12',
                                    'onchange' => 'javascript:if ($(this).val() == "1"){
                                    $("#jenis-belian").show();
                                         }
                                    else{
                                    $("#bil-belian").hide();
                                    $("#jenis-belian").hide();
                                    }'
                                 ],
                        
                                    'pluginOptions' => [
                                    'allowClear' => true
                                    ],

                        ])->label(false); ?>
                        
                            </div>
                        </td>
                       
                </tr>
                  
                <tr id="jenis-belian" style="display: none"  >
                    <td valign="4">Jenis Kasut:<span class="required" style="color:red;">* </span>
                     
                    </td>
                        <td colspan="2"> 
                             
                        <?= 
                         $form->field($model, 'jenis_belian')->widget(Select2::classname(), [
                            'name' => 'jenis_belian',
                            'data' => [
                                        'Kasut kulit biasa (RM 150.00)' => 'Kasut kulit biasa (RM 150.00)', 
                                        'Kasut kulit keselamatan (RM250.00)' => 'Kasut kulit keselamatan (RM250.00)',

                                      ],
                             'options' => ['placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                                  
                                 ], 
                                    'pluginOptions' => [
                                    'allowClear' => true
                                    ],

                        ])->label(false);
                        ?> 
                   
                        </td> 
                        
                    <td valign="2">Bil. Kasut :<span class="required" style="color:red;">*</span></td>
                    <td colspan="2"> 
                        <?= $form->field($model, 'bil_belian')->textInput(['maxlength' => true, 'type' => 'number', 'pattern'=>'0123456789', 'min' => 0, 'max' => 100])->label(false) ?>
                   </td> 
                </tr> 
                
                 <tr>
                    <td valign="2">Tarikh :<span class="required" style="color:red;">*</span></td>
                        <td colspan="2"> 
                        <?= $form->field($model, 'used_dt')->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>
                     
                        </td> 
                        
                    <td valign="3">No. Resit :<span class="required" style="color:red;">*</span></td>
                    <td colspan="2"> 
                        <?= $form->field($model, 'resit')->textInput(['maxlength' => true]) ->label(false);?>
                   </td> 
                </tr>
                
                 <tr>
                    <td valign="3">Jumlah Tuntutan (RM) :<span class="required" style="color:red;">*</span></td>
                        <td colspan="5"> 
                            <div class="col-md-7 col-sm-7 col-xs-10"> 
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
                             //   'placeholder' => 'Contoh: RM223437.04'
                                      ],
                                    ])->label(false);
                            ?>
                            </div>
                        </td>  
                </tr>
                
                 <tr>
                    <td valign="2">Muat Naik :<span class="required" style="color:red;">*</span>
                     <i data-html="true" class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
                        title="1. Borang Upah Jahit (BUJ/PP Bil.1/2014)m<br>
                        2. Gambar Pakaian Seragam<br>
                        3. Salinan Resit"></i></td>
                        <td colspan="2"> 
                        <?= $form->field($model, 'file')->fileInput()->label(false);?>
                           
                        </td> 
                        
                    <td valign="2">Muat Naik :<span class="required" style="color:red;">*</span>
                     <i data-html="true" class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
                        title="1. Borang Upah Jahit (BUJ/PP Bil.1/2014)m<br>
                        2. Gambar Pakaian Seragam<br>
                        3. Salinan Resit"></i>
                    </td>
                    <td colspan="2"> 
                       <?= $form->field($model, 'file2')->fileInput()->label(false);?>
                   </td> 
                </tr>
                
                </thead>
                  
                         </table>
        
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
        <div class="col-sm-11 col-offset-1">

            <table>
                <tr>
                    <td class="col-sm-3 text-right">
                        <br><input type="checkbox"  id="checkbox1" class="default-input sale-text-req" onclick="checkTerms();"/>
                    </td>

                    <td class="col-sm-2 text-center">
                        <div style="width: 790px; height: 90px;border:2px solid burlywood">
                            <h5 style="color:black;" ><br> 
                           &nbsp;Saya mengesahkan bahawa segala maklumat yang diberikan di atas adalah benar.<p>
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
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
                    <br>
                    <?php // Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Hantar'), ['id'=> 'submitb', 'disabled'=> true,'class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']])?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
                </div>
            </div>   
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