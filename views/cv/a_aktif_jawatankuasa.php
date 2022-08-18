<?php

use yii\helpers\Html;
use app\models\cv\TblAccess;
?>  
<div class="x_panel">  
    <div class="x_content">    

        <?php
        if(TblAccess::isAdminAcademic()){
      
        $btntapisan = $btntapisan2 = 'btn btn-default';
        $btn = app\models\cv\StatusTapisan::findOne(['status' => 1, 'id' => 7]);
        $tapisan = 0;
        if ($btn) {
            $btntapisan = 'btn btn-success';
            $tapisan = 1;
        }
        $btn2 = app\models\cv\StatusTapisan::findOne(['status' => 1, 'id' => 8]);
        $pemilihan = 0;
        if ($btn2) {
            $btntapisan2 = 'btn btn-success';
            $pemilihan = 1;
        }
        ?>
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr> 
                    <th>Type</th> 
                    <th>Action</th>
                </tr>  

                <tr> 
                    <td>Jawatankuasa Tapisan</td>
                    <td><?php
                        if (($tapisan == 1 && $pemilihan == 0) || ($tapisan == 0 && $pemilihan == 0)) {
                            echo Html::a('<i class="fa fa-lightbulb-o"></i>', ['status-tapisan', 'id' => 7], [
                                'class' => $btntapisan
                            ]);
                        }
                        ?></td>
                </tr>  
                <tr> 
                    <td>Jawatankuasa Pemilihan</td>
                    <td><?php
                        if (($tapisan == 0 && $pemilihan == 1) || ($tapisan == 0 && $pemilihan == 0)) {
                            echo Html::a('<i class="fa fa-lightbulb-o"></i>', ['status-tapisan', 'id' => 8], [
                                'class' => $btntapisan2
                            ]);
                        }
                        ?></td>
                </tr> 
            </table>
        </div> 
            <?php }else{
      
        $btntapisan = $btntapisan2 = 'btn btn-default';
        $btn = app\models\cv\StatusTapisan::findOne(['status' => 1, 'id' => 9]);
        $tapisan = 0;
        if ($btn) {
            $btntapisan = 'btn btn-success';
            $tapisan = 1;
        }
        $btn2 = app\models\cv\StatusTapisan::findOne(['status' => 1, 'id' => 10]);
        $pemilihan = 0;
        if ($btn2) {
            $btntapisan2 = 'btn btn-success';
            $pemilihan = 1;
        }
        ?>
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr> 
                    <th>Type</th> 
                    <th>Action</th>
                </tr>  

                <tr> 
                    <td>Jawatankuasa Tapisan</td>
                    <td><?php
                        if (($tapisan == 1 && $pemilihan == 0) || ($tapisan == 0 && $pemilihan == 0)) {
                            echo Html::a('<i class="fa fa-lightbulb-o"></i>', ['status-tapisan', 'id' => 9], [
                                'class' => $btntapisan
                            ]);
                        }
                        ?></td>
                </tr>  
                <tr> 
                    <td>Jawatankuasa Pemilihan</td>
                    <td><?php
                        if (($tapisan == 0 && $pemilihan == 1) || ($tapisan == 0 && $pemilihan == 0)) {
                            echo Html::a('<i class="fa fa-lightbulb-o"></i>', ['status-tapisan', 'id' => 10], [
                                'class' => $btntapisan2
                            ]);
                        }
                        ?></td>
                </tr> 
            </table>
        </div> 
            <?php }  ?>
    </div>
</div>  

