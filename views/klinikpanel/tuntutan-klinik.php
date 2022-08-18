<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

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
                    <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
                </p>
        </div>
    <div class="x_title">
            <h2><i class="fa fa-list-alt"></i><strong> Senarai Tuntutan Klinik Telah Dijana</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
                </ul>
            <div class="clearfix"></div>
        </div>
    <div>
          <?php
                $form = ActiveForm::begin([
                    'action' => ['tuntutan-klinik'],
                    'method' => 'get',
                ]);
                ?>
   
        <div class="col-md-6 col-sm-6 col-xs-12">
     
                <?=
                $form->field($searchModel, 'batch_klinik_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\klinikpanel\RefKlinikpanel::find()->where(['isActive' => 1])->orderBy(['nama'=>SORT_ASC])->all(), 'klinik_id', 'nama'),
                        'options' => ['placeholder' => 'Carian Klinik Panel'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                ?>                           
            </div>                        
        <div class="form-group">               
              <?= Html::submitButton('<i class="fa fa-search"></i> Cari', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    </div>
    <div>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            
                ['class' => 'yii\grid\SerialColumn',],              
                ['label' => 'No. Invois Sistem',
                'attribute' => 'DisplayId',
                'format' => 'raw',                
                ],            
                ['label' => 'No. Invois Klinik',
                'value' => 'remarks',
                'format' => 'text',                
                ],            
                ['label' => 'Nama Klinik',
                'attribute' => 'klinik.nama',
                'format' => 'text',                
                ],            
                ['label' => 'Tarikh Tuntutan Dijana',
                'attribute' => 'batch_date_issued',
                'format' => 'text',                
                ],
                [
                'label' => 'Jumlah Tuntutan (RM)',
                'attribute' => 'total_batch_claim',
                'format' => 'text',                
                ],
                [
                'label' => 'Status',
                'attribute' => 'status',
                'format' => 'raw',                
                ],
                [
                'class' => 'yii\grid\ActionColumn',
                'header' => '<span class="glyphicon glyphicon-info-sign"></span>',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $dataProvider) {
                        $url = Url::to(['klinikpanel/views', 'batch_id' => $dataProvider->batch_id]);
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                    }
                ],
            ],
                [
                'class' => 'yii\grid\ActionColumn',
                'header' => '<span class="glyphicon glyphicon-edit"></span>',
                'template' => '{update-status}',
                'buttons' => [
                    'update-status' => function ($url, $dataProvider) {
                        $url = Url::to(['klinikpanel/update-status', 'batch_id' => $dataProvider->batch_id]);
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                    }
                ],
            ],
                [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Cetak',
                'template' => '{invois}',
                'buttons' => [
                    'invois' => function ($url, $dataProvider) {
                        $url = Url::to(['klinikpanel/invois', 'batch_id' => $dataProvider->batch_id]);
                        return Html::a('<span class="glyphicon glyphicon-print"></span>', $url,['target' => '_blank']);
                    }
                ],
            ],
    ]]);
    ?>
</div>
</div>
</div>



