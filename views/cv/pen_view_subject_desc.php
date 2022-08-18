<?php

use yii\helpers\Html;
?> 

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
        <?php echo $this->render('menu'); ?>
        <div class="x_panel">  

            <div class="x_title">
                <p align ="right"><?= Html::a('Back', Yii::$app->request->referrer, ['class' => 'btn btn-primary btn-sm']); ?> </p>
                <div class="clearfix"></div>
            </div> 
            <div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
                <table class="table table-sm table-bordered table-striped" style="font-size: 12px">

                    <tr> 

                        <th bgcolor="#2A3F54" style="color: white;"><?= $subject->subj; ?>  <i class="fa fa-question-circle-o fa-lg" aria-hidden="true"></i></th> 

                    </tr> 
                    <tr> 

                        <td style="color: black;"><?= $subject->desc; ?></td> 

                    </tr>

                </table> 
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
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
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
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
        </div>


    </div>
</div>