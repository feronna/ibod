<div class="table-responsive">
                        <table class="data table table-striped no-margin">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center">Year</th>
                                    <th class="text-center">Point</th>
                                </tr>
                            </thead> 
                            <?php if ($biodata->jawatan->job_category == 1) { ?>
                                <tr>
                                    <td class="text-center"><?= $biodata->markahlnptCV(1, 'Tahun'); ?></td>
                                    <td class="text-center"><?= $biodata->markahlnptCV(1, 'Markah'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><?= $biodata->markahlnptCV(2, 'Tahun'); ?></td>
                                    <td class="text-center"><?= $biodata->markahlnptCV(2, 'Markah'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><?= $biodata->markahlnptCV(3, 'Tahun'); ?></td>
                                    <td class="text-center"><?= $biodata->markahlnptCV(3, 'Markah'); ?></td>
                                </tr>
                            <?php } else { ?> 
                                <tr>
                                    <td class="text-center"><?= $biodata->markahlnptCVpen(1, 'Tahun'); ?></td>
                                    <td class="text-center"><?= $biodata->markahlnptCVpen(1, 'Markah'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><?= $biodata->markahlnptCVpen(2, 'Tahun'); ?></td>
                                    <td class="text-center"><?= $biodata->markahlnptCVpen(2, 'Markah'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><?= $biodata->markahlnptCVpen(3, 'Tahun'); ?></td>
                                    <td class="text-center"><?= $biodata->markahlnptCVpen(3, 'Markah'); ?></td>
                                </tr>
                            <?php } ?>
                        </table> 
                    </div>