
<div class="row"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong><i class="fa fa-book"></i> Publication</strong></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <i>[FROM SMP-PPI]</i>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <?php if($model->icno == Yii::$app->user->getId()){?>
                    <h2>Current Contract</h2><?php }?>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center">No</th>
                                    <th class="text-center">Title</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Year of Publication</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                             <?php
                            $no=0;
                            if ($model->journalInternational) {?>
                                <?php foreach ($model->journalInternational as $l) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-center"><?php echo $l->Title; ?></td>
                                    <td class="text-center">Journal International</td>
                                    <td class="text-center"><?php echo $l->PublicationYear; ?></td>
                                    <td class="text-center"><?php echo $l->AuthorType; ?></td>
                                    <td class="text-center"><?php echo $l->Keterangan_PublicationStatus; ?></td>
                                </tr>

                            <?php } }?>
                            <?php
                            if ($model->journalNational) { $no++;?>
                                <?php foreach ($model->journalNational as $l) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-center"><?php echo $l->Title; ?></td>
                                    <td class="text-center">Journal National</td>
                                    <td class="text-center"><?php echo $l->PublicationYear; ?></td>
                                    <td class="text-center"><?php echo $l->AuthorType; ?></td>
                                    <td class="text-center"><?php echo $l->Keterangan_PublicationStatus; ?></td>
                                </tr>

                            <?php } }?>
                            <?php
                            if ($model->book) { $bil1=1;?>
                                <?php foreach ($model->book as $l) { $no++;?>
                                <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td class="text-center"><?= $l->BookTitle; ?></td>
                                    <td class="text-center">Book</td>
                                    <td class="text-center"><?= $l->PublicationYear; ?></td>
                                    <td class="text-center"><?= $l->AuthorType; ?></td>
                                    <td class="text-center"><?= $l->Keterangan_PublicationStatus; ?></td>
                                </tr>

                            <?php } }?>
                            <?php
                            if ($model->bookChapter) { $no++;?>
                                <?php foreach ($model->bookChapter as $l) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-center"><?php echo $l->BookTitle; ?></td>
                                    <td class="text-center">Chapter in Book</td>
                                    <td class="text-center"><?php echo $l->PublicationYear; ?></td>
                                    <td class="text-center"><?php echo $l->AuthorType; ?></td>
                                    <td class="text-center"><?php echo $l->Keterangan_PublicationStatus; ?></td>
                                </tr>

                            <?php } }?>
                        </table>
                    </div>
                    
                </div>
                
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center" rowspan="2"></th>
                                    <th class="text-center" rowspan="2">Scopus</th>
                                    <th class="text-center" rowspan="2">Google Scholar</th>
                                </tr>
                            </thead>
                                <tr class="headings">
                                    <th class="column-title text-center">H-index</th>
                                    <td><?= $model->hindex->scopus_hindex?></td>
                                    <td><?= $model->hindex->googlescholar_hindex?></td>
                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center">Citation</th>
                                    <td><?= $model->hindex->scopus_citation?></td>
                                    <td><?= $model->hindex->googlescholar_citation?></td>
                                </tr>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>

