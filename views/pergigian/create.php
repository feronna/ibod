<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Pergigian\Klinik;
use kartik\number\NumberControl;
use app\models\hronline\Tblkeluarga;
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1261, 1264, 1291], 'vars' => []]); ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<div class="col-md-12">
</div>


<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> Tuntutan Baru</strong></h2>
            <div class="clearfix"></div>
        </div>
<div class="x_content">
            <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3  col-md-offset-1">JENIS PERMOHONAN</label>
            <div class="col-md-4 col-sm-4 ">
            <select class="form-control"id="foo">
            <option value=" ../pergigian/create ">Tuntutan Rawatan Pergigian</option>
            <option value=" ../pergigian/kacamata ">Tuntutan Kacamata</option>

             
            </select>
            </div>
            </div>
         
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
                </div>
            <div class="form-group">  
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
                <?= $form->field($model->kakitangan, 'COOUCTelNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                <?php // $form->field($model->rekod, 'destinasi')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>      
                </div>
                </div>
                </div>
                </div>
        <div class="col-md-6">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-money"></i><strong> Perincian Peruntukan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="headings">
                    <tr class="odd"><td><strong>Peruntukan Tahunan </strong></td><td><strong> RM 300.00</strong></td>
                    <tr class="odd"><td><strong>Jumlah Tuntutan Terkini</strong></td><td><strong><?= Yii::$app->formatter->asCurrency( $model->jumlah, 'RM '); ?></strong></td>
                    <tr class="odd"><td><strong>Baki Kelayakan</strong></td><td><strong><?= Yii::$app->formatter->asCurrency( $model->baki, 'RM '); ?></strong></td>
                    </tr>                                             
                </thead>
            </table>
                </div>
            </div>
        </div>
    </div>
        <div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
       
        <div class="x_title">
            <h2><i class="fa fa-book"></i><strong> Butiran Tuntutan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>

        <div class="clearfix"></div>   
        </div>

        <div class="form-group">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12" >Nama Klinik Pergigian<span class="required" style="color:red;">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                     <?=  $form->field($model, 'klinik_gigi_id')->widget(Select2::classname(), [
                            'name' => 'klinik_gigi_id',
                            'data' => \yii\helpers\ArrayHelper::map(Klinik::find()->all(),'klinik_gigi_id', 'klinik_nama'),
                             'options' => ['placeholder' => 'Pilih Klinik Pergigian', 'class' => 'form-control col-md-7 col-xs-12',
                                    'onchange' => 'javascript:if ($(this).val() == "174"){
                                    $("#Lain-lain").show();
                                         }
                                    else{
                                    $("#Lain-lain").hide();
                                    }'],
                        
                                    'pluginOptions' => [
                                    'allowClear' => true
                                    ],

                        ])->label(false); ?>
                        
                        <div class="form-group">
                              <div id="Lain-lain" style="display: none">
                            <?= $form->field($model, 'lain')->textInput()->label(false); ?>
                              </div>
                        </div>
                    </div>
                </div>
        <div class="form-group">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12" >Digunakan Oleh<span class="required" style="color:red;">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                     <?=  $form->field($model, 'used_by')->widget(Select2::classname(), [
                         'data' => \yii\helpers\ArrayHelper::map(Tblkeluarga::find()->where(['ICNO' => Yii::$app->user->identity->ICNO])->andWhere(['RelCd' => ['01','02','03','04','05','15']])->all(),'FamilyId', 'FmyNm'),   
                         'options' => ['placeholder' => 'Sila pilih. Kosongkan sekiranya tuntutan atas nama anda.', 'class' => 'form-control col-md-7 col-xs-12',
                                    ],                       
                                    'pluginOptions' => [
                                    'allowClear' => true
                                    ],
                        ])->label(false); ?>
                    </div>
                </div>
      
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="used_dt">Tarikh Rawatan <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <!--<input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">-->
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'used_dt',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Tuntutan (RM)<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'jumlah_tuntutan')->widget(NumberControl::classname(), [
                         'name' => 'jumlah_tuntutan',
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombor Bil/Resit<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'catatan')->textInput(['maxlength' => true, 'rows' => 2])->label(false); ?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-6 col-sm-6 col-xs-12">Dokumen Sokongan <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                  <?= $form->field($model, 'file')->fileInput()->label(false);?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Penyemak
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" value="NORJAIDAH JAFFAR" disabled />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Melulus
                </label>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" value="ROZAIDAH AMIR HUSSEIN" disabled />
                </div>
            </div>
            
            <p style="color: green"><strong>
                    Sila pastikan maklumat tuntutan adalah tepat sebelum klik hantar. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini.<br>Resit asal hendaklah dikemukakan kepada Bahagian Sumber Manusia.</br>
            </strong></p>

            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
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


