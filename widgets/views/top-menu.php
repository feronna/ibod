<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\helpers\Url;

?>

<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12">
<?php
NavBar::begin();
    echo Nav::widget([
        'items' => $tops,
        'encodeLabels' => false,
        'options' => ['class' => 'navbar-nav'],
    ]);
NavBar::end();
?>
</div>
</div>
<br>