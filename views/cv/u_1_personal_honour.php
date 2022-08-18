<div class="table-responsive">
                                <table class="table table-sm table-bordered jambo_table table-striped"> 

                                    <?php
                                    if ($biodata->anugerah) {
                                        $bil1 = 1;
                                        ?>
                                        <tr>
                                            <th class="text-center">Award</th>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">From</th>
                                            <th class="text-center" style="width: 10%;">Date</th>
                                            <th class="text-center">Category</th>
                                        </tr>
                                        <?php foreach ($biodata->anugerah as $l) { ?>

                                            <tr>
                                                <td class="text-center"><?= $l->namaAnugerah ? $l->namaAnugerah->Awd : ''; ?></td>
                                                <td class="text-center"><?= $l->gelaran ? $l->gelaran->Title : ''; ?></td>                            
                                                <td class="text-center"><?= $l->dianugerahkanOleh ? $l->dianugerahkanOleh->CfdBy : ''; ?></td>
                                                <td class="text-center"><?= $l->AwdCfdDt ? $l->AwdCfdDt : ''; ?></td>
                                                <td class="text-center"><?= $l->kategoriAnugerah ? $l->kategoriAnugerah->AwdCat : ''; ?></td>
                                            </tr>

                                            <?php
                                        }
                                    }
                                    ?>
                                </table>
                            </div>