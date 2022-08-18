<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\number\NumberControl;
use app\models\pinjaman\Refbank;
?> 
<?php $this->title = 'Pinjaman Peribadi';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1306,1309,1312], 'vars' => []]); ?>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
    <div class="x_panel"> 
        <div class="x_title">
            <h2>Maklumat Peribadi</h2>  
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama Pegawai</th>
                        <td>
                         <?= $model->displayGelaran . ' ' . ucwords(strtolower($model->CONm)); ?>
                        </td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan</th>
                        <td> 
                        <?php
                            if ($model->NatStatusCd == 1) {
                                echo $model->ICNO;
                            } else {
                                echo $model->latestPaspot;
                            }
                        ?>
                        </td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">UMS-PER</th>
                        <td>
                        <?= $model->COOldID; ?>
                        </td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Gred Gaji</th>
                        <td>
                        <?= $model->jawatan->gred; ?>
                        </td> 
                    </tr>
                   <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Gaji Pokok</th>
                        <td><?= $model->gajiBasic; ?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                        <td>
                        <?= $model->jawatan->nama; ?>
                        </td> 
                    </tr>
                     
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Alamat Pejabat</th>
                        <td>
                           <?= $model->department->fullname; ?>,
                            Universiti Malaysia Sabah,
                            <?php
                            if ($model->campus_id == 1) {
                                echo " Jalan Universiti Malaysia Sabah, 88400 Kota Kinabalu.";
                            } else if ($model->campus_id == 2) {
                                echo " Labuan International Campus, Jln. Sungai Pagar, 87000 Labuan.";
                            } else if ($model->campus_id == 3) {
                                echo " Locked Bag No. 3, 90509 Sandakan.";
                            }
                            ?>
                        </td> 
                    </tr>  
                </table>
            </div> 

        </div>
    </div>

    <div class="x_panel"> 
        <div class="x_title">
            <h2>Butiran Permohonan</h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Agensi /Bank: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                  
                    <?=
                         $form->field($permohonan, 'agensi_bank')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Refbank::find()->all(), 'id', 'agensi_bank'),
                        'options' => ['placeholder' => 'Pilih Agensi/Bank', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        ]);
                        ?>
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Pinjaman:
                </label> 
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($permohonan, 'jumlah_pinjaman')->widget(NumberControl::classname(), [
                         'name' => 'jumlah_pinjaman',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         
                         'displayOptions' => [
                         //   'placeholder' => 'Contoh: RM223437.04'
                                  ],
                                ])->label(false);
                            ?>
                </div> 
            </div> 
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Bayaran Bulanan:
                </label> 
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($permohonan, 'bayaran_bulanan')->widget(NumberControl::classname(), [
                         'name' => 'bayaran_bulanan',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         
                         'displayOptions' => [
                         //   'placeholder' => 'Contoh: RM223437.04'
                                  ],
                                ])->label(false);
                    ?>
                </div> 
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Bulan Pembayaran:
                </label> 
                <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($permohonan, 'jumlah_bulan_bayaran')->textInput(['maxlength' => true, 'placeholder' => 'Bulan']) ->label(false);?>
<!--                    <?=
                    $form->field($permohonan, 'jumlah_bulan_bayaran')->widget(NumberControl::classname(), [
                         'name' => 'jumlah_bulan_bayaran',
                           'pluginOptions'=>[
                           'initialize' => true,
                                                    ],
                               'maskedInputOptions' => [
                                'prefix' => 'RM',
                             'rightAlign' => false
                           ],
                         
                         'displayOptions' => [
                         //   'placeholder' => 'Contoh: RM223437.04'
                                  ],
                                ])->label(false);
                            ?> -->
                </div> 
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mohon:
                </label> 
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $permohonan->tarikhm;?>" disabled="disabled">
                </div> 
            </div> 
            <div class="form-group text-center">
               <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Hantar'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']])?>
               <button class="btn btn-primary" type="reset">Reset</button>
            </div>

        </div>
    </div>   

    <?php ActiveForm::end(); ?> 

</div> 
</div>  

</div>