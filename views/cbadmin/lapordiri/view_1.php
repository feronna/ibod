<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;


?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<h5> <strong><center>MAKLUMAT PENGAJIAN</center></strong> </h5>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
        
       
<table class="table table-sm table-bordered">
            
                    

                     
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                                
                                <tr class="headings">
                                    <th class="text-center" colspan="3"> <?= $pengajian->HighestEduLevel;?></th>
                                </tr>
                       <tr> 
                        <th style="width:10%" align="right">NAMA KAKITANGAN</th>
                        <td style="width:20%"><?=
                        strtoupper($pengajian->kakitangan->CONm) ?></td>
                       
                    </tr>
                    <tr> 
                        <th style="width:10%" align="right">TEMPAT PENGAJIAN</th>
                        <td style="width:20%"><?=
                        strtoupper($pengajian->InstNm) ?></td>
                       
                    </tr>
                    
                    <tr> 
                        <th style="width:10%" align="right">BIDANG</th>
                        <td style="width:20%"><?php
                        
                        if(($pengajian->MajorCd == NULL) && ($pengajian->MajorMinor != NULL))
                        {
                                echo  strtoupper($pengajian->MajorMinor);
                        }
                        elseif (($pengajian->MajorCd != NULL) && ($pengajian->MajorMinor != NULL))  {
                            echo   strtoupper($pengajian->MajorMinor);

                        }
                        else
                        {
                          echo   strtoupper($pengajian->major->MajorMinor);
                        }
?></td>
                       
                    </tr>
                    
                   
                    
                    <tr> 
                        <th style="width:10%" align="right">TARIKH MULA CUTI BELAJAR</th>
                        <td style="width:20%"><?= strtoupper($pengajian->tarikhmula)?></td>
                    </tr>
                    
                    <tr><th style="width:10%" align="right">TARIKH TAMAT CUTI BELAJAR</th>
                        <td style="width:20%"><?= strtoupper($pengajian->tarikhtamat)?></td>
                    </tr>
                      <tr> 
                        <th style="width:10%" align="right">TEMPOH PENGAJIAN</th>
                        <td style="width:20%"><?= strtoupper($pengajian->tempohpengajian)?></td>
                    </tr>
                    <?php 
                         foreach($pengajian->lanjutan as $l)
                         {
                         ?>
                     <tr>
                         
                        
                         <th style="width:10%" align="right">TARIKH PELANJUTAN <?= $l->idlanjutan?></th>
                        <td style="width:20%">

                            <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->stlanjutan)?> 
                            HINGGA <?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->ndlanjutan)?> (<?= strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['id'=>$l->id])->one()->tempohlanjutan)?>)</td>
                         </tr><?php }?>
                     
                    
                    
                     
                     
                                
<!--                                <tr class="headings">
                                    <th class="column-title text-center">Telah Dimuatnaik</th>
                                    <th class="column-title text-center">Belum Dimuatnaik</th>
                                </tr>-->
                            </thead>
                        
                                     
<!--                                   // <td class="text-center">
                                        <?//php
                                   if (!$k->namafile)
                                       {
                                     echo '&#10008;'; }?></td>
                                 
                                </tr>-->
                                
                      
                        </table>
                    </div> 

        </div>
                    
    


         
        
        
        


    </div>
    </div>

<h5> <strong><center>PEMAKLUMAN LAPOR DIRI KEMBALI BERTUGAS/GAGAL PENGAJIAN</center></strong> </h5>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">

        
    <div class="x_content">
        
       
<table class="table table-sm table-bordered">
            
                    

                     
                        <table class="table table-striped table-sm  table-bordered">
                            <thead>
                              
                       <tr> 
                        <th style="width:10%" align="right">STATUS PERKHIDMATAN</th>
                        <td style="width:20%"><span class="label label-warning"> <?=  strtoupper($pengajian->kakitangan->serviceStatus->ServStatusNm);?></span>
                           
</td>
                       
                    </tr> 
                    <tr> 
                        <th style="width:10%" align="right">TARIKH LAPOR DIRI/BERHENTI</th>
                        <td style="width:20%">    
                            <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'dt_lapordiri',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
</td>
                       
                    </tr>
                    <tr> 
                        <th style="width:10%" align="right">STATUS PENGAJIAN</th>
                        <td style="width:20%">
                            
                         <?php
            echo $form->field($model,'status_pengajian')->
            dropDownList(['SELESAI' => 'SELESAI ',
                          'BELUM SELESAI' => 'BELUM SELESAI',
                 '11' => 'BERHENTI PENGAJIAN',
                          'GAGAL PENGAJIAN' => 'GAGAL PENGAJIAN',
                          'GAGAL PENGAJIAN DAN DIBERHENTIKAN' => 'GAGAL PENGAJIAN DAN DIBERHENTIKAN',
                          'GAGAL PENGAJIAN DAN MELETAK JAWATAN' => 'GAGAL PENGAJIAN DAN MELETAK JAWATAN',
                           "12"=> 'MENDAFTAR DAN DIBENARKAN MENGULANG PEPERIKSAAN DALAM TEMPOH 6 BULAN',
                          "MIA"=> 'MIA',
                
                          
                        ],['prompt'=>'Status Pengajian'])->label(false);
?></td>
                       
                    </tr>
                    <tr> 
                        <th style="width:10%" align="right">TARIKH SELESAI</th>
                        <td style="width:20%">    
                            <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'dt_selesai',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
</td>
                       
                    </tr>
                    <tr> 
                        <th style="width:10%" align="center">SELESAI-GOT?</th>
                        <td style="width:20%"> 
                         <?php
            echo $form->field($model,'got')->
            dropDownList(['1' => 'YA ',
                          '2' => 'TIDAK', 
                          
                        ],['prompt'=>'GOT'])->label(false);
?></td>
                       
                    </tr>
                    
                     <tr> 
                        <th style="width:10%" align="middle">CATATAN</th>
                        <td style="width:20%">         <?= $form->field($model, 'catatan')->textarea(['maxlength' => true, 'rows' => 10])->label(false); ?>
</td>
                       
                    </tr>
                   
                    
                   
                    <tr> 
                        <th style="width:10%" align="right">TARIKH MULA NOMINAL DAMAGES</th>
                        <td style="width:20%">         
<?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'dt_nominal',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                    //                        'viewMode' => "years", 
//                            'minViewMode'=> "months"
                        ]
                    ]);
                    ?></td>
                       
                    </tr>
                   
                    
                 
                    
                     
                    
                    
                     

                            </thead>
                        
                                     
                        </table>
    

                    
    

      <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
<!--                <= Html::a('</i> Kembali', ['view', 'id'=>$model->ICNO], ['class'=>'btn btn-primary']) ?>       -->
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Sila Tunggu..']]) ?>
            </div>
        </div>
         
        
        <?php ActiveForm::end(); ?>

        


    </div>
    </div>