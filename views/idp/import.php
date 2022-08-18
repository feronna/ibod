<?php 
//use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

echo $this->render('/idp/_topmenu'); 
?>
<div class="latihan-form"> 
    <div class="col-md-12"> 
        <div class="x_panel">
                <div class="x_title">
                    <h2>Muatnaik EXCEL Latihan</h2> 
                    <div class="clearfix"></div>
                </div>
            <div class="x_content">
            
    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
                <div class="form-group">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?= $form->field($modelImport,'fileImport')->fileInput()->label(false); ?>
                    </div>
                    <div>
                        <?= Html::submitButton('Muatnaik',['class'=>'btn btn-primary']);?>
                    </div>
                </div>

    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>