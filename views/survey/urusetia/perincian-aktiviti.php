<?php

use kartik\detail\DetailView;
use yii\helpers\Html;

?>
<?= Yii::$app->controller->renderPartial('/survey/_menu'); ?>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-info-circle"></i>&nbsp;<strong>Maklumat Akitiviti</strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php

                echo DetailView::widget([
                    'model' => $aktiviti,
                    'attributes' => [
                        'nama:html',    // description attribute in HTML
                        'full_date:html',    // description attribute in HTML
                        [                      // the owner name of the model
                            'attribute' => 'dept_id',
                            'value' => $aktiviti->jfpib->fullname,
                        ],
                        [                      // the owner name of the model
                            'attribute' => 'adminpos_id',
                            'value' => $aktiviti->adminPosition->ref_position_name,
                        ],
                        [                      // the owner name of the model
                            'attribute' => 'program_id',
                            'value' => $aktiviti->programText,
                        ],               // title attribute (in plain text)
                        'catatan:html',    // description attribute in HTML
                        'statusText:html',    // description attribute in HTML
                        'create_dt:datetime', // creation date formatted as datetime
                    ],
                ]);
                ?>
                <div class="pull-left">
                    <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Kembali', ['senarai-aktiviti'], ['class' => 'btn btn-default']) ?>
                    <?= Html::a('<i class="fa fa-pencil"></i>&nbsp;Kemaskini', ['update-aktiviti', 'id' => $aktiviti->id], ['class' => 'btn btn-warning']) ?>
                    <?= Html::a('<i class="fa fa-user"></i>&nbsp;Senarai Calon', ['senarai-calon', 'id' => $aktiviti->id], ['class' => 'btn btn-success']) ?>
                    <?= Html::a('<i class="fa fa-users"></i>&nbsp;Senarai Pengundi', ['senarai-pengundi', 'id' => $aktiviti->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('<i class="fa fa-list"></i>&nbsp;Overview', ['overview', 'id' => $aktiviti->id], ['class' => 'btn btn-dark']) ?>
                </div>
                <div class="pull-right">
                    <?= Html::a('<i class="fa fa-trash"></i>&nbsp;Buang', ['delete-aktiviti', 'id' => $aktiviti->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Anda pasti untuk buang aktiviti ini?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>