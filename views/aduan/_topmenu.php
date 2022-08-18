<style>
    .navbar-nav .open .dropdown-menu {
        position: absolute;
        background:
            #fff;
        margin-top: 0;
        border: 1px solid #D9DEE4;
        -webkit-box-shadow: none;
        right: 0;
        left: auto;
        width: auto;
    }
</style>

<?php

use app\models\myidp\UserAccess;
use app\models\myidp\AdminJfpiu;
use app\models\cuti\SetPegawai;
use app\models\hronline\Department;
use app\models\hronline\Tblprcobiodata;
use app\models\aduan\RptTblAduan;
use app\widgets\TopMenuWidget;

// $user = Yii::$app->user->getId();

// $findUser = UserAccess::find()->where(['userID' => $user])->one();


// $findUser2 = AdminJfpiu::find()->where(['staffID' => $user])->one();

echo TopMenuWidget::widget(['top_menu' => [1488, 1489, 1492], 'vars' => [
    ['label' => '',
        
    ],
    ['label' => RptTblAduan::calcPendingAduan(),
        'items' => [
            [
                'label' => RptTblAduan::calcPendingAduan()
            ],
         ],
    ],
    ['label' => RptTblAduan::calcPendingPenyiasat(),
        'items' => [
            [
                'label' => RptTblAduan::calcPendingPenyiasat()
            ],
         ],
    ],

]]);
?>