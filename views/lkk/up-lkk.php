<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\pengesahan\TblPtm */
/* @var $form yii\widgets\ActiveForm */
error_reporting(0);
?>
<script type="text/javascript">
        function GetDays(){
                var dropdt = new Date(document.getElementById("lanjutanedt").value);
                var pickdt = new Date(document.getElementById("lanjutansdt").value);
                return parseInt((dropdt - pickdt) / (24 * 3600 * 1000));
        }      
        function cal(){
        if(document.getElementById("lanjutanedt")){
            document.getElementById("tempoh").value=GetDays();
        }  
        }
        
</script>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5 style='color:red'> <strong><center>PLEASE SUBMIT YOUR COMMENT</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
      
       
        <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">COMMENT:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  
                    <td><?= $form->field($model, 'd_comment')->textarea(['maxlength' => true, 'rows' => 8]) ->label(false);?> 

                </div>
</div>
        
        

        
  
       
      
         
        
        
         
        
         
        
         

        
        

    </div>
    </div>
</div>
</div>


  
        
        
        
        
        
      
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('SUBMIT', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>

<?php ActiveForm::end(); ?>




