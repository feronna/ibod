<?php

use app\widgets\AduanTileWidget;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\aduan\RptTblAduanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sistem E - Aduan');
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('/aduan/_topmenu');

echo $this->render('/aduan/contact');
?>
<div class="aduan-menu">
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-md-6">
                <div class="row top_tiles">
                    <div class="animated flipInY">
                        <?php
                        $testingPage1 =  AduanTileWidget::widget(
                            [
                                'icon' => 'folder-open',
                                'header' => 'Aduan Baru',
                                'text' => 'Klik di sini untuk membuat aduan baru <i class="fa fa-hand-pointer-o" aria-hidden="true"></i> ',
                                'number' => ' '
                            ]
                        );
                        echo Html::a($testingPage1, ['aduan/create'], ['title' => 'Sila klik di sini untuk membuat aduan baru.']);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="row top_tiles">
                    <div class="animated flipInY">
                        <?php
                        $testingPage2 = AduanTileWidget::widget(
                            [
                                'icon' => 'folder',
                                'header' => 'Senarai Aduan',
                                'text' => 'Klik di sini untuk melihat senarai aduan anda <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>',
                                'number' => ' '
                            ]
                        );
                        echo Html::a($testingPage2, ['aduan/view-list'], ['title' => 'Sila klik di sini untuk melihat senarai aduan anda.']);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>