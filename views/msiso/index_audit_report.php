<?php 
use yii\helpers\Html;
 
error_reporting(0);
?> 
<?= $this->render('menu') ?> 
<div class="x_panel">  
            <div class="x_title">
                <h2>ISO - AUDIT DALAM</h2>  
                <div class="clearfix"></div>
            </div>  
         
            <div class="table-responsive">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    
                        <table class="table table-sm table-bordered jambo_table table-striped" style="width:100%;", > 
                        
                            <tr>   
                                <th colspan="4"><center>TAHUN</center></th>  
                                <td colspan="2"><center> REPORT</center></td> 
                            </tr>
                       
                                
                            <tr>    
                                <td rowspan="10"><center><strong><?= $current_year ?> </strong></center></td> 
                            </tr> 
                            
                            <tr>    
                                <td colspan="5">   
                                <?php 
                                    echo Html::a('<i class="fa fa-list "></i> Opportunities for Improvement (OFI)',['msiso/ofi-report'], ['class' => 'btn btn-success btn-sm']);
                                 ?>
                                 </td>  
                            </tr> 

                            <tr>    
                                <td colspan="5"> 
                                <?php 
                                    echo Html::a('<i class="fa fa-list "></i> Nonconformity Report (NCR)',['msiso/ncr-report'], ['class' => 'btn btn-success btn-sm']);
                                 ?>
                                </td>   
                            </tr>  
                            <tr>    
                                <td colspan="5"> 
                                <?php 
                                    echo Html::a('<i class="fa fa-list "></i> Nota Audit',['msiso/senarai-nota-audit'], ['class' => 'btn btn-success btn-sm']);
                                 ?>
                                </td>   
                            </tr> 
                            <tr>    
                                <td colspan="5"> 
                                <?php 
                                    echo Html::a('<i class="fa fa-list "></i> Best Practice',['msiso/senarai-best-practice'], ['class' => 'btn btn-success btn-sm']);
                                 ?>
                                </td>   
                            </tr>
                            <tr>    
                                <td colspan="5"> 
                                <?php 
                                    echo Html::a('<i class="fa fa-list "></i> Laporan OFI',['msiso/laporan-ofi'], ['class' => 'btn btn-success btn-sm']);
                                 ?> 
                                <div style="color: red; margin-top: 0px;">
                                <?php // echo '*Masih Dalam Pembangunan'; ?></div>
                                </td>   
                            </tr> 
                            <tr>    
                                <td colspan="5"> 
                                <?php 
                                    echo Html::a('<i class="fa fa-list "></i> Laporan NCR',['msiso/laporan-ncr'], ['class' => 'btn btn-success btn-sm']);
                                 ?> 
                                <div style="color: red; margin-top: 0px;">
                               
                                </td>   
                            </tr> 
                            <tr>    
                                <td colspan="5"> 
                                <?php 
                                    echo Html::a('<i class="fa fa-list "></i> Laporan Best Practice',['msiso/laporan-best-practice'], ['class' => 'btn btn-success btn-sm']);
                                 ?> 
                                <div style="color: red; margin-top: 0px;">
                                
                                </td>   
                            </tr> 
                            <tr>    
                                <td colspan="5"> 
                                <?php 
                                    echo Html::a('<i class="fa fa-list "></i> Statistik OFI',['msiso/statistik-ofi'], ['class' => 'btn btn-success btn-sm']);
                                ?>
                                <div style="color: red; margin-top: 0px;">
                               
                                </td>   
                            </tr>  
                            <tr>    
                                <td colspan="5"> 
                                <?php 
                                    echo Html::a('<i class="fa fa-list "></i> Statistik NCR',['msiso/statistik-ncr'], ['class' => 'btn btn-success btn-sm']);
                                ?>
                                <div style="color: red; margin-top: 0px;"> 
                                </td>   
                            </tr>  
                            
                            <tr>    
                                <td colspan="5" style="background-color:Gray;">
                                 
                                </td>    
                            </tr> 
                                     
                        </table>
  
                    </div>            
                </div>
            </div>
         
        </div>
    </div> 
</div>
