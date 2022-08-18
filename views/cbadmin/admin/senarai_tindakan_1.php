<?php
 
use kartik\tabs\TabsX;
error_reporting(0);
?>
 
<?php echo $this->render('/cutibelajar/_topmenu');?>

<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>SENARAI KAKITANGAN CUTI BELAJAR</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
          
      
     

                <?= $this->render('_senarai_menunggu', ['bil' => 1,  'icno' => $icno, 'senarai' => $senarai, 'title' => $title,])?>

    </div> 
<!--            end of dropdownl link-->
  
    </div>
</div>
</div>
 

