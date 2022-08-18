<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
?> 
<?php echo $this->render('menu'); ?> 
<div class="x_panel"> 
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">ESTEEM & LEADERSHIP</p> 
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
    <div class="x_content">   
        <div class="hide">
        <?= $form->field($model, 'fid')->hiddenInput(['value' => md5(uniqid(rand(), true))])->label(false); ?>
        <?= $form->field($model, 'ICNO')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 
        </div> 
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Type: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-7 col-sm-7 col-xs-12"> 
                <?=
                $form->field($model, 'type')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\cv\RefPanelType::find()->where(['!=','id',13])->orderBy(['sort' => SORT_ASC])->all(), 'id', 'output'),
                    'options' => ['placeholder' => '....', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
               
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Title: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-7 col-sm-7 col-xs-12"> 
                 <?= $form->field($model, 'title')->textInput()->label(false); ?>
            </div>
        </div>  
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Year: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?=
                    $form->field($model, 'year')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => '....'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy',
                            'minViewMode' => "years"
                        ]
                    ])->label(false);
                    ?> 
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
        <table class="table table-sm table-bordered jambo_table table-striped"> 
            <tr> 
                <th>No.</th> 
                <th>Type</th>
                <th style="width: 40%;">Title</th>
                <th>Year</th>  
                <th style="width: 15%;">Action</th>   

            </tr> 

            <?php
            $counter = 0;
            foreach ($record as $record) {
                $counter = $counter + 1;
                ?> 

                <tr>
                    <td><?= $counter; ?></td> 
                    <td><?= $record->type ? $record->name->output : ' '; ?> </td> 
                    <td><?= $record->title ? $record->title : ' '; ?> </td> 
                    <td><?= $record->year ? $record->year : ' '; ?> </td>   
                    <td><?=
                        Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $record->fid, 'title' => 'esteem-leadership'], ['class' => 'btn btn-default',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete?',
                                'method' => 'post',
                        ]]);
                        ?>
                        <?=  Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['edit-services', 'id' => $record->fid, 'title' => 'esteem-leadership'], ['class' => 'btn btn-default']);  
                        ?>
                    </td>  
                </tr>

                <?php
            }
            ?>
        </table>
    </div>
</div>
