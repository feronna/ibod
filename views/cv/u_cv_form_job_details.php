<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
?> 
<?php echo $this->render('menu'); ?> 
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php echo $this->render('menu_info_tugas'); ?> 
</div>

<div class="col-md-3 col-sm-12 col-xs-12"> 
    <?php echo $this->render('menu_services'); ?>   
</div>

<div class="col-md-9 col-sm-12 col-xs-12">
    <div class="x_panel"> 
        <div class="x_title">
            <p style="font-size:15px;font-weight: bold;">HALAMAN UTAMA</p> 
            <div class="clearfix"></div>
        </div> 
    </div>
</div>  