<div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center" rowspan="2">Course Title</th>
                                    <th class="text-center" rowspan="2">Course Code</th>
                                    <th class="text-center" rowspan="2">Semester / Session</th>
                                    <th class="text-center" rowspan="2">No. of Students</th>
                                    <th class="text-center" rowspan="2">No. of Hour Per Semester</th>
                                    <th class="text-center" colspan="2">Co. Teaching</th>
                                </tr>
                                <tr class="headings">
                                    <th class="column-title text-center">Yes</th>
                                    <th class="column-title text-center">No</th>
                                </tr>
                            </thead>
                             <?php
                            if ($model->pengajaran) { $bil1=1;?>
                                <?php foreach ($model->pengajaran as $l) {
                                    if(substr($l->SESI, -9) > $model->sesimulakontrak || (substr($l->SESI, -9) == $model->sesimulakontrak && substr($l->SESI, 1) >= $model->semmulakontrak)){
                                        ?>
                                <tr>
                                    <td class="text-center"><?= $l->NAMAKURSUS; ?></td>
                                    <td class="text-center"><?= $l->SMP07_KodMP; ?></td>
                                    <td class="text-center"><?= $l->SESI; ?></td>
                                    <td class="text-center"><?= $l->BILPELAJAR; ?></td>
                                    <td class="text-center"><?= $l->JAMKREDIT; ?></td>
                                    <td class="text-center"><?php if($l->coteaching->coteaching === 'y') {echo '&#10004;';} ?></td>
                                    <td class="text-center"><?php if($l->coteaching->coteaching === 'n') {echo '&#10004;';} ?></td>
                                </tr>

                                    <?php }} }else { ?>
                                <tr>
                                    <td colspan="7"></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>