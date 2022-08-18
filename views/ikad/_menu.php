<?php

use app\widgets\TopMenuWidget;
use app\models\keselamatan\TblRekod;
use app\models\keselamatan\TblRekodOt;
use app\models\keselamatan\TblRollcall;
?>
<?=
TopMenuWidget::widget(['top_menu' => [1421,1424,1425,1426], 'vars' => [   
    // [
    //     'label' => TblRekod::totalPending(Yii::$app->user->getId(), 0),
    //     'items' => [
    //         // [
    //         //     'label' => TblRekod::totalPending(Yii::$app->user->getId(), 3)
    //         // ],
    //         // [
    //         //     'label' => TblRekod::totalPending(Yii::$app->user->getId(), 1)
    //         // ],
    //         // [
    //         //     'label' => TblRekod::totalPending(Yii::$app->user->getId(), 2)
    //         // ],
    //     ],
    // ],
    // [
    //     'label' =>'',
    // ],
 
   
]]);
?>