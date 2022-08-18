

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
error_reporting(0);
?>
<?php

Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true ]]); ?>
<div > 
    <div class="x_panel"> 
        <div class="x_title">
            <h2>Upload Document</h2>
            <div class="clearfix"></div>
        </div>
        <div class="form-group" id="tempoh" ><br><br>
            <div class="col-md-6 col-sm-6 col-xs-12"><br>
                <?= $form->field($model, 'file[]')->fileInput(['multiple'=>true])->label(false) ?>
            </div>
            </div>
            
            <div id="viewdokumen" class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Uploaded : <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <?php 
            foreach($dokumen as $dokumen){
            if($dokumen){?>
                    <?= Html::a($dokumen->tajuk, yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($dokumen->dokumen), true), ['target' => '_blank']) ?>
                    <button class="delete" value="<?=$dokumen->id?>"><i class="fa fa-trash"></i></button>
                    <br>
                <?php }}?>
                </div>
                
                </div>
            
           
         <div class="ln_solid"></div>
            <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 
                    ]) ?>
                <a style="color: green; font-weight: bold"><?php echo $message;?></a>
            </div>
        </div>
        </div>
    </div>
<script type="text/javascript">
$('.delete').click(function() {
 var filename = $(this).attr('value');
// alert(filename);
 $.ajax({
    url: 'deletedokumen?id='+filename,
    success: function(data) {
           $('#viewdokumen').load('uploadsurat?id=<?=id?>'+' #viewdokumen');
    }
});
});
</script>
            <?php ActiveForm::end(); 
            Pjax::end();?>