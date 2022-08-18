<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
error_reporting(0);
?>
<?php
Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true ]]); ?>
<script type="text/javascript">
        function GetDays(){
                var dropdt = new Date(document.getElementById("tarikh_mohon_balik2").value);
                var pickdt = new Date(document.getElementById("tarikh_mohon_balik").value);
                return parseInt((dropdt - pickdt) / (24 * 3600 * 1000));
        }      
        function cal(){
        if(document.getElementById("tarikh_mohon_balik2")){
            document.getElementById("days").value=GetDays();
        }  
        }
</script>
<div style="display: <?php echo $displaytempoh;?>"> 
    <div class="x_panel"> 
        <div class="x_title">
                     <h2><strong><i class="fa fa-book"></i>Keputusan Mesyuarat</strong></h2>
                    <div class="clearfix"></div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Mesyuarat Kali Ke-</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'kali_ke')->textInput(['maxlength' => true, 'rows' => 4, 'value' => $tmp['kali_ke'], 'disabled' => 'disabled'])->label(false);
                ?>
            </div>
        </div>
        
        <div class="form-group">
           <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun Mesyuarat</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
           <?= $form->field($model, 'tahun_mesyuarat')->textInput(['maxlength' => true, 'rows' => 4, 'value' => $tmp['tahun_mesyuarat'], 'disabled' => 'disabled'])->label(false);
                ?>
            </div>         
        </div>
        
        <div class="form-group">
           <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mesyuarat</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
           <?= $form->field($model, 'tarikh_mesyuarat')->textInput(['maxlength' => true, 'rows' => 4, 'value' => $tmp['tarikh_mesyuarat'], 'disabled' => 'disabled'])->label(false);
                ?>
            </div>         
        </div>
        
        <div class="form-group">
             <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Pengesahan: <span class="required" style="color:red;">*</span>
             </label> 
             <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'tarikh_pengesahan')->widget(DatePicker::className(),
                ['clientOptions' => ['changeMonth' => true,
                    'yearRange' => '1996:2099',
                    'changeYear' => true, 
                    'format' => 'yyyy-mm-dd', 
                    'autoclose' => true],
                'options' => [ 'placeholder' => 'Pilih Tarikh ', 
                    'onchange' => 'cal()', 
                    'id' => 'tarikh_pengesahan' ]])
                ->label(false);?>
                </div>
        </div>
        
        <div class="form-group" id="ConfirmStatusCd" >
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Status Pengesahan<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?php
                    $ConfirmStatusCd =ArrayHelper::map(\app\models\pengesahan\RefStatusPengesahan::find()->where(['ConfirmStatusCd' => '1' ])->orWhere(['ConfirmStatusCd' => '2'])->orWhere(['ConfirmStatusCd' => 3])->orWhere(['ConfirmStatusCd' => 4])->orWhere(['ConfirmStatusCd' => 5])->orWhere(['ConfirmStatusCd' => 6])->all(), 'ConfirmStatusCd', 'ConfirmStatusNm');
                    ?>
                   <?=
                    $form->field($model, 'ConfirmStatusCd')->label(false)->widget(Select2::classname(), [
                        'data' => $ConfirmStatusCd,
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "1"){
                        $("#tempoh").hide();
                        }
                        else{
                        $("#tempoh").show();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>        
                </div>
        </div> 
        
        <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Implikasi Pelanjutan<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <?php
                        $implikasi =ArrayHelper::map(\app\models\Pengesahan\RefImplikasiPelanjutan::find()->where(['id' =>1])->orWhere(['id' =>2])->orWhere(['id' =>3])->orWhere(['id' =>4])->all(), 'implikasi', 'implikasi');
                        ?>
                       <?=
                        $form->field($model, 'implikasi')->label(false)->widget(Select2::classname(), [
                            'data' => $implikasi,
                            'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                                'onchange' => 'javascript:if ($(this).val() == "LAIN-LAIN"){
                            $("#place-holder").show();
                            }
                            else{
                            $("#place-holder").hide();
                            }'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);?>        
                    </div>
        </div>   
        
        <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tempoh Mohon Balik (Hari)<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                      <?= $form->field($model, 'days')->textInput(['maxlength' => true, 'id' => 'days', 'pattern'=>'[0123456789]+', 'title'=>'Invalid Date!Please enter correct date.']) ->label(false);?>    
                    </div>  
        </div>

        <div class="form-group" id="tempoh" style="display: none">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Cadangan Tempoh Memohon Balik Pengesahan Dalam Perkhidmatan<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                        <?php
                        $tempoh =ArrayHelper::map(\app\models\Pengesahan\RefTempoh::find()->where(['id' =>2])->orWhere(['id' =>3])->orWhere(['id' =>4])->all(), 'tempoh', 'tempoh');
                        ?>
                       <?=
                        $form->field($model, 'tempoh_l_bsm')->label(false)->widget(Select2::classname(), [
                            'data' => $tempoh,
                            'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                                'onchange' => 'javascript:if ($(this).val() == "LAIN-LAIN"){
                            $("#place-holder").show();
                            }
                            else{
                            $("#place-holder").hide();
                            }'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);?>
                        <div class="col-md-3 col-sm-3 col-xs-12" style="display: inline">
                            <input type="number" id="place-holder" name="tempohs" class="form-control" maxlength="20" style="display: none" placeholder="bulan    cth: 6">
                        </div>   
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Pelanjutan<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?php
                    $pelanjutan =ArrayHelper::map(\app\models\Pengesahan\RefPelanjutan::find()->where(['id' =>2])->orWhere(['id' =>3])->orWhere(['id' =>4])->all(), 'pelanjutan', 'pelanjutan');
                    ?>
                   <?=
                    $form->field($model, 'pelanjutan')->label(false)->widget(Select2::classname(), [
                        'data' => $pelanjutan,
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "LAIN-LAIN"){
                        $("#place-holder").show();
                        }
                        else{
                        $("#place-holder").hide();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>        
                </div>
            </div>   
        
            <div class="col-md-12 col-sm-12 col-xs-12" style="color: green;">
                         Sila isi tarikh mohon balik jika permohonan ditolak.  Sila abaikan jika permohonan diluluskan.
            </div>
           
            <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mohon Balik (Dari)</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'tarikh_mohon_balik')->widget(DatePicker::className(),
                            ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                            'options' => [ 'placeholder' => 'Pilih Tarikh ', 'onchange' => 'cal()', 'id' => 'tarikh_mohon_balik' ]])->label(false);?>
                    </div>
            </div>
            <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mohon Balik (Hingga)</label>   
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                      <?= $form->field($model, 'tarikh_mohon_balik2')->widget(DatePicker::className(),
                              ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                              'options' => [ 'placeholder' => 'Pilih Tarikh ', 'onchange' => 'cal()', 'id' => 'tarikh_mohon_balik2' ]])->label(false);?>   
                    </div>
            </div> 

        </div> 
        
        <div class="col-md-12 col-sm-12 col-xs-12" style="color: green;">
            Sila isi ulasan anda seperti contoh berikut untuk kegunaan surat yang akan dijana oleh pengguna. Sila abaikan jika tidak ada ulasan.<br> *Cth: rekod kehadiran adalah tidak memuaskan
        </div>

        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'ulasan_bsm')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
        </div>
        
        <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Simpan' ,['class' => 'btn btn-primary','name' => 'simpan']) ?>
                    <a style="color: green; font-weight: bold"><?php echo $message;?></a>
                </div>
            </div>
    </div>
</div>

            <?php ActiveForm::end(); 
            Pjax::end();?>
