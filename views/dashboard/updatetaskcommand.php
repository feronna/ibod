<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

?><?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1,2,3,4, 1179, 1180]]) ?>
<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Add pending task command</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
    <div class="x_content">
        
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); 
            ?>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Name :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'name')->label(false); ?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Url :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'url')->label(false)->widget(Select2::classname(), [
                                'data' => $list_controllers,
                                'options' => [
                                    'placeholder' => 'Pilih Url', 
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    //'selected'    => 2,
                                    'id' => 'url',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'tags' => true,
                                ],
                            ]); ?>
            </div>
        </div>
        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icon_id">Icon</label>
                        <div class="col-md-6 col-sm-6 col-xs-10">
                             <?=
                            $form->field($model, 'icon')->label(false)->widget(Select2::classname(), [
                                'data' => \yii\helpers\ArrayHelper::map(\app\models\system_core\RefIcon::find()->all(), 'icon_label', 'icon_label'),
                                'options' => [
                                    'placeholder' => 'Pilih Icon', 
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    //'selected'    => 2,
                                    'id' => 'icon_id',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                    </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Code for count :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'command')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">
            </label>
        <div class="col-md-6 col-sm-6 col-xs-12" style="color: green; margin-top: -15px;">
                Rule: <br>
                1. Must return value<br>
                2. Must contain $icno<br>
                Example : \app\models\kontrak\Kontrak::find()->where(['icno' => $icno])->count();
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button class="btn btn-primary" type="reset">Reset</button>
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'data'=>['confirm'=>'Proceed?']]) ?>
            </div>
        </div>
            <?php ActiveForm::end();?>
    </div>
    </div>
    </div>

