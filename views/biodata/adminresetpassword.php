<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;


$this->title = 'Hasil Carian';
?>

<?php
Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">...</h4>',
]);

Modal::end();

?>


<div class="col-md-12 col-sm-12 col-xs-12 ">
    
</br>
    <?php $form = ActiveForm::begin([
        'action' => ['admin-carian-staf'],
        'method' => 'get',
        'options' => ['class' => 'form-horizontal form-label-left']
    ]); ?>
    <div class="x_panel">
        <div class="x_title">
            <h2><?= "Ruang Carian" ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group ">
                <div class="form-group">
                    <div class=" col-md-2 col-sm-2 col-xs-12">
                        <?=
                            $form->field($carian, 'jenis_carian')->label(false)->widget(Select2::classname(), [
                                'data' => ["0" => "IC", "1" => "Nama"],
                                'options' => ['placeholder' => 'Jenis Carian', 'class' => 'form-control col-md-2 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                        ?>
                    </div>
                    <div class=" col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($carian, 'carian_data')->textInput(['placeholder' => 'Nama / Nombor IC'])->label(false) ?>
                    </div>
                    <div class=" col-md-2 col-sm-2 col-xs-12">
                        <?= Html::submitButton('<i class="fa fa-search"></i> Cari', ['class' => 'btn btn-primary']) ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>
            <h5 class="pull-right"><?= Html::encode('Jumlah Carian: ') . $model->getCount() . " / " . $model->getTotalCount() ?></h5>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <div class="tblprcobiodata-index">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <thead>
                            <tr class="headings">
                                <th style="width: 200px">No KP / Paspot</th>
                                <th style="width: 250px">UMSPER</th>
                                <th style="width: 800px">Nama Kakitangan</th>
                                <th style="width: 800px">Jabatan</th>
                                <th class="text-center" style="width:auto">Tindakan</th>
                            </tr>
                        </thead>
                        <!--A-->

                        <?php
                        if (!empty($model->getModels())) {

                            foreach ($model->getModels() as $data) {

                        ?>
                                <tr>
                                    <td><?= $data->ICNO ?></td>
                                    <td><?= $data->COOldID ?></td>
                                    <td><?= $data->CONm ?></td>
                                    <td><?= $data->displayDepartment ?></td>
                                    <td class="text-center"><?= Html::a('<button style="color:Green">Papar Rekod</button>', ['view-a-r-p', 'id' => $data->ICNO], [
                                                                'data-toggle' => "modal",
                                                                'data-target' => "#myModal",
                                                                'data-title' => "RESET PASSWORD (Staff Info)",
                                                            ]) ?></td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr class="text-center">
                                <td colspan="9">No Data.</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <?php
            echo LinkPager::widget([
                'pagination' => $model->pagination,
            ]);
            ?>
        </div>
    </div>

    <?php
    $this->registerJs("
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title') 
        var href = button.attr('href') 
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        })
");

    ?>

</div>