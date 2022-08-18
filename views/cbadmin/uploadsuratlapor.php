

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
error_reporting(0);
?>
<?php

Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true ]]); ?>
<div > 
    <div class="x_panel"> 
        <div class="x_title">
            <h2><i class="fa fa-upload"></i><strong> Muatnaik Surat Makluman</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="form-group" id="tempoh" ><br><br>
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                <?= $form->field($dokumen, 'tajuk')->textInput()->label(false) ?>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12"><br>
                <?= $form->field($dokumen, 'file')->fileInput()->label(false) ?>
            </div>
            </div>
            <?php if($dokumen->dokumen!= ''){?>
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Surat Tawaran : <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($dokumen->dokumen), true); ?>" target="_blank" ><i></i><u>Document.pdf</u></a><br>
                    
                </div>
                </div>
            <?php }?>
            
           
         <div class="ln_solid"></div>
            <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary', 
                    ]) ?>
                <a style="color: green; font-weight: bold"><?php echo $message;?></a>
            </div>
        </div>
        </div>
    </div>
            <?php ActiveForm::end(); 
            Pjax::end();?>

