<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\widgets\TopMenuWidget;

?>
<?= TopMenuWidget::widget(['top_menu' => [18,44,45,51], 'vars' => [
    ['label' => ''],
//    ['label' => app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId())]
]]); ?>
<div class="col-md-12"> 
    <div class="x_panel">
        
          <div class="x_title">
            <h2> Laman Utama</h2>
            
            </ul>
            <div class="clearfix"></div>
        </div>  
    </div>
</div>