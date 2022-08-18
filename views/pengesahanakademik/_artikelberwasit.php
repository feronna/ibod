<div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center">Bil.</th>
                                    <th class="text-center">Jenis Penulis</th>      
                                    <th class="text-center">Nama Penulis</th>                                   
                                    <th class="text-center">Tajuk Artikel</th>
                                    <th class="text-center">Jenis</th>
                                    <th class="text-center">Nama Jurnal & Tahun</th>
                                    <th class="text-center" style="width:8%">Bil. Jilid</th>
                                    <th class="text-center" style="width:8%">Bil. Muka Surat</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                             <?php
                            $no=0;
                            if ($model->journalInternational) {?>
                                <?php foreach ($model->journalInternational as $l) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-center"><?php echo $l->AuthorStatus; ?></td>
                                    <td class="text-center"><?php echo $l->FullAuthorName; ?></td>
                                    <td class="text-center"><?php echo $l->Title; ?></td>
                                    <td class="text-center">Journal International</td>
                                    <td class="text-center"><?php echo $l->JournalName; ?>(<?php echo $l->PublicationYear; ?>)</td>
                                    <td class="text-center">Vol. <?php echo $l->Volume; ?>, Issue <?php echo $l->Isu; ?></td>
                                    <td class="text-center"><?php echo $l->PageNumber; ?></td>
                                    <td class="text-center"><?php echo $l->Keterangan_PublicationStatus; ?></td>
                                </tr>
                            <?php } }?>
                                
                            <?php
                            if ($model->journalNational) { ?>
                                <?php foreach ($model->journalNational as $l) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
                                    <td class="text-center"><?php echo $l->AuthorStatus; ?></td>
                                    <td class="text-center"><?php echo $l->FullAuthorName; ?></td>
                                    <td class="text-center"><?php echo $l->Title; ?></td>
                                    <td class="text-center">Journal National</td>
                                    <td class="text-center"><?php echo $l->JournalName; ?>(<?php echo $l->PublicationYear; ?>)</td>
                                    <td class="text-center">Vol. <?php echo $l->Volume; ?>, Issue <?php echo $l->Isu; ?></td>
                                    <td class="text-center"><?php echo $l->PageNumber; ?></td>
                                    <td class="text-center"><?php echo $l->Keterangan_PublicationStatus; ?></td>
                                </tr>
                            <?php } }?>
                        </table>
                    </div>

 