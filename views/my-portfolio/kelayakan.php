<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii;
use yii\helpers\ArrayHelper;
?>

<div class="row">
<div class="col-md-12">
   <div class="x_panel">
        <div class="x_title">
            <h2>Kelayakan Akademik</h2>
            <p align="right" >
                    <?php echo Html::a('Kembali', ['/my-portfolio/lihat-kelayakan', 'id' => $portfolio->id], ['class' => 'btn btn-primary btn-sm']); ?>  
               
                </p>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
           
<div class="customer-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    

   
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 15, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelKelayakan[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'kompetensi',
                    
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelKelayakan as $i => $modelKelayakan): ?>
                
                
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                
                   
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelKelayakan->isNewRecord) {
                                echo Html::activeHiddenInput($modelKelayakan, "[{$i}]id");
                            }
                        ?>
                        

                        <div class="row">
		  <div>KELAYAKAN AKADEMIK / IKHTISAS<span class="required" style="color:red;">*</span>			
                  <?=
                    $form->field($modelKelayakan, "[{$i}]ikhtisas")->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\PendidikanTertinggi::find()->orderBy(['HighestEduLevel' => SORT_ASC])->all(), 'HighestEduLevelCd', 'HighestEduLevel'),
                        'options' => ['placeholder' => 'Pilih Tahap', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?>           
                </div><!-- .row -->
                  <div>BIDANG<span class="required" style="color:red;">*</span>			
                    <?= $form->field($modelKelayakan, "[{$i}]bidang")->textarea(['maxlength' => true, 'placeholder' => 'Contoh: Sains Komputer dengan Kepujian (Kejuruteraan Perisian), UMS'])->label(false)?>
                           
                </div>
                </div>
                </div>
                </div>
            <?php endforeach; ?>
            </div>
          
                
            
            <?php DynamicFormWidget::end(); ?>
        </div>
   
    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
        
        
        
        
            </div>
        </div>
</div>
</div>
