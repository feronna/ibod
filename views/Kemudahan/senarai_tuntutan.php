<?php

use yii\helpers\Html;

?>
<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86], 'vars' => []]); ?>
        
<!--list permohonanan yang telah dibuka-->
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> Permohonan Online</strong></h2>

                <div class="clearfix"></div>
            </div>
        <div class="x_content">
           <div class="table-responsive">
               <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center;">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL </th>
                        <th class="column-title text-center">KOD AKAUN</th>
                        <th class="column-title text-center">JENIS KEMUDAHAN</th>
                         <th class="column-title text-center">BUDGET</th>
                       
                        <th class="text-center">TINDAKAN</th>   
                    </tr>
                </thead>
               <?php if ($model) { ?>
                    <?php foreach ($model as $list) { ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                            <td class="text-justify"><?php echo $list->displayakaun->kodAkaun; ?></td>
                            <td class="text-justify"><?php echo $list->displayjenis->kemudahan; ?></td>
                            <td class="text-center"><?php echo $list->amount; ?></td>
                            <td class="text-center"> <?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ["kemudahan/view", 'id' => $list->id]) ?> | <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ["kemudahan/update", 'id' => $list->id]) ?> | <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $list->id], [
                         'data' => [
                                   'confirm' => 'Are you sure to delete this item?',
                                   'method' => 'post',
                                       ],
                                    ]) ?>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td class="text-center" colspan="5"><i>Permohonan Kemudahan Belum Didaftarkan.</i></td>
                            </tr>
                        <?php } ?>
            
            </table>
           </div>
           </div>
        </div>
    </div>
</div>
    
    

