<?php
 
use kartik\form\ActiveForm; 
?>  
<div class="x_panel"> 
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">FEEDBACK</p>
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
    <div class="x_content">     
        

        <div class="form-group"> 
            <div class="col-md-12 col-sm-12 col-xs-12"> 
                <?= $form->field($model, 'catatan')->textarea(['rows' => 6])->label(false); ?>
            </div>
        </div>
 

        <?php ActiveForm::end(); ?> 
    </div>
</div> 

