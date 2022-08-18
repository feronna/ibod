<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\grid\GridView;
?>



<?php  $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86], 'vars' => []]); ?>
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
                 
                <label class="control-label col-md-3 col-sm-3 col-xs-12">J/ A/ F/ P/ I/ B  <span class="required"></span>
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
        
<div class="row"> 
    <div class="x_panel">
       
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i>REKOD PEMAKAIAN ELAUN PAKAIAN PANAS</strong></h2>
          <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
                <div class="clearfix"></div>
            </div>
        <?= GridView::widget([
         'dataProvider' => $dataProvider,
         'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => 'Mesyuarat/ Seminar/ Lawatan/ Kursus'], 
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn',
                                'header' => 'Bil',
                                'vAlign' => 'middle',
                                'hAlign' => 'center',
                
                                ],
            [
                'label' => 'Tarikh',
                'value' => 'entrydate'
            ],
            [
                'label' => 'Tujuan',
                'value' => 'butiran'
            ], 
            [
                'label' => 'Destinasi',
                'value' => function($dataProvider) { return $dataProvider->nama_tempat  . " " . $dataProvider->negara ;},
            ],
//             [
//                'label' => 'Jumlah',
//                'value' => 'jumlah'
//            ],
           
            
        ],
    ]); ?>


        </div>
    </div>

        <div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-book"></i><strong> BUTIR-BUTIR TEMPAT BERTUGAS / PERJALANAN / KURSUS DI LUAR NEGARA</strong></h2>
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
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT PEMAKAIAN ELAUN PAKAIAN PANAS</center></th>

                <tr>
                        <td valign="5">Butiran:<span class="required" style="color:red;">*</span></td>
                        <td colspan="5">  
                            <div class="col-md-6 col-sm-6 col-xs-10"> 
                            <?= $form->field($model->reftujuan, 'tujuan')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>

                            </div>
                        </td>
                </tr>

                <tr>
                        <td valign="5">Tujuan:<span class="required" style="color:red;">*</span></td>
                        <td colspan="5"> 
                            <div class="col-md-12 col-sm-12 col-xs-10"> 
                            <?= $form->field($model, 'tujuan')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                            </div>
                        </td>

                </tr> 

                <tr>
                        <td valign="2">Nama Tempat:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="2">
                            <div class="col-md-12 col-sm-12 col-xs-10"> 
                            <?= $form->field($model, 'nama_tempat')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                            </div>
                        </td>
                        <td valign="2">Negara:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="2"> 
                            <?= $form->field($model, 'negara')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>   
                        </td>
 
                 </div> 
                </tr>
                
                <tr>
                        <td valign="1">Dari:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="1">
                            <?= $form->field($model, 'datefrom')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                        </td>
                        <td valign="1">Hingga:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="1">
                            <?= $form->field($model, 'dateTo')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>    
                        </td>
                        <td valign="1">Tempoh:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="1">
                        <div class="col-md-6 col-sm-6 col-xs-12"> 
                             <?= $form->field($model, 'days')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
                        </div>
                        </td>
 
                 </div> 
                </tr>
                
                 
        </thead>
        </table>
            
        <table class="table table-sm table-bordered" >
        <thead>
                <tr>
                    <?php if($model->dokumen_sokongan!= NULL){?>
                    <td valign="4">Dokumen LN 1 :<span class="required" style="color:red;">*</span></td>
                    <td colspan="4"><a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan), true); ?>" target="_blank" ><i></i><u>Dokumen LN1.pdf</u></a></td>
                    <?php } ?>
                    <?php if($model->dokumen_sokongan2!= NULL){?>
                    <td valign="4">Surat Kelulusan:<span class="required" style="color:red;">*</span></td>
                    <td colspan="4"><a class="form-control" style="border:0;box-shadow: none;" href="<?php echo yii\helpers\Url::to(Yii::$app->FileManager->DisplayFile($model->dokumen_sokongan2), true); ?>" target="_blank" ><i></i><u>Surat Kelulusan.pdf</u></a></td>
                    <?php }?>  
                </tr> 
        </thead>
        </table>
        </div> 
        </div>  
</div> 
    
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
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Semakan :  <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">    
                 <input type="text" class="form-control" value="<?php echo $model->status;?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                <?= $form->field($model, 'catatan')->textarea(array('rows'=>6,'cols'=>5, 'disabled'=>'disabled'))->label(false);?>   
                </div>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Semakan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->reviewdate;?>" disabled="disabled">
                </div>
            </div>
            </div>
    </div>
    </div>
    
       
       <?php if($model->status_pp == 'MENUNGGU KELULUSAN' || $model->status_pp == '' && $model->entry_type == 1){?>  
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
           <?php if($model->status_pp == 'DIPERAKUI' || $model->status_pp == 'TIDAK DIPERAKUI' || $model->status_pp == 'TIDAK DIPERAKUKAN' || $model->status_pp == 'DIPERAKUKAN'){?>  
            
          
    <div class="x_panel">
        <div class="x_title">
             <h2><i class="fa fa-book"></i><strong> Status Perakuan Pegawai BSM</strong></h2>
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
                    <input type="text" class="form-control" value="<?php  echo $model->verdate;?>" disabled="disabled">
                </div>
            </div>
            </div>
           <?php }?>
    </div>
</div>      
    </div> 
    </div> 
            <?php ActiveForm::end(); ?>
        </div>
    </div>


