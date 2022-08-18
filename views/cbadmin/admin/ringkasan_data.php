<?php
use app\models\cbelajar\TblPermohonan;
use yii\helpers\Html;

error_reporting(0);
?>
<?= $this->render('/cutibelajar/_topmenu') ?>


<div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">

    <div class="x_panel">
         <div class="x_content">
               <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> STATISTIK KESELURUHAN PERMOHONAN MENGIKUT JPIU</strong></h2>
           
            
            <div class="clearfix"></div>
            
        </div>
<div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped "> 
                    <tr>
                    <th scope="col" colspan=16"  style="background-color:white;"><center>TAHUN <?= date('Y')?></center></th>

                     </tr>
                     <tr class="headings">
                        <th  class="column-title text-center">BIL</th>
                        <th  class="column-title text-center" width="40%">FPIU</th>
                        <th  class="column-title text-center">PHD </th>
<!--                        <tr scope="col" colspan="2">SELESAI:</tr>
                        <tr scope="col" colspan="2">BELUM SELESAI:</tr>-->
                        
                        <th  class="column-title text-center">SARJANA</th>
                        <th class="column-title text-center">LATIHAN INDUSTRI</th>
                        <th  class="column-title text-center">POST DOKTORAL</th>
                        <th class="column-title text-center">SUB KEPAKARAN</th>
                        <th  class="column-title text-center">CUTI SABATIKAL</th>
                        <th  class="column-title text-center">JUMLAH PERMOHONAN</th>
                         
                     

                    </tr>
<!--                    <tr >
                           <th rowspan="18"  class="column-title text-center">JUMLAH KESELURUHAN</th>
                    </tr>-->
                   
                    
                    
             <?php
                            if ($fakulti) 
                            { $no=0;?>
                            
                                <?php foreach ($fakulti as $fac) { 
                                
                                      $s1 = TblPermohonan::find()->joinWith('kakitangan.department')->where([
                           'department.shortname'=>$fac->shortname,
                           'tbl_permohonan.HighestEduLevelCd' => 1, 'tbl_permohonan.status'=>"LULUS"
                                        
                                    ])->count();
                                      
                                      $s2 = TblPermohonan::find()->joinWith('kakitangan.department')->where([
                           'department.shortname'=>$fac->shortname,
                           'tbl_permohonan.HighestEduLevelCd' => 20, 'tbl_permohonan.status'=>"LULUS"])->count();
                                      
                                       $s3 = TblPermohonan::find()->joinWith('kakitangan.department')->where([
                           'department.shortname'=>$fac->shortname,
                           'tbl_permohonan.HighestEduLevelCd' => 101, 'tbl_permohonan.status'=>"LULUS"])->count();
                                       
                                        $s4 = TblPermohonan::find()->joinWith('kakitangan.department')->where([
                           'department.shortname'=>$fac->shortname,
                           'tbl_permohonan.HighestEduLevelCd' => 200, 'tbl_permohonan.status'=>"LULUS"])->count();
                                        
                                         $s5 = TblPermohonan::find()->joinWith('kakitangan.department')->where([
                           'department.shortname'=>$fac->shortname,
                           'tbl_permohonan.HighestEduLevelCd' => 102, 'tbl_permohonan.status'=>"LULUS"])->count();
                                         
                                          $s6 = TblPermohonan::find()->joinWith('kakitangan.department')->where([
                           'department.shortname'=>$fac->shortname,
                           'tbl_permohonan.HighestEduLevelCd' => 103, 'tbl_permohonan.status'=>"LULUS"])->count();
                                           $total = $s1 + $s2 + $s3 + $s4 + $s5 + $s6;
                                           
                                           $allTot = $allTot + $total;
                                    $no++; 

                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-center">
                                       
                                        <?php  $link_address1 = 'senarai-pemohon?DeptId='.$fac->id;
                                        echo "<u><strong><a href='$link_address1'>$fac->shortname</a></strong></u>"?>
                                            <?php //echo $fac->shortname; ?></td>
                                    <td class="text-center"> <?php echo $s1;?></td>
                                        
                                    <td class="text-center"> <?php echo $s2;?></td>
                                    <td class="text-center"> <?php echo $s3;?></td>
                                    <td class="text-center"> <?php echo $s4;?></td>
                                    <td class="text-center"> <?php echo $s5;?></td>
                                    <td class="text-center"> <?php echo $s6;?></td>
                                    <td class="text-center" style="background-color: rgba(50, 115, 220, 0.3); color: black"><?= $total;?></td>



                                </tr>
                                
                                <tr>
                                    
                                </tr>
                                
                                
                                    <?php 
                                    
                            }}?>
                                <tr>
                    <td  colspan="8" class="text-center" colspan="2" style="text-align:right; background-color: rgba(50, 115, 220, 0.3); color: black"><b>JUMLAH KESELURUHAN</b></td>
                   <td class="text-center" style="background-color: rgba(50, 115, 220, 0.3); color: black"><?= $allTot;?></td>
                </tr>
                 
            

                    
                    

                     
                </table>
