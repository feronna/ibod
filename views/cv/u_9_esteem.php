<?php echo $this->render('menu'); ?>  
<?php echo $this->render('main', ['biodata' => $biodata]); ?>   
<br/>
<div class="x_panel"> 
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">ESTEEM & LEADERSHIP <a href="<?php echo yii\helpers\Url::to(['cv/esteem-leadership']); ?>" target="_blank"  class="btn btn-default btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> UPDATE RECORD</a></p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content"> 
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr> 
                    <th>No.</th> 
                    <th>Type</th>
                    <th style="width: 40%;">Title</th>
                    <th>Year</th>   

                </tr> 

                <?php
                if ($biodata->esteem) {
                    $counter = 0;
                    foreach ($biodata->esteem as $esteem) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td> 
                            <td><?= $esteem->type ? $esteem->name->output : ' '; ?> </td> 
                            <td><?= $esteem->title ? $esteem->title : ' '; ?> </td> 
                            <td><?= $esteem->year ? $esteem->year : ' '; ?> </td>     
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4" class="text-center">No Information</td>  
                    </tr>

                    <?php
                }
                ?>
            </table>
        </div>
    </div>  

    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">THESIS EXAMINER <a href="<?php echo yii\helpers\Url::to(['cv/thesis-examiner']); ?>" target="_blank"  class="btn btn-default btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> UPDATE RECORD</a></p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="table-responsive">
        <table class="table table-sm table-bordered jambo_table table-striped"> 
            <tr> 
                <th>No.</th>  
                <th style="width: 30%;">Title</th>
                <th>Year</th>  
                <th>Examiner Type</th> 
                <th>Level</th> 
                <th style="width: 15%;">Student Name</th> 
                <th style="width: 15%;">Institutions</th>  

            </tr> 

            <?php
            if ($biodata->examiner) {
                $counter2 = 0;
                foreach ($biodata->examiner as $examiner) {
                    $counter2 = $counter2 + 1;
                    ?> 

                    <tr>
                        <td><?= $counter2; ?></td>  
                        <td><?= $examiner->title ? $examiner->title : ' '; ?> </td> 
                        <td><?= $examiner->year ? $examiner->year : ' '; ?> </td>   
                        <td><?= $examiner->examiner_type ? ucwords($examiner->examiner_type) : ' '; ?> </td> 
                        <td><?= $examiner->level ? ucwords($examiner->level) : ' '; ?> </td> 
                        <td><?= $examiner->student_name ? $examiner->student_name : ' '; ?> </td> 
                        <td><?= $examiner->institution ? $examiner->university->output : ' '; ?> </td>   
                    </tr>

                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="7" class="text-center">No Information</td>  
                </tr>

                <?php
            }
            ?>
        </table>
        </div>
    </div>
</div>  
