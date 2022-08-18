<?php echo $this->render('menu'); ?>  
<?php echo $this->render('main', ['biodata' => $biodata]); ?>    
<br/>
<div class="x_panel">
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">BLENDED LEARNING <a href="<?php echo yii\helpers\Url::to('https://smartv3.ums.edu.my/'); ?>" target="_blank"  class="btn btn-default btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> UPDATE RECORD</a></p>
        <div class="clearfix"></div>
    </div>
        <div class="x_content"> 

            <?php
            $blended = $biodata->blendedLearningSmartv3;
            if ($blended) {

                if ($blended == 'no_ad_ums') {
                    ?>
                    <span style="color: red;">BLENDED LEARNING = EMAIL UMS NOT UPDATED !</span>
                    <?php
                } else {
                    ?> 
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered jambo_table table-striped">
 
                            <tr>   
                                <th style="width: 2%;">No.</th>  
                                <th style="width: 85%;">Course Code & Course Name</th>
                                <th>Status</th>  
                            </tr> 

                            <?php
                            $counter = 0;
                            foreach ($blended as $blended) {
                                $counter = $counter + 1;
                                ?> 

                                <tr>
                                    <td><?= $counter; ?></td>  
                                    <td> <?= $blended->fullname ? $blended->fullname : ' '; ?> </td> 
                                    <td> <?= $blended->status ? $blended->status : ' '; ?> </td>   
                                </tr>

                                <?php
                            }
                            ?>
                        </table>
                    </div>
                    <?php
                }
            } else {
//                echo 'No data - (SUMBER + elnpt.tbl_blended_learning)';
            }
            ?>

            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped">

                    <tr> 
                        <th class="text-center" colspan="15">SUMMARY BLENDED LEARNING</th> 
                    </tr> 
                    <tr>   
                        <th style="width: 2%;">No.</th>  
                        <th style="width: 85%;">Status</th> 
                        <th>Total</th> 
                    </tr> 

                    <tr>
                        <td>1</td>
                        <td>PASS </td>
                        <td> <?= count($biodata->getBlendedLearningSmartv3byStatus('PASS')); ?></td>  
                    </tr> 
                    <tr>
                        <td>2</td>
                        <td>FAIL </td>
                        <td> <?= count($biodata->getBlendedLearningSmartv3byStatus('FAIL')); ?></td>  
                    </tr> 
                </table>
            </div> 
        </div> 
    </div>  
</div>  
