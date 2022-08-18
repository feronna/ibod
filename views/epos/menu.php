<?php
use app\models\utilities\epos\PosTblPermohonan; 
?> 
<div class="x_panel"> 
    <div class="x_title">
        <h2>Jumlah Permohonan</h2> 
        <div class="clearfix"></div>
    </div>  
    <div class="clearfix"></div>
    <ul class="stats-overview">
        <li>
            <span class="name"><a href="mel-senarai-permohonan" class="btn btn-info btn-sm"> Permohonan <i class="fa fa-eye"></i></a> </span>
            <span class="value text-success"> 
                <?php
                    echo PosTblPermohonan::TotalPermohonan();
               
                ?> 
            </span>
        </li>
        
        
         
    </ul> 
</div>
<div class="x_panel"> 
    <div class="x_title">
        <h2>Status Permohonan</h2> 
        <div class="clearfix"></div>
    </div>  
    <div class="clearfix"></div>
    <ul class="stats-overview">
        <li>
            <span class="name"><a href="record-permohonan-by-status?status=1" class="btn btn-primary btn-sm"> Menunggu <i class="fa fa-edit"></i></a> </span>
            <span class="value text-success"> 
                <?php
                    echo PosTblPermohonan::TotalbyStatus(1);
               
                ?> 
            </span>
        </li>
        <li>
            <span class="name"><a href="record-permohonan-by-status?status=2" class="btn btn-success btn-sm"> DiLuluskan <i class="fa fa-check"></i></a> </span>
            <span class="value text-success">
            <?php
                    echo PosTblPermohonan::TotalbyStatus(2);
               
                ?>
            </span>
        </li>
        <li class="hidden-phone">
            <span class="name"><a href="record-permohonan-by-status?status=3" class="btn btn-danger btn-sm"> Ditolak <i class="fa fa-times"></i></a> </span>
            <span class="value text-success">
            <?php
                    echo PosTblPermohonan::TotalbyStatus(3);
               
                ?>
            </span>
        </li>
        
         
    </ul> 
</div>