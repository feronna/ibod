


 <?php 
 use yii\helpers\Html;

 
 echo $this->render('/cutibelajar/_topmenu'); 
 
 error_reporting(0);?>
    <p align="right"><?= Html::a('Kembali', ['cutibelajar/halaman-pemohon'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>
<div class="x_panel">
<div class="x_content"> 
    
<span class="required" style="color:#062f49;">
<center> <h2><strong><?= strtoupper('
REKOD NOMINAL DAMAGES & BON PERKHIDMATAN'); ?>
                        </strong></h2> </center>
            </span> 
</div>
</div>

 
  
<div class="x_panel">
    <br/>
<div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
          
            <table class="table" style="width:100%">
                <thead>
                    <tr>
                        <th colspan="6"><i class="fa fa-legal"></i> NOMINAL DAMAGES</th> 
                    </tr>
                </thead>
            </table>
            <div class="col-md-12 col-sm-12 col-xs-12"> 

                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> 

                                    <?php
//                                    $B = $biodata->pengajian;
                                    if ($nd) {
                                        $bil1 = 1;
                                        ?>
                                            <th scope="col" colspan="6" width="100%" style="background-color:lightgrey;"><center>PENGIRAAN TEMPOH BERKHIDMAT</center></th>

                                        <tr>
                                            <th class="text-center">TARIKH NOMINAL DAMAGES</th>
                                            <th class="text-center">CATATAN</th>
<!--                                            <th class="text-center" style="width: 10%;">TEMPOH PENGAJIAN</th>-->
                                          

                                        </tr>
<!--                                             <tr><th class="text-center">CATATAN</th></tr>-->
                                       


                                        <?php foreach ($nd as $l) { ?>

                                            <tr>
                                                <td class="text-center"><?= strtoupper($l->dt_nominal);?></td>
                                            
                                                <td class="text-center" scope="col" colspan="6"></td></tr>
                                                
                                            </tr>
                                                

                                            <?php
                                        }
                                        
                                    }
                                    else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                        </tr>
<?php }
                                    ?>
                                            
                                </table>
                             
                            </div>
                        </div>
                    </div>
        </div></div></div>


    


<div class="x_panel">
    <br/>
<div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
          
            <table class="table" style="width:100%">
                <thead>
                    <tr>
                        <th colspan="6"><i class="fa fa-calculator"></i> BON PERKHIDMATAN</th> 
                    </tr>
                </thead>
            </table>
                
                
                    <div class="col-md-12 col-sm-12 col-xs-12"> 

                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> 

                                    <?php
//                                    $B = $biodata->pengajian;
                                    if ($bon) {
                                        $bil1 = 1;
                                        ?>
                                            <th scope="col" colspan="6" width="100%" style="background-color:lightgrey;"><center>PENGIRAAN TEMPOH BERKHIDMAT</center></th>

                                        <tr>
                                            <th class="text-center">TARIKH MULA BERKHIDMAT</th>
                                            <th class="text-center">CATATAN</th>
<!--                                            <th class="text-center" style="width: 10%;">TEMPOH PENGAJIAN</th>-->
                                          

                                        </tr>
<!--                                             <tr><th class="text-center">CATATAN</th></tr>-->
                                       


                                        <?php foreach ($bon as $l) { ?>

                                            <tr>
                                                <td class="text-center"><?= strtoupper($l->dt_mkhidmat);?></td>
                                            
                                                <td class="text-center" scope="col" colspan="6"><?= strtoupper($l->catatan);?></td></tr>
                                                
                                            </tr>
                                                <tr><th class="text-right" scope="col">JUMLAH TEMPOH PERKHIDMATAN</th>
                                                 <td class="text-center" ><?= strtoupper($l->j_bon);?></td></tr>

                                            <?php
                                        }
                                        
                                    }
                                    else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                        </tr>
<?php }
                                    ?>
                                            
                                </table>
                             
                            </div>
                        </div>
                    </div>
            
            <div class="col-md-12 col-sm-12 col-xs-12"> 

                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> 

                                    <?php
//                                    $B = $biodata->pengajian;
                                    if ($bon) {
                                        $bil1 = 1;
                                        ?>
                                            <th scope="col" colspan="6" width="100%" style="background-color:lightgrey;"><center>MAKLUMAT BON PERKHIDMATAN</center></th>

                                        <tr>
                                            <th class="text-center">PERKARA</th>
                                            <th class="text-center">CATATAN</th>
                                          

                                        </tr>
<!--                                             <tr><th class="text-center">CATATAN</th></tr>-->
                                       


                                        <?php foreach ($bon as $l) { ?>

                                            <tr>
                                                <td class="text-left">TEMPOH BON PHD</td>
                                            
                                                <td class="text-center" scope="col" colspan="6">6 Tahun (72 Bulan)</td></tr>
                                                
                                            </tr>
                                            <tr>
                                                <td class="text-left">TEMPOH BON SABATIKAL</td>
                                            
                                                <td class="text-center" scope="col" colspan="6">1 Tahun (12 Bulan)</td></tr>
                                                
                                            </tr>
                                            
                                             <tr>
                                                <td class="text-left">JUMLAH BON</td>
                                            
                                                <td class="text-center" scope="col" colspan="6">7 Tahun (84 Bulan)</td></tr>
                                                
                                            </tr>
                                             <tr>
                                                <td class="text-left">JUMLAH PERKHIDMATAN DARI LAPOR DIRI</td>
                                            
                                                <td class="text-center" scope="col" colspan="6">4 Tahun 1 BULAN (49 Bulan)</td></tr>
                                                
                                            </tr>
                                                <tr><th class="text-right" scope="col">BAKI BON PERHIDMATAN</th>
                                                    <td class="text-center" ><b>2 Tahun 11 Bulan (35 Bulan)</b></td></tr>

                                            <?php
                                        }
                                        
                                    }
                                    else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                        </tr>
<?php }
                                    ?>
                                            
                                </table>
                             
                            </div>
                        </div>
                    </div>
            
            
            <div class="col-md-12 col-sm-12 col-xs-12"> 

                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> 

                                    <?php
