<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\grid\GridView;
use kartik\form\ActiveForm;
?>

<div class="row">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['dass21/index']) ?></li>
        <li>Borang Dass-21</li>
    </ol>
</div>


<div class="row"> 
    <div class="col-xs-12 col-md-12 col-lg-12">
    <div class="x_panel">
        <div class="x_content">
            <p align="justify">
                Sila baca setiap kenyataan di bawah dan pilih nombor 0, 1, 2 atau 3 bagi menggambarkan keadaan anda sepanjang minggu yang lalu. Tiada jawapan yang betul dan salah.
                Jangan mengambil masa yang terlalu yang lama untuk menjawab  mana-mana kenyataan.<br><br>
                <i>
                    Please read each statement and select a number 0, 1, 2 or 3 which indicates how much the statement applied to you over the past week. There are no right or wrong answers. Do not spend too much time on any statement.
                </i>
            </p>
            <hr>
            <p>
                Skala permakahan adalah seperti berikut: / The rating scale is as follows:
            </p>
            
            <ol start="0">
                <li><strong>Tidak langsung</strong> menggambarkan keadaan saya / <strong>Did not </strong>apply to me at all - NEVER</li>
                <li><strong>Sedikit atau jarang-jarang</strong> menggambarkan keadaan saya / Applied to me to <strong>some degree, or some of the time</strong> - SOMETIMES</li>
                <li><strong>Banyak atau kerapkali</strong> menggambarkan keadaan saya / Applied to me to a <strong>considerable degree, or a good part of time</strong> - OFTEN</li>
                <li><strong>Sangat banyak atau sangat kerap</strong> menggambarkan keadaan saya / Applied to me <strong>very much, or most of the time</strong> - ALMOST ALWAYS</li>
            </ol> 
            
            
            <?php 
                $form = ActiveForm::begin(['action' => ['assessment'], 'method' => 'post', ]);
                
            ?>
            <div class="table-responsive">
            <?=
                GridView::widget([
                    'summary' => '',
                    //'emptyText' => 'Tiada rekod penetapan SKT',
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'label' => 'BIL',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:5%'],
                            'attribute' => 'id',
                        ],
                        [
                            'label' => 'SOALAN / QUESTION',
                            'headerOptions' => ['class'=>'text-center'],
                            //'contentOptions' => ['style'=>'width:75%'],
                            'attribute' => 'soalan',
                            'format' => 'html'
                                    
                        ],
                        [
                            'label' => 'SKOR / SCORE',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:15%'],
                            'value' => function($model) use ($form, $model1) {
                                //return Html::radio('skor['.$model->id.']', false, ['value' => $model->id]);
                                $data = [0 => '0', 1 => '1', 2 => '2', 3 => '3'];
                                return $form->field($model1, "q$model->id")->radioButtonGroup($data)->label(false);
                            },
                                    'format' => 'raw'
                        ],
                    ],
                ]);
            ?>
            </div>
            <div class="form-group pull-right">
                <div class="">
                    <?= Html::submitButton('Hantar / Submit', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div> 
    </div></div>
</div>