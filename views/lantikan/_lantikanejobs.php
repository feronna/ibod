<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;

error_reporting(0);


$this->title = 'Rekod';
?>
<div class="tblprcobiodata-form" >

    <?php
    $form = ActiveForm::begin([
                'action' => ['lantikan-ejobs'],
                'method' => 'get',
                'options' => ['class' => 'form-horizontal form-label-left']
    ]);
    ?>

    <div class="x_panel" >
        <div class="x_title">
            <h2>Carian</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group ">
                <div class="form-group">
                    <div class=" col-md-5 col-sm-5 col-xs-12">
                        <?= $form->field($searchModel, 'nama')->textInput(['placeholder' => 'Nama'])->label(false);
                        ?>
                    </div> 
                    <div class="col-md-4 col-sm-4 col-xs-3">
                        <?=
                        $form->field($searchModel, 'jawatan_id')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\GredJawatan::find()->all(), 'id', 'fname'),
                            'options' => ['placeholder' => 'Pilih Jawatan'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);
                        ?>
                    </div>
                    <div class=" col-md-2 col-sm-2 col-xs-12">
                        <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> Cari', ['class' => 'btn btn-primary']) ?> 
                    </div> 
                </div>  
            </div>           
        </div>
    </div>
<?php ActiveForm::end(); ?>


    <div class="x_panel">
        <div class="x_title" style="color:#37393b;">
            <h2><?= Html::encode($this->title) ?></h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <div class="tblprcobiodata-index">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <thead>
                            <tr class="headings">
                                <th style="width: 800px">Nama Kakitangan</th>
                                <th style="width: 800px">No KP / Paspot</th>  
                                <th style="width: 800px">Jawatan Di Mohon</th>
                                <th class="text-center" style="width:auto">Tindakan</th>   
                            </tr>
                        </thead>   
                        <!--A-->

                        <?php
                        if (!empty($dataProvider)) {

                            foreach ($dataProvider->getModels() as $data) {
                                ?>
                                <tr>
                                    <td><?= strtoupper($data->biodataOrgAwam->CONm) ?></td> 
                                    <td><?= $data->biodataOrgAwam->ICNO ?></td>  
                                    <td><?= strtoupper($data->iklan->jawatan->fname) ?></td> 
                                    <td class="text-center"><?= Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['lantik-staf-baru-ejobs', 'icno' => $data->ICNO]) ?></td>  
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr class="text-center">
                                <td colspan="9">No Data Found.</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <?php
            echo LinkPager::widget([
                'pagination' => $dataProvider->pagination,
            ]);
            ?>
        </div>
    </div>

</div>
