

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
error_reporting(0);
?>
<?php

Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true ]]); ?>
<div>
    <a class="btn btn-primary" href="<?= Url::to('@web/'.'kontrakakademik/update?id='.$model->id.'&action_id=1', true); ?>" target="_blank" >Send back to Applicant</a>
    <a class="btn btn-primary" href="<?= Url::to('@web/'.'kontrakakademik/update?id='.$model->id.'&action_id=2', true); ?>" target="_blank" >Send back to Head of Program</a>
    <a class="btn btn-primary" href="<?= Url::to('@web/'.'kontrakakademik/update?id='.$model->id.'&action_id=3', true); ?>" target="_blank" >Send back to Head of Department</a>
                               
    <div class="x_panel"> 
        <div class="x_title">Update</div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Head of Program
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                    $form->field($model, 'ver_by')->label(false)->widget(Select2::classname(), [
                        'data' => $listname,
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Head of Department
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?=
                    $form->field($model, 'app_by')->label(false)->widget(Select2::classname(), [
                        'data' => $listname,
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
            </div>
        </div>
		
		<div class="form-group">
            <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Mesyuarat
            </label>
            <div class="col-md-1 col-sm-1 col-xs-12">
                <?= $form->field($model, 'sesi_id')->textInput([
                                 'type' => 'number','placeholder' => 'Bil'
                            ])->label(false); ?>
            </div>
			<div class="col-md-2 col-sm-2 col-xs-12">
				<?= $form->field($model, 'tahun_sesi')->textInput([
                                 'type' => 'number','placeholder' => 'Tahun'
                            ])->label(false); ?>
			</div>
        </div>
		
            <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 
                    ]) ?>
                <a style="color: green; font-weight: bold"><?php echo $message;?></a>
            </div>
        </div>
        </div>
    </div>
            <?php ActiveForm::end(); 
            Pjax::end();?>