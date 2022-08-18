<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


  $title = $this->title = 'MaklumatPermohonan';
?>
<style>

    .html-marquee {
        height: auto;
        /*background-color:#ffff33;*/
        /*font-family:Cursive;*/
        font-size:14px;
        color:red;
        /*border-width:4;*/
        /*border-style:dotted;*/
        /*border-color:#ff0000;*/
    }
</style>

        <?php echo $this->render('/ptb/_menu'); ?>
<div class="row">
<div class="col-md-12 col-xs-12"> 
  <div class="x_panel">
 
        <div class="x_content">
             <div class="table-responsive">
                <strong>  
                    
                    Sebarang pertanyaan dan kemusykilan mengenai sistem PTB sila hubungi talian berikut:<br/><br/>
                  
                      <table  class="table table-bordered jambo_table">
                        <tr>
                            <td width="1px">Nama Sistem</td>
                            <td width="1px">Pertukaran Tempat Bertugas (PTB)</td>
                        </tr>
                             <tr>
                            <td width="1px">Garis Panduan</td> 
                            <td width="1px"> <?php ?>
                    <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to('@web/files/guideline_ptb.pdf'); ?>" target="_blank" ><u>Garis Panduan.pdf</u></a>
                    <?php 
?></td>
                        </tr> 
                       <tr>
                            <td width="1px">Manual Pengguna</td> 
                            <td width="1px"> <?php ?>
                    <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to('@web/files/manual_pengguna_ptb.pdf'); ?>" target="_blank" ><u>Manual Pengguna.pdf</u></a>
                    <?php 
?></td>
                        </tr>  
                        <tr>
                            <td width="1px">Pegawai Bertanggungjawab</td> 
                            <td width="1px">1. Encik Ismail Bin Ladama    (Tel: 088-320000 Samb. 103233)<br>
                             2. Puan Hafizah Binti Hassan  (Tel: 0102386110)</td>
                        </tr>  
                    </table>
                    
                </strong>
             </div>
        </div>
        </div>
</div>
</div>

          <div class="x_panel" style="display: <?php echo $display;?>">
              <div class="hash" style="color: green">
             * Pemohon hendaklah melengkapkan dan menghantar Borang Deskripsi Tugas terlebih dahulu dengan menekan butang dibawah sebelum membuat permohonan Pertukaran Tempat Bertugas (PTB)
              </div><br>
            <?=   Html::a('Deskripsi Tugas', ['my-portfolio/maklumat-umum'], ['class' => 'btn btn-primary']);?>
            
   </div>

<div class="row">
<div class="col-md-12 col-xs-12"> 
   <div class="x_panel" style="display: <?php echo $displaymohon;?>">
        <div class="x_title">
            <h2>Permohonan Pertukaran Tempat Bertugas</h2>
            <ul class="nav navbar-right panel_toolbox">
               
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
              <div class="table-responsive">
            <p style="color: green">
                * Permohonan Pertukaran sekali sahaja.
            </p>
            <!--form-->
            <!--<form class="form-horizontal form-label-left">-->
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">J/A/F/P/I/B Yang Dikehendaki<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'new_dept')->label(false)->widget(Select2::classname(), [
                        'data' => $departments,
                        'options' => ['placeholder' => 'Pilih Jabatan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Kampus Yang Dikehendaki<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($model, 'new_campus')->label(false)->widget(Select2::classname(), [
                        'data' => $campus,
                        'options' => ['placeholder' => 'Pilih Jabatan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sebab Permohonan<span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'reason')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
             <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Dokumen Sokongan :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                   <?php
                    if (!empty($model->file) && $model->file != 'deleted') {
                        echo Html::a(Yii::$app->FileManager->NameFile($model->file));
                        echo '&nbsp&nbsp&nbsp&nbsp';
                    }
                    else{
                       echo $form->field($model, 'file')->fileInput()->label(false);
                    }
                    ?>
                  <p style="color: green;">
         
        Pemohon boleh memuat naik dokumen sokongan yang difikirkan perlu. Contoh : Pengiktirafan / Lesen kepakaran / Rekod hospital atau lain-lain 
            </p>
            </div>
        </div>
        
            
                       <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Mempersetuju
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" value="<?php 
                   //    if (($peg->id ==  158)){
                         if($peg->pp){
                         echo  ($peg->pp) ? $peg->ppBiodata->CONm : 'Terus Kepada Pegawai Pelulus';
                              }
                    //}
               
//                    if (($peg->id !=  158)){
//                                  if(!is_null($peg->sub_of)){
//
//                                              if($deptSubOff->pp){
//                                              echo  ($deptSubOff->pp) ? $deptSubOff->ppBiodata->CONm : 'Terus Kepada Pegawai Peraku';
//                                              }
//                                  }else{
//                                                  if($peg->pp){
//                                                  echo  ($peg->pp) ? $peg->ppBiodata->CONm : 'Terus Kepada Pegawai Peraku';
//                                                    }
//                                      }
//               
//                    }   
?>" disabled />
                    
                    
                   
                </div>                                                                                
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai Memperaku
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    
                         <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" value="<?php 
                 //   if (($peg->id ==  158)){
                         if($peg->chief){
                         echo  ($peg->chief) ? $peg->chiefBiodata->CONm : 'Terus Kepada Pegawai Pelulus';
                              }
                 //   }
               
//                    if (($peg->id !=  158)){
//                                  if(!is_null($peg->sub_of)){
//
//                                              if($deptSubOff->chief){
//                                              echo  ($deptSubOff->chief) ? $deptSubOff->chiefBiodata->CONm : 'Terus Kepada Pegawai Pelulus';
//                                              }
//                                  }else{
//                                                  if($peg->chief){
//                                                  echo  ($peg->chief) ? $peg->chiefBiodata->CONm : 'Terus Kepada Pegawai Pelulus';
//                                                    }
//                                      }
//               
//                    }     
?>" disabled />
                </div>
            </div>

        
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar Permohonan',['class' => 'btn btn-success', 'data'=>['confirm'=>'Sila pastikan maklumat permohonan adalah tepat. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini. Teruskan?']]) ?>
                </div>
            </div>


            <?php ActiveForm::end(); ?>

            <!--form-->
        </div>
    </div>
        
</div>
</div>
</div>
<!-- Modal -->
<div id="alert" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Perhatian!</h4>
            </div>
            <div class="modal-body">
                <b>Permohonan masih <mark>ditutup</mark>. Permohonan boleh dilakukan mulai <?= $options['date']['date_open']." hingga ".$options['date']['date_close']  ?></b>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>

    </div>
</div>
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script type="text/javascript">

    $(document).ready(function(){

        function checker(){
            var is_open = <?= $options['open'] ?>

            if(is_open === false){
               $("button[type='submit']").prop("disabled",true);
                $("#alert").modal('show');
            }
        }

        $( "#application-reason").keypress(function() {
            checker();
        });

        checker();
    });
</script>


