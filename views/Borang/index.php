<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Tblbuka\kemudahanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Borangs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="borang-index">
 
    <p>
    <h3> this is a testing page..</h3>
         
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
        'options' => [
                'class' => 'table-responsive',
                    ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'Bil',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
                                ],
            [
                'label' => 'Nama Pemohon',
                'value' => 'kakitangan.CONm',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Jenis Permohonan',
                'value' => 'displayjenis.kemudahan',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
            [
                'label' => 'Tarikh Mohon',
                'value' => 'entrydate',
                'headerOptions' => ['class'=>'text-center'],
                                'contentOptions' => ['class'=>'text-center'],
            ],
             
            
        ],
    ]); ?>
</div>
