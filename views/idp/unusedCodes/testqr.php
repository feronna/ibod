<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Da\QrCode\QrCode;
use yii\helpers\Url;

Url::base();         // /myapp
Url::base(true);     // http(s)://example.com/myapp - depending on current schema
$test = Url::base('https');  // https://example.com/myapp
Url::base('http');   // http://example.com/myapp
Url::base('');       // //example.com/myapp

//$qrCode = (new QrCode('https://registrar.ums.edu.my/staff/web/idp/testqr'))
$qrCode = (new QrCode($test.'/idp/index'))
    ->setSize(250)
    ->setMargin(5)
    ->useForegroundColor(51, 153, 255);

// now we can display the qrcode in many ways
// saving the result to a file:

$qrCode->writeFile(__DIR__ . '/code.png'); // writer defaults to PNG when none is specified

// display directly to the browser 
header('Content-Type: '.$qrCode->getContentType());
//echo $qrCode->writeString();

echo '<img src="' . $qrCode->writeDataUri() . '">';
