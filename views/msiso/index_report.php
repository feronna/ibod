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
                        <?php foreach ($model as $list) { ?>
                           
                            <tr>    
                                <td colspan="4"><center><strong>TAHUN <?php  echo $list->year ?></strong></center></td>    
                            </tr>
                            <tr>   
                                <th colspan="2"><center>JAFPIB</center></th>  
                                <td colspan="2"><center> REPORT</center></td> 
                            </tr>
                       
                                
                            <tr>    
                                <td rowspan="5"><center><strong><?php  echo $list->dept ?></strong></center></td> 
                            </tr> 
                            
                            <tr>    
                                <td colspan="5">   
                                <?php 
                                    echo Html::a('<i class="fa fa-plus"></i> Opportunities for Improvement (OFI)',['msiso/ofi-general', 'id' => $list->id ], ['class' => 'btn btn-success btn-sm']);
                                 ?>
                                 </td>
                                  
                            </tr> 

                            <tr>    
                                <td colspan="5"> 
                                <?php 
                                    echo Html::a('<i class="fa fa-plus"></i> Nonconformity Report (NCR)',['msiso/ncr-form', 'id' => $list->id ], ['class' => 'btn btn-success btn-sm']);
                                 ?>
                                </td>  
                                
                            </tr> 

                            <tr>    
                                <td colspan="5">
                                <?php 
                                    echo Html::a('<i class="fa fa-plus"></i> Nota Audit',['msiso/nota-audit', 'id' => $list->id ], ['class' => 'btn btn-success btn-sm']);
                                 ?>
                                </td>   
                            </tr>
                            <tr>    
                                <td colspan="5">
                                <?php 
                                    echo Html::a('<i class="fa fa-plus"></i> Best Practice',['msiso/best-practice', 'id' => $list->id ], ['class' => 'btn btn-success btn-sm']);
                                 ?>
                                </td>   
                            </tr>

                            <tr>    
                                <td colspan="5" style="background-color:Gray;">
                                 
                                </td>    
                            </tr> 
                            <?php } ?>                  
                        </table>
  
                    </div>            
                </div>
            </div>
         
        </div>
    </div> 
</div>
