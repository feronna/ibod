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
        <div class="container">
        <div class="table-responsive">
        <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=6" width="120%" style="background-color:lightgrey;"><center>MAKLUMAT PERMOHONAN TAMBANG BELAS EHSAN</center></th>

                <tr>
                        <td valign="3">Permohonan Kali:<span class="required" style="color:red;"></span></td>
                        <td colspan="3">  
                            <div class="col-md-6 col-sm-6 col-xs-10"> 
                              <?= $form->field($model, 'pohon')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                            </div>
                        </td>
                </tr>
 
                <tr>
                        <td valign="2">Tujuan:<span class="required" style="color:red;"></span></td> 
                        <td colspan="2">
                            <div class="col-md-12 col-sm-12 col-xs-10"> 
                             <?= $form->field($model->vtujuan, 'tujuan')->textarea(array('rows'=>4,'cols'=>4, 'disabled'=>'disabled'))->label(false);?>
                            </div>
                        </td> 
                </tr> 
        </thead>
        </table>
            
        <table class="table table-sm table-bordered" >
        <thead>
                <tr>
                    <?php if($model->dokumen_sokongan!= NULL){?>
                    <td valign="4">Dokumen Sokongan :<span class="required" style="color:red;"></span></td>
                    <td colspan="4"><a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><i></i><u>Resit Tiket.pdf</u></a></td>
                    <?php } ?>
                    <?php if($model->dokumen_sokongan2!= NULL){?>
                    <td valign="4">Dokumen Sokongan:<span class="required" style="color:red;"></span></td>
                    <td colspan="4"><a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan2), true); ?>" target="_blank" ><i></i><u>Sijil Kematian.pdf</u></a></td>
                    <?php }?>  
                </tr> 
        </thead>
        </table>
        </div> 
        </div> 

    <!--                keluarga view-->
   
    <div class="row"> 
    <div class="x_title">
            <h2><i class="fa fa-plus-circle"></i> Tambang Untuk Seorang Ahli Keluarga ( jika pengguna tambang adalah selain pegawai) </h2> 
            <div class="clearfix"></div>
        </div> 
             <div class="x_content">
             <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <thead>
                    <tr class="headings">
                        <th>Bil.</th> 
                        <th>Nama</th>
                        <th>Hubungan</th>
                        <th>No. Kad Pengenalan</th>
                        <th>Umur</th>

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
                        <td><?= $diff = (date('Y') - date('Y',strtotime($keluargakakitangan->tarikh_lahir)));?></td>


                    </tr>

                       <?php } 

                    } else{
                        ?>
                        <tr>
                            <td colspan="4" class="text-center">Tiada Rekod</td>                     
                        </tr>
                      <?php  
                    } ?>
                </table>
                </div>
            </div>  
    </div>
     </div> 
<!--            rekod keluarga  -->  
                 
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
         
            <?php if($model->status_pp == 'MENUNGGU KELULUSAN' || $model->status_pp == ''){?>  
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
                    'data' => ['DIPERAKUI' => 'DIPERAKUI',
                                   'TIDAK DIPERAKUI' => 'TIDAK DIPERAKUI',],
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
        </div><?php }?>
           
             
            <?php if($model->status_pp == 'DIPERAKUI' || $model->status_pp == 'TIDAK DIPERAKUI'){?>  
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
                
                 <?php }?>
        </div></div>
            
    </div>
    </div>
        </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>


