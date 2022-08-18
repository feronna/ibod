<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;   
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata; 
use kartik\date\DatePicker;

error_reporting(0);
?> 
<?= $this->render('menu') ?> 
 
<?php  $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left','enctype' => 'multipart/form-data']]); ?>
   
<div class="row"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><i class="fa fa-list"></i><strong> AMALAN BAIK </strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
            
    <table class="table table-sm table-bordered" >
        <thead> 
        <th scope="col" colspan=8" width="100%" style="background-color:lightgrey;"><center>AMALAN BAIK</center></th>

                <tr>
                        <td valign="2">Rujukan Fail:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="3">
                        <?= $form->field($model, 'rujukan_fail')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ->label(false);?> 
                         
                        </td>
                        
                        <td valign="3">JAFPIB :<span class="required" style="color:red;">*</span></td> 
                        <td colspan="4">
                        <?= $form->field($dept, 'dept')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ->label(false);?>  
                        </td>
                        </td>  
                </tr> 
        </thead>
        </table>

        <table class="table table-sm table-bordered" >
            <thead>
            <th scope="col" colspan=8" width="30%" style="background-color:lightgrey;"><center> </center></th>
                  
            
            <tr> 
                <td colspan="8"><strong>Amalan Baik <span class="required" style="color:red;">*</span></strong></td>  
                </tr> 

                <tr>
                <td colspan="8">
                <?= $form->field($model, 'best_practice')->textarea(array('rows'=>15,'cols'=>5)) ->label(false);?>   
                </td>  
            </tr>  
            </thead>
        </table>
        
        <div class="customer-form">  
                <div class="form-group" align="left">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5"> 
                    <br>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    <button class="btn btn-primary" type="reset">Reset</button>
                </div>
                </div>
        </div>

    </div>
</div>
     
</div>  
      
    </div>
    </div>
</div> <?php ActiveForm::end(); ?>



 