//                                    $B = $biodata->pengajian;
                                    if ($bon) {
                                        $bil1 = 1;
                                        ?>
                                            <th scope="col" colspan="6" width="100%" style="background-color:lightgrey;"><center>PENGIRAAN JUMLAH GANTIRUGI</center></th>

                                        <tr>
                                            <th class="text-center">PERKARA</th>
                                            <th class="text-center">CATATAN</th>
<!--                                            <th class="text-center" style="width: 10%;">TEMPOH PENGAJIAN</th>-->
                                          

                                        </tr>
<!--                                             <tr><th class="text-center">CATATAN</th></tr>-->
                                       


                                        <?php foreach ($bon as $l) { ?>

                                            <tr>
                                                <td class="text-left"><b>TUNTUTAN GANTIRUGI PHD:</b> <br><br>
                                                    - Perbelanjaan Cuti Belajar <br><br>
                                                    Jumlah Gantirugi secara Pro Rata:<br>
                                                    <i>(Baki ikatan kontrak didarab dengan jumlah keseluruhan tuntutan<br>
                                                        dan kemudinnya dibahagi dengan ikatan kontrak keseluruhan)</i></td>
                                            
                                                        <td  scope="col" colspan="6">= RM243,411.15 <i>(Tempoh pengajian lebih 3 tahun pengajian luar negara<br/>
                                                                dengan kos sebenar sehingga 04 Oktober 2013)</i><br><br>

                                                                = <u>35 Bulan X RM243,411.15</u><br><br>
                                                    72 Bulan (Jumlah ikatan keseluruhaan – 6 Tahun)<br>
                                                    <b> = RM118,324.86</b>
</td></tr>
                                                
                                            </tr>
<!--                                            <tr>
                                                <td class="text-left">TEMPOH BON SABATIKAL</td>
                                            
                                                <td class="text-center" scope="col" colspan="6">1 Tahun (12 Bulan)</td></tr>
                                                
                                            </tr>
                                            -->
                                             <tr>
                                                <td class="text-left">JUMLAH TUNTUTAN KESELURUHAN</td>
                                            
                                                <td class="text-center" scope="col" colspan="6">7 Tahun (84 Bulan)</td></tr>
                                                
                                            </tr>
<!--                                             <tr>
                                                <td class="text-left">JUMLAH PERKHIDMATAN DARI LAPOR DIRI</td>
                                            
                                                <td class="text-center" scope="col" colspan="6">4 Tahun 1 BULAN (49 Bulan)</td></tr>
                                                
                                            </tr>
                                                <tr><th class="text-right" scope="col">BAKI BON PERHIDMATAN</th>
                                                    <td class="text-center" ><b>2 Tahun 11 Bulan (35 Bulan)</b></td></tr>-->

                                            <?php
                                        }
                                        
                                    }
                                    else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center"><i>Maaf, Tiada Rekod</i></td>                     
                        </tr>
<?php }
                                    ?>
                                            
                                </table>
                             
                            </div>
                        </div>
                    </div>
                
        </div>
</div>
</div>


        <br/><br/>
 
