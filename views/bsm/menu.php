<?php
use app\assets\BoxAsset;

BoxAsset::register($this);

?>
 
<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="form_wizard wizard_horizontal">
        <ul class="wizard_steps"><br/>
            <li>Langkah<br /> <br /> 
                <a href="#">
                    <span class="step_no">1</span><br/>
                    <span class="step_descr">
                        <?php
                        
                        if ($title == "Iklan") {
                            echo '<box2><i class="fa fa-arrow-right" aria-hidden="true"></i>&nbsp;&nbspIKLAN&nbsp;&nbsp;<i class="fa fa-file-image-o" aria-hidden="true"></i></box2><br/><br/>';
                        } else {
                            echo '<box>Iklan&nbsp;&nbsp;<i class="fa fa-file-image-o" aria-hidden="true"></i></box><br/><br/>';
                        } 
                          
                        ?>  
                    </span>
                </a>
            </li>
            <li> Langkah<br /> <br /> 
                <a href="#">
                    <span class="step_no">2</span><br/>
                    <span class="step_descr"> 
                        <?php  
                        
                        if ($title == "Kelayakan") {
                            echo '<box2><i class="fa fa-arrow-right" aria-hidden="true"></i>&nbsp;&nbsp;DESKRIPSI KELAYAKAN&nbsp;&nbsp;<i class="fa fa-graduation-cap" aria-hidden="true"></i></box2><br/><br/>';
                        } else {
                            echo '<box>Deskripsi Kelayakan&nbsp;&nbsp;<i class="fa fa-graduation-cap" aria-hidden="true"></i></box><br/><br/>';
                        } 
                        ?>      
                    </span>
                </a>
            </li>
            <li> Langkah<br/> <br /> 
                <a href="#"> 
                    <span class="step_no">3</span><br/>
                    <span class="step_descr"> 
                        <?php  
                         
                        if ($title == "Tugas") {
                            echo '<box2><i class="fa fa-arrow-right" aria-hidden="true"></i>&nbsp;&nbsp;TUGAS&nbsp;&nbsp;<i class="fa fa-book" aria-hidden="true"></i></box2><br/><br/>';
                        } else {
                            echo '<box>Tugas&nbsp;&nbsp;<i class="fa fa-book" aria-hidden="true"></i></box><br/><br/>';
                        } 
                         
                        ?>        
                    </span>
                </a>
            </li> 
        </ul>
    </div>
</div>
     