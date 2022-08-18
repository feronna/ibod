<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\hronline\PendidikanTertinggi;
use app\models\hronline\ServiceStatus;
use app\models\hronline\StatusLantikan;
use yii\widgets\LinkPager;
error_reporting(0); 

/* @var $this yii\web\View */
/* @var $searchModel app\models\hronline\TblprcobiodataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekod Peribadi';
?>

<div class="row">
<div class="col-md-12">
    <?php echo $this->render('/tblrscoadminpost/_topmenu'); ?> 
</div>
</div>

    <?php $form = ActiveForm::begin([
        'action' => ['halaman-utama'],
        'method' => 'get',
    'options' => ['class' => 'form-horizontal form-label-left']
    ]); ?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12" >
<!--    <div class="x_panel" style="background-color:#b4c4d4;color:#37393b;">-->
    <?php ActiveForm::end(); ?>
</div>
            
        <div class="col-md-12 col-sm-12 col-xs-12" > 
            <div class="x_panel">
                <div class="col-xs-12 col-md-6">
                    <?php
                    $rekod_lantikan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Papar Lantikan Terkini',
                                        'text' => 'JFPIB Akademik',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($rekod_lantikan, ['tblrscoadminpost/admin-post-list-akademik']);
                    ?>
                </div> 
                <div class="col-xs-12 col-md-6">
                    <?php
                    $tambah_rekod = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Papar Lantikan Keseluruhan',
                                        'text' => 'JFPIB Akademik',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($tambah_rekod, ['tblrscoadminpost/admin-post-list-keseluruhan-akademik']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php
                    $rekod_lantikan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Pelantikan 3 Bulan Akan Tamat',
                                        'text' => 'JFPIB Akademik',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($rekod_lantikan, ['tblrscoadminpost/admin-post-list-akademik2']);
                    ?>
                </div>   
                
            </div>
        </div>
    
</div>
