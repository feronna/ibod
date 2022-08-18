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
                        'data' => ArrayHelper::map(\app\models\esticker\TblPelawat::find()->where(['not in','CatCd',[1]])->all(), 'id', 'CONm'),
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
        <h2>Rekod Kenderaan Pelawat</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">  <br/>    
        <?php
        if ($record) {
            ?>
        <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Kategori: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">  
                        <?= $form->field($record, 'CatCd')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\esticker\RefKategoriPelawat::find()->all(), 'id', 'nama'),
                        'options' => ['disabled' => true, 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ]);?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. K/P: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                        <?= $form->field($record, 'ICNO')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3"> 
                        <?= Html::a('<i class="fa fa-edit"></i>', ['kemaskini-pelawat', 'id' => $record->id], ['class' => 'btn btn-default btn-sm']);?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">  
                        <?= $form->field($record, 'CONm')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
                    </div>
                </div>
            </div> 
            <div class="form-group">
                <div class="row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">No. Tel: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">  
                        <?= $form->field($record, 'COOffTelNo')->textInput(['maxlength' => true, 'disabled' => true])->label(false); ?>
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
                        <th class="text-center">Tarikh Tamat Lesen</th>
                        <th class="text-center">Tarikh Tamat Roadtax</th>
                        <th class="text-center">Tindakan</th> 
                    </tr>
                    <?php foreach ($record->kenderaan as $l) { ?>

                        <tr>
                            <td class="text-center"><?= $bil; ?></td> 
                            <td class="text-center"><?= $l->reg_number ? $l->reg_number : ''; ?></td> 
                            <td class="text-center">
                                <?php
                                if ($l->lesen_exp) {
                                    if (date('Y-m-d') >= $l->lesen_exp) {
                                        echo '<span class="label label-danger">' . $l->lesen_exp . '</span>';
                                    } else {
                                        echo $l->lesen_exp;
                                    }
                                }
                                ?> 
                            </td> 
                            <td class="text-center"> 
                                <?php
                                if ($l->roadtax_exp) {
                                    if (date('Y-m-d') >= $l->roadtax_exp) {
                                        echo '<span class="label label-danger">' . $l->roadtax_exp . '</span>';
                                    } else {
                                        echo $l->roadtax_exp;
                                    }
                                }
                                ?>
                            </td> 
                            <td class="text-center"><?= Html::a('<i class="fa fa-edit"></i>', ['kemaskini-kenderaan-pelawat', 'id' => $l->id], ['class' => 'btn btn-default btn-sm']); ?>

                                <?= Html::a('MOHON', ['mohon-pelawat', 'id' => $l->id], ['class' => 'btn btn-primary btn-sm']); ?>
                            </td> 
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
