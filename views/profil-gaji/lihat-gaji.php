<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
error_reporting(0);
$statusLabel = [
        '1' => 'Monthly',
        '2' => 'Part-time/Claims-based Salary',
        '3' => 'Bonus/Cash Assist (Separate)',
        '4' => 'BOD'
];
?>


        <div class ="row"> 
       <div class="col-md-12 col-xs-12"> 
         <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-money"></i><strong> PROFIL GAJI</strong></h2>
                <div class="clearfix"></div>
            </div> 
        <div class="container">
        <div class="table-responsive">
            
         <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT AKAUN</center></th>
                </thead></table>
              
            <table class="table table-sm table-bordered" >    
                <tr>
                        <td width="100px" height="20px">Nama Akaun</td> 
                        <td colspan="5">
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?=$akaun->SA_BANK_CODE?>" disabled="">
                                <div class="help-block"></div>
                        
                        </td>
                        
                        <td width="100px" height="20px">No Akaun</td> 
                        <td colspan="5">
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?=  $akaun->SA_ACCT_NO ?>" disabled="">
                                <div class="help-block"></div>
                        </td>
                </tr>
           </table>
          
        <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT TARIKH</center></th>
                </thead></table>
              
            <table class="table table-sm table-bordered" >    
                <tr>
                        <td width="100px" height="20px">Tarikh Mula</td> 
                        <td colspan="5">
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?=$model->tarikhMula?>" disabled="">
                                <div class="help-block"></div>
                     
                        </td>
                        
                        <td width="100px" height="20px">Tarikh Akhir</td> 
                              <td colspan="5">
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?php
                                 if($model->SS_END_DATE == '0000-00-00 00:00:00'){
                                echo '';
                             }else{
                               echo $model->tarikhTamat;
                             }
                            ?>" disabled="">
                                <div class="help-block"></div>
                     
                        </td>
                        </tr>
           </table>
            
             <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>MAKLUMAT GAJI</center></th>
                </thead></table>
             
              <table class="table table-sm table-bordered" >
                    <thead>
                        
                    <tr>
                      <td width="100px" height="10px">Jenis Gaji</td> 
                      <td colspan="5">  
           
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?= strtoupper($statusLabel[$model->SS_SALARY_TYPE])?>" disabled="">
                                <div class="help-block"></div>
                          </td>
                    </tr>
                 <tr>
                     <td width="100px" height="10px">Status Gaji</td> 
                      <td>
     
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?php if($model->SS_SALARY_STATUS == 'Y'){
                                echo 'YA';
                              }if($model->SS_SALARY_STATUS == 'N'){
                               echo 'TIDAK';
                              }?>" disabled="">
                                <div class="help-block"></div>
                  
                      </td>
                    <td valign="1" width="100px" height="10px">Kadar Harian/Jam</td> 
                              <td colspan="5">
                      
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?= $model->SS_RATE?>" disabled="">
                                <div class="help-block"></div>
                        
                            </td>
                 </tr>

                    </thead> 
               </table>
            
            
              <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>CUKAI</center></th>
              
        </thead>
              </table>

               <table class="table table-sm table-bordered" >
                   <tr>
                      <td width="100px" height="10px">Cukai?</td> 
                      <td>
                 
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?php if($model->SS_EPF_STATUS == 'Y'){
                                echo 'YA';
                              }if($model->SS_EPF_STATUS == 'N'){
                               echo 'TIDAK';
                              }?>" disabled="">
                                <div class="help-block"></div>
                         
                     </td>
                   </tr>
                
                    <tr>
                      <td width="100px" height="10px">Kategori Cukai</td> 
                      <td colspan="8">  
           
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?= strtoupper($model->kategoriCukai->TC_CATEGORY_DESC)?>" disabled="">
                                <div class="help-block"></div>
                          </td>
                    </tr>
                    
                     <tr>
                
                      <td width="100px" height="10px">Formula Cukai</td> 
                          <td colspan="5">  
                     
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?= strtoupper($model->formulaCukai->TFT_DESC)
                              ?>" disabled="">
                                <div class="help-block"></div>
                     
                     </td>
                    </tr>
                        
                
                        
                      <tr>
                     <td width="100px" height="10px">Cukai Bayar Zakat</td> 
                          <td colspan="5">
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?php  if($model->SS_ZAKAT_STATUS == 'Y'){
                                echo 'YA';
                              }if($model->SS_ZAKAT_STATUS == 'N'){
                               echo 'TIDAK';
                              }else{
                                  echo '';
                              }
                              ?>" disabled="">
                                <div class="help-block"></div>
                         
                      </td>
                    <td valign="1" width="100px" height="10px">Zakat Bayar Kepada</td> 
                             <td colspan="5">
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?php  if($model->SS_ZAKAT_CODE == 'NULL'){
                                 echo '';
                              }else{
                                 echo strtoupper($model->SS_ZAKAT_CODE);
                              }
                              ?>" disabled="">
                                <div class="help-block"></div>
                 
                     
                          </td>
                </tr></table>
            
            
              <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>KWSP</center></th>
                </thead></table>
            
              <table class="table table-sm table-bordered" >
                 <tr>
                     <td width="100px" height="10px">KWSP?</td> 
                        <td colspan="5"> 
                   
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?php   if ($model->SS_TAX_STATUS == 'Y'){
                                echo 'YA';
                              }if($model->SS_TAX_STATUS == 'N'){
                                  echo 'TIDAK';
                              }else{
                                  echo '';
                              }
                              ?>" disabled="">
                                <div class="help-block"></div>
            
                      </td>
                 </tr>
        

                    <tr>
                     <td width="100px" height="10px">Jenis KWSP</td> 
                  
                         <td colspan="5">
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?= strtoupper($model->jenisKwsp->ET_DESC) ?>"
                               disabled="">
                                <div class="help-block"></div>
                 
                        
                      </td>
                    <td valign="1" width="200px" height="10px">Kaedah Kiraan</td> 
                          <td colspan="5">
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?= strtoupper($model->SS_EPF_METHOD) ?>"
                              disabled="">
                                <div class="help-block"></div>
                    
                      </td>
                   </tr>
                
                 <tr>
                     <td width="100px" height="10px">Pekerja %</td> 
                          <td colspan="5">
                       <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?= strtoupper($model->SS_EPF_EMPYEE_PCT)?>"
                              disabled="">
                                <div class="help-block"></div>
                    
                      </td>
                    <td valign="1" width="100px" height="10px">Majikan %</td> 
                           <td colspan="5">
                        <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?= strtoupper($model->SS_EPF_EMPYER_PCT)?>"
                              disabled="">
                                <div class="help-block"></div>
                      
                       </td>
                </tr>
                          </table>
            
                <table class="table table-sm table-bordered" >
        <thead>
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>PERKESO</center></th>
                </thead></table>
            
            
             <table class="table table-sm table-bordered" >
                <tr>
                     <td width="100px" height="10px">PERKESO</td> 
                       <td>
                        <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?php if($model->SS_SOCSO_STATUS == 'Y'){
                                echo 'YA';
                              }if($model->SS_SOCSO_STATUS == 'N'){
                               echo 'TIDAK';
                              }?>"
                              disabled="">
                         <div class="help-block"></div>
                    
                      </td>
                
                    <td valign="1" width="100px" height="10px">Jenis Perkeso</td> 
                      <td colspan="5">
                             <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?= strtoupper($model->jenisPerkeso->ST_DESC)?>"
                              disabled="">
                         <div class="help-block"></div>
                       
                      
                          </td>
                </tr>
                 </table>
            
                    <table class="table table-sm table-bordered" >
               <thead>
                <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;"><center>LAIN-LAIN</center></th>
                </thead></table>
            
            <table class="table table-sm table-bordered" >
              <tr>
                     <td width="100px" height="10px">Pencen?</td> 
                      <td>  
           
                             <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?php   if($model->SS_PENSION_STATUS == 'Y'){
                                echo 'YA';
                              }if($model->SS_PENSION_STATUS == 'N'){
                               echo 'TIDAK';
                              }?>"
                              disabled="">
                         <div class="help-block"></div>
                     
                      </td>
           
                        <td width="100px" height="20px">No. Pendaftaran Kumpulan Wang Persaraan (Diperbadankan)</td> 
                        <td> 
                       
                                <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?= $kwap->SA_ACCT_NO?>" disabled="">
                                <div class="help-block"></div>
                           
                        </td>
              </tr>
                        
                        <tr>
                     <td width="100px" height="10px">Sebab Perubahan</td> 
                      <td colspan="5">  
                        
                             <input type="text" id="" class="form-control col-md-6 col-sm-6 col-xs-12" name="" value="<?= strtoupper($model->SS_CHANGE_REASON) ?>"
                              disabled="">
                            <div class="help-block"></div>
                    
                      </td>
                        </tr>

              </table>
        </div>
    
        </div>
        </div>  
       </div>
    </div> 