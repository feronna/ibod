
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
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-search"></i> Carian', ['brp/index']) ?></li>
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['brp/view', 'ICNO' =>   $model->ICNO ]) ?></li>
        <li>Tambah Rekod BRP Pegawai</li>
    </ol>
</div>


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

              
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">Jenis BRP<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="Tblrscobrp[brpCd]" class="form-control" id="brpCd">
                        <?php foreach (app\models\brp\Brp::find()->all() as  $brp) { ?>
                        <option value="<?= $brp->brpCd ?>" data-foo="<?= $brp->brpBottomDesc ?>"><?= $brp->brpTitle ?> </option>
                    <?php } ?>
                    </select>
                </div>
            </div>
                
            
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Butir-butir perubahan atau lain-lain hal mengenai pegawai<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($tambah, 'remark')->textarea(['maxlength' => true, 'rows' => 4])->label(false); ?>
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
             
                             <?= $form->field($tambah, 'tarikh_mulai')->widget(DatePicker::className(),
                                  ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                                  ])->label(false);?>
                    </div>
                </div>

            
     
            
                   <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Hingga<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
             
                             <?= $form->field($tambah, 'tarikh_hingga')->widget(DatePicker::className(),
                                  ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                                  ])->label(false);?>
                    </div>
                </div>
            

            
              <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Lulus (Induksi)<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
             
                             <?= $form->field($tambah, 'tarikh_lulus')->widget(DatePicker::className(),
                                  ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
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
             
                             <?= $form->field($tambah, 'tarikh_surat')->widget(DatePicker::className(),
                                  ['clientOptions' => ['changeMonth' => true,'yearRange' => '1996:2099','changeYear' => true, 'format' => 'yyyy-mm-dd', 'autoclose' => true],
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

<script type="text/javascript">
   
   $("#brpCd").change(function(){
       
       var selected = $(this).find('option:selected');
       var remark = selected.data('foo'); 
      
       $("textarea#tblrscobrp-remark").val(remark);
   });

</script>

