<?php if($model->icno == Yii::$app->user->getId()){?>
                    <h2>Current Contract</h2><?php }?>
<div class="table-responsive">
                        <table class="table table-striped table-sm table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center">Student's Name</th>
                                    <th class="text-center">Research Title</th>
                                    <th class="text-center">Supervision Type</th>
                                    <th class="text-center">Mod Level</th>
                                    <th class="text-center">Semester / Session</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                             <?php
                            if ($model->penyeliaanpasca) { $bil1=1;?>
                                <?php foreach ($model->penyeliaanpasca as $l) {?>
                                <tr>
                                    <td class="text-center"><?php echo $l->studentName; ?></td>
                                    <td class="text-center"><?php echo $l->researchTitle; ?></td>
                                    <td class="text-center"><?php echo $l->supervisionType; ?></td>
                                    <td class="text-center"><?php echo $l->ModLevelName; ?></td>
                                    <td class="text-center"><?php echo $l->KodSesi_Sem; ?></td>
                                    <td class="text-center"><?php echo $l->studentStatus; ?></td>
                                </tr>

                            <?php } }else { ?>
                                <tr>
                                    <td colspan="6"></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>