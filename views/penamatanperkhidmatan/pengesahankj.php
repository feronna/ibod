<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
error_reporting(0);
$bil=1;
?>

<?= $this->render('_topmenu') ?><?= $this->render('_maklumatpemohon',['model'=> $model]) ?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>

        <div class="row">  
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Pengesahan Ketua JFPIB </strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <i>[Tarikh terakhir dikemaskini : <?= $model->tarikh_kj?>]</i>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            
            <?php if($model->tarikh_kj){?>
            <div class="form-group">
                <?= $model->statuspengesahankj?>
            </div>
            <?php } else{?>
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"><span style="color: red" class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'status_kj')->label(false)->widget(Select2::classname(), [
                        'data' => ['1' => 'DILULUSKAN', '0' => 'DITOLAK'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "1"){
                        $("#form").show();
                        }
                        else{
                        $("#form").hide();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
            </div>
        </div>
        </div>

         
            <div class="form-group" align="center">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
            <?php ActiveForm::end(); ?>


