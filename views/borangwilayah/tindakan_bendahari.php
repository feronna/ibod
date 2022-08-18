<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

?>
 
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,1410,1470], 'vars' => []]); ?>
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
                 
                <label class="control-label col-md-3 col-sm-3 col-xs-12">J/ A/ F/ P/ I/ B <span class="required"></span>
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
                 <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. Telefon Bimbit <span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COHPhoneNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                
                <label class="control-label col-md-3 col-sm-3 col-xs-12">No. UC<span class="required"></span>
                </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                 <?= $form->field($model->kakitangan, 'COOUCTelNo')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                </div>
                
                 
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
                <th scope="col" colspan=8" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT TAMBANG MENGUNJUNGI WILAYAH ASAL</center></th>

                <tr>
                        <td valign="4">Wilayah Asal :<span class="required" style="color:red;">*</span></td>
                        <td colspan="3"> 
                            
                            <?php if($model->entry_type == 1){ ?>
                                <?= $form->field($model, 'wilayah_asal')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                            <?php }else{ ?>
                                <input type="text" class="form-control" value="<?php echo $model->wilayah_asal;?>" disabled="disabled">
                            <?php } ?>
                        </td>
                         
                        <td valign="4">Kampus Cawangan :<span class="required" style="color:red;"></span></td>
                        <td colspan="3"> 
                        <?= $form->field($model->kakitangan->kampus, 'campus_name')->textArea(['maxlength' => true, 'rows' => 4])->textInput(['disabled'=>'disabled'])->label(false); ?>
                          
                        <?php // $form->field($model, 'wilayah_asal')->textInput(['maxlength' => true]) ->label(false); ?>
                        </td>
                            
                        </td> 
                </tr>
                 <tr>
                        <td valign="4">Tarikh Terakhir Kemudahan Digunakan :<span class="required" style="color:red;"></span></td>
                        <td colspan="3"> 
                           <?php
                            if($mod){
                                echo ' <input type="text" class="form-control" value="'.$mod->lastdt.'" disabled="disabled">'; //id 1 n 2 
                            } 
                            else { 
                                 echo '<input type="text" class="form-control" value="" disabled="disabled">' ;
                            } 
                            ?>  
                        </td>
                        <td valign="4">Tarikh Kemudahan Akan Digunakan :<span class="required" style="color:red;">*</span></td>
                        <td colspan="3">
                            <input type="text" class="form-control" value="<?php echo $model->useddt;?>" disabled="disabled">
                              
                        </td> 
                </tr> 
                </thead>
                <tr class="headings">
                                
                     <td valign="4">Tujuan :<span class="required" style="color:red;">*</span></td>
                     <td colspan="8">
                            <input type="text" class="form-control" value="<?php echo $model->tujuan;?>" disabled="disabled">
                                </td>
                                 
                           
                            </tr>
            </table> 
            <table class="table table-sm table-bordered" >
        <thead>
                <tr>
                    <?php // if($model->dokumen_sokongan!= NULL){?>
