<?php

use app\models\cv\TblAduan;
use app\models\cv\TblAduanPentadbiran;
use app\models\cv\TblAccess;
?> 
<div class="x_panel"> 
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">STATUS</p> 
        <div class="clearfix"></div>
    </div>  
    <div class="clearfix"></div>
    <ul class="stats-overview">
        <li>
            <span class="name"><a href="record-complain-by-status?status=1" class="btn btn-primary btn-sm"> Waiting <i class="fa fa-edit"></i></a> </span>
            <span class="value text-success"> 
                <?php
                if (TblAccess::isAdminAcademic()) {
                    echo TblAduan::TotalbyStatus(1);
                } else {
                    echo TblAduanPentadbiran::TotalbyStatus(1);
                }
                ?> 
            </span>
        </li>
        <li>
            <span class="name"><a href="record-complain-by-status?status=2" class="btn btn-warning btn-sm"> In Action <i class="fa fa-edit"></i></a> </span>
            <span class="value text-success">
            <?php
                if (TblAccess::isAdminAcademic()) {
                    echo TblAduan::TotalbyStatus(2);
                } else {
                    echo TblAduanPentadbiran::TotalbyStatus(2);
                }
                ?>
            </span>
        </li>
        <li class="hidden-phone">
            <span class="name"><a href="record-complain-by-status?status=3" class="btn btn-success btn-sm"> Completed <i class="fa fa-eye"></i></a> </span>
            <span class="value text-success">
            <?php
                if (TblAccess::isAdminAcademic()) {
                    echo TblAduan::TotalbyStatus(3);
                } else {
                    echo TblAduanPentadbiran::TotalbyStatus(3);
                }
                ?>
            </span>
        </li>
    </ul> 
</div>