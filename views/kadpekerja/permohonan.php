<?php

use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;  
use yii\helpers\ArrayHelper;
use app\models\Kadpekerja\Refjeniskad;
use yii\helpers\Html;
use kartik\widgets\DateTimePicker;
?> 
<?php //\app\widgets\TopMenuWidget::widget(['top_menu' => [1319,1324], 'vars' => []]); ?>
<!--1322 / 1326 -> admin top menu-->
<?= $this->render('menu') ?> 
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
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Telefon</th>
                        <td>
                        <?= $model->COHPhoneNo; ?>
                        </td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Emel</th>
                        <td>
                        <?= $model->COEmail; ?>
                        </td> 
                    </tr>
                     
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                        <td>
                        <?= $model->jawatan->nama; ?>
                        </td> 
                    </tr>
                     
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">JFPIB</th>
                        <td>
                           <?= $model->department->fullname; ?>
                           
                        </td> 
                    </tr>  
                </table>
            </div> 

        </div>
    </div>

    <div class="x_panel"> 
        <div class="x_title">
            <h2>Permohonan Kad Pekerja</h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Permohonan Kad: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">  
                    <?=
                         $form->field($permohonan, 'card_type')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Refjeniskad::find()->all(), 'id', 'card_type'),
                        'options' => ['placeholder' => 'Pilih Jenis Kad', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        ]);
                        ?>
                    
                    <?php
                           $form->field($permohonan, 'card_type')->widget(Select2::classname(), [
                            'name' => 'card_type',
                            'data' => ArrayHelper::map(Refjeniskad::find()->all(), 'id', 'card_type'),
                             'options' => ['placeholder' => 'Pilih Jenis Kad', 'class' => 'form-control col-md-7 col-xs-12',
                                    'onchange' => 'javascript:if ($(this).val() == "5" ){
                                    $("#jenis-belian").show();
                                         }
                                    else{
                                  
                                    $("#jenis-belian").hide();
                                    }'
                                 ],
                        
                                    'pluginOptions' => [
                                    'allowClear' => true
                                    ],

                        ])->label(false); ?>
 
                </div>
            </div> 

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Surat Tawaran: <span class="required" style="color:red;"></span>
                <i data-html="true" class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
                        title="Muat Naik bagi Permohonan Kad Pertukaran Tempat Baru Dan Pertukaran Skim Sahaja"></i>       
            </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 

                <?= $form->field($permohonan, 'dokumen')->fileInput()->label(false);?>

                </div>
            </div> 

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Surat Lantikan: <span class="required" style="color:red;"></span>
                <i data-html="true" class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
                        title="Muat Naik bagi Permohonan Kad Pertukaran Tempat Baru Dan Pertukaran Skim Sahaja"></i>   
            </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 

                <?= $form->field($permohonan, 'dokumen2')->fileInput()->label(false);?>

                </div>
            </div> 
            
            <div id="jenis-belian" class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Gambar: <span class="required" style="color:red;"></span>
                <i data-html="true" class="fa fa-info-circle fa-xs" aria-hidden="true" data-toggle="tooltip" data-placement="top" 
                        title="Muat Naik bagi Permohonan Kad Gantian Gambar Baru Sahaja"></i>    
            </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 

                <?= $form->field($permohonan, 'dokumen3')->fileInput()->label(false);?>
                            
                </div>
            </div> 
            
        </div>
    </div>

    

    <div class="x_panel"> 
        <div class="x_title">
            <h2>Butiran Permohonan Kad Pekerja</h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <!-- <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Permohonan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                  
                    <?=
                         $form->field($permohonan, 'card_type')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Refjeniskad::find()->all(), 'id', 'card_type'),
                        'options' => ['placeholder' => 'Pilih Jenis Kad', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        ]);
                        ?>
                </div>
            </div> -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh/Masa pengambilan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                  
                     <?=
                    $form->field($permohonan, 'masa_ambil')->widget(DateTimePicker::classname(), [
                        'options' => ['placeholder' => '....'],
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ])->label(false);
                    ?>
            
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Bayaran: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                  
                     <?php
                    $kaunter = '<img src="../images/sticker/kaunter.png" width="22%" height="180%">';
                    $debit = '<img src="../images/sticker/debit.png" width="9%" height="48%">';
//                    $m_card = '<img src="../images/sticker/m_card.png" width="30%" height="250%">';
                    
                    if ($permohonan->payment) {
                        echo $form->field($permohonan, 'payment')->textInput(['disabled' => true])->label(false);
                    } else {
                        echo $form->field($permohonan, 'payment')->radioList(array('KAUNTER' => $kaunter.' KAUNTER', 'FPX' => $debit . ' DEBIT/FPX'), ['encode' => false])->label(false);
                    }
                    ?>
  
                </div>
            </div> 
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mohon:
                </label> 
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $permohonan->entrydt;?>" disabled="disabled">
                </div> 
            </div>  
        </div>
    </div>  

    <div class="x_panel"> 
        <div class="x_title">
            <h2>Wakil Pengambilan Kad Pekerja</h2>
            <br/><br/> <span class="required" style="color:red;">* Sekiranya perlu.</span>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Kp: <span class="required" style="color:red;"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                <?= $form->field($permohonan, 'wakil_ICNO')->textInput(['maxlength' => true]) ->label(false); ?>
                     
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama: <span class="required" style="color:red;"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                  
                <?= $form->field($permohonan, 'wakil_nama')->textInput(['maxlength' => true]) ->label(false); ?>


                </div>
            </div>
             
            
            
              
            <div class="form-group text-center">
               <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Mohon'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']])?>
               <button class="btn btn-primary" type="reset">Reset</button>
            </div>

        </div>
    </div>  

     

    <?php ActiveForm::end(); ?> 

</div> 
</div>  
 