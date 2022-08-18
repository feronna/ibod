<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;

error_reporting(0);

$statusLabel = [
        0 => '<span class="label label-danger">BELUM DIPERAKUKAN</span>',
        1 => '<span class="label label-success">DIPERAKUKAN</span>',
        2 => '<span class="label label-danger">DITOLAK</span>',
];

?>    



<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/memorandum/_menu');?> 
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
                  <p align="right" >
                    <?php echo Html::a('Kembali', ['senarai-memorandum'], ['class' => 'btn btn-primary btn-sm']); ?>  
               
                </p>
            <div class="x_title">
                <h2><strong><i class="fa fa-list"> </i> Rekod Memorandum</strong></h2>
             
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="w0" class="form-horizontal form-label-left" action="" method="post">

                    
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mesyuarat :
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $rekod->tblRekod->tarikhRekod?>" disabled="">

                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bil.JPU :
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $rekod->tblRekod->bil_jpu?>" disabled="">

                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    
                                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">KALI KE- :
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" value="<?= $rekod->tblRekod->kali_ke?>" disabled="">

                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Minit :
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                               <?php echo $rekod->tblRekod->perkara ?> 

                          
                            </div>
                        </div>
                    </div>
                    
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Perkara :
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                               <?php echo $rekod->perkara ?> 

                          
                            </div>
                        </div>
                    </div>
                    
                    
                              <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Lampiran Dokumen :
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                   <?php if($rekod->tblRekod->doc_name != null){
                                           echo  Html::a(''  . $rekod->tblRekod->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $rekod->tblRekod->hashcode, $schema = true), ['target' => '_blank',  'style' =>  'text-decoration: underline; color:green']);
                                       }else{
                                           echo 'Tiada Lampiran';
                                       }
                 
                                       ?>
                                       
                      
                            </div>
                        </di

                </form>
            </div>
        </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status :
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group field-tblrekod-tarikh">

                                <input type="text" id="tblrekod-tarikh" class="form-control col-md-6 col-sm-6 col-xs-12" name="TblRekod[tarikh]" 
                                       value="<?php if($rekod->status == 0){
                                           echo 'BELUM SELESAI';
                                       }else{
                                           echo 'SELESAI';
                                       }
                                       
                                       ?>" disabled="">
                                       
                                <div class="help-block"></div>
                            </div>
                        </di

                </form>
            </div>
        </div>

                        

                </form>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-briefcase"></i> Senarai Maklumbalas JAFPIB</strong></h2>
                
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title">Bil</th>
                        <th class="column-title">Tarikh Maklumbalas </th>
                        <th class="column-title">Pemaklumbalas </th>
                        <th class="column-title">Jabatan </th>
                        <th class="column-title">Maklumbalas </th>
                        <th class="column-title">Lampiran </th>
                        <th class="column-title">Ketua Jabatan/Dekan </th>
                        <th class="column-title">Status Perakuan </th>
                        <th class="column-title">Perincian </th>
                     
                    </tr>

                </thead>
                <tbody>

                  <?php if($senarai) {
                             foreach ($senarai as $key=>$senarai){ ?>
                        <tr>

                            <td style="width:10px"><?= $key+1?></td>
                            <td style="width:20px"><?= $senarai->tarikhMaklumbalas; ?></td>
                            <td style="width:40px"><?= $senarai->kakitangan->CONm ;?></td>
                            <td style="width:20px"><?= $senarai->kakitangan->department->shortname;?></td>
                            <td><?= $senarai->maklumbalas_ptj?></td>
                                <td><?php              
                            if ($senarai->doc_name) {
                             echo  Html::a(''  . $senarai->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $senarai->hashcode, $schema = true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]);
                            } else {
                                echo 'Tiada Lampiran';
                            }?></td>
                            <td style="width:40px"><?= $senarai->pegawaiPeraku->CONm?></td>
                            <td style="width:20px"><?= $statusLabel[$senarai->status_kj]?></td>
                            <td style="width:20px"><?php
                              $t = Url::to(['detail-maklumbalas-ptj',  'id_rekod' => $senarai->id_rekod, 'id' => $senarai->id]);
                                echo Html::button('<span class="fa fa-eye"></span>', ['value' => Url::to($t), 'class' => 'btn btn-default modalButton']) ?>
                            </td>
                          
                            
                        </tr>
                           
                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">Tiada Rekod Maklumbalas</td>                     
                    </tr>
                  <?php  
                } ?>
                        
                      </table>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> Senarai Maklumbalas Urus Setia</strong></h2>
                
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="w0" class="form-horizontal form-label-left" action="">

                       <table class="table table-bordered jambo_table">
                    <thead>
                    <tr class="headings">
                        <th class="column-title">Bil</th>
                        <th class="column-title">Tarikh Maklumbalas </th>
                        <th class="column-title">Pemaklumbalas </th>
                        <th class="column-title">Maklumbalas Urusetia </th>
                         <th class="column-title">Lampiran </th>
                    </tr>

                </thead>
                <tbody>

                  <?php if($senarai_urusetia) {
                             foreach ($senarai_urusetia as $key=>$senarai){ ?>
                        <tr>

                            <td><?= $key+1?></td>
                            <td><?= $senarai->tarikhMaklumbalas; ?></td>
                            <td><?= $senarai->kakitangan->CONm ;?></td>
                            <td><?= $senarai->maklumbalas?></td>
                                  <td><?php              
                            if ($senarai->doc_name) {
                             echo  Html::a(''  . $senarai->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $senarai->hashcode, $schema = true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]);
                            } else {
                                echo 'Tiada Lampiran';
                            }?></td>
                 

                        </tr>
                           
                   <?php } 
                   
                } else{
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">Tiada Rekod Maklumbalas</td>                     
                    </tr>
                  <?php  
                } ?>
                        
                      </table>
                </form>
            </div>
        </div>
    </div>
</div>
  

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
                <h2><i class="fa fa-book"></i>&nbsp;<strong>Maklumbalas Memorandum Urusetia</strong></h2>
                <hr>
            <div class="x_content">


                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>


    
                
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Maklumbalas Urusetia:<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
               <?= $form->field($model, 'maklumbalas')->widget(TinyMce::className(), [
                            'options' => ['rows' => 15],
                            'language' => 'en',
                            'clientOptions' => [
                                'plugins' => [
                                    "advlist autolink lists link charmap print preview anchor",
                                    "searchreplace visualblocks code fullscreen",
                                    "insertdatetime media table contextmenu paste"
                                ],
                                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                            ]
                        ])->label(false); ?>
                </div>
            </div>
                
                

       <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Lampiran :<span class="required" style="color:red;">*</span></label>
           
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                        echo $form->field($model, 'file', ['enableAjaxValidation' => false])->label(false)->widget(FileInput::class, [
                            'options' => [
                                'accept' => ['image/*', 'application/pdf'],
                            ],
                            'pluginOptions' => [
                                'showUpload' => false
                            ],

                        ]);
                        ?>
                    </div>
                    <?= Html::error($model, 'file3'); ?>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                    <p>Attachment *Only images (jpg, jpeg, png) or PDF is allowed (Max upload: 2MB)</p>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                    </div>
                </div>
          
                  <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                        <?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;Hantar', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

</div>

