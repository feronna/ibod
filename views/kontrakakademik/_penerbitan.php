
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
                    <h2 style="color:green">Filter by 'Year of Publication' Based on Current Contract {<?= $model->startdatelantik?> - <?= $model->enddatelantik?>}</h2><?php }?>
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
                            if ($model->penerbitan) {$no=0;?>
                                <?php foreach ($model->penerbitan as $m) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-center"><?= ($m->FullAuthorName ? $m->FullAuthorName . '.' : '') . 
                                        ($m->PublicationYear ? $m->PublicationYear : '.') .
                                        ($m->ProsidingName ? $m->ProsidingName . '.' : '') .
                                        ($m->Title ? $m->Title . '.' : '') .
                                        ($m->Publisher ? $m->Publisher . '.' : '') .
                                        ($m->SourceName ? $m->SourceName . '.' : '') .
                                        ($m->Volume ? 'Jil. ' . $m->Volume . '.' : '') .
                                        ($m->Issue ? $m->Issue . '.' : '') .
                                        ($m->PageNumber ? $m->PageNumber . '.' : ''); ?></td>
                                    <td class="text-center"><?= $m->Keterangan_PublicationTypeID?></td>
                                    <td class="text-center"><?= $m->PublicationYear; ?></td>
                                    <td class="text-center"><?= $m->KeteranganBI_WriterStatus; ?></td>
                                    <td class="text-center"><?= $m->Keterangan_PublicationStatus; ?></td>
                                </tr>

                            <?php } }?>
                        </table>
                    </div>
                    
                </div>
                
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center" rowspan="2"></th>
                                    <th class="text-center" rowspan="2">Scopus</th>
                                    <th class="text-center" rowspan="2">Google Scholar</th>
                                </tr>
                            </thead>
                                <tr class="headings">
                                    <th class="column-title text-center">H-index</th>
                                    <td><?= $model->kakitangan->scopus->h_index?></td>
                                    <td><?= $model->kakitangan->googleScholar->h_index?></td>
                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center">Citation</th>
                                    <td><?= $model->kakitangan->scopus->Citations?></td>
                                    <td><?= $model->kakitangan->googleScholar->Citations?></td>
                                </tr>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>

