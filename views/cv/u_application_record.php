<?php

use kartik\grid\GridView;
?> 
<?= $this->render('menu') ?> 

<div class="x_panel">
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">RECORD OF APPLICATION</p> 
        <div class="clearfix"></div>
    </div> 
    <div class="x_content">
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr> 
                    <th>No.</th>  
                    <th style="width: 15%;">Date Applied</th>  
                    <th style="width: 40%;">Position Applied</th>  
                    <th style="width: 45%;">Status</th>  

                </tr> 

                <?php
                $counter = 0;
                if ($model) {
                    foreach ($model as $model) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td>  
                            <td><?= $model->submit_datetime; ?> </td>   
                            <td><?php
                                if ($model->user->jawatancv->svc == 2) {
                                    echo $model->findJawatan($model->ads->gred_id);
                                } else {
                                    if ($model->ads_id == 10) {
                                        echo $model->jawatan->fname . '  <a href="self-check?gred=10" class="label label-info" target="_blank">Check my criteria (Click Here)</a>';
                                    } else {
                                        echo $model->jawatan->fname;
                                    }
                                }
                                ?> </td>
                            <td><?php
                                if ($model->status_id == 1) {
                                    echo '<span class="label label-warning">Waiting Dean/Officer approval</span>';
                                } else if ($model->status_id == 2) {
                                    echo '<span class="label label-info">Waiting BSM approval</span>';
                                } else if ($model->status_id == 3) {
                                    echo '<span class="label label-primary">Interview Offer</span>';
                                } else if ($model->status_id == 4) {
                                    echo '<span class="label label-success">Application Pass</span>';
                                } else if ($model->status_id == 5) {
                                    echo '<span class="label label-danger">Application Failed</span>';
                                }
                                ?> 
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4" class="text-center">No Information</td>      
                    </tr>

                <?php }
                ?>
            </table> 
        </div>
    </div> 
</div>


<div class="x_panel">
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">STATUS INFO</p> 
        <div class="clearfix"></div>
    </div> 
    <div class="x_content">
        <?php foreach ($status as $status) { ?>
            <ul>
                <li><?= '<span class="label label-' . $status->label . '">'; ?><?= $status->name; ?></span> : <?= $status->desc; ?></li> 
            </ul>
        <?php } ?>
    </div> 
</div>


