
<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\cbelajar\RefKriteria;
error_reporting(0);
?> 
<?php echo $this->render('/cutibelajar/_topmenu'); ?>
<div class="x_panel"> 
    <div class="x_title">
        <h2>Cadangan/Aduan</h2> 
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
    <div class="x_content">    
        <?= $form->field($model, 'ICNO')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?> 
        <?= $form->field($model, 'tarikh_mohon')->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false); ?> 
        <?= $form->field($model, 'status_id')->hiddenInput(['value' => 1])->label(false); ?>  
        <?php if ($biodata->jawatan->job_category == 1) { ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kriteria: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12"> 
                <?=
                $form->field($model, 'kriteria_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(RefKriteria::find()->all(), 'id', 'type'),
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Justifikasi: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12"> 
                <?= $form->field($model, 'justifikasi')->textarea(['rows'=>6,'placeholder'=>'Nyatakan cadangan/masalah yang dihadapi..'])->label(false); ?>
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
        <h2>Info Status</h2> 
        <div class="clearfix"></div>
    </div>  
            <?php foreach ($status as $s){ ?>
                 
    <li><span class="label label-<?= $s->color; ?>"><?= $s->output; ?></span> : <?= $s->desc; ?></li>
             
            <?php } ?>  
</div>

<div class="x_panel">
    <div class="x_title">
        <h4><strong><i class="fa fa-pencil-square"></i> Rekod</strong></h4> 
        <div class="clearfix"></div>
    </div> 
    <div class="table-responsive">
        <table class="table table-sm table-bordered jambo_table table-striped"> 
            <tr> 
                <th style="width: 3%;">No.</th> 
             
                <th style="width: 15%;">Kriteria</th>
                
                <th>Justifikasi</th>
                <th style="width: 15%;">Tarikh Aduan</th> 
                <th style="width: 10%;">Status</th>    
                <th style="width: 8%;">Maklum Balas</th>  

            </tr> 

            <?php
            $counter = 0;
            foreach ($record as $record) {
                $counter = $counter + 1;
                ?> 

                <tr>
                    <td><?= $counter; ?></td> 
                 
                    <td><?= $record->kriteria ? $record->kriteria->type : ' '; ?> </td> 
                 
                    <td><?= $record->justifikasi ? $record->justifikasi : ' '; ?> </td> 
                    <td><?= $record->tarikh_mohon ? $record->tarikh_mohon : ' '; ?> </td> 
                    <td><span class="label label-<?= $record->status ? $record->status->color : ' '; ?>"><?= $record->status ? $record->status->output : ' '; ?></span></td>   
                    <td><center><?php if(in_array($record->status_id,[2,3])){ echo Html::button(' ', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['complain-feedback', 'id' => $record->id]), 'class' => 'fa fa-info-circle mapBtn btn btn-default btn-sm']); } ?></center> </td> 
                </tr>

                <?php
            }
            ?>
        </table>
    </div>
</div>
