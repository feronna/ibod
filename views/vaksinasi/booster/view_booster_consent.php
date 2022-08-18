<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

$this->title = 'Program Vaksinasi';
?>
<style>
    .fix-width>tbody>tr>th {
        width: 30%;
    }
</style>
<div class="x_panel">

    <div class="x_title">
        <h4><?= "Program Vaksinasi (Booster)" ?></h4>
        <div class="clearfix"></div>
    </div>


    <p>
        <?= \yii\helpers\Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
        <?=  Html::a('Kemaskini', ['booster'], ['class' => 'btn btn-success']) ?>
        
       
    </p>
    <div class="row">
    <div class="x_content ">
        <?= DetailView::widget([
            'options' => ['class' => 'table table-striped table-bordered detail-view fix-width'],
            'model' => $model,
            'attributes' => [
                [
                    'label' => 'IC / Passport No',
                    'attribute' => 'icno',
                ],
                [
                    'label' => 'Telah Menerima Vaksin',
                    'value' => function ($model) {
                        
                        switch ($model->setuju_st) {
                            case '1':
                                $status = 'Setuju';
                                break;
                            case '0':
                                $status = 'Tidak Setuju';
                                break;
                            
                            default:
                                $status = '-';
                                break;
                        }
                        return $status;
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Telah Menerima Vaksin',
                    'attribute' =>'penerangan' ,
                    'format' => 'raw',
                ],
            ],
        ]); ?>
    </div>
    </div>
</div>