<!--                    <td valign="4">Dokumen Sokongan :<span class="required" style="color:red;"></span></td>
                    <td colspan="4"><a class="form-control" style="border:0;box-shadow: none;" href="<?php // echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><i></i><u>Dokumen Sokongan.pdf</u></a></td>-->
                    <?php // } ?>
                    <?php if($model->dokumen_sokongan2!= NULL){?>
                    <td valign="4">Dokumen Sokongan:<span class="required" style="color:red;"></span></td>
                    <td colspan="4"><a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan2), true); ?>" target="_blank" ><i></i><u>Dokumen Sokongan.pdf</u></a></td>
                    <?php }?>  
                </tr> 
        </thead>
        </table>
        </div>
      </div>  
             
   
 
   
    <div class="row"> 
    <div class="x_title">
            <h2><i class="fa fa-plus-circle"></i> Maklumat Pasangan dan Anak Jenis Maklumat
                <!--(A = Anak, S = Suami, I = Isteri)</center></h2>-->
            <div class="clearfix"></div>
        </div> 
             <div class="x_content">
             <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <thead>
                    <tr class="headings">
                       <th>Bil.</th>
                        <th>Nama</th>
                        <th>Umur </th>
                        <th>No.Mykad </th>
                        <th>Tarikh Lahir </th> 
                        <th>Jenis Maklumat</th>
                         

                    </tr>
                    </thead>
                    <?php if($keluarga) {  $bil=1; 
                       foreach ($keluarga as $keluargakakitangan) { 
                    ?>

                    <tr>
                        <th><?= $bil++ ?></th>
                        <td><?= $keluargakakitangan->nama; ?></td>
                        <td><?= $diff = (date('Y') - date('Y',strtotime($keluargakakitangan->tarikh_lahir)));?> </td>
                        <td><?= $keluargakakitangan->icno; ?></td>
                        <td><?= $keluargakakitangan->tarikhLahir;?> </td>
                        <td><?= $keluargakakitangan->hubungan; ?></td>
                       

                    </tr>

                       <?php } 

                    } else{
                        ?>
                        <tr>
                            <td colspan="6" class="text-center">Tiada Rekod</td>                     
                        </tr>
                      <?php  
                    } ?>
                </table>
                </div>
            </div>  
    </div> 
        
        <div class="row"> 
    <div class="x_title">
            <h2><i class="fa fa-plus-circle"></i> Jadual Penerbangan Yang Dirancang / Ditempah</h2> 
            <div class="clearfix"></div>
        </div> 
             <div class="x_content">
             <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <thead>
                    <th scope="col" colspan=17" width="30%" class="headings"><center>Jadual Penerbangan Yang Dirancang/ Ditempah <br> 
                        <!--(S = Sendiri, P = Pasangan, A = Anak)</center></th>-->
                    <tr class="headings">
                        
                        <th scope="col" colspan=4"  ><center>PERLEPASAN</center></th>
                        <th scope="col" colspan=3" ><center>KETIBAAN</center></th>
                        <!--<th scope="col" colspan=2" > </th>-->
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
                        <!--<th>JENIS(S/P/A)</th>-->
                        <!--<th>KELAS(Y/C)</th>--> 

                    </tr>
                    </thead>
                    <?php if($planes) {  $bil=1;
                       foreach ($planes as $planes) { 
                    ?>

                    <tr>
                        <th><?= $bil++ ?></th>
                        <td><?= $planes->tarikh_berlepas; ?></td>
                        <td><?= $planes->dest_berlepas ?> </td>
                        <td><?= $planes->masa_berlepas; ?></td>
                        <td><?= $planes->tarikh_tiba; ?></td>
                        <td><?= $planes->dest_tiba ?> </td>
                        <td><?= $planes->masa_tiba; ?></td>
                        <!--<td><center><?php // $planes->tempahan->jenisTempahan; ?></center></td>-->
<!--                        <td><center><?php// $planes->penerbangan->jenisKelas; ?></center></td>-->

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
        </div> 
        </div>
    </div> 
        
        <?php if($model->status_pp == 'MENUNGGU KELULUSAN'){?>  
        <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-book"></i><strong>  Status Perakuan Pegawai BSM</strong></h2>
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Perakuan : <span class="required"></span>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12">    
                <?= $form->field($model, 'status_pp')->label(false)->widget(Select2::classname(), [
                    'data' => ['DIPERAKUKAN' => 'DIPERAKUKAN',
                                   'TIDAK DIPERAKUKAN' => 'TIDAK DIPERAKUKAN',],
                   'options' => [
                         'placeholder' => 'Sila Pilih'],

                ]); ?>
            </div>
            </div>
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12">
             <?= $form->field($model, 'catatan_pp')->textarea(array('rows'=>6,'cols'=>5))->label(false);?> 
            </div>
            </div> 
            <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                <button class="btn btn-primary" type="reset">Reset</button> 
            </div>
            </div>
            <?php }?> 
             
        <?php if($model->status_pp == 'DIPERAKUKAN' || $model->status_pp == 'TIDAK DIPERAKUKAN' || $model->status_pp == 'DIPERAKUI' || $model->status_pp == 'TIDAK DIPERAKUI'){?>  
        <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-book"></i><strong>  Status Perakuan Pegawai BSM</strong></h2>
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Perakuan : <span class="required"></span>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12">    
            <input type="text" class="form-control" value="<?php echo $model->status_pp;?>" disabled="disabled">
            </div>
            </div>
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12">
            <?= $form->field($model, 'catatan_pp')->textarea(array('rows'=>6,'cols'=>5, 'disabled'=>'disabled'))->label(false);?>   
            </div>
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Perakuan : <span class="required"></span>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12">
            <input type="text" class="form-control" value="<?php echo $model->verdate;?>" disabled="disabled">
            </div>
            </div>
            </div>
        </div>
            </div>
        <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-book"></i><strong>  Status Kelulusan Ketua BSM</strong></h2>
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Kelulusan : <span class="required"></span>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12">    
            <input type="text" class="form-control" value="<?php echo $model->status_kj;?>" disabled="disabled">
            </div>
            </div>
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12">
            <?= $form->field($model, 'catatan_kj')->textarea(array('rows'=>6,'cols'=>5, 'disabled'=>'disabled'))->label(false);?>  
            </div>
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Kelulusan : <span class="required"></span>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12">
            <input type="text" class="form-control" value="<?php  echo $model->appdate;?>" disabled="disabled">
            </div>
            </div>
            </div>
        </div>
        </div>
     <?php }?> 
                
        <?php // if($model->stat_bendahari == 'EFT'){?>         
<!--        <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-book"></i><strong>  Status Bendahari</strong></h2>
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status : <span class="required"></span>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12">    
            <input type="text" class="form-control" value=" " disabled="disabled">
            </div>
            </div>
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12">
            
            </div>
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh : <span class="required"></span>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12">
            <input type="text" class="form-control" value=" " disabled="disabled">
            </div>
            </div>   
            </div>-->
       <?php // }?>
                
        <?php // if($model->stat_bendahari == 'DALAM PROSES BAYARAN' || $model->stat_bendahari == ''){?>        
<!--        <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-book"></i><strong>  Status Bendahari</strong></h2>
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status : <span class="required"></span>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12">    
                 
            </div>
            
            <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12">
          
            </div>
            </div>    
          
        <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
            <button class="btn btn-primary" type="reset">Reset</button>
        </div>
        </div> 
        <?php //}?>    
    </div>    -->
</div>        
</div> 
            <?php ActiveForm::end(); ?>
</div>
</div>
        </div>
            </div>

