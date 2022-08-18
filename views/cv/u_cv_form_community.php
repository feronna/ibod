<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper; 
?> 
<?php echo $this->render('menu'); ?> 
<div class="x_panel"> 
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">SERVICE TO COMMUNITY</p> 
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
    <div class="x_content">   
        <div class="hide">
        <?= $form->field($model, 'fid')->hiddenInput(['value' => md5(uniqid(rand(), true))])->label(false); ?>
        <?= $form->field($model, 'ICNO')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>  
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Year: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?= $form->field($model, 'year')->textInput()->label(false); ?>
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Level: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12"> 
                <?=
                $form->field($model, 'level')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\cv\RefSwSociety::find()->all(), 'id', 'output'),
                    'options' => ['placeholder' => '....', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
            </div>
        </div>  

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Service: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12"> 
                <?= $form->field($model, 'service')->textInput()->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Role: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12"> 
                <?=
                $form->field($model, 'role_key')->widget(Select2::classname(), [
                    'data' => ['Chairman'=>'Chairman','Member Committee'=>'Member Committee'],
                    'options' => ['placeholder' => '....', 'multiple' => false],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
            </div>
        </div>  
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Role Details: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12"> 
                <?= $form->field($model, 'role')->textInput()->label(false); ?>
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
                <th style="width: 40%;">Service</th>
                <th>Year</th>
                <th>Role</th>  
                <th style="width: 15%;">Role Details</th> 
                <th>Level</th>   
                <th style="width: 15%;">Action</th>   

            </tr> 

            <?php
            $counter1 = 0;
            foreach ($record as $record) {
                $counter1 = $counter1 + 1;
                ?> 

                <tr>
                    <td><?= $counter1; ?></td> 
                    <td><?= $record->service ? $record->service : ' '; ?> </td> 
                    <td><?= $record->year ? $record->year : ' '; ?> </td> 
                    <td><?= $record->role_key ? $record->role_key : ' '; ?> </td> 
                    <td><?= $record->role ? $record->role : ' '; ?> </td> 
                    <td><?= $record->lvl ? $record->lvl->output : ' '; ?></td>   
                    <td><?=
                        Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $record->fid, 'title' => 'services-community'], ['class' => 'btn btn-default',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete?',
                                'method' => 'post',
                        ]]);
                        ?>
                        <?= Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['edit-services', 'id' => $record->fid, 'title' => 'services-community'], ['class' => 'btn btn-default']);
                        ?>
                    </td>  
                </tr>

                <?php
            }
            ?>
        </table>
    </div>
</div> 
