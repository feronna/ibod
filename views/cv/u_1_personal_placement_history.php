<div class="table-responsive">
                            <table class="table table-sm table-bordered jambo_table table-striped">

                                <tr>
                                    <th style="width: 10%;">Date</th>
                                    <th style="width: 10%;">Date Updated</th>
                                    <th>JFPIU</th>
                                    <th>Campus</th>
                                    <th>Remark</th> 
                                </tr>

                                <?php
                                $penempatan = $biodata->allPenempatan;

                                if ($penempatan) {
                                    foreach ($penempatan as $penempatan) {
                                        ?>

                                        <tr>
                                            <td><?= $penempatan->tarikhMula ? $penempatan->tarikhMula : '' ?></td>
                                            <td><?= $penempatan->tarikhKemaskini ? $penempatan->tarikhKemaskini : '' ?></td>
                                            <td><?= $penempatan->department ? $penempatan->department->fullname : '' ?></td>
                                            <td><?= $penempatan->kampus ? $penempatan->kampus->campus_name : '' ?></td>
                                            <td><?= $penempatan->remark ? $penempatan->remark : '' ?></td> 

                                        </tr>

                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Tiada Rekod</td>                     
                                    </tr>
                                <?php }
                                ?>
                            </table>
                        </div>