</div> </div>
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> STATISTIK KESELURUHAN PERMOHONAN MENGIKUT JENIS PENGAJIAN</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            
            <div class="clearfix"></div>
            
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
                <thead>
                <tr class="headings">
                    <th class="text-center">Bil</th>
                    <th class="text-center">J/F/P/I/U</th>
                    <th class="text-center">Peringkat Pengajian</th>
<!--                    <th class="text-center">PHD</th>
                    <th class="text-center">SARJANA</th>
                    <th class="text-center">LATIHAN INDUSTRI / CUTI SABATIKAL</th>
                    <th class="text-center">POST DOKTORAL</th>
                    <th class="text-center">SUB KEPAKARAN</th>-->
                </tr>
                </thead>
                <tr>
                   <td class="text-center"  style="text-align:center">1</td>
                   <td class="text-center">PHD</td>
                     <td class="text-center"  style="text-align:center">
                       <?php $s1 = TblPermohonan::find()->where(['HighestEduLevelCd' => 1])->count();
                       echo $s1;?></td>
                </tr>
                <tr>
                   <td class="text-center"  style="text-align:center">2</td>
                   <td class="text-center">Sarjana</td>
                   <td class="text-center"  style="text-align:center">
                       <?php $s2 = TblPermohonan::find()->where(['HighestEduLevelCd' => 20])->count();
                       echo $s2;?></td>
                </tr>
                <tr>
                   <td class="text-center"  style="text-align:center">3</td>
                   <td class="text-center">Latihan Industri / Cuti Sabatikal</td>
                   <td class="text-center"  style="text-align:center">
                       <?php $s3 = TblPermohonan::find()->where(['HighestEduLevelCd' => 101])->count();
                       echo $s3;?></td>
                </tr>
                <tr>
                   <td class="text-center"  style="text-align:center">4</td>
                   <td class="text-center">Post Doktoral</td>
                   <td class="text-center"  style="text-align:center">
                       <?php $s4 = TblPermohonan::find()->where(['HighestEduLevelCd' => 102])->count();
                       echo $s4;?></td>
                </tr>
                <tr>
                   <td class="text-center"  style="text-align:center">5</td>
                   <td class="text-center">Sub Kepakaran</td>
                   <td class="text-center"  style="text-align:center">
                       <?php $s5 = TblPermohonan::find()->where(['HighestEduLevelCd' => 200])->count();
                       echo $s5;?></td>
                </tr>
                
               
              
                <tr>
                    <td class="text-center" colspan="2" style="text-align:right; background-color: rgba(50, 115, 220, 0.3); color: black"><b>JUMLAH KESELURUHAN</b></td>
                   <td class="text-center" style="background-color: rgba(50, 115, 220, 0.3); color: black"><?= $s1+$s2+$s3+$s4+$s5;?></td>
                </tr>
            </table>
            </div>
        </div>
    </div>
</div>
</div>