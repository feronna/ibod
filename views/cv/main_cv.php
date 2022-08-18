<h5><b>1.1 PERSONAL DETAILS</b></h5>
<table class="table" style="font-size: 12px;font-family:Times New Roman;"> 
    <tbody>
        <tr class="info">

            <th colspan="5" class="text-center"> 
                <p style="font-size: 14px;"><?= strtoupper($biodata->CONm); ?></p><br/>
            </th>
        </tr>
        <tr>
            <th rowspan="4" class="text-center">
    <center>
        <div class="profile_img">
            <div id="crop-avatar"> <br/><br/>
                <img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($biodata->ICNO)); ?>.jpeg" width="90" height="120">
            </div>
        </div> 
    </center>
</th>  
<th  colspan="4" class="text-center">
    <small>
        <?php if ($biodata->jawatan->job_category == 1) { ?>
            TITLE : <?= strtoupper($biodata->gelaran->Title); ?>
            <br/>
            ACADEMIC PROGRAM : <?= $biodata->programPengajaran ? $biodata->programPengajaran->NamaProgram : '-'; ?>
            <br/>
        <?php } ?>
        <i class="fa fa-phone-square user-profile-icon"></i> <?= $biodata->COHPhoneNo; ?> |
        <i class="fa fa-envelope user-profile-icon"></i> <?= $biodata->COEmail; ?>
    </small>
</th> 
</tr>  

<tr> 
    <th style="width:20%">ICNO</th>
    <td style="width:20%"><?= $biodata->ICNO; ?></td> 
    <th>UMSPER</th>
    <td><?= $biodata->COOldID; ?></td>  

</tr>
<tr> 
    <th style="width:20%">Address</th>
    <td style="width:20%"><?php
        if ($biodata->alamatTetap) {
            echo $biodata->alamatTetap->alamatPenuh;
        } elseif ($biodata->alamatSemasa) {
            echo $biodata->alamatSemasa->alamatPenuh;
        } elseif ($biodata->alamatSuratmenyurat) {
            echo $biodata->alamatSuratmenyurat->alamatPenuh;
        } elseif ($biodata->alamatLain2) {
            echo $biodata->alamatLain2->alamatPenuh;
        } elseif (empty($biodata->rekodAlamat)) {
            echo 'N/A';
        }
        ?></td>
    <th>State</th>
    <td><?php
        if ($biodata->COBirthPlaceCd) {
            echo $biodata->tempatLahir->State;
        }
        ?></td> 
</tr>
<tr> 

    <th style="width:20%">Date of Birth</th>
    <td style="width:20%"><?= $biodata->COBirthDt ? $biodata->getTarikhBI($biodata->COBirthDt) : '-'; ?></td>
    <th style="width:20%">Gender</th>
    <td style="width:20%"><?= $biodata->jantina->GenderBI; ?></td>

</tr> 
</tbody>
</table> 




<br/> 