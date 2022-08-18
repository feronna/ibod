<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\grid\GridView;
?> 
<?php echo $this->render('menu'); ?>   
<div class="x_panel"> 
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">AWARDS/HONOURS/STEWARDSHIP</p> 
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
    <div class="x_content">    
        <?= $form->field($model, 'ICNO')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Award/Honour/Invention Title: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12">  
                <?= $form->field($model, 'title')->textarea(['rows' => 3])->label(false); ?>
            </div>
        </div>   
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Date: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?=
                DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'date',
                    'template' => '{input}{addon}',
                    'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'required' => 'required', 'placeholder' => '....'],
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]);
                ?>

            </div>
        </div>  
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Type: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12">  
                <?=
                $form->field($model, 'type_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\cv\RefTypeStewardship::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => '....', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'readonly' => true,
                    ],
                ])->label(false);
                ?>

            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Individual/Institutional: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12">  
                <?=
                $form->field($model, 'role_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\cv\RefRoleStewardship::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => '....', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'readonly' => true,
                    ],
                ])->label(false);
                ?>

            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Level: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12">  
                <?=
                $form->field($model, 'level_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\cv\RefLevel::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => '....', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'readonly' => true,
                    ],
                ])->label(false);
                ?>

            </div>
        </div> 
         
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Conferring Body: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12"> 
                <?= $form->field($model, 'conferring_body')->textarea(['rows' => 2])->label(false); ?>
            </div>
        </div>

        <div class="form-group text-center">
            <?= Html::submitButton($model->isNewRecord ? 'SAVE' : 'UPDATE', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?> 
    </div>
</div>

<div class="x_panel">
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">RECORD</p>  
        <div class="clearfix"></div>
    </div> 
    <div class="table-responsive">
        <?=
        GridView::widget([
            'dataProvider' => $record,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'class' => 'yii\grid\DataColumn',
                    'label' => 'Details',
                    'format' => 'raw',
                    'value' => function ($record) {
                        return $record->title. '. '.$record->biodata->getTarikhBI($record->date) .'. ' .$record->type->name.' ( '.$record->role->name.'). '. $record->level->name . '. ' . $record->conferring_body.'.';
                    },
                    'contentOptions' => [ 'width' => '500px'],
                ],  
                [
                    'class' => 'yii\grid\DataColumn',
                    'label' => 'Status',
                    'format' => 'raw',
                    'value' => function ($record) {
                        return $record->verification;
                    },
                ],
                [
                    'class' => 'yii\grid\DataColumn',
                    'label' => 'Action',
                    'value' => function ($record) {
                        return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $record->id, 'title' => 'stewardship'], ['class' => 'btn btn-default',
                            'data' => [
                                'confirm' => 'Anda yakin ingin padam?',
                                'method' => 'post',
                    ]]) . ' ' . Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['edit-services', 'id' => $record->id, 'title' => 'stewardship'], ['class' => 'btn btn-default']);
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center', 'width' => '130px'],
                ],
            ],
        ]);
        ?>   

    </div>
</div> 