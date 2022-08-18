<?php 
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\hronline\Negara;
use kartik\number\NumberControl;

?>
<?php $form1 = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>
<?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper1', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items1', // required: css class selector
                    'widgetItem' => '.item1', // required: css class
                    'limit' => 6, // the maximum times, an element can be added (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item1', // css class
                    'deleteButton' => '.remove-item1', // css class
                    'model' => $modelsAddress1[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                       'nama_tajaan',
                       'bentukBantuan',
                       'amaunBantuan'
                    ],
                ]); ?>

<!--        <div class="panel panel-default">-->
<!--            <div class="panel-heading">-->
                <h4>
                    <button type="button" class="add-item1 btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i>Tambah </button>
                </h4>
<!--            </div>-->
                <div class="container-items1"><!-- widgetBody -->
                <?php foreach ($modelsAddress1 as $i => $modelAddress1): ?>
                    <div class="item1 panel panel-default"><!-- widgetItem -->
                        
                        <div class="panel-body">
                            <?php
                                // necessary for update action.
                                if (! $modelAddress1->isNewRecord) {
                                    echo Html::activeHiddenInput($modelAddress1, "[{$i}]id");
                                }
                            ?>
                            <?php // $form->field($modelAddress, "[{$i}]icno")->textInput(['maxlength' => true]) ?>
                          

                                  <div class="col-sm-6">
                                      
                                       <label> Bentuk Tajaan </label>
                                    <?php
                                 echo $form1->field($modelAddress1, "[{$i}]BantuanCd")->dropDownList
                                 ([
                                     
                                     '6' => 'Yuran Pengajian', '7' => 'Tiket Penerbangan', '8'=>'Sara Hidup'],['prompt'=>'Bentuk Tajaan'])->label(false);
?>
                                  </div>
                            
                            <div class="col-sm-6">
                                 <label> Amaun Tajaan (RM) </label>
                                 <?=
                    $form1->field($modelAddress1, "[{$i}]amaunBantuan")->widget(NumberControl::classname(), [
                         'name' => 'amaunBantuan',
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
                                    <?php // $form->field($modelAddress, "[{$i}]umur")->textInput(['maxlength' => true]) ?>
                     


<!--<script>
    $(document).ready(function() {
                                    <?php // $form->field($modelAddress, "[{$i}]umur")->textInput(['maxlength' => true]) ?>
                                </div>

                            </div>
                        </div>
                    </div>
            
               
                </div>
            
         
            </div> 
             <?php endforeach; ?>
</div><!-- .panel --></div></div></div>
        
        <?php DynamicFormWidget::end(); ?>

        <?php ActiveForm::end(); ?>
  