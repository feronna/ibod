<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\time\TimePicker;
error_reporting(0);

echo $this->render('/e-perkhidmatan/contact');
?>

<?php $form = ActiveForm::begin(['options' => ['enableAjaxValidation' => true, 'class' => 'form-horizontal form-label-left disable-submit-buttons', 'id' => 'dynamic-form']]); ?>

<script type="text/javascript">
        function GetDays(){
                var dropdt = new Date(document.getElementById("tarikh_hingga").value);
                var pickdt = new Date(document.getElementById("tarikh_mula").value);
                return parseInt((dropdt - pickdt) / (24 * 3600 * 1000));
        }      
        function cal(){
        if(document.getElementById("tarikh_hingga")){
            document.getElementById("days").value=GetDays();
        }  
        }
</script>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Borang Permohonan Papan Tanda</h2>
            <div class="clearfix"></div>
<!--            <h2><strong><i class="fa fa-list"></i> BORANG PERMOHONAN PAPAN TANDA </strong></h2>-->
<!--            <p align="right"><= \yii\helpers\Html::a('Kembali', ['halaman-utama-papan-tanda?id='.$model2->event_id], ['class' => 'btn btn-primary']) ?></p>      -->
<!--            <p align="right"><?= \yii\helpers\Html::a('Kembali', ['e-perkhidmatan/senarai-permohonan?id=' . $model2->event_id], ['class' => 'btn btn-primary']) ?></p>      -->
            <div class="clearfix"></div>
        </div>
    <div class="col-md-12 col-xs-12">
        
    <div class="row">    
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Program</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <div class="col-md-10 col-sm-10 col-xs-12">
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Nama Program</label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                        <?= $form->field($model2, 'event_name')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>  
                    </div>
                </div>
                <div class="form-group">                 
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tempat Program</label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                        <?= $form->field($model2, 'location')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                    </div>               
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tarikh Mula Program</label>  
                    <div class="col-md-3 col-sm-3 col-xs-10"> 
                    <?= $form->field($model2, 'datestart')->textInput(['disabled'=>'disabled', 'maxlength' => true]) ->label(false);?>
                    </div>
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tarikh Tamat Program</label>   
                    <div class="col-md-3 col-sm-3 col-xs-10"> 
                    <?= $form->field($model2, 'dateend')->textInput(['disabled'=>'disabled', 'maxlength' => true]) ->label(false);?>
                    </div> 
                </div>    
            </div>
        </div>
        </div>
    </div>
    </div>

<!--    <div class="row">    
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Pemohon</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive">
            <div class="col-md-10 col-sm-10 col-xs-12">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Pemohon</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model->kakitangan, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No. IC</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <= $form->field($model->kakitangan, 'ICNO')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>  
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Matrik / No. Kakitangan</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model->kakitangan, 'COOldID')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>  
                    </div>
                </div>
                <div class="form-group">                 
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jabatan / Kolej</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model->kakitangan->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                    </div>               
                </div>
                <div class="form-group">                 
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Telefon Bimbit</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model->kakitangan, 'COHPhoneNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                    </div>               
                </div>
                <div class="form-group">                 
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Telefon Pejabat</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model->kakitangan, 'COOffTelNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                    </div>               
                </div>
                <div class="form-group">                 
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Sambungan 1</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model->kakitangan, 'COOffTelNoExtn')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                    </div>               
                </div>
                <div class="form-group">                 
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No. UC</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?= $form->field($model->kakitangan, 'COOUCTelNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                    </div>               
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>-->

    <div class="row">    
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Papan Tanda</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="table-responsive"> 
            <div class="col-md-10 col-sm-10 col-xs-12"> 
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tajuk Papan Tanda:<span class="required" style="color:red;">*</span></label>        
                    <div class="col-md-8 col-sm-8 col-xs-10"> 
                    <?= $form->field($model, 'tajuk')->textArea(['maxlength' => true, 'placeholder' => 'Nama papan tanda']) ->label(false);?>
                    </div>
                </div> 
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tarikh Mula Pemasangan:<span class="required" style="color:red;">*</span></label>  
                    <div class="col-md-3 col-sm-3 col-xs-10"> 
                    <?= $form->field($model, 'tarikh_mula')->widget(DatePicker::className(),
                            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'startDate'=>date('tarikh_mula'), 'format' => 'yyyy-mm-dd', 'autoclose' => true], 
                            'options' => [ 'placeholder' => 'Pilih tarikh ', 'onchange' => 'cal()', 'id' => 'tarikh_mula', 'onchange' => 'javascript:
                        var selected = ($(this).val()).substr(3,2)+"/"+($(this).val()).substr(0,2)+"/"+($(this).val()).substr(6,4);
                        var t = new Date($(this).val());
                        var today = new Date();
                        today.setHours(0);
                        today.setMinutes(0);
                        today.setSeconds(0);
//                        if (Date.parse(today)+1209600000 > Date.parse(t)) {
//                            alert("Permohonan aktiviti adalah kurang daripada 14 hari, sila pastikan permohonan dibuat dalam 14 hari sebelum tarikh permohonan untuk mengelakkan sebarang masalah. Permohonan lewat dari tempoh tersebut hendaklahlah disertakan dengan alasan/justifikasi yang kukuh.");
//                            $(this).val() = NULL;
//                        }
////                         else {
////                           alert("");
////                        }' 
                                ]])->label(false);?>
                    </div>
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tarikh Tamat Pemasangan:<span class="required" style="color:red;">*</span></label>   
                    <div class="col-md-3 col-sm-3 col-xs-10"> 
                      <?= $form->field($model, 'tarikh_hingga')->widget(DatePicker::className(),
                              ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'startDate'=>date('tarikh_hingga'), 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                              'options' => [ 'placeholder' => 'Pilih tarikh ', 'onchange' => 'cal()', 'id' => 'tarikh_hingga',  ]])->label(false);?>   
                    </div>
                    <label class="control-label col-md-1 col-sm-1 col-xs-4">Tempoh Pemasangan:</label>
                    <div class="col-md-1 col-sm-1 col-xs-10"> 
                      <?= $form->field($model, 'days')->textInput(['maxlength' => true, 'id' => 'days', 'pattern'=>'[0123456789]+', 'title'=>'Invalid Date!Please enter correct date.']) ->label(false);?>    
                    </div>  
                </div>
<!--                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Tempat Pemasangan:<span class="required" style="color:red;">*</span></label>  
                    <div class="col-md-8 col-sm-8 col-xs-10">
                    <?= $form->field($model, 'tempat')->textArea(['maxlength' => true, 'placeholder' => 'Tempat aktiviti yang dihadiri']) ->label(false);?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2 col-sm-2 col-xs-4">Masa Pemasangan:<span class="required" style="color:red">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                       <?= TimePicker::widget([
                        'name' => 'masa',
                        'size' => 'sm',
                        'containerOptions' => ['class' => 'has-success']
                        ]);
                        ?>
                    </div>
                </div>-->
            </div>
        </div>
        </div>
    </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <button class="btn btn-primary" type="reset">Reset</button>
            <?= Html::submitButton(Yii::t('app', '</i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1', 'data'=>['disabled-text' => 'Please Wait..' , 'confirm'=>'Sila pastikan maklumat permohonan adalah tepat. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini. Teruskan?']]) ?>

<!--            <= Html::submitButton('Hantar',['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Please Wait..' , 'confirm'=>'Sila pastikan maklumat permohonan adalah tepat. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini. Teruskan?' ]]) ?>-->
        </div>
    </div>

    <?php ActiveForm::end(); ?>
        
    </div>   
    </div>
</div>
</div>