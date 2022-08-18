<?php
use app\assets\BoxAsset;
 use  yii\helpers\Html;
BoxAsset::register($this);
use yii\helpers\Url;
?>

 <div class="table-responsive">
<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="form_wizard wizard_horizontal">
        <ul class="wizard_steps">
            <li>Langkah<br /> <br /> 
                 <a href="<?= Url::toRoute(['harta/maklumat-pegawai'])?>">   
                    <span class="step_no">1</span><br/>
                    <span class="step_descr">
                        <?php
                        
                         
                        if ($title == "MaklumatPegawai") {
                            echo '<box2><i class="fa fa-arrow-right" aria-hidden="true"></i>&nbsp;&nbsp;Maklumat&nbsp;Pegawai&nbsp&nbsp;<i class="fa fa-user" aria-hidden="true"></i></box2><br/><br/>';
                        } else {
                            echo '<box>Maklumat&nbsp;Pegawai&nbsp;<i class="fa fa-user" aria-hidden="true"></i></box><br/><br/>';
                        }
    
                       
                        ?>  
                    </span>
                </a>
            </li>
            <li> Langkah<br /> <br /> 
                    <a href="<?= Url::toRoute(['harta/jumlah-pendapatan'])?>">   
                    <span class="step_no">2</span><br/>
                    <span class="step_descr"> 
                        <?php  
                        
                         if ($title == "Pendapatan") {
                            echo '<box2><i class="fa fa-arrow-right" aria-hidden="true"></i>&nbsp;&nbsp;Jumlah&nbsp;Pendapatan&nbsp;&nbsp;<i class="fa fa-money" aria-hidden="true"></i></box2><br/><br/>';
                        } else {
                            echo '<box>Jumlah&nbsp;Pendapatan&nbsp;&nbsp;<i class="fa fa-money" aria-hidden="true"></i></box><br/><br/>';
                        }
              
                       
                        ?>      
                    </span>
                </a>
            </li>
            <li> Langkah<br/> <br /> 
                <a href="<?= Url::toRoute(['harta/jumlah-pinjaman'])?>">   
                    <span class="step_no">3</span><br/>
                    <span class="step_descr"> 
                        <?php  
                        if ($title == "Pinjaman") {
                            echo '<box2><i class="fa fa-arrow-right" aria-hidden="true"></i>&nbsp;&nbsp;Jumlah&nbsp;Tanggungan&nbsp;&nbsp;<i class="fa fa-money" aria-hidden="true"></i></box2><br/><br/>';
                        } else {
                            echo '<box>Jumlah&nbsp;Tanggungan&nbsp;&nbsp;<i class="fa fa-money" aria-hidden="true"></i></box><br/><br/>';
                        }
                       
                        ?>        
                    </span>
                </a>
            </li>
     
        </ul>


    </div>
</div>
     </div>