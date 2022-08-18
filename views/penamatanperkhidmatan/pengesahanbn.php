<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\penamatanperkhidmatan\TblPengesahan;

error_reporting(0);
$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});
';

$this->registerJs($js);
?>
<?= $this->render('_topmenu') ?>
<?= $this->render('_maklumatpemohon',['model'=> $model]) ?>
<?php $form = ActiveForm::begin(['options' => ['id' => 'dynamic-form', 'class' => 'form-horizontal form-label-left']]); ?>


<div class="row">  
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Pengesahan Jabatan Bendahari </strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <i>[Tarikh terakhir dikemaskini : <?= $model->tarikh_bn?>]</i>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped jambo_table table-bordered" style="text-align:center;">
               
                    <th class="text-center">BIL</th>
                    <th class=" text-center">PERKARA</th>
                    <th class=" text-center">TIDAK</th>
                    <th class="text-center">YA</th>
                    <th id="baki" style="display:<?php echo TblPengesahan::find()->where(['permohonan_id' =>$id, 'dept_id'=> 8])->exists() ? '' : 'none'?>" class="text-center">BAKI (RM)</th>
          
                    <tbody>
                    <?php
                    $bil=1;
                    foreach($refbn as $refbn){
                            $m = TblPengesahan::find()->where(['permohonan_id' =>$id, 'perkara'=> $refbn->perkara])->one();
                            ?>
                    <tr>
                        <td><?= $bil?></td>
                        <td><?= $refbn->perkara?></td>
                        <td>
                            <input onchange="myFunction(this.value, this.name)" type="radio" name=<?=$refbn->id?> value="0"
                            <?php echo (empty($m)) ? 'checked' : ''?>>
                        </td>
                        <td>
                            <input onchange="myFunction(this.value, this.name)" type="radio" name=<?=$refbn->id?> value="1"
                                   <?php echo (empty($m)) ? '' : 'checked'?>>
                        </td>
                        <td style="display:<?php echo (empty($m)) ? 'none' : ''?>" id=<?= "baki".$refbn->id?>>
                            <input id="input<?=$refbn->id?>" type="number" step=".01" name="baki<?=$refbn->id?>" value="<?=$m->baki?>">
                        </td>
                    </tr>
                    
                    <?php $bil++;}?>
                    </tbody>
            </table>
        </div>
        </div>
        <script>
            function myFunction(val, name) {
                if(val === "1"){
                    $("#baki"+name).show();
                    
                    $("#baki").show();
                    $("#input"+name).prop("required",true);
                }
                else{
                    $("#baki"+name).hide();
                    $("#input"+name).prop("required",false);
                }
            }
        </script>
        
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
                            'perkara',
                            'baki'
                        ],
                    ]); ?>
                            <div id="form" class="container-items"><br>
                                 <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <?php $in=1; foreach ($modelsAddress as $i => $modelAddress): ?>
                                <div class="item"><!-- widgetBody -->
                                        <?php
                                            // necessary for update action.
                                            if (! $modelAddress->isNewRecord) {
                                                echo Html::activeHiddenInput($modelAddress, "[{$i}]id");
                                            }
                                        ?>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="item"><span class="panel-title-address"><?= $in++ ?></span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-10">
                                                <?= $form->field($modelAddress, "[{$i}]perkara")->textInput(['maxlength' => true, 'placeholder' => 'Nama', 'required' => true])->label(false) ?>
                                            </div>
                                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                        </div>
                                    <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="baki"></label>
                                            <div class="col-md-6 col-sm-6 col-xs-10">
                                                <?= $form->field($modelAddress, "[{$i}]baki")->textInput(['maxlength' => true, 'required' => true,'placeholder' => "Baki (RM)", 'type' => 'number', 'step'=>".01", 'min' => '0.00'])->label(false) ?>
                                            </div>
                                        </div>
                                </div>
                            <?php endforeach; ?>
                            </div>
                            <?php DynamicFormWidget::end(); ?>
         <div class="ln_solid"></div>

            <div class="form-group" align="center">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
            <?php ActiveForm::end(); ?>

