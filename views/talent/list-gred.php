<?php

use yii\helpers\Html;
?>

<?php echo $this->render('_menu'); ?>

<div class="row">

    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-search"></i> Senarai Gred</strong></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center">Bil</th>
                                    <th class="text-center">Gred</th>
                                    <th class="text-center">Susunan</th>
                                    <th class="text-center">Kemaskini ?</th>
                                    <th class="text-center">Buang ?</th>
                                </tr>
                            </thead>
                            <?php foreach ($model as $mdl) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center"><?= $bil++; ?></td>
                                    <td><?= $mdl->gred; ?></td>
                                    <td class="text-center" style="text-align:center"><?= $mdl->sort_no; ?></td>
                                    <td class="text-center" style="text-align:center"><?= Html::a('<i class="fa fa-pencil"></i>', ['talent/update-jwtn', 'id' => $mdl->id], ['class' => 'btn btn-default btn-sm', 'target' => '_blank']); ?></td>
                                    <td class="text-center" style="text-align:center"><?= Html::a(
                                                                                            '<i class="fa fa-trash"></i>',
                                                                                            ['talent/delete-gred', 'id' => $mdl->id],
                                                                                            ['class' => 'btn btn-danger btn-sm', 'data' => [
                                                                                                'confirm' => 'Are you sure you want to delete this item?',
                                                                                                'method' => 'post',
                                                                                            ],]
                                                                                        ); ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>