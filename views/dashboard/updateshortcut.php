<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\hronline\Department;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
error_reporting(0);
$bil=1;
echo \app\widgets\TopMenuWidget::widget(['top_menu' => [1,2,3,4, 1179, 1180]]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

        <div class="row"> 
            <div class="x_panel">
                <div class="x_title">
                    <div class="clearfix"></div>
                </div> <br>
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">URL <span class="required" style="color : red"> *</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-6"><div id="id" type="button"></button></div>
                        
                        <?=
                    $form->field($model, 'url')->label(false)->textInput();
                    ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Name<span class="required" style="color : red"> *</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-6"><div id="id" type="button"></button></div>
                        
                    <?=
                    $form->field($model, 'name')->label(false)->textInput();
                    ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">For<span class="required" style="color : red"> *</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-6"><div id="id" type="button"></button></div>
                        
                        <?=
                    $form->field($model, 'role')->label(false)->widget(Select2::classname(), [
                        'data' => ['all' => 'All Staff', 'staff' => 'By Individu'],
                        'options' => ['required' => true,'placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:
                        if ($(this).val() == "dept"){
                        $("#dept").show();
                        $("#staff").hide();
                        }
                        else if($(this).val() == "staff"){
                        $("#staff").show();
                        $("#dept").hide();
                        }else{
                        $("#staff").hide();
                        $("#dept").hide();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                    </div>
                </div>
                
                <div id="dept" style="display: none" class="form-group">
                    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Department
                        <span class="required" style="color : red"> *</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <?=
                    Select2::widget([
                        'name' => 'dept',
                        'data' => ArrayHelper::map(Department::find()->where(['isActive' => 1])->all(), 'id', 'shortname'),
                        'options' => ['multiple' => true, 'placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'
                           ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?></div>
                </div>
                
                <div id="staff" style="display:none" class="form-group">
                    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Staff's name</label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <?=
                    Select2::widget([
                        'name' => 'staff',
                        'data' => ArrayHelper::map(\app\models\hronline\TblprcobiodataSearch::find()->where(['!=', 'Status', 6])->all(), 'ICNO', 'CONm'),
                        'options' => ['multiple' => true, 'placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'
                           ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?></div>
                </div>
                
                <div class="form-group">
                    <div align="center" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?= Html::submitButton('<i class="fa fa-paper-plane"></i> Submit', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
        </div>
<?php ActiveForm::end(); 
?>



