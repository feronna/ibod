<?php

use yii\helpers\Html;
//use yii\grid\GridView;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\detail\DetailView;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\myidp\BorangPenilaianLatihan */
/* @var $form ActiveForm */

// setup your attributes
// DetailView Attributes Configuration

?>
<style>
    .btn-info:active, .btn-info.active, .open > .dropdown-toggle.btn-info {
    color: #fff;
    background-color: #0000FF;
    background-image: none;
    border-color: #269abc;
}
    
</style>
<div class="row">
    <div class="x_panel">
        <div class="x_title">
            <h2><i class="fa fa-pencil" aria-hidden="true"></i> Pelepasan Cukai Individu Pemastautin</h2>
            <div class="clearfix"></div>
        </div>
        <br>

<!--        <div class="row"> -->
        <div>
            <h4><i class="fa fa-folder-open-o" aria-hidden="true"></i> Checklist Borang</h4>
            <div class="clearfix"></div>
        </div>
        
                Sila tandakan  maklumbalas anda mengikut pilihan berikut: / <em>Please tick  your response as per following options</em> :<br>

        <?php $form = ActiveForm::begin();?>
<!--        <div class="table-responsive">-->
            <?= GridView::widget([
                    'summary' => '',
                    //'emptyText' => 'Tiada rekod penetapan SKT',
                    'dataProvider' => $dataProviderA,
                    'columns' => [
                        [
                            'label' => 'BIL',
                            'headerOptions' => ['class'=>'text-center', 'style' => 'display: none;',],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:5%'],
                            'attribute' => 'soalanID',
                        ],
                        [
                            'label' => 'JENIS POTONGAN INDIVIDU',
                            'headerOptions' => ['class'=>'text-center', 'colspan' => '2',],
                            'contentOptions' => ['style'=>'width:60%'],
                            'attribute' => 'soalan',
                            'format' => 'html'
                                    
                        ],
                    
                        [
                            'label' => 'PILIHAN',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:5%'],
                            'value' => function($model) use ($modelL, $form) {
                                $data = [ 1 => 'YA', 2 => 'TIDAK'];
                                
                                //return $form->field($model1, "q$model->id")->radioButtonGroup($data)->label(false);
                                return $form->field($modelL, "$model->soalanID")->radioButtonGroup($data, [
                                    'class' => 'btn-group-sm',
                                //    'itemOptions' => ['labelOptions' => ['class' => 'btn btn-info']]
                                    'itemOptions' => ['labelOptions' => ['class' => 'btn btn-info', 'disabled' => $modelL->status == 1 ? true : false]]
                                ])->label(false);
                            },
                            'format' => 'raw'
                        ],
                    ],
                ]);
            ?>
     <div class="form-group" align="right">
                
                 <div class=""><?= Html::submitButton('Hantar / Submit', ['class' => 'btn btn-success', 'disabled' => $modelL->status == 1 ? true : false]) ?></div>
                </div>
           
        </div>
      
        <?php ActiveForm::end(); ?> 
    </div>
</div>