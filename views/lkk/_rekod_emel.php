<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
<?= $this->render('/cutibelajar/_topmenu') ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">

                <li role="presentation" class="active" ><a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false"><b>REKOD PENGHANTARAN EMEL</b></a>
                </li>


            </ul>
        </div>



        <div role="tabpanel" class="tab-pane active" id="tab_content1" aria-labelledby="home-tab">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel"> 


                        <div class="table-responsive">

                            <?php
                            $gridColumns3 = [
                                ['class' => 'yii\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'headerOptions' => ['style' => 'width:1%', 'class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
//                     [
//                           //'attribute' => 'CONm',
//                            'label' => 'JENIS PERMOHONAN',
//                            'headerOptions' => ['class'=>'text-center'],
//                            'contentOptions' => ['class'=>'text-center'],
//                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                return Html::a('<strong>'.strtoupper($model->borang->alt).'</strong>');
//                            }, 
//                                    'format' => 'html',
//                        ],
                                [
                                    //'attribute' => 'CONm',
                                    'label' => 'TAJUK EMEL',
                                    'headerOptions' => ['style' => 'width:2%', 'class' => 'text-left'],
                                    'value' => function($model) {
                                return '<strong><small>' . $model->from_name . '</strong></small>';
                            },
                                    'format' => 'html',
                                ],
                                [
                                    //'attribute' => 'CONm',
                                    'label' => 'EMEL KEPADA:-',
                                    'headerOptions' => ['style' => 'width:20%', 'class' => 'text-left'],
                                    'value' => function($model) {
                                if ($model->to_email) {
                                    return '<strong><small style=color:green>' . $model->subject . '</strong></small><br>'.
                                            '<strong><small>' . $model->to_name . '</strong></small><br>'
                                            . '<small style="color:red"><i>' . $model->to_email . '</small></i> ' .
                                            '<small><strong>' . $model->date_published . '</small></strong>';
                                } else {
                                    return '<strong><small>' . $model->to_name . '</strong></small><br>' .
                                            '<strong style="color:red"> NO EMAIL HAS BEEN SENT</strong>';
                                }
                            },
                                    'format' => 'html',
                                ],
                                   
//                    [        
//                        'class' => 'yii\grid\CheckboxColumn',
//                        'checkboxOptions' => function ($data) { 
//                        if(($data->status_bsm=='Diluluskan' ||$data->status_bsm=='Tidak Diluluskan')){
//                        return ['disabled' => 'disabled'];
//                            }
//                            return ['value' => $data->id, 'checked'=> true];
//                            },
//                     ],
                            ];



                            echo GridView::widget([
                                'pager' => [
                                    'firstPageLabel' => 'First',
                                    'lastPageLabel' => 'Last'
                                ],
                                'dataProvider' => $emel,
                                'columns' => $gridColumns3,
                                'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                                'beforeHeader' => [
                                    [
                                        'columns' => [],
                                        'options' => ['class' => 'skip-export'] // remove this row from export
                                    ]
                                ],
                                'toolbar' => [
                                    ['content' => '']
                                ],
                                'bordered' => true,
                                'striped' => false,
                                'condensed' => false,
                                'responsive' => true,
                                'hover' => true,
                                'panel' => [
                                    'type' => GridView::TYPE_DEFAULT,
                                    'heading' => '<h6> '
                                    . '<i class="fa fa-check fa-lg" style="color:green"></i> REKOD EMEL</h6>',
                                ],
                            ]);
                            ?>
                        </div>


                    </div>
                </div>  

            </div>
        </div>
    </div>
</div>