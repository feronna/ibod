<?php
use app\assets\BoxAsset1;
use yii\helpers\Url;
BoxAsset1::register($this);

?>
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">

<div class="table-responsive">


<div class="sticky">
    <div class="form_wizard wizard_horizontal">
        <ul class="wizard_steps">
    
             <li><br /> <br /> 
                <a href="<?= Url::toRoute(['cutisabatikal/gambar', 'id' => $id])?>">  
                    <span class="step_no"><i class="fa fa-file-image-o" aria-hidden="true"></i></span><br/>
                    <span class="step_descr">
                        <?php
                        
                         
                        if ($title == "Gambar") {
                            echo '<box2>&nbsp;&nbsp;Gambar&nbsp;&nbsp;</box2><br/><br/>';
                        } else {
                            echo '<box>Gambar&nbsp;&nbsp;</box><br/><br/>';
                        }
    
                       
                        ?>  
                    </span>
                </a>
            </li>

            <li><br /> <br /> 
                    <a href="<?= Url::toRoute(['cutisabatikal/maklumat-peribadi', 'id' => $id])?>">  
                    <span class="step_no"><i class="fa fa-user" aria-hidden="true"></i></span><br/>
                    <span class="step_descr">
                        <?php
                        
                         
                        if ($title == "Maklumat Peribadi") {
                            echo '<box2>&nbsp;&nbsp;Maklumat&nbspPeribadi&nbsp;&nbsp;</box2><br/><br/>';
                        } else {
                            echo '<box>Maklumat&nbsp;Peribadi&nbsp;&nbsp;&nbsp</box><br/><br/>';
                        }
    
                       
                        ?>  
                    </span>
                </a>
            </li>
            <li> <br /> <br /> 
                    <a href="<?= Url::toRoute(['cutisabatikal/maklumat-akademik','id' => $id])?>">  
                    <span class="step_no"><i class="fa fa-book" aria-hidden="true"></i></span><br/>
                    <span class="step_descr"> 
                        <?php  
                        
                         if ($title == "Maklumat Akademik") {
                            echo '<box2>&nbsp;&nbsp;Maklumat&nbsp;Akademik&nbsp;&nbsp;</box2><br/><br/>';
                        } else {
                            echo '<box>Maklumat&nbsp;Akademik&nbsp;&nbsp;&nbsp;</box><br/><br/>';
                        }
              
                       
                        ?>      
                    </span>
                </a>
            </li>
            <li> <br/> <br /> 
                    <a href="<?= Url::toRoute(['cutisabatikal/maklumat-pengajian', 'id' => $id])?>">  
                    <span class="step_no"><i class="fa fa-graduation-cap" aria-hidden="true"></i></span><br/>
                    <span class="step_descr"> 
                        <?php  
                        if ($title == "Maklumat Pengajian") {
                            echo '<box2>&nbsp;&nbsp;Maklumat&nbsp;Pengajian&nbsp;&nbsp;</box2><br/><br/>';
                        } else {
                            echo '<box>Maklumat&nbsp;Pengajian&nbsp;&nbsp;</box><br/><br/>';
                        }
                       
                        ?>        
                    </span>
                </a>
            </li>
            <li><br /> <br /> 
                    <a href="<?= Url::toRoute(['cutisabatikal/maklumat-biasiswa', 'id' => $id])?>">  
                    <span class="step_no"><i class="fa fa-money" aria-hidden="true"></i></span><br/>
                    <span class="step_descr"> 
                        
                        <?php  
                        
                       
                        if ($title == "Pembiayaan / Pinjaman") {
                            echo '<box2>&nbsp;&nbsp;Pembiayaan&nbsp;/&nbsp;Pinjaman&nbsp;&nbsp;</box2><br/><br/>';
                        } else {
                            echo '<box>Pembiayaan&nbsp;/&nbsp;Pinjaman&nbsp;&nbsp;</box><br/><br/>';
                        }
                         
                         
                        ?>       
                    </span>
                </a>
            </li>

            
            
            <li><br /> <br /> 
                    <a href="<?= Url::toRoute(['cutisabatikal/senarai-dokumen-dimuatnaik', 'id' => $id])?>">  
                    <span class="step_no"><i class="fa fa-list" aria-hidden="true"></i></span><br/>
                    <span class="step_descr">
                        <?php
                        
                        if ($title == "Muatnaik Dokumen") {
                            echo '<box2>&nbsp;Muatnaik&nbspDokumen&nbsp;&nbsp;&nbsp</box2></i><br/><br/>';
                        } else {
                            echo '<box>Muatnaik&nbspDokumen&nbsp;&nbsp;</box><br/><br/>';
                        }
                         
                        
                          
                        ?>  
                    </span>
                </a>
            </li>

             <li><br /> <br /> 
                    <a href="<?= Url::toRoute(['cutisabatikal/pengakuan-pemohon', 'id' => $id])?>">  
                    <span class="step_no"><i class="fa fa-edit"aria-hidden="true"></i></span><br/>
                    <span class="step_descr">
                        <?php
                        
                        if ($title == "Pengakuan") {
                            echo '<box2>&nbsp;&nbsp;&nbsp;Pengakuan</box2></i><br/><br/>';
                        } else {
                            echo '<box>&nbsp;&nbsp;Pengakuan</box><br/><br/>';
                        }
                         
                        
                          
                        ?>  
                    </span>
                </a>
            </li>



         
        </ul>

</div>
    </div>
</div>

 </div>
      </div>