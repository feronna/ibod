<div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center">Bil.</th>
<!--                                    <th class="text-center">Jenis Penulis</th> -->
                                    <th class="text-center">Nama Penulis</th>                                   
                                    <th class="text-center">Tajuk Artikel</th>
                                    <th class="text-center">Jenis</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Tahun Diterbitkan</th>
                                    <th class="text-center" style="width:8%">Bil. Jilid</th>
                                    <th class="text-center" style="width:8%">Bil. Muka Surat</th>
                                </tr>
                            </thead> 
                             <?php
                             $no=0;
                            if ($model->abstrak) { ?>
                                <?php foreach ($model->abstrak as $l) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
<!--                                    <td class="text-center"><?php echo $l->AuthorStatus; ?></td>-->
                                    <td class="text-center"><?php echo $l->FullAuthorName; ?></td>
                                    <td class="text-center"><?php echo $l->PaperTitle; ?></td>
                                    <td class="text-center">Abstrak</td>
                                    <td class="text-center"><?php echo $l->ProsidingName; ?> (<?php echo $l->ProsidingName; ?>)</td>
                                     <td class="text-center"><?php echo $l->ProsidingName; ?></td>
                                    <td class="text-center">Vol. <?php echo $l->Volume; ?>, Issue <?php echo $l->Isu; ?></td>
                                    <td class="text-center"><?php echo $l->PageNumber; ?></td>
                                </tr>
                            <?php } }?>
                            <?php 
                            if ($model->anthology) { ?>
                                <?php foreach ($model->anthology as $l) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
<!--                                    <td class="text-center"><?php echo $l->AuthorStatus; ?></td>-->
                                    <td class="text-center"><?php echo $l->FullAuthorName; ?></td>
                                    <td class="text-center"><?php echo $l->Title; ?></td>
                                    <td class="text-center">Antologi</td>
                                     <td class="text-center"></td>
                                    <td class="text-center"><?php echo $l->PublicationYear; ?></td>
                                    <td class="text-center">Vol. <?php echo $l->Volume; ?>, Issue <?php echo $l->Isu; ?></td>
                                    <td class="text-center"><?php echo $l->PageNumber; ?></td>
<!--                                    <td class="text-center"><?php echo $l->Keterangan_PublicationStatus; ?></td>-->
                                </tr>
                            <?php } }?>
                            <?php
                            if ($model->creative) { ?>
                                <?php foreach ($model->creative as $l) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
<!--                                    <td class="text-center"><?php echo $l->AuthorStatus; ?></td>-->
                                    <td class="text-center"><?php echo $l->FullAuthorName; ?></td>
                                    <td class="text-center"><?php echo $l->Title; ?></td>
                                    <td class="text-center">Kreatif</td>
                                     <td class="text-center"></td>
                                    <td class="text-center"><?php echo $l->PublicationYear; ?></td>
                                    <td class="text-center">Vol. <?php echo $l->Volume; ?>, Issue <?php echo $l->Isu; ?></td>
                                    <td class="text-center"><?php echo $l->PageNumber; ?></td>
<!--                                    <td class="text-center"><?php echo $l->Keterangan_PublicationStatus; ?></td>-->
                                </tr>
                            <?php } }?>
                            <?php
                            if ($model->magazine) { ?>
                                <?php foreach ($model->magazine as $l) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
<!--                                    <td class="text-center"><?php echo $l->AuthorStatus; ?></td>-->
                                    <td class="text-center"><?php echo $l->FullAuthorName; ?></td>
                                    <td class="text-center"><?php echo $l->Title; ?></td>
                                    <td class="text-center">Majalah</td>
                                     <td class="text-center"></td>
                                    <td class="text-center"><?php echo $l->PublicationYear; ?></td>
                                    <td class="text-center">Vol. <?php echo $l->Volume; ?>, Issue <?php echo $l->Issue; ?></td>
                                    <td class="text-center"><?php echo $l->PageNumber; ?></td>
<!--                                    <td class="text-center"><?php echo $l->Keterangan_PublicationStatus; ?></td>-->
                                </tr>
                            <?php } }?>
                            <?php
                            if ($model->manual) { ?>
                                <?php foreach ($model->manual as $l) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
<!--                                    <td class="text-center"><?php echo $l->AuthorStatus; ?></td>-->
                                    <td class="text-center"><?php echo $l->FullAuthorName; ?></td>
                                    <td class="text-center"><?php echo $l->Title; ?></td>
                                    <td class="text-center">Manual</td>
                                     <td class="text-center"></td>
                                    <td class="text-center"><?php echo $l->PublicationYear; ?></td>
                                    <td class="text-center">Vol. <?php echo $l->Volume; ?>, Issue <?php echo $l->Issue; ?></td>
                                    <td class="text-center"><?php echo $l->PageNumber; ?></td>
<!--                                    <td class="text-center"><?php echo $l->Keterangan_PublicationStatus; ?></td>-->
                                </tr>
                            <?php } }?>
                            <?php
                            if ($model->module) { ?>
                                <?php foreach ($model->module as $l) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
<!--                                    <td class="text-center"><?php echo $l->AuthorStatus; ?></td>-->
                                    <td class="text-center"><?php echo $l->FullAuthorName; ?></td>
                                    <td class="text-center"><?php echo $l->BookTitle; ?></td>
                                    <td class="text-center">Module</td>
                                     <td class="text-center"></td>
                                    <td class="text-center"><?php echo $l->PublicationYear; ?></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
<!--                                    <td class="text-center"><?php echo $l->Keterangan_PublicationStatus; ?></td>-->
                                </tr>
                            <?php } }?>
                            <?php
                            if ($model->preUni) { ?>
                                <?php foreach ($model->preUni as $l) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
<!--                                    <td class="text-center"><?php echo $l->AuthorStatus; ?></td>-->
                                    <td class="text-center"><?php echo $l->FullAuthorName; ?></td>
                                    <td class="text-center"><?php echo $l->BookTitle; ?></td>
                                    <td class="text-center">Pra Uni</td>
                                     <td class="text-center"></td>
                                    <td class="text-center"><?php echo $l->PublicationYear; ?></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
<!--                                    <td class="text-center"><?php echo $l->Keterangan_PublicationStatus; ?></td>-->
                                </tr>
                            <?php } }?>
                            <?php
                             
                            if ($model->technical) { ?>
                                <?php foreach ($model->technical as $l) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
<!--                                    <td class="text-center"><?php echo $l->AuthorStatus; ?></td>-->
                                    <td class="text-center"><?php echo $l->FullAuthorName; ?></td>
                                    <td class="text-center"><?php echo $l->Title; ?></td>
                                    <td class="text-center">Teknikal</td>
                                     <td class="text-center"></td>
                                    <td class="text-center"><?php echo $l->PublicationYear; ?></td>
                                    <td class="text-center">Vol. <?php echo $l->Volume; ?>, Issue <?php echo $l->Issue; ?></td>
                                    <td class="text-center"><?php echo $l->PageNumber; ?></td>
<!--                                    <td class="text-center"><?php echo $l->Keterangan_PublicationStatus; ?></td>-->
                                </tr>
                            <?php } }?>
                            <?php 
                            if ($model->textBook) { ?>
                                <?php foreach ($model->textBook as $l) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
<!--                                    <td class="text-center"><?php echo $l->AuthorStatus; ?></td>-->
                                    <td class="text-center"><?php echo $l->FullAuthorName; ?></td>
                                    <td class="text-center"><?php echo $l->BookTitle; ?></td>
                                    <td class="text-center">Buku Teks</td>
                                     <td class="text-center"></td>
                                    <td class="text-center"><?php echo $l->PublicationYear; ?></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
<!--                                    <td class="text-center"><?php echo $l->Keterangan_PublicationStatus; ?></td>-->
                                </tr>
                            <?php } }?>
                            <?php
                            if ($model->translation) { ?>
                                <?php foreach ($model->translation as $l) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
<!--                                    <td class="text-center"><?php echo $l->AuthorStatus; ?></td>-->
                                    <td class="text-center"><?php echo $l->FullAuthorName; ?></td>
                                    <td class="text-center"><?php echo $l->Title; ?></td>
                                    <td class="text-center">Terjemahan</td>
                                     <td class="text-center"></td>
                                    <td class="text-center"><?php echo $l->PublicationYear; ?></td>
                                    <td class="text-center">Vol. <?php echo $l->Volume; ?>, Issue <?php echo $l->Isu; ?></td>
                                    <td class="text-center"><?php echo $l->PageNumber; ?></td>
<!--                                    <td class="text-center"><?php echo $l->Keterangan_PublicationStatus; ?></td>-->
                                </tr>
                            <?php } }?>
                            <?php
                            if ($model->book) { ?>
                                <?php foreach ($model->book as $l) { $no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
<!--                                    <td class="text-center"><?php echo $l->AuthorStatus; ?></td>-->
                                    <td class="text-center"><?php echo $l->FullAuthorName; ?></td>
                                    <td class="text-center"><?php echo $l->BookTitle; ?></td>
                                    <td class="text-center">Buku</td>
                                    <td class="text-center"></td>
                                    <td class="text-center"><?php echo $l->PublicationYear; ?></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
<!--                                    <td class="text-center"><?php echo $l->Keterangan_PublicationStatus; ?></td>-->
                                </tr>

                            <?php } }?>
                            <?php
                            if ($model->bookChapter) { ?>
                                <?php foreach ($model->bookChapter as $l) {$no++;?>
                                <tr>
                                    <td class="text-center"><?php echo $no; ?></td>
<!--                                    <td class="text-center"><?php echo $l->AuthorStatus; ?></td>-->
                                    <td class="text-center"><?php echo $l->FullAuthorName; ?></td>
                                    <td class="text-center"><?php echo $l->BookTitle; ?></td>
                                    <td class="text-center">Bab Dalam Buku</td>
                                     <td class="text-center"></td>
                                    <td class="text-center"><?php echo $l->PublicationYear; ?></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
<!--                                    <td class="text-center"><?php echo $l->Keterangan_PublicationStatus; ?></td>-->
                                </tr>
                            <?php } }?>
                        </table>
                    </div>