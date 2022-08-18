<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\hronline\Negara;
use dosamigos\datepicker\DatePicker;
error_reporting(0);
?>
<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1306,1309,1312], 'vars' => []]); ?>

<?php  $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="form-horizontal form-label-left"> 
    <div class="x_panel">
        <div class="x_title">
           <h2><strong><i class="fa fa-list"></i> Admin: Permohonan Pinjaman Peribadi</strong></h2>
           <div class="form-group text-right">
                <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?>
            </div>
            <div class="clearfix"></div>
        </div>
    <div class="row"> 
    <div class="x_panel"> 
        <div class="x_title">
            <h2>Maklumat Peribadi</h2>  
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    
                    <tr>
                        <td valign="5">Nama Pegawai:<span class="required" style="color:red;"></span></td>
                        <td colspan="5">  
                             
                              <?= $model->biodata->displayGelaran . ' ' . ucwords(strtolower($model->biodata->CONm)); ?>
                             
                        </td>
                    </tr>
                    <tr>
                        <td valign="2">No. Kad Pengenalan:<span class="required" style="color:red;"></span></td> 
                        <td colspan="2">
                             
                           <?php
                            if ($model->biodata->NatStatusCd == 1) {
                                echo $model->biodata->ICNO;
                            } else {
                                echo $model->latestPaspot;
                            }
                        ?>  
                             
                        </td>
                        <td valign="2">UMS-PER:<span class="required" style="color:red;"></span></td> 
                        <td colspan="2"> 
                             <?= $model->biodata->COOldID; ?>
                        </td> 
                    </tr>
                    <tr>
                        <td valign="2">J/F/P/I/B:<span class="required" style="color:red;"></span></td> 
                        <td colspan="2">
                          
                             <?= $model->biodata->department->fullname; ?>
                             
                        </td>
                        <td valign="2">Jawatan dan Gred:<span class="required" style="color:red;"></span></td> 
                        <td colspan="2"> 
                            <?= $model->biodata->jawatan->fname; ?>
                        </td> 
                    </tr>
                    
                    <tr>
                        <td valign="2">Emel:<span class="required" style="color:red;"></span></td> 
                        <td colspan="2">
                          
                             <?= $model->biodata->COEmail; ?>
                            
                        </td>
                        <td valign="2">No.Telefon / Ext:<span class="required" style="color:red;"></span></td> 
                        <td colspan="2"> 
                           <?= $model->biodata->COOffTelNo; ?> / <?= $model->biodata->COOffTelNoExtn; ?>
                        </td> 
                          
                    </tr>
                      
                     <tr>
                        <td valign="5">Alamat Pejabat:<span class="required" style="color:red;"></span></td>
                        <td colspan="5">  
                             
                              <?= $model->biodata->department->fullname; ?>,
                            Universiti Malaysia Sabah,
                            <?php
                            if ($model->biodata->campus_id == 1) {
                                echo " Jalan Universiti Malaysia Sabah, 88400 Kota Kinabalu.";
                            } else if ($model->biodata->campus_id == 2) {
                                echo " Labuan International Campus, Jln. Sungai Pagar, 87000 Labuan.";
                            } else if ($model->biodata->campus_id == 3) {
                                echo " Locked Bag No. 3, 90509 Sandakan.";
                            }
                            ?>
                           
                        </td>
                    </tr> 
                </table>
            </div>  
        </div>
    </div>
</div> 
        
      
     <?php if($model->isActive == '1'){?>  
      
        <div class ="row">  
         <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-book"></i><strong> BUTIRAN PERMOHONAN PINJAMAN PERIBADI</strong></h2>
                <div class="clearfix"></div>
            </div> 
        <div class="container">
        <div class="table-responsive">
        <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT PERMOHONAN PINJAMAN PERIBADI</center></th>

                <tr>
                        <td valign="5">Agensi / Bank:<span class="required" style="color:red;">*</span></td>
                        <td colspan="5">  
                            <div class="col-md-6 col-sm-6 col-xs-10"> 
                            <?= $form->field($model->bank, 'agensi_bank')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>

                            </div>
                        </td>
                </tr>

                <tr>
                        <td valign="5">Jumlah Pinjaman:<span class="required" style="color:red;">*</span></td>
                        <td colspan="5"> 
                            <div class="col-md-9 col-sm-9 col-xs-10"> 
                            <?= $form->field($model, 'jumlah_pinjaman')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
     
                            </div>
                        </td>

                </tr>
                 <tr>
                        <td valign="5">Jumlah Bayaran Bulanan:<span class="required" style="color:red;">*</span></td>
                        <td colspan="5"> 
                            <div class="col-md-9 col-sm-9 col-xs-10"> 
                            <?= $form->field($model, 'bayaran_bulanan')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>
     
                            </div>
                        </td>

                </tr>
                <tr>
                        <td valign="5">Jumlah Bulan Bayaran :<span class="required" style="color:red;">*</span></td>
                        <td colspan="5"> 
                            <div class="col-md-9 col-sm-9 col-xs-10"> 
                            <?= $form->field($model, 'jumlah_bulan_bayaran')->textInput(['maxlength' => true, 'disabled'=>'disabled'])->label(false); ?>   
     
                            </div>
                        </td>

                </tr>
  
        </thead>
        </table>  
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <td>BULAN/TAHUN</td>
                        <td>PENDAPATAN</td> 
                        <td>PEMOTONGAN</td> 
                        <td>JUMLAH BERSIH</td> 
                        <td>EMOLUMEN</td> 
                    </tr>
                    <?php foreach($data as $payoll){ ?>
                    <tr>
                        <td><?= $payoll->MPH_PAY_MONTH ?></td>
                        <td>RM <?= $payoll->MPH_TOTAL_ALLOWANCE?></td> 
                        <td>RM <?= $payoll->MPH_TOTAL_DEDUCTION ?></td> 
                        <td>RM <?= ($payoll->MPH_TOTAL_ALLOWANCE)-($payoll->MPH_TOTAL_DEDUCTION) ?></td> 
                        <td><?= sprintf('%0.2f', round(($payoll->MPH_TOTAL_DEDUCTION/$payoll->MPH_TOTAL_ALLOWANCE)*100, 2)) ?>%</td> 
                    </tr>
                    <?php  } ?>
               
                </table>
        </div> 
        </div>
        </div>  
       
   
        
          <?php }?>  
    
    <div class="x_panel">
        <div class="x_title">
             <h2><i class="fa fa-book"></i><strong>Semakan Oleh Pembantu Tadbir BSM</strong></h2>
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
                    <input type="text" class="form-control" value="<?php echo $model->datetimept;?>" disabled="disabled">
                </div> 
            </div>
            </div>
    </div>
        
        
    </div>
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
                    <input type="text" class="form-control" value="<?php echo $model->datetimepp;?>" disabled="disabled">
                </div>
                
            </div>
        </div>
    </div>
</div>   
        <?php ActiveForm::end(); ?>
     
  </div> 
</div>
</div>


