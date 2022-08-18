<?php
 
use kartik\form\ActiveForm;  
?>   


<div class="x_panel">
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">APPROVAL STATUS</p> 
        <div class="clearfix"></div>
    </div>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
<div class="x_content">   
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Name (Dean's): 
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12"> 
            <?= $model->biodataChief? $model->biodataChief->CONm:'-' ; ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Date: 
        </label>
        <div class="col-md-3 col-sm-3 col-xs-12"> 
            <?= $model->kj_datetime? $model->kj_datetime:'-' ; ?>
        </div>
    </div> 
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-3 col-sm-3 col-xs-12"> 
            <?= $form->field($model, 'kj_status')->radioList(array('1' => 'Approve', 2 => 'Reject'))->label(false); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Comment: <span class="required" style="color:red;">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">  
            <?= $form->field($model, 'kj_ulasan')->textarea(['rows' => 6])->label(false);?>
        </div>  
    </div>   
    <?php ActiveForm::end(); ?> 
</div>
</div>   
</div>  
