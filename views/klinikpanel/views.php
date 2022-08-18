<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\myhealth\TblmaxtuntutanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

error_reporting(0);
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1162], 'vars' => []]); ?>
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel" >
        <div class="x_content">
            
                <p>
                    <?= Html::a('Kembali', ['tuntutan-klinik'], ['class' => 'btn btn-primary']) ?>
                </p>
        </div>
    <div class="x_title">
            <h2><i class="fa fa-list-alt"></i><strong> Senarai Lawatan Klinik</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
        
        
    <div>

    <?= GridView::widget([
        'dataProvider' => $query,        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                ],

            [
                'attribute' => 'rawatan_date',
                'format' => 'text',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                
            ],
            [
                'label' => 'No.KP Kakitangan',
                'attribute' => 'visit_icno',
                'format' => 'text',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                
            ],
            [
                'label' => 'Nama Kakitangan',
                'value' => 'kakitangan.kakitangan.CONm',
                'format' => 'text',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-left'],
                
            ],
            
            [
                'label' => 'No.KP Pesakit',
                'attribute' => 'pesakit_icno',
                'format' => 'text',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                
            ],
            [
                'attribute' => 'pesakit_name',
                'format' => 'text',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-left'],
                
            ],
            [
                'attribute' => 'jum_tuntutan',
                'format' => 'text',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class' => 'text-center'],
                
            ],
            ['class' => 'yii\grid\ActionColumn',
             'header' => '<span class="glyphicon glyphicon-info-sign"></span>',
             
             'template' => '{view-admins}',
                'buttons' => [
                'view-admins' => function ($url, $query) {
                        $url = Url::to(['klinikpanel/view-admins', 'id' => $query->rawatan_id]);
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                    }
]
    ]]]); ?>
</div>
</div>
</div>

              
                

