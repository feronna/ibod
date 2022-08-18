<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

?>
  
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86], 'vars' => []]); ?>
<?php  $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="form-horizontal form-label-left"> 
    <div class="x_panel">
        <div class="x_title">
           <h2><strong><i class="fa fa-list"></i> Permohonan Tuntutan Kemudahan</strong></h2>
            <div class="form-group text-right">
            <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
            </div>
            <div class="clearfix"></div>
        </div>
    <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-user"></i> Maklumat Pemohon</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            
            <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penuh <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <?= $form->field($model->kakitangan, 'CONm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                  
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No Kad Pengenalan <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <?= $form->field($model->kakitangan, 'ICNO')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">UMS-PER <span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COOldID')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                     
                </div>
            </div>
                
                <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jawatan dan Gred <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                 <?= $form->field($model->kakitangan->jawatan, 'fname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                 
            </div>
             <div class="form-group">
                 
                <label class="control-label col-md-3 col-sm-3 col-xs-12">J/ F/ P/ I/ B <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                <?= $form->field($model->kakitangan->department, 'fullname')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                
            </div>
            <div class="form-group">
                
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Taraf Jawatan <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                <?= $form->field($model->kakitangan->statusLantikan, 'ApmtStatusNm')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
              
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Emel <span class="required"></span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COEmail')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
            </div>
             <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Telefon <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COOffTelNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Ext  <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                <?= $form->field($model->kakitangan, 'COOffTelNoExtn')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                 
        </div>
            </div>
        </div>
    </div>
</div> 

    <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-book"></i><strong> Butiran Permohonan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="table-responsive">
        <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=8" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT PERMOHONAN PENGANGKUTAN BARANG-BARANG</center></th>

                <tr>
                        <td valign="4">DARI :<span class="required" style="color:red;">*</span></td>
                        <td colspan="3"> 
                           <?= $form->field($model, 'dest_berlepas')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                            
                        </td>
                        <td valign="4">KE :<span class="required" style="color:red;">*</span></td>
                        <td colspan="3">
                            <?= $form->field($model, 'dest_tiba')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                             
                        </td> 
                </tr>
                 <tr>
                        
                     <td colspan="4"><center>(Nama Bandar)</center><span class="required" style="color:red;"></span></td>
                        <td colspan="4"><center>(Nama Bandar)</center><span class="required" style="color:red;"></span></td>
                </tr>
                <tr>
                    <?php if($model->dokumen_sokongan!= NULL){?>
                    <td valign="4">Muat Naik<span class="required" style="color:red;">* :</span></td>
                    <td colspan="6"> 
                    <a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><i></i><u>Dokumen Sokongan .pdf</u></a></td>
                     <?php } ?>
                </tr>
                </thead>
                         </table>
             
    </div>   
    <div class="row"> 
    <div class="x_title">
            <h2><i class="fa fa-plus-circle"></i> Maklumat Tanggungan dan Kelayakan Pengangkutan</h2> 
            <div class="clearfix"></div>
        </div> 
             <div class="x_content">
             <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <thead>
                    <tr class="headings">
                        <th>Bil.</th>
                        <th>Nama</th>
                        <th>Pertalian/ Hubungan</th>
                         <th>No.Mykad </th>
                         <th>Kelayakan Meter Padu</th>

                    </tr>
                    </thead>
                    <?php if($keluarga) { 
                       foreach ($keluarga as $keluargakakitangan) { 
                    ?>

                    <tr>
                        <th><?= $bil++ ?></th>
                        <td><?= $keluargakakitangan->nama; ?></td>
                        <td><?= $keluargakakitangan->hubungan; ?></td>
                        <td><?= $keluargakakitangan->icno; ?></td>
                        <td><?= $keluargakakitangan->meter_padu; ?></td>                       

                    </tr>

                       <?php } 

                    } else{
                        ?>
                        <tr>
                            <td colspan="5" class="text-center">Tiada Rekod</td>                     
                        </tr>
                      <?php  
                    } ?>
                </table>
                </div>
            </div>  
    </div>
            
            <div class="row"> 
    <div class="x_title">
            <h2><i class="fa fa-plus-circle"></i> Jadual Penerbangan Yang Dirancang/ Ditempah</h2> 
            <div class="clearfix"></div>
        </div> 
             <div class="x_content">
             <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <thead>
                    <th scope="col" colspan=17" width="30%" class="headings"><center>Jadual Penerbangan Yang Dirancang/ Ditempah <br> 
                        (S = Sendiri, P = Pasangan, A = Anak)</center></th>
                    <tr class="headings">
                        
                        <th scope="col" colspan=4"  ><center>PERLEPASAN</center></th>
                        <th scope="col" colspan=3" ><center>KETIBAAN</center></th>
                        <th scope="col" colspan=2" > </th>
                        <!--<th scope="col" colspan=1" ></th>-->

                    </tr>
                    <tr class="headings">
                        
                        <th>Bil.</th>
                        <th>Tarikh</th>
                        <th>Destinasi Perlepasan</th>
                        <th>Masa</th>
                        <th>Tarikh</th>
                        <th>Destinasi Ketibaan</th>
                        <th>Masa</th>
                        <th>JENIS(S/P/A)</th>
<!--                        <th>KELAS(Y/C/F)</th>-->

                    </tr>
                    </thead>
                    <?php if($planes) { 
                       foreach ($planes as $planes) { $bil=1
                    ?>

                    <tr>
                        <th><?= $bil++ ?></th>
                        <td><?= $planes->tarikh_berlepas; ?></td>
                        <td><?= $planes->dest_berlepas; ?></td>
                        <td><?= $planes->masa_berlepas; ?></td>
                        <td><?= $planes->tarikh_tiba; ?></td>
                        <td><?= $planes->dest_tiba; ?></td>
                        <td><?= $planes->masa_tiba; ?></td>
                        <td><center><?= $planes->tempahan->jenisTempahan; ?></center></td>
                        <!--<td><center><?php // $planes->penerbangan->jenisKelas; ?></center></td>-->

                    </tr>

                       <?php } 

                    } else{
                        ?>
                        <tr>
                            <td colspan="9" class="text-center">Tiada Rekod</td>                     
                        </tr>
                      <?php  
                    } ?>
                </table>
                </div>
            </div>  
    </div>
        </div>
        </div>
        </div>  
        
        <?php if($model->status_pt == 'MENUNGGU TINDAKAN' || $model->status_pt == ''){?>    
        <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
             <h2><i class="fa fa-book"></i><strong>  Semakan Oleh Pembantu Tadbir BSM</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?= $form->field($model, 'ver_date')->hiddenInput()->label(false)?>
            <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                     <?= $form->field($model, 'status_pt')->label(false)->widget(Select2::classname(), [
                    'data' => ['SEMAKAN LAYAK' => 'SEMAKAN LAYAK',
                                   'SEMAKAN TIDAK LAYAK' => 'SEMAKAN TIDAK LAYAK',],
                   'options' => [
                         'placeholder' => 'Sila Pilih'],

                ]); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <?= $form->field($model, 'catatan_pt')->textarea(array('rows'=>6,'cols'=>5))->label(false);?>   
                </div>
            </div>
                <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                <button class="btn btn-primary" type="reset">Reset</button> 
            </div>
        </div>
               <?php }?> 
                
     <?php if($model->status_pt == 'SEMAKAN LAYAK' || $model->status_pt == 'SEMAKAN TIDAK LAYAK'){?>    
        <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
             <h2><i class="fa fa-book"></i><strong>  Semakan Oleh Pembantu Tadbir BSM</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <?= $form->field($model, 'ver_date')->hiddenInput()->label(false)?>
            <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                     <input type="text" class="form-control" value="<?php echo $model->status_pt;?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <?= $form->field($model, 'catatan_pt')->textarea(array('rows'=>6,'cols'=>5, 'disabled'=>'disabled'))->label(false);?>   
                </div>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Semakan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->date_pt;?>" disabled="disabled">
                </div>
            </div>
               <?php }?> 
                 
        </div>
        
    </div>
    </div> 
</div>
    </div>
    </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>


