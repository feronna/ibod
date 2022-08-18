<?php
$this->registerJs('$(function () {
  $(\'[data-toggle="tooltip"]\').tooltip()
})');
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\hronline\Negara;
use kartik\number\NumberControl;

use wbraganca\dynamicform\DynamicFormWidget;

error_reporting(0); 
$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});

jQuery(".dynamicform_wrapper1").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper1 .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});
';

$this->registerJs($js);
$title = $this->title = 'Pembiayaan / Pinjaman';
?>


<p align ="right">
               
                <?php echo Html::a('Kembali',['tambah-biasiswa', 'id'=>$iklan->id], ['class' => 'btn btn-primary btn-sm']); ?>  
    
            </p>
<div class="col-xs-12 col-md-12 col-lg-12">

<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | BAHAGIAN SUMBER MANUSIA<br/><u> 
     PERMOHONAN PENGAJIAN LANJUTAN SUB KEPAKARAN
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>

</div>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
<div class="col-xs-12 col-md-12 col-lg-12">
   
 <div class="x_panel">
     
        <div class="x_content">
            
        <div class="customer-form"> 
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'limit' => 6, // the maximum times, an element can be added (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $modelsAddress[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                       'nama_tajaan',
                       'bentukBantuan',
                       'amaunBantuan'
                    ],
                ]); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>
                    <i class="fa fa-plus-circle"></i> Tajaan Luar
                    <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i>Tambah </button>
                </h4>
            </div>
            <div class="panel-body">
                <div class="container-items"><!-- widgetBody -->
                <?php foreach ($modelsAddress as $i => $modelAddress): ?>
                    <div class="item panel panel-default"><!-- widgetItem -->
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left">Tajaan Luar</h3>
                            <div class="pull-right">
                                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                                // necessary for update action.
                                if (! $modelAddress->isNewRecord) {
                                    echo Html::activeHiddenInput($modelAddress, "[{$i}]id");
                                }
                            ?>
                            <?php // $form->field($modelAddress, "[{$i}]icno")->textInput(['maxlength' => true]) ?>
                          
                            <div class="col-sm-6">
                                 <label> Nama Agensi / Tajaan </label>
                                    <?= $form->field($modelAddress, "[{$i}]nama_tajaan")->textInput(['maxlength' => true])->label(false) ?>
                                </div>

                            <div class="col-sm-6">
                                <label> Negara </label>
                           
                         <?= $form->field($modelAddress, "[{$i}]CountryCd")->widget(Select2::classname(), 
                        ['data' => ArrayHelper::map(Negara::find()->orderBy(['CountryCd' => SORT_ASC,])->all(), 'CountryCd', 'Country'),
                        'options' => [
                            'placeholder' => 'Pilih Negara'],
                    ])->label(false); ?>
                      
                            </div>
<!--<script>
    $(document).ready(function() {
    $('.testing').select2();
});
</script>-->
                                       
                               
                            
                                                       

                                    <?php // $form->field($modelAddress, "[{$i}]umur")->textInput(['maxlength' => true]) ?>
                                </div>

                            </div>
                        </div>
                <?= $this->render('test',['model' => $model,
            'modelsAddress1' => (empty($modelsAddress)) ? [new TblBiasiswa] : $modelsAddress,]) ?>
                    </div>
            
                <?php endforeach; ?>
                </div>
            
         
            </div> 
          
        
        <?php DynamicFormWidget::end(); ?>
  <div class="form-group">
            
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
        
           
        </div>

            </div> 
 </div></div>
      

        <?php ActiveForm::end(); ?>
  
  



