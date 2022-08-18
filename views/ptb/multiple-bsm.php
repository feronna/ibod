<?php
//use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

 
/* @var $this yii\web\View */
 
/* @var $modelCustomer app\modules\yii2extensions\models\Customer */
 
/* @var $modelsAddress app\modules\yii2extensions\models\Address */
 
 
$js = '
 
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
 
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
 
        jQuery(this).html("Address: " + (index + 1))
 
    });
 
});
 
 
jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
 
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
 
        jQuery(this).html("Address: " + (index + 1))
 
    });
 
});
 
';
 
 
$this->registerJs($js);
 
?>

    <?php echo $this->render('/ptb/_menu');?> 



<div class="customer-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    

    <div class="panel panel-default">
   
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsKakitangan[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'icno',
                    'new_dept',
                    'new_campus',
                    'justifikasi',
                    
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelsKakitangan as $i => $modelKakitangan): ?>
                
                
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Permohonan Pertukaran Tempat Bertugas</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelKakitangan->isNewRecord) {
                                echo Html::activeHiddenInput($modelKakitangan, "[{$i}]id");
                            }
                        ?>
                        

                        <div class="row">
					
                                                     <?=
                $form->field($modelKakitangan, "[{$i}]icno")->label(false)->  widget(Select2::classname(), [
                    'data' => $MultipleStaff,
                    'options' => ['placeholder' => 'Pilih Nama Kakitangan', 'class' => 'form-control col-md-7 col-xs-12', 'required' => true, 'message'=> 'error'],
                    'pluginOptions' => [
                        'initialize' => true,
                        'allowClear' => true
                    ],
                ]);
                ?>
                            
                            
                            
                            
						</div><!-- .row -->
                        <div class="row">
                                                               <?=
                $form->field($modelKakitangan, "[{$i}]new_dept")->label(false)->  widget(Select2::classname(), [
                    'data' => $MultipleDepartments,
                    'options' => ['placeholder' => 'Pilih Jabatan', 'class' => 'form-control col-md-7 col-xs-12', 'required' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                        </div><!-- .row -->
                 <div class="row">
                                                               <?=
                $form->field($modelKakitangan, "[{$i}]new_campus")->label(false)->  widget(Select2::classname(), [
                    'data' => $MultipleCampus,
                    'options' => ['placeholder' => 'Pilih Kampus', 'class' => 'form-control col-md-7 col-xs-12', 'required' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                        </div><!-- .row -->
                        
                        
                         <div class="row">
                                                               <?=
                $form->field($modelKakitangan, "[{$i}]justifikasi")->label(false)->  widget(Select2::classname(), [
                    'data' => $MultipleJustifikasi,
                    'options' => ['placeholder' => 'Pilih Justifikasi', 'class' => 'form-control col-md-7 col-xs-12', 'required' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                        </div><!-- .row -->
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Hantar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>