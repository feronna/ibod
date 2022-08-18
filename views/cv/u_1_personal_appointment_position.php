<div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> 

                                    <?php
                                    if ($biodata->allSandangan) {
                                        $bil1 = 1;
                                        ?>
                                        <tr>
                                            <th class="text-center" style="width: 30%;">Position</th> 
                                            <th class="text-center">Appointment Status</th>
                                            <th class="text-center">Appointment Type</th>
                                            <th class="text-center" style="width: 15%;">Start Position</th> 
                                        </tr>
                                        <?php foreach ($biodata->allSandangan as $l) { ?>

                                            <tr>
                                                <td class="text-center"><?= $l->gredJawatan ? $l->gredJawatan->fname : ''; ?></td> 
                                                <td class="text-center"><?= $l->sandangan_id ? $l->statusSandangan->sandangan_name : ''; ?></td>
                                                <td class="text-center"><?= $l->ApmtTypeCd ? $l->jenisLantikan->ApmtTypeNm : ''; ?></td>
                                                <td class="text-center"><?= $l->start_date ? $l->tarikhMulaSandangan : ''; ?></td> 
                                            </tr>

                                            <?php
                                        }
                                    }
                                    ?>
                                </table>
                            </div>