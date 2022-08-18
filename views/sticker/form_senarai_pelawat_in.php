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
                <label class="control-label col-md-3 col-sm-3 col-xs-3 text-right">Nama: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-4">  
                    <?=
                    $form->field($model, 'id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\esticker\TblPelawat::find()->where(['in','CatCd',[1]])->all(), 'id', 'CONm'),
                        'options' => ['placeholder' => 'Pilih Nama', 'class' => 'form-control col-md-7 col-xs-12'],
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
        <h2>Rekod Daftar Masuk</h2><br/><br/> <span class="required" style="color:red;">* Sebarang pertanyaan boleh menghubungi pegawai yang bertugas.</span>
        <div class="clearfix"></div>
    </div>
    <div class="x_content"> 
        <?php ActiveForm::end(); ?><br/>   <br/>   
        <div class="table-responsive"> 
            <table class="table table-sm table-bordered jambo_table table-striped"> 

                <?php
                if ($record) {
                    ?>
                    <tr> 
                        <th class="text-center">Nama Pelawat</th>
                        <th class="text-center">No. K/P</th>
                        <th class="text-center">No. Tel</th>
                        <th class="text-center">Tarikh Dikemaskini</th>
                        <th class="text-center">Pengkemaskini</th>
                        <th class="text-center">Tindakan</th> 
                    </tr> 

                    <tr> 
                        <td class="text-center"><?= $record->CONm ? $record->CONm : ''; ?></td> 
                        <td class="text-center"><?= $record->ICNO ? $record->ICNO : ''; ?></td> 
                        <td class="text-center"><?= $record->COOffTelNo ? $record->COOffTelNo : ''; ?></td> 
                        <td class="text-center">
                            <?php
                            if (empty($record->updated_at)) {
                                echo $record->created_at;
                            } else {
                                echo $record->updated_at;
                            }
                            ?> 
                        </td>
                        <td class="text-center">
                            <?php
                            if (empty($record->updated_by)) {
                                echo $record->pegawaiDaftar->CONm;
                            } else {
                                echo $record->pegawaiKemaskini->CONm;
                            }
                            ?> 
                        </td>

                        <td class="text-center">
                            <?php
                            if (empty($checkin)) {
                                echo Html::a('<i class="fa fa-edit"></i>', ['kemaskini-pelawat', 'id' => $record->id], ['class' => 'btn btn-default btn-sm']) . ' ' . Html::a('DAFTAR MASUK', ['daftar-pelawat', 'id' => $record->id], ['class' => 'btn btn-primary btn-sm']);
                            } elseif ($checkin->flag == 2) {
                                echo 'SENARAI HITAM';
                            } elseif ($checkin->flag == 1) {
                                echo 'AKTIF';
                            }
                            ?>
                        </td> 
                    </tr>

                    <?php
                }
                ?>
            </table>
        </div>

    </div>
</div> 
