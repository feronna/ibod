<?php
use app\models\cbelajar\TblAduan;
?> 
       <?php echo $this->render('/cutibelajar/_topmenu'); ?>

<div class="x_panel"> 
    <div class="x_title">
        <h2>Status</h2> 
        <div class="clearfix"></div>
    </div>  
    <div class="clearfix"></div>
    <ul class="stats-overview">
        <li>
            <span class="name"><a href="record-complain-by-status?status=1" class="btn btn-primary btn-sm"> Waiting <i class="fa fa-edit"></i></a> </span>
            <span class="value text-success"> 
                <?php
                    echo TblAduan::TotalbyStatus(1);
               
                ?> 
            </span>
        </li>
        <li>
            <span class="name"><a href="record-complain-by-status?status=2" class="btn btn-warning btn-sm"> In Action <i class="fa fa-edit"></i></a> </span>
            <span class="value text-success">
            <?php
                    echo TblAduan::TotalbyStatus(2);
               
                ?>
            </span>
        </li>
        <li class="hidden-phone">
            <span class="name"><a href="record-complain-by-status?status=3" class="btn btn-success btn-sm"> Completed <i class="fa fa-eye"></i></a> </span>
            <span class="value text-success">
            <?php
                    echo TblAduan::TotalbyStatus(3);
               
                ?>
            </span>
        </li>
    </ul> 
</div>