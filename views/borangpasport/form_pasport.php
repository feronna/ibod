<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\kemudahan\Reftujuan;
use kartik\date\DatePicker;
use kartik\number\NumberControl;
 
$tujuan = ArrayHelper::map(Reftujuan::find()->all(), 'id', 'tujuan');
error_reporting(0); 
?>

<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86], 'vars' => []]); ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'id' => 'dynamic-form']]); ?>
<div class="col-md-12 col-xs-12"> 
<!--    <div class="x_panel">
         
        
    <div class="row"> 
         <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> Permohonan Tuntutan Staf Secara Atas Talian(On-line): Pasport</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
        <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
            <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3 ">JENIS PERMOHONAN</label>
            <div class="col-md-4 col-sm-4 ">
            <select class="form-control"id="foo">
             <option value="" disabled selected>Pasport</option>
            <option value=" ../boranglesen/form_lesen " id="8">Lesen Memandu</option>
            <option value=" ../borangpasport/form_pasport ">Pasport</option>
            <option value="../pakaian-istiadat/form_pakaian">Pakaian Istiadat</option>
            <option value="../borangehsan/form_pemohon">Tambang Belas Ehsan</option>
            <option value="../borang-alat/maklumat-pembelian">Pembelian Alat Komunikasi</option>
            <option value="../borangyuran/maklumat-yuran">Yuran / Badan Ikhtisas</option>
            <option value="../boranguniform/maklumat-seragam">Pakaian Seragam</option>

            </select>
            </div>
            </div>
         
        </div> 
           
        </div>
    </div>
    </div>-->
</div>

<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="row"> 
            
        <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Pemohon</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
<!--                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                <li>  <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p></li>
              
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
        <div class="x_content">
    
        <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Tuntutan <span class="required">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-10">
                   <?= $form->field($model, 'jeniskemudahan')->textInput(['disabled'=>'disabled', 'value' =>  'Pasport'])->label(false)?>
                </div>
            </div>   

        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh* :<span class="required"></span>
        </label>
        <div class="col-md-4 col-sm-4 col-xs-10"> 

         <?= $form->field($model, 'used_dt')->label(false)->widget(DatePicker::classname(),[
                                            'readonly' => false,
                                            'removeButton' => false,
                                            'pluginOptions' => [
                                                'autoclose'=>true,
                                                'format' => 'yyyy-mm-dd'
                                            ],
                                            'options' => ['class' => 'form-control col-md-7 col-xs-12', 'data-datepicker-source' => '1'],
                                            ]); ?>
        </div>    
        </div>
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombor Bil/Resit* :<span class="required"></span>
        </label>
        <div class="col-md-4 col-sm-4 col-xs-10"> 
        <?= $form->field($model, 'resit')->textInput(['maxlength' => true]) ->label(false);?>
        </div>
        </div>
            
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Tuntutan (RM)*:<span class="required"></span>
        </label>
        <div class="col-md-4 col-sm-4 col-xs-10"> 
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
                            'placeholder' => 'Contoh: RM223437.04'
                                  ],
                                ])->label(false);
                            ?>


        </div>
        </div>    
              
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resit Bayaran* :<span class="required"></span>
        </label>
        <div class="col-md-1 col-sm-1 col-xs-10">
        <?= $form->field($model, 'file')->fileInput()->label(false);?>
        </div>
            
        <label class="control-label col-md-4 col-sm-4 col-xs-12">Dokumen Sokongan* :<span class="required"></span>
        </label>
        <div class="col-md-3 col-sm-3 col-xs-10">
        <?= $form->field($model, 'file2')->fileInput()->label(false);?>
        </div>    
        </div>
            
        <div style="color: green; margin-top: 0px;">
        <strong> Pemohon perlu memuat naik resit bayaran; serta lampirkan dokumen sokongan yang perlu untuk memudahkan pertimbangan.</strong><br>
        <strong> Sila pastikan maklumat tuntutan adalah tepat sebelum klik hantar. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini.</strong>
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
        <div class="form-group">
        <div class="col-sm-11 text-center">

            <table>
                <tr>
                    <td class="col-sm-3 text-right">
                        <?php // $model->agree = 0; ?> 
                        <br><input type="checkbox"  id="checkbox1" class="default-input sale-text-req" onclick="checkTerms();"/>
                    </td>

                    <td class="col-sm-2 text-center">
                        <div style="width: 790px; height: 90px;border:2px solid burlywood">
                            <h5 style="color:black;" ><br> 
                           &nbsp;Saya mengakui bahawa maklumat dan resit yang dikemukakan bersama dengan permohonan ini adalah benar dan betul dan UMS berhak melulus atau 
                           menolak sebahagian atau sepenuhnya tuntutan saya ini.<p>
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