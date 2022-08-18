<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>

<?= $this->render('menu') ?> 
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>  
<div class="x_panel"> 
    <div class="x_title">
        <h2><?= $title ?></h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-4">  
                    <?=
                    $form->field($model, 'id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\hronline\TblAhliLembagaPengarah::find()->all(), 'id', 'name'),
                        'options' => ['placeholder' => 'Nama', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-success', 'data'=>['disabled-text'=>'Sila Tunggu..']]) ?>
                </div>
            </div>
        </div>

    </div>
</div> 

<div class="x_panel"> 
    <div class="x_title">
        <h2>Rekod Pelekat Vip</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">  <br/>    
        <?php
        if ($biodata) {
            ?> 
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">  
                        <?= $form->field($biodata, 'name')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3"> 
                        <?= Html::a('<i class="fa fa-edit"></i>', ['kemaskini-vip', 'id' => $biodata->id], ['class' => 'btn btn-default btn-sm']);?>
                    </div>
                </div>
            </div> 
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Tel: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">  
                        <?= $form->field($biodata, 'no_tel_1')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
                    </div>
                </div>
            </div> 
            <?php
        }
        ?> 
        <?php ActiveForm::end(); ?><br/>   <br/>   
        <div class="table-responsive"> 
            <table class="table table-sm table-bordered jambo_table table-striped"> 

                <?php
                if ($record) {
                    $bil = 1;
                    ?>
                    <tr>
                        <th class="text-center">No</th> 
                        <th class="text-center">No Kenderaan</th>
                        <th class="text-center">Jenis</th>
                        <th class="text-center">Tarikh Mohon</th>
                        <th class="text-center">No Siri</th> 
                         <th class="text-center">No Resit</th>
                        <th class="text-center">Yang Bertugas</th>
                    </tr>
                    <?php foreach ($record as $l) { ?>

                        <tr>
                            <td class="text-center"><?= $bil; ?></td>  
                            <td class="text-center"><?= $l->kenderaan ? $l->kenderaan->reg_number : ''; ?></td> 
                            <td class="text-center"><?= $l->apply_type ? $l->apply_type : ''; ?></td> 
                            <td class="text-center"><?= $l->mohon_date ? $l->mohon_date : ''; ?></td> 
                            <td class="text-center"><?= $l->no_siri ? $l->no_siri: ''; ?></td>  
                            <td class="text-center"><?= $l->no_resit ? $l->no_resit: ''; ?></td> 
                            <td class="text-center"><?= $l->yangBertugas ? $l->yangBertugas->CONm: ''; ?></td> 
                        </tr>

                        <?php
                        $bil++;
                    }
                }
                ?>
            </table>
        </div>

    </div>
</div> 
