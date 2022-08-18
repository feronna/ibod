<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
error_reporting(0);
?>
<?php

//Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true ]]); ?>
<div> 
    <div class="x_panel"> 
        <div id="post" class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="flag">Status: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php echo
                $form->field($model, 'flag')->label(false)->widget(Select2::classname(), [
                    'data' => ['2' => 'Tidak Aktif'],
                    'options' => ['placeholder' => 'Pilih Status', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>
        
        <div id="post" class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan: </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'ulasan')->textArea(['maxlength' => true, 'rows' => 4, 'placeholder' => ''])->label(false); ?>
            </div>
        </div>
           
        <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('Hantar' ,['class' => 'btn btn-primary','name' => 'hantar']) ?>
                    <a style="color: green; font-weight: bold"><?php echo $message;?></a>
                </div>
            </div>
    </div>
</div>
            <?php ActiveForm::end(); 
//            Pjax::end();
            ?>

