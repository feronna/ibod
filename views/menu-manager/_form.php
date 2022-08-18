<?php

$this->registerJs('$(function () {
  $(\'[data-toggle="tooltip"]\').tooltip()
})');


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\system_core\RefIcon;
use kartik\widgets\SwitchInput;
use app\widgets\TopMenuWidget;
?>
<?= TopMenuWidget::widget(['top_menu' => [1,2,3,4, 1179, 1180]]) ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-plus-circle"></i>&nbsp;Tambah Controller/Action</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                
                <div class="customer-form">
                    
                <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['class' => 'form-horizontal']]); ?>
                <div class="row">
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="label">Label</label>
                        <div class="col-md-6 col-sm-6 col-xs-10">
                            <?= $form->field($modelCustomer, 'label')->textInput(['maxlength' => true])->label(false) ?>
                        </div>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
                           title="Title menu"></i>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="url">Url</label>
                        <div class="col-md-6 col-sm-6 col-xs-10">
                             <?=
                            $form->field($modelCustomer, 'url')->label(false)->widget(Select2::classname(), [
                                'data' => $list_controllers,
                                'options' => [
                                    'placeholder' => 'Pilih Url', 
                                    //'class' => 'form-control col-md-7 col-xs-12',
                                    //'selected'    => 2,
                                    'id' => 'url',
                                    ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'tags' => true
                                ],
                            ]);
                        ?>
                    </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icon_id">Icon ID</label>
                        <div class="col-md-6 col-sm-6 col-xs-10">
                             <?=
                            $form->field($modelCustomer, 'icon_id')->label(false)->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(RefIcon::find()->all(), 'id', 'icon_label'),
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="visible">Visible</label>
                        <div class="col-md-6 col-sm-6 col-xs-10">
                            <?= $form->field($modelCustomer, 'visible')->textarea(['rows' => '6', 'placeholder' => 'Kasi biar klo teda', 'style' => 'resize:none'])->label(false) ?>
                        </div>
                        <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
                           title="Letak PHP function, cth: (1 === 3)"></i>
                    </div>
                    
                    <?php
                        // necessary for update action.
                        if (! $modelCustomer->isNewRecord) {?>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status</label>
                                <div class="col-md-6 col-sm-6 col-xs-10">
                                    <?= $form->field($modelCustomer, 'status')->widget(SwitchInput::classname(), [
                                        'pluginOptions' => [
                                            'onText' => 'Enable',
                                            'offText' => 'Disable',
                                            'size' => 'small',
                                            'onColor' => 'success',
                                            'offColor' => 'danger',
                                        ]
                                    ])->label(false) ?>
                                </div>
                            </div>
                        <?php }
                    ?>
                    
                </div>

            <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        'limit' => 20, // the maximum times, an element can be cloned (default 999)
                        'min' => 0, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $modelsAddress[0],
                        'formId' => 'dynamic-form',
                        'formFields' => [
                            'label',
                            'url',
                            'icon_id',
                        ],
                    ]); ?>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>
                                Tambah Action 
                                <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Add</button>
                            </h4>
                        </div>
                        <div class="panel-body">
                            <div class="container-items"><!-- widgetContainer -->
                            <?php foreach ($modelsAddress as $i => $modelAddress): ?>
                                <div class="item panel panel-default"><!-- widgetBody -->
                                    <div class="panel-heading">
                                        <h3 class="panel-title pull-left">Action</h3>
                                        <div class="pull-right">
                                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="panel-body">
                                        <?php
                                            // necessary for update action.
                                            if (! $modelAddress->isNewRecord) {
                                                echo Html::activeHiddenInput($modelAddress, "[{$i}]id");
                                            }
                                        ?>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="label">Label</label>
                                            <div class="col-md-6 col-sm-6 col-xs-10">
                                                <?= $form->field($modelAddress, "[{$i}]label")->textInput(['maxlength' => true])->label(false) ?>
                                            </div>
                                            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
                                            title="Title action"></i>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ur2">Url</label>
                                            <div class="col-md-6 col-sm-6 col-xs-10">
                                                 <?=
                                                $form->field($modelAddress, "[{$i}]url")->label(false)->widget(Select2::classname(), [
                                                    'data' => $list_controllers,
                                                    'options' => [
                                                        'placeholder' => 'Pilih Url', 
                                                        //'class' => 'form-control col-md-7 col-xs-12',
                                                        //'selected'    => 2,
                                                        //'id' => 'url2',
                                                        ],
                                                    'pluginOptions' => [
                                                        'allowClear' => true,
                                                        'tags' => true
                                                        
                                                    ],
                                                ]);
                                            ?>
                                        </div>
                                        </div>
                                        
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="icon2">Icon ID</label>
                                            <div class="col-md-6 col-sm-6 col-xs-10">
                                                 <?=
                                                $form->field($modelAddress, "[{$i}]icon_id")->label(false)->widget(Select2::classname(), [
                                                    'data' => ArrayHelper::map(RefIcon::find()->all(), 'id', 'icon_label'),
                                                    'options' => [
                                                        'placeholder' => 'Pilih Icon', 
                                                        //'class' => 'form-control col-md-7 col-xs-12',
                                                        //'selected'    => 2,
                                                        //'id' => 'url2',
                                                        ],
                                                    'pluginOptions' => [
                                                        'allowClear' => true
                                                    ],
                                                ]);
                                            ?>
                                        </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="visible2">Visible</label>
                                            <div class="col-md-6 col-sm-6 col-xs-10">
                                                <?= $form->field($modelAddress, "[{$i}]visible")->textarea(['rows' => '6', 'placeholder' => 'Kasi biar klo teda', 'style' => 'resize:none'])->label(false) ?>
                                            </div>
                                            <i class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
                           title="Letak PHP function, cth: (1 === 3)"></i>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status2">Status</label>
                                            <div class="col-md-6 col-sm-6 col-xs-10">
                                                <?= $form->field($modelAddress, "[{$i}]status")->checkbox(['label' => ''])->label(false) ?>
                                            </div>
                                        </div>
                                            

                                    </div>
                                </div>
                            <?php endforeach; ?>
                            </div>
                            <?php DynamicFormWidget::end(); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton($modelCustomer->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>