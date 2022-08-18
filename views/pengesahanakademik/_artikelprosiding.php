<div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center">Bil.</th>
<!--                                    <th class=text-center">Jenis Penulis</th>-->
                                    <th class="text-center">Nama Penulis</th>                                   
                                    <th class="text-center">Tajuk Artikel</th>
                                    <th class="text-center">Jenis</th>
                                    <th class="text-center">Nama Prosiding & Tahun Diterbitkan</th>  
                                    <th class="text-center">Bil. Muka Surat</th>
                                </tr>
                            </thead>
                             <?php
                            $no=0;
                            if ($model->proceedingInternational) {?>
                                <?php foreach ($model->proceedingInternational as $l) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
<!--                                    <td class="text-center"><?php echo $l->AuthorStatus; ?></td>-->
                                    <td class="text-center"><?php echo $l->FullAuthorName; ?></td>
                                    <td class="text-center"><?php echo $l->PaperTitle; ?></td>
                                    <td class="text-center">Proceeding International</td>
                                    <td class="text-center"><?php echo $l->ProsidingName; ?> (<?php echo $l->PublicationYear; ?>)</td>
                                    <td class="text-center"><?php echo $l->PageNumber; ?></td>
                                </tr>
                            <?php } }?>
                                
                            <?php
                            if ($model->proceedingNational) { ?>
                                <?php foreach ($model->proceedingNational as $l) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
<!--                                    <td class="text-center"><?php echo $l->AuthorStatus; ?></td>-->
                                    <td class="text-center"><?php echo $l->FullAuthorName; ?></td>
                                    <td class="text-center"><?php echo $l->PaperTitle; ?></td>
                                    <td class="text-center">Proceeding National</td>
                                    <td class="text-center"><?php echo $l->ProsidingName; ?></td>
                                </tr>
                            <?php } }?>
                        </table>
                    </div>