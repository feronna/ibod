<?php

use yii\helpers\Html;
?>

<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <!--<h3>Menu</h3>-->
            <?php echo \yiister\gentelella\widgets\Menu::widget(["items" => $sides])?>                    
    </div>
</div>