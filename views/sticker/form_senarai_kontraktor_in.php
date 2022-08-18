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
        <h2>Carian</h2> 
        <div class="clearfix"></div>
    </div>
    <div class="x_content">    
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Syarikat: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-9">   
                    <?php
                    echo $form->field($model, 'apsu_suppid')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map($record, 'apsu_suppid', 'apsu_lname'),
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Sila Tunggu..']]) ?>
                </div>
            </div>
        </div>

    </div>
</div> 

<div class="x_panel"> 
    <div class="x_title">
        <h2>Rekod Kontraktor</h2><br/><br/> <span class="required" style="color:red;">* Sebarang pertanyaan boleh menghubungi pegawai yang bertugas.</span>
        <div class="clearfix"></div>
    </div>
    <div class="x_content"> 
        <?php ActiveForm::end(); ?><br/> 
        <div class="table-responsive"> 
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr> 
                    <th class="text-center">Jenis Kontraktor</th>
                    <th class="text-center">Nama Syarikat</th>
                    <th class="text-center">Jumlah Pekerja</th> 
                    <th class="text-center">Tindakan</th> 
                </tr> 
                <?php
                if ($record) {
                    foreach ($record as $record) {
                        ?>


                        <tr> 
                            <td class="text-center"><?= $record->getJenisKontraktor($record->apsu_suppid); ?></td> 
                            <td class="text-center"><?= $record->apsu_lname ? $record->apsu_lname : ''; ?></td> 
                            <td class="text-center"><?= $record->getJumlahPekerja($record->apsu_suppid); ?></td>  

                            <td class="text-center">
                                <?= Html::a('<i class="fa fa-edit"></i>', ['senarai-masuk-pekerja', 'id' => $record->apsu_suppid], ['class' => 'btn btn-default btn-sm']); ?>
                            </td> 
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr> 
                        <td class="text-center" colspan="4">Tiada Maklumat</td>   
                    </tr>

                    <?php
                }
                ?>
            </table>
        </div>

    </div>
</div> 
