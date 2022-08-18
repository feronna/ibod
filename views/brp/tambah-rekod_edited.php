
<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\brp\Brp;
use yii\helpers\Url;
use app\models\harta\TblKeteranganHarta;
use kartik\depdrop\DepDrop;
use kartik\number\NumberControl;
// as a widget
/* @var $form CActiveForm */
use app\models\harta\TblSenarai;
use dosamigos\datepicker\DatePicker;
?>

<div class="row">
<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2>Tambah Rekod BRP Pegawai</h2>
        
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
           
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

              
<!--            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">Jenis BRP<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="Tblrscobrp[brpCd]" class="form-control" id="brpCd">
                        <?php foreach (app\models\brp\Brp::find()->all() as  $brp) { ?>
                        <option value="<?= $brp->brpCd ?>" data-foo="<?= $brp->brpBottomDesc ?>"><?= $brp->brpTitle ?> </option>
                    <?php } ?>
                    </select>
                </div>
            </div>-->
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">Jenis BRP<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
            <?= Select2::widget([
                        'name' => 'jenis_penamatan',
                        'data' => ArrayHelper::map(app\models\brp\Brp::find()->orderBy(['brpCd' => SORT_ASC])->all(), 'brpCd', 'brpTitle'),
                        'value' => $titlebrp,
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'jenis($(this).val())'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    
                    ]); ?>
                    </div>
            </div>
                
            
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Butir-butir perubahan atau lain-lain hal mengenai pegawai<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="x_panel"
                          style="color:black;line-height: 2em">
                    <?php
                    $brp =Brp::find()->where(['brpCd' =>$titlebrp])->one();
                    $array = explode('_', $brp->brpBottomDesc);
                    $formy = explode(',', $brp->brpForm);
                    $r='';
                    $f=0;
                    for ($i=0;$i<=count($array);$i++){
                    if($array[$i] !='' && $array[$i] !='.'){
                            $r = $r.$array[$i];
//                            if (\app\models\brp\RefCodebrpdesc::find()->where(['title' => $formy[$f]])->exists()) {
//                                $r = $r.eval(\app\models\brp\RefCodebrpdesc::find()->where(['title' => $formy[$f]])->one()->code);
//                            }
//                            else {
                            if($i!=(count($array)-1)){
                            $r = $r.Brp::Brp($formy[$f], $ICNO);}
//                            }
                            
                            $f++;
                        }
                    }
                    
                    $tambah->remark=$r;
                    
                    echo $form->field($tambah, 'remark')->textArea(['maxlength' => true, 'rows' => 4])->label(false);
                        
                    ?></div>
                </div>
            </div>
            
            
               <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">Jawatan<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($tambah, 'jawatan_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\GredJawatan::find()->orderBy(['fname' => SORT_ASC])->all(), 'id', 'fname'),
                        'options' => ['placeholder' => 'Pilih Jawatan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            
               <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mulai daripada / Kuatkuasa<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
               <?= $form->field($tambah, 'tarikh_mulai')->widget(DatePicker::classname(), [
                            'value' => date('d-m-Y'),
                            'template' => '{addon}{input}',
                            'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-m-dd'
                            ]
                        ])->label(false);?>
                    </div>
                </div>
            
               <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Hingga<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($tambah, 'tarikh_hingga')->widget(DatePicker::classname(), [
                            'value' => date('d-m-Y'),
                            'template' => '{addon}{input}',
                            'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-m-dd'
                            ]
                        ])->label(false);?>
                    </div>
                </div>
            
               <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lulus (Induksi)<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($tambah, 'tarikh_lulus')->widget(DatePicker::classname(), [
                            'value' => date('d-m-Y'),
                            'template' => '{addon}{input}',
                            'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-m-dd'
                            ]
                        ])->label(false);?>
                    </div>
                </div>
       
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Rujukan Surat</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($tambah, 'rujukan_surat')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            
               <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Surat<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
               <?= $form->field($tambah, 'tarikh_surat')->widget(DatePicker::classname(), [
                            'value' => date('d-m-Y'),
                            'template' => '{addon}{input}',
                            'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-m-dd'
                            ]
                        ])->label(false);?>
                    </div>
                </div>
            
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Pencen<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($tambah, 'isPencen')->label(false)->widget(Select2::classname(), [
                                  'data' => [1 =>'Berpencen', 0 => 'Tak Berpencen', 2 => 'Peruntukan Terbuka'],
                                'options' => ['placeholder' => 'Sila Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                    </div>
                </div>
          
            
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Gaji Pokok Sebulan</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                     <?= $form->field($tambah, 'gaji_sebulan')->widget(NumberControl::classname(), [
                        'name' => 'gaji_sebulan',
                        'pluginOptions'=>[
                        'initialize' => true,],
                        'maskedInputOptions' => [
                        'prefix' => 'RM',
                        'rightAlign' => false
                        ],
                        'options' => $saveOptions,
                        'displayOptions' => [
                        'placeholder' => 'Contoh: RM223437.04'],
                        ])->label(false);
                     ?>
                </div>
            </div>

     

            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <!--form-->
        </div>
    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

<!--<script type="text/javascript">
   
   $("#brpCd").change(function(){
       
       var selected = $(this).find('option:selected');
       var remark = selected.data('foo'); 
      
       $("textarea#tblrscobrp-remark").val(remark);
   });

</script>-->
<script>
        function jenis(val){
            var icno = '<?= $ICNO?>';
            if (['20','21','22','23'].includes(val)){
                var curl = 'http://localhost/staff/web/brp/view-rekod-anugerah?ICNO='+icno;
            }
            
            else if (['27','28','29','30'].includes(val)){
                var curl = 'http://localhost/staff/web/brp/view-rekod-bersara?ICNO='+icno;
            }
            
            else {
                var url = window.location.href;
                var curl = new URL(url);
                curl.searchParams.set("titlebrp", val);}
                window.location.href = curl;
            }
</script>
