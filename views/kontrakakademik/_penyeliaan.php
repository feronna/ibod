
<div class="row"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-book"></i> Postgraduate Students' Supervision</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <i>[FROM SMP]</i>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php if($model->icno == Yii::$app->user->getId()){?>
                    <h2 style="color:green">Filter by 'Semester / Session' Based on Current Contract {<?= $model->startdatelantik?> - <?= $model->enddatelantik?>}</h2><?php }?>
            
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    
                    <thead> 
                        <tr>
                            <th>No.</th> 
                            <th width="16%">Student Name</th>  
                            <th width="12%">No Matric</th>  
                            <th class="text-center">Supervision Type</th>
                            <th class="text-center">Semester / Session</th>
                            <th class="text-center">Status</th>   
                        </tr> 
                    </thead>
                      
                    
                    
                     <?php
        $penyeliaanphd = array_filter($model->penyeliaan, function ($var) use ($model){
                        return ($var['LevelPengajian'] == 'PHD')&&
                        (substr($var['KodSesi_Sem'], -9) > $model->sesimulakontrak || (substr($var['KodSesi_Sem'], -9) == $model->sesimulakontrak && substr($var['KodSesi_Sem'], 0,1) >= $model->semmulakontrak)
                        );
                        });
        if ($penyeliaanphd) {
            ?>
                    <tr>
                        <th colspan="8">Level : PHD</th>  
                    </tr>
                    <?php                  
                    $counter = 0; $id = 0;
                    foreach ($penyeliaanphd as $l) {
                        $id++; 
                        if($matrik != $l->Nomatrik && $matrik != ''){
                        $counter = $counter + 1;?>
                            
                        <tr>   
                            <th><?= $counter ?>.</th>
                            <td class="text-center"><?= $nama; ?></td>
                            <td class="text-center"><?= $matrik; ?></td>
                            <td class="text-center"><?= $type; ?></td>
                            <td class="text-center"><?= $sem; ?></td>
                            <td class="text-center"><?= $status; ?></td>
                            
                        </tr> 
                        <?php 
                        $sem = $l->KodSesi_Sem;
                        }
                        else{
                           $sem = $matrik !=''? $sem.'<br>'.$l->KodSesi_Sem: $l->KodSesi_Sem; 
                        }
                        
                        if (count($penyeliaanphd) == $id) {
                            $counter = $counter + 1;?>
                            <tr>   
                                <th><?= $counter; ?>.</th>
                                <td class="text-center"><?= $l->NamaPelajar; ?></td>
                                <td class="text-center"><?= $l->Nomatrik; ?></td>
                                <td class="text-center"><?= $l->TahapPenyeliaanBI; ?></td>
                                <td class="text-center"><?= $l->Nomatrik == $matrik? $sem.'<br>'.$l->KodSesi_Sem:$l->KodSesi_Sem; ?></td>
                                <td class="text-center"><?= $l->StatusPengajianBI; ?></td>

                            </tr> 
                        <?php }
                        
                        $nama = $l->NamaPelajar;
                        $matrik = $l->Nomatrik;
                        $type = $l->TahapPenyeliaanBI;
                        $status = $l->StatusPengajianBI;
        }}
                    
                        
         $penyeliaanmaster = array_filter($model->penyeliaan, function ($var) use ($model){
                        return ($var['LevelPengajian'] == 'MASTER')&&
                        (substr($var['KodSesi_Sem'], -9) > $model->sesimulakontrak || (substr($var['KodSesi_Sem'], -9) == $model->sesimulakontrak && substr($var['KodSesi_Sem'], 0,1) >= $model->semmulakontrak)
                        );
                        });
        if ($penyeliaanmaster) {?>
                    <tr>
                        <th colspan="8">Level : MASTER</th>  
                    </tr>
                    <?php                  
                    $counter = 0; $matrik = ''; $id = 0;
                    foreach ($penyeliaanmaster as $l) { $id++;
                        if($matrik != $l->Nomatrik && $matrik != ''){
                        $counter = $counter + 1;?>
                            
                        <tr>   
                            <th><?= $counter; ?>.</th>
                            <td class="text-center"><?= $nama; ?></td>
                            <td class="text-center"><?= $matrik; ?></td>
                            <td class="text-center"><?= $type; ?></td>
                            <td class="text-center"><?= $sem; ?></td>
                            <td class="text-center"><?= $status; ?></td>
                            
                        </tr> 
                        <?php 
                        $sem = $l->KodSesi_Sem;
                        }
                        else{
                           $sem = $matrik !=''? $sem.'<br>'.$l->KodSesi_Sem: $l->KodSesi_Sem; 
                        }
                        
                        if (count($penyeliaanmaster) == $id) {
                            $counter = $counter + 1;?>
                            <tr>   
                                <th><?= $counter; ?>.</th>
                                <td class="text-center"><?= $l->NamaPelajar; ?></td>
                                <td class="text-center"><?= $l->Nomatrik; ?></td>
                                <td class="text-center"><?= $l->TahapPenyeliaanBI; ?></td>
                                <td class="text-center"><?= $l->Nomatrik == $matrik? $sem.'<br>'.$l->KodSesi_Sem:$l->KodSesi_Sem; ?></td>
                                <td class="text-center"><?= $l->StatusPengajianBI; ?></td>

                            </tr> 
                        <?php }
                        
                        $nama = $l->NamaPelajar;
                        $matrik = $l->Nomatrik;
                        $type = $l->TahapPenyeliaanBI;;
                        $status = $l->StatusPengajianBI;
                        ?>  

                        <?php
        }}
        
        $penyeliaanphil = array_filter($model->penyeliaan, function ($var) use ($model){
                        return ($var['LevelPengajian'] == 'M.Phil.')&&
                        (substr($var['KodSesi_Sem'], -9) > $model->sesimulakontrak || (substr($var['KodSesi_Sem'], -9) == $model->sesimulakontrak && substr($var['KodSesi_Sem'], 0,1) >= $model->semmulakontrak)
                        );
                        });
        if ($penyeliaanphil) {?>
                    <tr>
                        <th colspan="8">Level : M.Phil.</th>  
                    </tr>
                    <?php                  
                    $counter = 0; $matrik  = ''; $id = 0;
                    foreach ($penyeliaanphil as $l) {
                        $id++;
                        if($matrik != $l->Nomatrik && $matrik != ''){
                        $counter = $counter + 1;?>
                            
                        <tr>   
                            <th><?= $counter; ?>.</th>
                            <td class="text-center"><?= $nama; ?></td>
                            <td class="text-center"><?= $matrik; ?></td>
                            <td class="text-center"><?= $type; ?></td>
                            <td class="text-center"><?= $sem; ?></td>
                            <td class="text-center"><?= $status; ?></td>
                            
                        </tr> 
                        <?php 
                        $sem = $l->KodSesi_Sem;
                        }else{
                           $sem = $matrik !=''? $sem.'<br>'.$l->KodSesi_Sem: $l->KodSesi_Sem; 
                        }
                        
                        if (count($penyeliaanphil) == $id) {
                            $counter = $counter + 1;?>
                            <tr>   
                                <th><?= $counter; ?>.</th>
                                <td class="text-center"><?= $l->NamaPelajar; ?></td>
                                <td class="text-center"><?= $l->Nomatrik; ?></td>
                                <td class="text-center"><?= $l->TahapPenyeliaanBI; ?></td>
                                <td class="text-center"><?= $l->Nomatrik == $matrik? $sem.'<br>'.$l->KodSesi_Sem:$l->KodSesi_Sem; ?></td>
                                <td class="text-center"><?= $l->StatusPengajianBI; ?></td>

                            </tr> 
                        <?php }
                        $nama = $l->NamaPelajar;
                        $matrik = $l->Nomatrik;
                        $type = $l->TahapPenyeliaanBI;;
                        $status = $l->StatusPengajianBI;
                        ?>  

                        <?php
        }}
                    ?>
                </table>
            </div>
            <br/>

                </div>
            </div>
        </div>