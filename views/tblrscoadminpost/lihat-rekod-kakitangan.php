<?php
use yii\helpers\Html;
?> 
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Rekod Lantikan</strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', ['admin-view', 'id' => $ICNO], ['class' => 'btn btn-primary']) ?></p>   
        <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th class="text-center">Bil. </th>
                    <th class="text-center">No IC</th>
                    <th class="text-center">Nama Staf</th>
                    <th class="text-center">Jawatan Pentadbiran</th>
                    <th class="text-center">Program Pengajaran</th>
                    <th class="text-center">Catatan</th>
                    <th class="text-center">JAFPIB</th>
                    <th class="text-center">Kampus</th>
                    <th class="text-center">Tarikh Kuatkuasa</th>
                    <th class="text-center">Tarikh Tamat</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Tindakan</th>   
                </tr>
                </thead>
                <?php 
                
                 $bil=1;
                
                if($provider) {
                    
                   foreach ($provider->getModels() as $models) {
                    
                ?>
                  
                <tr>
                    <td class="text-center" style="width:5%;"><?= $bil++; ?></td>
                    <td class="text-center" style="width:5%;"><?= $models->ICNO; ?></td>
                    <td class="text-center" style="width:10%;"><?= $models->kakitangan->CONm; ?></td>
                    <td class="text-center" style="width:10%;"><?= $models->adminpos->position_name; ?></td>
                    <td class="text-center" style="width:10%;"><?php if($models->program!= NULL){?>  
                        
                                                                <?= $models->program->NamaProgram; ?>
                        
                                                                <?php }else{
                                                                echo "Tiada Rekod";
                                                                }?>
                    </td>
                    <td class="text-center" style="width:15%;"><?= $models->description; ?></td>
                    <td class="text-center" style="width:13%;"><?= $models->dept->fullname; ?></td>
                    <td class="text-center" style="width:10%;"><?= $models->campus->campus_name; ?></td>
                    <td class="text-center" style="width:10%;"><?= $models->tarikhmula; ?></td>
                    <td class="text-center" style="width:13%;"><?= $models->tarikhtamat; ?></td>
                    <td class="text-center" style="width:8%;"><?= $models->displayflag->flagstatus; ?></td>
                    <td class="text-center"><?php echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihat-rekod-lantikan-semua', 'id' => $models->id], ['target' => '_blank']) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['kemaskini-rekod-lantikan', 'id' => $models->id], ['target' => '_blank']) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $models->id], [
                                            'data' => ['confirm' => 'Anda ingin membuang rekod ini?',            
                                            'method' => 'post',
                                            ],
                                            ]) ?>
                    </td>  
<!--                    <td class="text-center" style="width:8%;"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['lihat-rekod-lantikan', 'id' => $models->id]) ?></td>  -->
                </tr>

                   <?php } 
                   
                } else{
                    ?>
                <tr>
                    <td colspan="12" class="text-center">Tiada Rekod</td>                     
                </tr>
                  <?php  
                } ?>
            </table>
            </div>
        </div>
    </div>
</div>
</div>



