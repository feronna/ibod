<html>
    <style>
        .div {
        font-family: Tahoma,serif;
        font-size:10pt;
        }
        </style>
    
    <body><div style="  
    position: absolute;
    width: 550px;
    bottom: 560px;
    right: 57px;
    text-transform: capitalize;">
            <b><?= $model->kakitangan->CONm;?></b>
        </div>
    <div style="  
    position: absolute;
    width: 445px;
    bottom: 535px;
    right: 57px;">
            <b><?= ucwords($model->kakitangan->jawatan->nama).' ('.strtoupper($model->kakitangan->jawatan->gred).')';?></b>
        </div>
        
    <div style="
    position: absolute;
    width: 270px;
    bottom: 476px;
    right: 57px;
    text-transform: capitalize;">
            <b><?= $model->icno;?></b>
        </div>
    
        <div style="
    position: absolute;
    width: 239px;
    bottom: 446px;
    right: 57px;
    text-transform: capitalize;">
            <b><?= $model->kakitangan->umur;?></b>
        </div>
        
    <div style="
    position: absolute;
    width: 208px;
    bottom: 446px;
    right: 400px;
    text-transform: capitalize;">
            <b><?= $model->kakitangan->displayBirthDt;?></b>
        </div>
        
        <div style="
    position: absolute;
    width: 175px;
    bottom: 420px;
    right: 57px;
    text-transform: capitalize;">
            <b><?= $model->kakitangan->displayWarganegara;?></b>
        </div>
        <div style="
    position: absolute;
    width: 190px;
    bottom: 420px;
    right: 460px;
    text-transform: capitalize;">
            <b><?= $model->kakitangan->jantina->Gender;?></b>
        </div>
        <div style="
    position: absolute;
    width: 190px;
    bottom: 393px;
    right: 460px;
    text-transform: capitalize;">
            <b><?php if($model->kakitangan->agama->ReligionCd === '0' || $model->kakitangan->agama->ReligionCd === '99') 
            {echo '';}
            else{
            echo $model->kakitangan->agama->Religion;}?></b>
        </div>
        <div style="
    position: absolute;
    width: 230px;
    bottom: 393px;
    right: 57px;
    text-transform: capitalize;">
            <b><?php if($model->kakitangan->bangsa->RaceCd === '00' || 
                    $model->kakitangan->bangsa->RaceCd === '09' ||
                    $model->kakitangan->bangsa->RaceCd === '11' ||
                    $model->kakitangan->bangsa->RaceCd === '13') 
            {echo '';}
            else{
            echo $model->kakitangan->bangsa->Race;}?></b>
        </div>
        
        <div style="
    position: absolute;
    width: 360px;
    bottom: 368px;
    right: 200px;
    text-transform: capitalize;">
            <b><?php if($model->kakitangan->MrtlStatusCd === '0') 
            {echo '';}
            else{
            echo $model->kakitangan->displayTarafPerkahwinan;}?></b>
        </div>
        