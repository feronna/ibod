<?php

$statusLabel = [
        0 => 'Tidak Berpencen',
        1 => 'Berpencen'
   
];
$status = [
        5 => 'menolak',
        4 => 'meluluskan'
   
];
error_reporting(0);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div style="margin-bottom: 12px" ALIGN="center">
    <br><b>KEPUTUSAN JAWATANKUASA TATATERTIB KAKITANGAN</b>
   &nbsp; &nbsp;&nbsp;&nbsp; 
</div>

<div style="margin-bottom: 20px"; text-align="justify"; font-size="25px">
    Jawatankuasa Tatatertib Kakitangan Universiti Malaysia telah bersidang pada <?= $model->tarikhMesyuarat?> telah <strong><?= $status[$model->status]?></strong> perisytiharan harta Tuan/Puan mengikut Seksyen 9, Jadual Kedua, Akta Badan-Badan Berkanun (Tatatertib dan Surcaj) Tahun 2000 [Akta 605] 
    atau pindaannya.
</div>
