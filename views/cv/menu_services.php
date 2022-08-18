<?php
$color1 = $color2 = $color3 = $color4 = $color5 = $color6 = $color7 = $color8 = '#2A3F54';

$action = Yii::$app->controller->action->id;

if ($action == 'job-details') {
    $color1 = 'green';
} elseif ($action == 'innovation') {
    $color2 = 'green';
} elseif ($action == 'view') {
    $color3 = 'green';
} elseif ($action == 'skills') {
    $color4 = 'green';
} elseif ($action == 'activities-other') {
    $color5 = 'green';
} elseif ($action == 'income') {
    $color6 = 'green';
} elseif ($action == 'sports') {
    $color7 = 'green';
} elseif ($action == 'paper-work') {
    $color8 = 'green';
}
?>

<div class="x_panel">
    <div class="x_title">
        <p style="font-size:15px;font-weight: bold;">MENU</p> 
        <div class="clearfix"></div>
    </div> 
    <div class="x_content"> 
        <strong><u>
                <ol type="1">
                    <li><a href="../my-portfolio/senarai-myjd" style="color: <?= $color1; ?>;" target="_blank">SENARAI TUGAS UTAMA </a></li>
                    <li><a href="innovation" style="color: <?= $color2; ?>;">INOVASI DALAM KERJA </a></li>
                    <li><a href="../bidangkepakaran/view" target="_blank" style="color: <?= $color3; ?>;">SIJIL PROFESIONAL</a></li>
                    <li><a href="skills" style="color: <?= $color4; ?>;">KEMAHIRAN YANG DIMILIKI SEPANJANG BERKHIDMAT DI UMS</a></li>
                    <li><a href="activities-other" style="color: <?= $color5; ?>;">PENGLIBATAN LUAR</a></li>
                    <li><a href="income" style="color: <?= $color6; ?>;">PENJANAAN PENDAPATAN / PENJIMATAN</a></li>
                    <li><a href="sports" style="color: <?= $color7; ?>;">PENGANJURAN / PENGLIBATAN DALAM PROGRAM / MAJLIS KEBUDAYAAN / ACARA SUKAN </a></li>
                    <li><a href="paper-work" style="color: <?= $color8; ?>;">PENULISAN KERTAS KERJA / PEMBENTANG KERTAS KERJA / PENCERAMAH / PEMUDAH CARA </a></li>
               </ol>
            </u></strong>
    </div> 
</div> 

