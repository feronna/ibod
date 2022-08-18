<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?> 
<?php echo $this->render('menu'); ?> 
<div class="x_panel"> 
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">SUGGESTIONS/COMPLAIN</p> 
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
    <div class="x_content">    
        <?= $form->field($model, 'ICNO')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 
        <?= $form->field($model, 'tarikh_mohon')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false); ?> 
        <?= $form->field($model, 'status_id')->hiddenInput(['value' => 1])->label(false); ?>  
        <?php if ($biodata->jawatan->job_category == 1) { ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Criteria: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12"> 
                    <?=
                    $form->field($model, 'kriteria_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\cv\RefKriteria::find()->all(), 'id', 'type'),
                        'options' => ['placeholder' => '....', 'multiple' => false],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>
                </div>
            </div>  
        <?php } ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Justification: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12"> 
                <?= $form->field($model, 'justifikasi')->textarea(['rows' => 6])->label(false); ?>
            </div>
        </div> 
        <div class="form-group text-center">
            <?= Html::submitButton('SUBMIT', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?> 
    </div>
</div>
<div class="x_panel">
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">STATUS INFO</p> 
        <div class="clearfix"></div>
    </div>  
    <?php foreach ($status as $s) { ?>
        <ul>
            <li><span class="label label-<?= $s->color; ?>"><?= $s->output; ?></span> : <?= $s->desc; ?></li>
        </ul>
    <?php } ?>  
</div>

<div class="x_panel">
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">RECORD</p> 
        <div class="clearfix"></div>
    </div> 
    <div class="table-responsive">
        <table class="table table-sm table-bordered jambo_table table-striped"> 
            <tr> 
                <th style="width: 3%;">No.</th> 
                <?php if ($biodata->jawatan->job_category == 1) { ?>
                    <th style="width: 15%;">Criteria</th>
                <?php } ?>
                <th>Justification</th>
                <th style="width: 15%;">Date Complain</th> 
                <th style="width: 10%;">Status</th>    
                <th style="width: 8%;">Feedback</th>  

            </tr> 

            <?php
            $counter = 0;
            foreach ($record as $record) {
                $counter = $counter + 1;
                ?> 

                <tr>
                    <td><?= $counter; ?></td> 
                    <?php if ($biodata->jawatan->job_category == 1) { ?>
                        <td><?= $record->kriteria ? $record->kriteria->type : ' '; ?> </td> 
                    <?php } ?>
                    <td><?= $record->justifikasi ? $record->justifikasi : ' '; ?> </td> 
                    <td><?= $record->tarikh_mohon ? $record->tarikh_mohon : ' '; ?> </td> 
                    <td><span class="label label-<?= $record->status ? $record->status->color : ' '; ?>"><?= $record->status ? $record->status->output : ' '; ?></span></td>   
                    <td><?php if (in_array($record->status_id, [2, 3])) {
                    echo Html::button(' ', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['complain-feedback', 'id' => $record->id]), 'class' => 'fa fa-info-circle mapBtn btn btn-default btn-sm']);
                } ?> </td> 
                </tr>

                <?php
            }
            ?>
        </table>
    </div>
</div>
