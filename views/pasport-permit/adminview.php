<?php

use yii\helpers\Html;

$this->title = 'Passport and Work Permit';
?>
<ul class="nav nav-tabs">
    <li class="nav-item active">
        <a class="nav-link " href="#paspot" data-toggle="tab">Passport</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#permit" data-toggle="tab">Work Permit</a>
    </li>

</li>
</ul>
<div class="tab-content">
    <div class="tab-pane fade in active " id="paspot">
        <br>
     <div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><?= "Passport" ?></h2>
            
            <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
         
         <?= Html::a('Back', ['biodata/adminview', 'id' => $ICNO], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('New Passport', ['admintambahpasport', 'icno' => $ICNO], ['class' => 'btn btn-primary']) ?>   
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th>Passport Number</th>
                    <th>Passport Type</th>
                    <th>Nationality</th>
                    <th>Place of birth</th>
                    <th>Date of Issue</th>
                    <th>Date of Expiry</th>
                    <th class="text-center">Action</th>   
                </tr>
                </thead>
                <?php if($pasport) {
                    
                   foreach ($pasport as $pasportkakitangan) {
                    
                ?>
                   
                <tr>
                    <td><?= $pasportkakitangan->PassportNo;?></td>
                    <td><?= $pasportkakitangan->jenpaspot; ?></td>
                    <td><?= $pasportkakitangan->nega; ?></td>
                    <td><?= $pasportkakitangan->nege; ?></td>
                    <td><?= $pasportkakitangan->issuedDt; ?></td>
                    <td><?= $pasportkakitangan->passportExpiryDt; ?></td>
                    <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['adminlihatpasport', 'id' => $pasportkakitangan->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['adminupdatepasport', 'id' => $pasportkakitangan->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['admindeletepaspot', 'id' => $pasportkakitangan->id], [
                         'data' => [
                                   'confirm' => 'Do you wish to remove this data ?',
                                   'method' => 'post',
                                       ],
                                    ]) ?></td>  
                </tr>

                   <?php } 
                   
                }else{
                    ?>
                    <tr>
                        <td colspan="7" class="text-center">No Record Found</td>                     
                    </tr>
                  <?php  
                } ?>
            </table> 
            </div>
        </div>
    </div>
</div>   

    </div>
    <div class="tab-pane fade " id="permit">
        <br>
        <div class="col-md-12 col-sm-12 col-xs-12 "> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><?= "Work Permit" ?></h2>

                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <?= Html::a('Back', ['biodata/adminview', 'id' => $ICNO], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('New Work Permit', ['admintambahpermitkerja', 'icno' => $ICNO], ['class' => 'btn btn-primary']) ?>   
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered jambo_table table-striped">
                            <thead>
                                <tr class="headings">
                                    <th>Work Permit Number</th>
                                    <th>Immigration Reference Number</th>
                                    <th>Date of Issue</th>
                                    <th>Date of Expiry</th>
                                    <th class="text-center">Action</th> 
                                </tr>
                            </thead>
<?php
if ($permit) {

    foreach ($permit as $permitkakitangan) {
        ?>

                                    <tr>
                                        <td><?= $permitkakitangan->WrkPermitNo; ?></td>
                                        <td><?= $permitkakitangan->ImigRefNo; ?></td>
                                        <td><?= $permitkakitangan->wrkPermitIssueDt; ?></td>
                                        <td><?= $permitkakitangan->wrkPermitExpiryDt; ?></td>
                                        <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['adminlihatpermitkerja', 'id' => $permitkakitangan->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['adminupdatepermitkerja', 'id' => $permitkakitangan->id]) ?> | <?=
                            Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['admindeletepermit', 'id' => $permitkakitangan->id], [
                                'data' => [
                                    'confirm' => 'Do you wish to remove this data ?',
                                    'method' => 'post',
                                ],
                            ])
        ?></td>  
                                    </tr>

                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="5" class="text-center">No Record Found</td>                     
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






