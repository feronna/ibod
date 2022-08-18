<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
error_reporting(0);
$this->title = ' ';
?>
<?php Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
     $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true ]]);
    ?>
<div class="tblkeluarga-search">

        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3" ><span class="required" style="color:red;"><b>*</b></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                   <input type="text"  class="form-control" name="fmyIcno" required="required" aria-required="true" aria-invalid="true" placeholder="Nombor IC / IC Number"></input>
                </div>
        </div>
        <div class="form-group text-center ">
                <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
        </div>

    <div class="form-group text-center" >

                <input type="radio" name="staffums" value="1" required="required">Staff UMS</input> &nbsp&nbsp
                <input type="radio" name="staffums" value="0" >Bukan Staff UMS</input>             
    </div>
    
    <div class="form-group text-center">
    <?= Html::submitButton('Tambah',['class' => 'btn btn-primary', 'name' => 'ums', 'value' => 'submit_1']) ?>
    </div>
    
</div>
<?php ActiveForm::end();  
Pjax::end(); ?>