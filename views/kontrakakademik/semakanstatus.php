<?php
use yii\helpers\Url;
error_reporting(0);
?>
<?= $this->render('/kontrak/_topmenu') ?>
<?= $this->render('_inquiry') ?>
<div class="row"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>LIST OF APPLICATION FOR CONTRACT EXTENSION</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">NO </th>
                        <th class="column-title text-center">DATE OF APPLICATION</th>
                        <th class="column-title text-center">STATUS</th>


                        <th class="column-title text-center">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bil=1;
                    if($status){
                    foreach ($status as $statuss) {
                        if($statuss->tarikh_m !=''){
                        
                        ?>
                        <tr>
                            <td style="width:10%;"><?= $bil++; ?></td>
                            <td style="width:30%;">
                                <a class="form-control" style="background-color: transparent; border:0;box-shadow: none;" href="mohonlanjut?id=<?= $statuss->id?>"><u><?= $statuss->tarikhmohon; ?></u></a>
                            </td>
                            <td style="width:30%;"><?= $statuss->statusakademik; ?></td>
                            
                            <td style="width:30%;">
                                <?php if($statuss->status == '4'){?>
                                <div class="container" align="center">
                                    <button class="btn btn-primary" type="button" style="border:none;" data-toggle="collapse" data-target='#demo<?php echo $statuss->id?>'><i class="fa fa-hand-o-down"></i></button>
                                <div id='demo<?php echo $statuss->id?>' class="collapse" style="text-align: left; padding-left: 10%;">
                                <?php if($statuss->dokumen){ 
                                    foreach($statuss->dokumen as $d){?>
                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($d->dokumen), true); ?>" target="_blank" ><i class="fa fa-download"></i> <?= $d->tajuk?></a><br>
                                    <?php }}
                                
                                foreach($dokumen as $d){
                                    if($d->dokumen){?>
                                    <a class="form-control" style="background-color: transparent; border:0;box-shadow: none;" href="<?= Url::to('@web/'.$d->dokumen, true); ?>" target="_blank" ><i class="fa fa-download"></i> <?= $d->title?></a><br>
                                    <?php }
                                    else{?>
                                    <a class="form-control" style="background-color: transparent; border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($d->source), true); ?>" target="_blank" ><i class="fa fa-download"></i> <?= ucwords(strtolower($d->title))?></a><br>
                                   <?php }?><?php
                                   }?><br>
                                </div>
                              </div>
                                 <?php }elseif($statuss->status == '5'){?>
                                     <div class="container" align="center">
                                    <button class="btn btn-primary" type="button" style="border:none;" data-toggle="collapse" data-target='#demo<?php echo $statuss->id?>'><i class="fa fa-hand-o-down"></i></button>
                                <div id='demo<?php echo $statuss->id?>' class="collapse" style="text-align: left; padding-left: 10%;">
                                <?php if($statuss->dokumen){ 
                                    foreach($statuss->dokumen as $d){?>
                                    <a class="form-control" style="background-color: transparent;border:0;box-shadow: none;" href="<?= Url::to(Yii::$app->FileManager->DisplayFile($d->dokumen), true); ?>" target="_blank" ><i class="fa fa-download"></i> <?= $d->tajuk?></a><br>
                                    <?php }}?><br>
                                </div>
                              </div>
                                <?php  }
?>
                                  </td>
                           
                        </tr>
                        <?php }}} ?>
                </tbody>
            </table>
            <ul>
                <li><span class="label label-warning">TNCA</span> : Waiting for endorsement from TNCA</li>
                <li><span class="label label-default">VC</span> : Waiting for endorsement from VC</li>
                <li><span class="label label-warning">HEAD OF PROGRAM</span> : Waiting for endorsement from Head of Program</li>
                <li><span class="label label-default">HEAD OF DEPARTMENT</span> : Waiting for endorsement from Head of Department</li>
                <li><span class="label label-primary">HUMAN RESOURCES DIVISION</span> : Waiting for endorsement from Human Resources Division(Academia Intake Unit)</li>
<!--            <li><span class="label label-info">RETURNED</span> : KPI is not approved by Head of Department. Please revise and make an amendment</li>-->
<!--                <li><span class="label label-primary">REGISTRAR</span> : Waiting for endorsement from Registrar</li> 
                <li><span class="label label-warning">VC</span> : Waiting for endorsement from Vice Chancellor</li>-->
             <li><span class="label label-success">APPROVED</span> : Application successful</li>
                <li><span class="label label-danger">REJECTED</span> : Application not successful</li>
            </ul>
        </div>
        </div>
    </div>
</div>
