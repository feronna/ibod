<?php

use yii\helpers\Html; 
use kartik\grid\GridView; 
use yii\widgets\ActiveForm;
use kartik\widgets\StarRating;
?> 

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <?php echo $this->render('menu'); ?>
        <div class="x_panel"> 
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

            <div class="x_title">
                <h2><?= strtoupper('applied position - ' . $iv->jawatan->fname); ?></h2> 
                <div class="clearfix"></div>
            </div>
            <div  class="col-md-7 col-sm-7 col-xs-7">

                <table class="table table-sm table-bordered">  
                    <tr>
                        <td rowspan="4" class="col-md-2 col-sm-2 col-xs-12 text-center"> 
                        <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($biodata->ICNO)); ?>.jpeg" width="125" height="150"></center>
                    <br/> 

                    <?php
                     if($biodata->checkJd($biodata->ICNO)){
                                    $btn = 'btn-default';
                                }else{
                                    $btn = 'btn-danger';
                                }
                            
                                echo Html::a('CV', [
                                        'view-cv',
                                        'id' => sha1($biodata->ICNO),
                                        'title' => 'personal',
                                            ], [
                                        'class' => 'btn btn-default',
                                        'target' => '_blank',
                                    ]).Html::a('JD', [
                                        "jd", 
                                        'id' => $biodata->ICNO
                                            ],[
                                        'class' => 'btn '.$btn,
                                        'target' => '_blank',
                                    ]);
                    ?>
                    </td> 

                    </tr>
                    <tr>
                        <th class="text-right">Name / IC </th>
                        <td> <?= strtoupper($biodata->biodata->CONm) . '  (' . $biodata->ICNO . ')';?></td>  
                    </tr>

                    <tr>
                        <th class="text-right"><br/>Level <span class="required" style="color:red;">*</span></th>
                        <td>  
                            <?=
                            $form->field($markah, 'markah')->widget(StarRating::classname(), [
                                'pluginOptions' => [
                                    'min' => 0,
                                    'max' => 4,
                                    'stars' => 4,
                                    'starCaptions' => [
                                        1 => 'Novice',
                                        2 => 'Qualified',
                                        3 => 'Proficient',
                                        4 => 'Expert',
                                    ],
                                ]
                            ])->label(false);
                            ?>
                        </td>

                    </tr>
                </table>
            </div>
            <div  class="col-md-5 col-sm-5 col-xs-5">

                <table class="table table-sm table-bordered">  
                    <tr>
                        <th class="col-md-5 col-sm-5 col-xs-5">Comment <span class="required" style="color:red;">*</span></th>
                    </tr>
                    <tr class="text-center">
                        <td>  
                            <?= $form->field($markah, 'ulasan')->textarea(array('rows' => 5, 'cols' => 5))->label(false) ?>

                            <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-sm']) . '  ' . Html::a('Cancel', ['list-iv', 'id' => $iv->id], ['class' => 'btn btn-danger btn-sm']); ?>
                        </td>
                    </tr>
                </table>

            </div>
            <?php ActiveForm::end(); ?> 
            <table class="table table-sm table-bordered table-striped" style="font-size: 12px">
 
                <tr> 

                    <th bgcolor="#2A3F54" style="color: white;">Assigned Competency - <?= $subject->subjek->subj; ?>  <i class="fa fa-question-circle-o fa-lg" aria-hidden="true"></i></th> 
 
                </tr> 
                <tr> 

                        <td style="color: black;"><?= $subject->subjek->desc; ?></td> 
 
                </tr>
                
            </table>
            
            
            <table class="table table-sm table-bordered table-striped" style="font-size: 12px;">


                <tr>
                    <?php
                    foreach ($dictSubject as $dictSubject) {
                        ?>

                        <th bgcolor="#2A3F54" style="color: white;" class="text-center" style="width: 10%;"><?= $dictSubject->name ?></th> 

                    <?php } ?>
                </tr>        

                <?php
                $dictLevel1 = $subject->level;
                $dictLevel2 = $subject->level;
                $dictLevel3 = $subject->level;
                $dictLevel4 = $subject->level;
                ?>

                <tr>

                    <td bgcolor="#ffadad" style="color: black; width:25%;"><ul>
                            <?php foreach ($dictLevel1 as $dictLevel) { ?>

                                <?php
                                if ($dictLevel->level == 1) {
                                    echo '<li>' . $dictLevel->desc . '</li>';
                                }
                                ?>

                            <?php } ?>
                        </ul></td>   

                    <td bgcolor="#ffcc8a" style="color: black; width:25%;"><ul>
                            <?php foreach ($dictLevel2 as $dictLevel) { ?>

                                <?php
                                if ($dictLevel->level == 2) {
                                    echo '<li>' . $dictLevel->desc . '</li>';
                                }
                                ?>

                            <?php } ?>
                        </ul></td>

                    <td bgcolor="#5da6f5" style="color: black; width:25%;"><ul>
                            <?php foreach ($dictLevel3 as $dictLevel) { ?>

                                <?php
                                if ($dictLevel->level == 3) {
                                    echo '<li>' . $dictLevel->desc . '</li>';
                                }
                                ?>

                            <?php } ?>
                        </ul></td>

                    <td bgcolor="#3d67ff" style="color: black; width:25%;"><ul>
                            <?php foreach ($dictLevel4 as $dictLevel) { ?>

                                <?php
                                if ($dictLevel->level == 4) {
                                    echo '<li>' . $dictLevel->desc . '</li>';
                                }
                                ?>

                            <?php } ?>
                        </ul></td>


                </tr>   
            </table>  
            <table class="table table-sm table-bordered table-striped" style="font-size: 12px">
 
                <tr> 
                    <th bgcolor="#2A3F54" style="color: white;">Negative Indicators</th>  
                </tr>
                <tr>
                    <?php $dictIndicators = $subject->indicators; ?>
                    <td style="color: black;"><ul>
                            <?php
                            foreach ($dictIndicators as $indicators) {
                                echo '<li>' . $indicators->desc . '</li>';
                            }
                            ?>
                        </ul></td>    
                </tr>  
            </table>
        </div>
        <div class="x_panel"> 

            <div class="table-responsive">   
                <?php
                $Columns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'List',
                        'value' => function($model) {
                            return $model->question;
                        },
                        'format' => 'raw'
                    ],
                ];


                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $Columns,
                    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                    'beforeHeader' => [
                        [
                            'options' => ['class' => 'skip-export'] // remove this row from export
                        ]
                    ],
                    'toolbar' => [
                    ],
                    'pjax' => false,
                    'bordered' => true,
                    'striped' => false,
                    'condensed' => false,
                    'responsive' => true,
                    'hover' => true,
                    'showPageSummary' => true,
                    'panel' => [
                        'type' => GridView::TYPE_DEFAULT,
                        'heading' => '<h2>Available Question</h2>',
                    ],
                ]);
                ?> 
            </div>
        </div> 

    </div>
</div>