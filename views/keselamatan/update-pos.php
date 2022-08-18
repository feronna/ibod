<?php

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
            <h2><strong>Kemaskini Pos Kawalan</h2>
            <div class="clearfix">
        <div class="x_content">

            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Pos Kawalan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                <?= $form->field($model, 'pos_kawalan')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>

                </div>
            </div>
           
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Pecahan Pos Kawan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                <?= $form->field($model, 'pecahan_pos')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>

                </div>
            </div>
           
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Status: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                <?=
                         $form->field($model, 'active')->label(false)->widget(Select2::classname(), [
                            'data' => ['1' => 'Aktif', '0' => 'Tidak Aktif'],
                            'options' => ['placeholder' => 'Pilih Bulan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                </div>
            </div>
           

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Add Staff', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <br>
        </div>
</div>
        </div>