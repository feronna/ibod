<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>


<div class="row">
<div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h3><span class="label label-success" style="color: white">KETERANGAN</span></h3>
               
                <div class="clearfix"></div>
            </div>
                <div class="x_content">
           <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                 
                    <th>Data Asal</th> 
                    <th>Selepas Kemaskini</th> 
                </tr>
                </thead>
              
                <tr>
                
                   <td><?=$model->detail_activity_before;  ?>
                   </td>
                   <td><?=$model->detail_activity ;?>
                   </td>
                </tr>

               
            </table>
            </div>
            </div> 
         
      
                </div> 
        </div>
    </div>


