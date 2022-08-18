<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;


?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>


<div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        
     <div class="x_title">
      <h2><i class="fa fa-pencil-square"></i>&nbsp;<strong>Rekod Kes : Sila Pilih Jenis Rekod /</strong></h2>
      <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
        <div class="x_content">
            <div class="form-group row">
            <label class="control-label col-md-3 col-sm-3  col-md-offset-1">JENIS PERMOHONAN</label>
            <div class="col-md-4 col-sm-4 ">
            <select class="form-control"id="foo">
            <option>--Pilih Rekod--</option>
            <option value="../tatatertib-staf/rekod-kes ">Rekod Kes Kakitangan</option>
            <option value="../tatatertib-staf/rekod-kes-batch ">Rekod Kes Batch</option>
             
            </select>
            </div>
            </div>
         
        </div> 
    </div>
 </div>
</div>
        
        
        
 <div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">       
        
        <div class="x_title">
            <h2>Rekod Kes Kakitangan</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            
            
           
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
          
            
               
            
            
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Pegawai<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($rekod, 'icno')->label(false)->widget(Select2::classname(), [
                        'data' => $biodataKakitangan,
                        'options' => ['placeholder' => 'Pilih Staf', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            
           
            
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Rujukan Kes<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($rekod, 'kes')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
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

     <script>
    document.getElementById("foo").onchange = function() {
        if (this.selectedIndex!==0) {
            window.location.href = this.value;
        }        
    };
</script>