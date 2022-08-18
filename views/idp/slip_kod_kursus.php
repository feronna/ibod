<?php

use Da\QrCode\QrCode;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Fruit */

Url::base();         // /myapp
Url::base(true);     // http(s)://example.com/myapp - depending on current schema
$test = Url::base('https');  // https://example.com/myapp
Url::base('http');   // http://example.com/myapp
Url::base('');       // //example.com/myapp

$qrCode = (new QrCode($test.'/idp/hadir-latihan-online?siriID='.$id))
    ->setSize(150)
    ->setMargin(5)
    ->useForegroundColor(0, 0, 0);

/******************************************************/
// display directly to the browser 
header('Content-Type: '.$qrCode->getContentType());

?>

<!DOCTYPE html>
<html>
<head>
<style>
table {
  width: 100%;
  height: 50%;
}
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 15px;
  text-align: left;
}
table#t01 tr:nth-child(even) {
  background-color: #eee;
}
table#t01 tr:nth-child(odd) {
 background-color: #fff;
}
table#t01 th#th01 {
  background-color: #2980B9;
  color: white;
}
table#t01 th {
  background-color: #797D7F;
  color: white;
}
.footer {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  color: black;
  text-align: center;
}
.header {
  position: fixed;
  left: 0;
  top: 0;
  width: 100%;
  text-align: center;
}
</style>
</head>
<body>
<header>
    <h1 align="center"><img src="images/LOGO_UMS_hitam2.png" alt=" "></h1>
    <br><br>
    <h2 align="center">Slip Pengesahan Pendaftaran Kursus Atas Talian</h2>
  </header>
<table id="t01" align="center">   
  <tr>
      <th colspan="2" align="center" id="th01">Maklumat Kursus</th>
  </tr>
  <tr>
    <th>Kursus</th>
<!--    <td><? ucwords(strtoupper($model->sasaran3->tajukLatihan)); ?> Siri <? $model->siri; ?></td>-->
        <td><?= ucwords(strtolower($model->sasaran3->tajukLatihan)); ?></td>
  </tr>
  <tr>
    <th>Tarikh</th>
    <td><?php 
    
        if (($model->tarikhMula != null) && ($model->tarikhMula != 0000-00-00)){
            $myDateTime = DateTime::createFromFormat('Y-m-d', $model->tarikhMula);
            $formatteddate = $myDateTime->format('d/m/Y');
            $myDateTime2 = DateTime::createFromFormat('Y-m-d', $model->tarikhAkhir);
            $formatteddate2 = $myDateTime2->format('d/m/Y');
                                    
            if ($formatteddate == $formatteddate2 ){
                $formatteddate = $formatteddate;    
            } else {
                $formatteddate = $formatteddate.' - '.$formatteddate2;
            }
        } else {
           $formatteddate = '<em><b>AKAN DIMAKLUMKAN</b></em>';
        } 
        echo $formatteddate;
        ?></td>
  </tr>
  <tr>
    <th>Tempat</th>
    <td><?= ucwords(strtolower($model->lokasi)); ?></td>
  </tr>
  <tr>
    <th>Kampus</th>
    <td><?= ucwords(strtolower($model->campusName->campus_name)); ?></td>
  </tr>
  <tr>
    <th>Urusetia</th>
    <td>
        <ul>
            <li>ENCIK ABDUL NASIR BIN ABDUL KADIR | EXT 101856 | nasir@ums.edu.my</li>
            <li>ENCIK AIRUL BIN MAHRUP | EXT 101600 | airulm@ums.edu.my</li>
          </ul>
    </td>
  </tr>
  <tr>
    <th>Kod QR</th>
    <td><?php echo '<br><img src="' . $qrCode->writeDataUri() . '">'; ?></td>
  </tr>
</table>
<caption><strong>Sila imbas slip ini menggunakan pengimbas kod QR untuk tujuan pendaftaran</strong></caption>


<div class="footer">
  <p>UNIVERSITI MALAYSIA SABAH (UMS)</p>
  <p>Universiti Malaysia Sabah, Jalan UMS, 88400, Kota Kinabalu, Sabah, Malaysia. </p>
  <p>Tel : (+6088) 320000 / 320474  |   Fax : (+6088) 320223</p>
  <p><a href="http://www.ums.edu.my/">http://www.ums.edu.my/</a>.</p>
</div>
</body>
</html>

