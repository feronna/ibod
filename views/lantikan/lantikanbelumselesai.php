<?php

use app\models\dass\Tblprcobiodata;
use yii\helpers\Html;
use yii\grid\GridView;
?>

<div class="x_panel">
    <div class="x_title">
        <h2>Senarai Lantikan Belum Selesai</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                [
                    'label' => 'Nombor IC',
                    'value' => 'ICNO',
                ],
                [
                    'label' => 'Staff ID',
                    'value' => 'Staff_Id',
                ],
                [
                    'label' => 'Admin Incharge',
                    'value' => function($model){
                        return Tblprcobiodata::findOne(['ICNO'=>$model->Admin_ICNO])->CONm;
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Tindakan',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view-utama','id'=>$model->ICNO]);
                        },

                    ],
                ],
            ],
        ]); ?>


    </div>
</div>