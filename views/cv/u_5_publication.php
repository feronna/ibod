<?php echo $this->render('menu'); ?>  
<?php echo $this->render('main', ['biodata' => $biodata]); ?>   
<br/>
<div class="x_panel">
    <div class="x_title"> 
        <p style="font-size:18px;font-weight: bold;">PUBLICATION <a href="<?php echo yii\helpers\Url::to('https://ppi.ums.edu.my/SMPPPI/Default.aspx'); ?>" target="_blank"  class="btn btn-default btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> UPDATE RECORD</a></p>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">   
        <?php
        $publicationC = $biodata->publicationAll;
        if ($publicationC) {
            ?>  
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped" style="width:100%">  

                    <?php
                    $type = $biodata->PublicationSortAll();
                    foreach ($type as $type) {
                        $typeN = $type->name;
                        ?>  
                        <tr>  
                            <th colspan="7"><?= $typeN; ?> </th>
                        </tr> 
                        <tr>  
                            <th>No.</th> 
                            <th width="42%"><?= $typeN; ?> Detail</th>  
                            <th width="16%">Role</th> 
                            <th width="10%">Year</th>
                            <th width="15%">Status Indeks</th>  
                            <th width="10%">Verified</th>

                        </tr>  
                        <?php
                        $publication = $biodata->publicationAll;
                        $counter = 1;
                        foreach ($publication as $publication) {
                            $check = $publication->Keterangan_PublicationTypeID ? $publication->Keterangan_PublicationTypeID : '';
                            if ($check == $type->name) {
                                ?> 

                                <tr> 
                                    <td><?= $counter; ?></td> 
                                    <td>
                                        <?= $publication->FullAuthorName ? $publication->FullAuthorName . '.' : ''; ?>
                                        <?= $publication->PublicationYear ? $publication->PublicationYear : '.'; ?>
                                        <?= $publication->ProsidingName ? $publication->ProsidingName . '.' : ''; ?>
                                        <?= $publication->Title ? $publication->Title . '.' : ''; ?> 
                                        <?= $publication->Publisher ? $publication->Publisher . '.' : ''; ?> 
                                        <?= $publication->SourceName ? $publication->SourceName . '.' : ''; ?> 
                                        <?= $publication->Volume ? 'Jil. ' . $publication->Volume . '.' : ''; ?> 
                                        <?= $publication->Issue ? $publication->Issue . '.' : ''; ?> 
                                        <?= $publication->PageNumber ? $publication->PageNumber . '.' : ''; ?> 
                                    </td> 
                                    <td><?= $publication->KeteranganBI_WriterStatus ? $publication->KeteranganBI_WriterStatus : ''; ?></td>
                                    <td><?= $publication->PublicationYear ? $publication->PublicationYear : ''; ?></td>
                                    <td><?= $publication->IndexingDesc ? $publication->IndexingDesc : ''; ?></td>
                                    <!--<td><?php// $publication->Keterangan_PublicationStatus ? $publication->Keterangan_PublicationStatus : ''; ?></td>-->
                                    <td><?php
                                        if($publication->ApproveStatus){
                                            if($publication->ApproveStatus == 'V'){
                                                echo 'Yes';
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr> 
                                <?php
                                $counter = $counter + 1;
                            }
                        }
                    }
                    ?>
                </table>
            </div>
            <?php
        } else {
//            echo '<br/> No data - (dbo.vw_LNPT_PublicationV2) /db 10';
        }
        ?>
    </div> 
</div>  
