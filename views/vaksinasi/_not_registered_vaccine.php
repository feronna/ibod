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

        <div class="form-group text-center">
                <p><h3>STATUS VAKSIN COVID-19</h3></p>
                <p>Tandakan ruangan yang berkaitan</p>
        </div>
        <div class="form-group text-center ">
                <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
        </div>

    <div class="form-group text-center" >

                <input type="radio" name="statusvaksin" value="1" required="required"><span class="required" style="color:green;"> Sudah Terima Vaksin</span></input> &nbsp&nbsp
                <input type="radio" name="statusvaksin" value="0" ><span class="required" style="color:red;"> Belum Terima Vaksin</span></input>             
    </div>
    
    <div class="form-group text-center">
    <?= Html::submitButton('Seterusnya',['class' => 'btn btn-primary', 'name' => 'ums', 'value' => 'submit_1']) ?>
    </div>
    
</div>
<?php ActiveForm::end();  
Pjax::end(); ?>