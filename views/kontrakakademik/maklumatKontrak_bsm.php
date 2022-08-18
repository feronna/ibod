<?php
error_reporting(0);
?>

<?= $this->render('/kontrak/_topmenu') ?>

<style>
    .x_panel{
        border-color: #495869;
    }
    .x_title{
        border: none;
        text-align: center;
        color: #6a7f95;
    }
    .x_title h2{
        font-size: 20px;
/*        color: #5f7286;*/
        color: #495869;
    }
    thead{
        background-color: #495869;
        color: white;
        
    }
    
</style>

<div class="row text-center"><h2><b>Application For Contract Extension [Academic Staff]</b></h2><br></div>
            
        
        <?= $this->render('_maklumatperibadi', ['model' => $model])?><br>
        <?= $this->render('_maklumatperkhidmatan', ['model' => $model, 'countlantikan' => $countlantikan])?><br>
        <?= $this->render('_senarailantikan', ['model' => $model])?><br>
        <?= $this->render('_lnpt', ['model' => $model])?><br>
        <?= $this->render('_anugerah', ['model' => $model])?><br>
        <?= $this->render('_kehadiran',['model'=>$model]) ?><br>
        <?= $this->render('_idp',['model'=>$model]) ?><br>
        <?= $this->render('_pengajaran',['model'=>$model,]) ?><br>
                    
        <?= $this->render('_penyelidikan',['model'=>$model,]) ?><br>
                    
        <?= $this->render('_penerbitan',['model'=>$model,]) ?><br>
                    
        <?= $this->render('_perundingan',['model'=>$model,]) ?><br>
                    
        <?= $this->render('_penyeliaan',['model'=>$model,]) ?><br>
        
        <?= $this->render('_maklumatpermohonan',['model'=>$model,]) ?><br>
        <?=$this->render('_viewhopendorsement',['model'=>$model,]);?><br>
        <?=$this->render('_viewhodendorsement',['model'=>$model,]);?>
    


