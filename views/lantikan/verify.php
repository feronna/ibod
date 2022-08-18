<?php

use yii\helpers\Html;


$this->title = 'Lantikan (Rekod Peribadi Dan Perkhidmatan)';

?> 

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
        <?= Html::a('Kembali', ['view-utama','id'=>$icno], ['class' => 'btn btn-primary']) ?>             
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Nama Bahagian</th>
                    <th>Status</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php if($tblval) {

                    for($i = 0; $i < count($tblval); $i++){
                        ?>
                            <tr>
                                <td><?= $tblnms[$i] ?></td>
                                <td><?= $tblval[$tbllist[$i]] ? '<span style="color:green;font-weight:bold">Pass</span> ' : '<span style="color:red;font-weight:bold">Failed</span>';  ?><?php if($tbllist[$i] == 'Tblrscoprobtnperiod'){ echo '<div class="jtooltip pull-right"><i class="fa fa-info-circle fa-md"></i>
                        <text>Tidak perlu "PASS" jika jenis lantikan bukan TETAP.</text>
                    </div>' ;}else{ echo ' ';} ?></td>
                                <td class="text-center"><?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', [$tbllink[$i],'icno'=>$icno]) ?> </td>  
                            </tr>
                    <?php   
                    }

                }else{
                    ?>
                    <tr>
                        <td colspan="3" class="text-center">Tiada Rekod</td>                     
                    </tr>
                  <?php  
                } ?>
            </table>
            </div>
            
        </div>
    </div>
</div>



