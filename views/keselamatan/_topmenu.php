<?php

use app\widgets\TopMenuWidget;
use app\models\keselamatan\TblRekod;
use app\models\keselamatan\TblRekodOt;
use app\models\keselamatan\TblRollcall;
?>
<?=
TopMenuWidget::widget(['top_menu' => [61, 67, 208, 209, 210,1087,1100,1303], 'vars' => [   
    [
        'label' => TblRekod::totalPending(Yii::$app->user->getId(), 0),
        'items' => [
            [
                'label' => TblRekod::totalPending(Yii::$app->user->getId(), 3)
            ],
            [
                'label' => TblRekod::totalPending(Yii::$app->user->getId(), 1)
            ],
            [
                'label' => TblRekod::totalPending(Yii::$app->user->getId(), 2)
            ],
        ],
    ],
    [
        'label' =>'',
    ],
    [
        'label' => TblRekod::totalPending(Yii::$app->user->getId(), 6),
        'items' => [
            [
                'label' => TblRekod::totalPending(Yii::$app->user->getId(), 8)
            ],
            [
                'label' => TblRekod::totalPending(Yii::$app->user->getId(), 7)
            ], 
            [
                'label' => TblRekod::totalPending(Yii::$app->user->getId(), 9)
            ],
            [
                'label' => TblRekod::totalPending(Yii::$app->user->getId(),4)
            ],
            [
                'label' => TblRekod::totalPending(Yii::$app->user->getId(),5)
            ],
            [
                'label' => TblRekod::totalPending(Yii::$app->user->getId(),3)
            ],
            [
                'label' => TblRekod::totalPending(Yii::$app->user->getId(),10)
            ],
        ],
    ],
   
]]);
?>