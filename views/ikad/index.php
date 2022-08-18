<?php

use yii\helpers\Html;
use app\models\keselamatan\cuti;
use app\widgets\TopMenuWidget;

// as a widget
?>
<?php echo $this->render('/ikad/_menu'); ?>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Application List and Status</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Bil</th>
                                <th class="text-center">Name on Card</th>
                                <th class="text-center">Card Language</th>
                                <th class="text-center">Application Date</th>
                                <!-- <th class="text-center">Submit Date</th> -->
                                <th class="text-center">Application Status</th>
                                <!--<th class="text-center">Status Perakuan Peraku</th>-->
                                <th class="text-center">Status</th>
                                <th class="text-center">Catatan Penyemak</th>
                            </tr>
                        </thead>
                        <?php foreach ($query as $models2) { ?>
                            <tr>

                                <td class="text-center" style="text-align:center"><?= $bil++ ?></td>
                                <td class="text-center" style="text-align:center"><?= $models2->d_nama ?></td>
                                <td class="text-center" style="text-align:center"><?= $models2->cardlang ?></td>
                                <td class="text-center" style="text-align:center"><?= $models2->formattarikh ?></td>
                                <td class="text-center" style="text-align:center"><?= $models2->appstatus ?></td>
                                <?php if ($models2->status_kad == 3) { ?>
                                    <td class="text-center"><?= Html::a('[Preview <i class="fa fa-search">]</i>', ['ikad/send-application', 'id' => $models2->id], ['class' => '']) ?>  
                                    <?= Html::a('[Edit <i class="fa fa-pencil">]</i>', ['ikad/update-app', 'id' => $models2->id], ['class' => '']) ?></td>
                                <?php } else { ?>
                                    <td class="text-center"><?= Html::a('[Preview <i class="fa fa-search">]</i>', ['ikad/preview', 'id' => $models2->id], ['class' => '']) ?> 

                                <?php } ?>
                                <td class="text-center" style="text-align:center"><?= $models2->remark ?></td>

                            </tr>
                        <?php } ?>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>