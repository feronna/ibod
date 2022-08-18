 <?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\hronline\GredJawatan;
use app\models\keselamatan\RefUnit;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile; 
use kartik\grid\GridView;
use app\widgets\TopMenuWidget;
use kartik\widgets\TimePicker;
error_reporting(0);
/* @var $this yii\web\View */
/* @var $model app\models\mohonjawatan\TblPermohonan */
/* @var $form ActiveForm */
$this->registerJs(
    "$('#save-draft-btn').on('click', function (e) {
    $.ajax({
       type: 'POST',
       url: draftUrl,
       data: $('#report-index').serialize()
    });      
})",
    'my-button-handler'
);
?>
<?= $this->render('/keselamatan/_topmenu') ?>

  <div class="control-label col-md-12"> 
    <div class="x_panel">
        
          <div class="x_title">
            <h2>Selenggara Senarai Syif</h2>
            
            </ul>
            <div class="clearfix"></div>
        </div>  

           <div class="x_content">
               
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                
               <div class="form-group">
                   <label class="control-label col-md-4 col-sm-6 col-xs-12">Unit Kawalan: <span class="required" style="color:red;">*</span>
                   </label>
                   <div class="col-md-6 col-sm-6 col-xs-12">
                       <?= $form->field($model, 'unit_name')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                   </div>
               </div>
            

  <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Kampus: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'kampus')->label(false)->widget(Select2::classname(), [
                        'data' => ['Kota Kinabalu' => 'Kota Kinabalu', 'Sandakan' => 'Sandakan', 'Labuan' => 'Labuan'],
                        'options' => ['placeholder' => 'Pilih Kampus', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "Dipersetujui"){
                        $("#tempoh").show();
                        }
                        else{
                        $("#tempoh").hide();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>                   </div>
            </div>               
                <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'url' => ['index']]) ?>
                </div>
            </div>
          
            <?php ActiveForm::end(); ?>
           </div>
                  </div>