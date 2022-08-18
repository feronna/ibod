<?php echo $this->render('menu'); ?>  
<?php echo $this->render('main', ['biodata' => $biodata]); ?>   
<br/>
<div class="x_panel"> 
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">SERVICES UNIVERSITY <a href="<?php echo yii\helpers\Url::to(['cv/services-university']); ?>" target="_blank"  class="btn btn-default btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> UPDATE RECORD</a></p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr> 
                    <th>No.</th> 
                    <th style="width: 30%;">Service</th>
                    <th style="width: 10%;">Year</th>
                    <th style="width: 10%;">Role</th> 
                    <th>Role Details</th> 
                    <th>Category</th>    

                </tr> 

                <?php
                if ($biodata->serviceUniversity) {
                    $counter = 0;
                    foreach ($biodata->serviceUniversity as $university) {
                        $counter = $counter + 1;
                        ?> 

                        <tr>
                            <td><?= $counter; ?></td> 
                            <td><?= $university->service ? $university->service : ' '; ?> </td> 
                            <td><?= $university->year ? $university->year : ' '; ?> </td> 
                            <td><?= $university->role_key ? $university->role_key : ' '; ?> </td> 
                            <td><?= $university->role ? $university->role : ' '; ?> </td> 
                            <td><?= $university->lvl ? $university->lvl->output : ' '; ?></td>    
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">No Information</td>  
                    </tr>

                    <?php
                }
                ?>
            </table>
        </div>
    </div>
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">SERVICES COMMUNITY <a href="<?php echo yii\helpers\Url::to(['cv/services-community']); ?>" target="_blank"  class="btn btn-default btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> UPDATE RECORD</a></p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content"> 
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped"> 
                <tr> 
                    <th>No.</th> 
                    <th style="width: 40%;">Service</th>
                    <th style="width: 10%;">Year</th>
                    <th style="width: 10%;">Role</th> 
                    <th>Role Details</th> 
                    <th>Level</th>    

                </tr> 

                <?php
                if ($biodata->serviceCommunity) {
                    $counter1 = 0;
                    foreach ($biodata->serviceCommunity as $community) {
                        $counter1 = $counter1 + 1;
                        ?> 

                        <tr>
                            <td><?= $counter1; ?></td> 
                            <td><?= $community->service ? $community->service : ' '; ?> </td> 
                            <td><?= $community->year ? $community->year : ' '; ?> </td> 
                            <td><?= $university->role_key ? $university->role_key : ' '; ?> </td> 
                            <td><?= $community->role ? $community->role : ' '; ?> </td> 
                            <td><?= $community->lvl ? $community->lvl->output : ' '; ?></td>    
                        </tr>

                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="5" class="text-center">No Information</td>  
                    </tr>

                    <?php
                }
                ?>
            </table>
        </div>
    </div>   

</div>  
