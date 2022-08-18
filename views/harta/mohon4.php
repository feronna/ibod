<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>

<div class="row">
<div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Pengakuan Pegawai</strong></h2>
                <div class="clearfix"></div>
            </div>
          
                  <div class="table-responsive">
                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                      
                      <div class="form-group">
                    <table>
                <tr>
                    <td class="col-sm-3 text-right">
                        <?= $form->field($mohon, 'status')->checkBox(['label' => '','data-size'=>'small', 'class'=>'bs_switch','margin-bottom:4px;', 'id'=>'checkbox1', 'onclick' =>"checkTerms()"]) ?>
                    </td>

                    <td class="col-sm-2 text-center">
                        <div style="width: 790px; height: 90px;border:2px solid burlywood">
                            <h5 style="color:black;" ><br> 
                           &nbsp;Saya mengesahkan bahawa segala maklumat yang diberikan adalah benar.<p>
                            </h5> 
                            <strong><p style="color:black;"><center>Tarikh Isytihar: <?php echo date('Y-m-d H:i:s'); ?> </p><br/> </strong></center>
                    </div>
                    </td>
                </tr>
            </table>
        
                   </div>
              
                   
                    <div class="ln_solid"></div>

               <div class="customer-form">  
                <div class="form-group" align="center">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
                    <br>
                    <?php // Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Hantar'), ['id'=> 'submitb', 'disabled'=> true,'class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']])?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
                </div>
            </div>  
                <?php ActiveForm::end(); ?>
                <!--form-->
            
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("foo").onchange = function() {
        if (this.selectedIndex!==0) {
            window.location.href = this.value;
        }        
    };
</script>

<script>
                 function checkTerms() {
                   // Get the checkbox
                   var checkBox = document.getElementById("checkbox1");
 
                   // If the checkbox is checked, display the output text
                   if (checkBox.checked === true){
                     document.getElementById("submitb").disabled = false;
                   } else {
                     document.getElementById("submitb").disabled = true;
                   }
                 }
                     </script>
