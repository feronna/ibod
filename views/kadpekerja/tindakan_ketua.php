<?php

use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;   
use yii\helpers\Html;

?> 
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1319,1322,1324,1326], 'vars' => []]); ?>
<div class="form-horizontal form-label-left"> 
    <div class="x_panel">
        <div class="x_title">
           <h2><strong><i class="fa fa-list"></i> Maklumat Permohonan Kad Pekerja</strong></h2>
           <div class="form-group text-right">
            <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
            </div>
            <div class="clearfix"></div>
        </div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
    <div class="row"> 
    <div class="x_panel"> 
        <div class="x_title">
            <h2>Butiran Peribadi</h2>  
            
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama Pegawai</th>
                        <td>
                         <?= $model->biodata->displayGelaran . ' ' . ucwords(strtolower($model->biodata->CONm)); ?>
                        </td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Kad Pengenalan</th>
                        <td> 
                        <?php
                            if ($model->biodata->NatStatusCd == 1) {
                                echo $model->biodata->ICNO;
                            } else {
                                echo $model->biodata->latestPaspot;
                            }
                        ?>
                        </td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">UMS-PER</th>
                        <td>
                        <?= $model->biodata->COOldID; ?>
                        </td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. Telefon</th>
                        <td>
                        <?= $model->biodata->COHPhoneNo; ?>
                        </td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Emel</th>
                        <td>
                        <?= $model->biodata->COEmail; ?>
                        </td> 
                    </tr>
                     
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                        <td>
                        <?= $model->biodata->jawatan->nama; ?>
                        </td> 
                    </tr>
                     
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">JFPIB</th>
                        <td>
                           <?= $model->biodata->department->fullname; ?>
                           
                        </td> 
                    </tr>  
                </table>
            </div> 

        </div>
    </div>
      
        <div class ="row"> 
       <div class="col-md-12 col-xs-12"> 
         <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-book"></i><strong> BUTIRAN PERMOHONAN</strong></h2>
                <div class="clearfix"></div>
            </div> 
        <div class="container">
        <div class="table-responsive">
        <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>BUTIRAN PERMOHONAN KAD PEKERJA</center></th>
 
                <tr>
                        <td valign="2">Jenis Kad:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="5">
                        <?= $form->field($model->kadPekerja, 'card_type')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?>  
                        </td> 
                </tr>
                <tr>
                        <td valign="2">Tarikh Mohon:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="5">
                        <?= $form->field($model,  'entryDt' )->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?>  
                        </td> 
                </tr>
                 <tr>
                        <td valign="2">Payment:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="5"> 
                            
                        </td> 
                </tr> 
        </thead>
                          </table> 
        </div>
        </div>  
        </div>
        </div> 
        </div>
        
         
        <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-book"></i><strong> Pegawai Tadbir</strong></h2>
<!--            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>-->
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="container">
        
            <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->ver_stat;?>" disabled="disabled">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <?= $form->field($model, 'ver_catatan')->textarea(array('rows'=>6,'cols'=>5, 'disabled'=>'disabled'))->label(false);?>     
                </div>
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Semakan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $model->ver_date;?>" disabled="disabled">
                </div>
            </div>
                 
        </div>     
        </div> 
        </div> 
        </div>
   
        
    <?php if($model->app_stat == 'MENUNGGU TINDAKAN'){?>  
        <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-book"></i><strong> Ketua Seksyen</strong></h2>
<!--            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>-->
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="container">
        
            <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                     <?= $form->field($model, 'app_stat')->label(false)->widget(Select2::classname(), [
                    'data' => ['DILULUSKAN' => 'DILULUSKAN',
                                   'TIDAK DILULUSKAN' => 'TIDAK DILULUSKAN',],
                   'options' => [
                         'placeholder' => 'SILA PILIH'],

                ]); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <?= $form->field($model, 'app_catatan')->textarea(array('rows'=>6,'cols'=>5))->label(false);?>   
                </div>
            </div>
                <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                <button class="btn btn-primary" type="reset">Reset</button> 
            </div>
        </div> 
        </div>     
        </div> 
        </div> 
        </div>
    <?php } ?>
            <?php if($model->app_stat == 'DILULUSKAN' || $model->app_stat == 'TIDAK DILULUSKAN'){?>  

        <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-book"></i><strong> Ketua Seksyen</strong></h2>
<!--            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>-->
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="container">
         
            <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                 <?= $form->field($model,  'app_stat' )->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?>   
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <?= $form->field($model, 'app_catatan')->textarea(array('rows'=>6,'cols'=>5, 'disabled'=>'disabled'))->label(false);?>   
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh : <span class="required"></span>
                </label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <?= $form->field($model, 'app_date')->textInput(['maxlength' => true, 'disabled'=>'disabled']) ->label(false);?>     
                </div>
            </div>
                 
        </div>     
        </div> 
        </div> 
        </div>
        <?php } ?> 
    </div></div></div>

     

    <?php ActiveForm::end(); ?> 

</div> 
</div>  

</div>