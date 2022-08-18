<?php

use app\models\hronline\Campus;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\RefUnit;
?>



        <div class="x_title">
            <h2><strong>Kemaskini Maklumat Staf</h2>
            <div class="clearfix">
        <div class="x_content">

            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Staff Name: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'staff_icno')->label(false)->widget(Select2::classname(), [
//                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->w, 'ICNO', 'CONm'),
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['status' => 1])->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => '-- Pilih Staf --', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'disabled' => true,
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Unit: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'unit_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(RefUnit::find()->where(['active' => 1])->all(), 'id', 'unit_name'),
                        'options' => ['placeholder' => 'Pilih Pos Kawalan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
             
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Campus: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'campus_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Campus::find()->where(['IN','campus_id',['1','2','3']])->all(), 'campus_id', 'campus_name'),
                        'options' => ['placeholder' => 'Pilih Campus', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>  
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">SKB/STARS: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'isExcluded')->label(false)->widget(Select2::classname(), [
                        'data' => ['0' => 'SKB','1' => 'STARS'],
                        'options' => ['placeholder' => 'Pilih Pos Kawalan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>  
            
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Update', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <br>
        </div>
</div>
        </div>