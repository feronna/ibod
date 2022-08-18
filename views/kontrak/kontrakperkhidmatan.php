<?php
$page1='none';
$page2='none';
if($view==1){
    $page1='';
}
elseif($view==2){
    $page2='';
}
?>
<html>
    <body>
    <div align="center" style="
    display: <?php echo $page1;?>;
    position:absolute;
    top: 7.5%;
    left: 15.6%;
    width:68.68%;
    font-weight:bold;
    font-family:  Arial, Helvetica, sans-serif;
    font-size: 14pt;
    text-align: center;">**************************************************************</div>
    <div  align="center" style="
    display: <?php echo $page1;?>;
    position:absolute;
    top: 15%;
    left: 15.6%;
    width:68.68%;
    font-weight:bold;
    font-family: Arial, Helvetica, sans-serif;
    text-align: center;">
        <div style="font-size: 24px;"><?php echo strtoupper('['.$model->kakitangan->jawatan->nama.' GRED '.$model->kakitangan->jawatan->gred.']');?></div>
        <div style="font-size: 14pt;">**************************************************************</div>
    </div>
    <div align="center" style="
    display: <?php echo $page1;?>;
    padding-top: 112.5%;
    font-weight:bold;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 15px;"><?php echo $model->kakitangan->CONm;?></div><br><div align="center" style="
    display: <?php echo $page1;?>;
    padding-top: -1.5%;
    font-weight:bold;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 15px;"><?php echo $model->icno; ?></div>
    
    <div  style="
    display: <?php echo $page2;?>;
    position:absolute;
    top: 25%;
    left: 15%;
    width:68.68%;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 10pt;
    text-align: justify;">
        satu pihak<b><?php echo 'DENGAN'.$model->kakitangan->CONm;?> </b>No Kad Pengenalan <b><?php echo $model->icno.'MAKA ADALAH DENGAN INI DIPERSETUJUI';?></b> seperti berikut:
    </div>
    
    
    </body></html>