<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$url1 = Url::to(['senarai-layak']);
$js = <<<js
    $('.hantar').on('click',function (){

        var keys = $('#grid').yiiGridView('getSelectedRows');
        $.post("$url1",
        {'keylist': keys},
        function(data){

        });

    });

js;
$this->registerJs($js);
?>
<style>
    fieldset.scheduler-border {
        border: 1px groove #1F9935 !important;
        padding: 0 1.4em 1.4em 1.4em !important;
        margin: 0 0 1.5em 0 !important;
        -webkit-box-shadow: 0px 0px 0px 0px #000;
        box-shadow: 0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
        width: inherit;
        /* Or auto */
        padding: 0 10px;
        /* To give a bit of padding on the left and right */
        border-bottom: none;
    }

    .table td,
    .table th {
        font-size: 12px;
    }
</style>
<?= $this->render('_inquiry') ?>
<?php echo $this->render('a_menu_admin') ?>
<div class="tblmaxtuntutan-search">
    <div class="x_panel">
        <div class="x_content">
            <p>
                <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
            </p>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" align="right">

            <?= Html::a('<i class="fa fa-bullhorn" aria-hidden="true"></i> NOTIFIKASI STAF', ['notifistaf'], ['class' => 'btn btn-primary btn-md'])
            ?>


        </div>
        <div class="x_title">
            <h2><i class="fa fa-users"></i><strong> Senarai Kakitangan Layak Menghadiri Program Transformasi Minda (PTM) </strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <?= Html::a('<div style="float: right; font-size:18px;"><i class="text-success fa fa-download"></i> Eksport Ke MS Excel</div>', ['senarai']) ?>
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $query,
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                        ],
                        [
                            'label' => 'Nama Kakitangan',
                            'attribute' => 'CONm',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'No.KP Kakitangan',
                            'attribute' => 'ICNO',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'UMSPER',
                            'attribute' => 'COOldID',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Gred & Jawatan',
                            'attribute' => 'jawatan.fname',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Tarikh Lantikan',
                            'attribute' => 'startDateLantik',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Lantikan',
                            'value' => 'statusLantikan.ApmtStatusNm',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Status',
                            'value' => 'serviceStatus.ServStatusNm',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'Kategori',
                            'value' => 'jawatan.longCat',
                            'format' => 'text',
                        ],
                        [
                            'label' => 'JAFPIB',
                            'value' => 'department.fullname',
                            'format' => 'text',
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '<span class="glyphicon glyphicon-info-sign"></span>',

                            'template' => '{admin-views}',
                            'buttons' => [
                                'admin-views' => function ($url, $query) {
                                    $url = Url::to(['ptm/admin-views', 'id' => $query->ICNO]);
                                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                                }
                            ]
                        ],
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'checkboxOptions' => function ($model) {
                                return ['value' => $model->COEmail];
                            }

                        ],
                    ]
                ]);
                ?>
                <div class="ln_solid"></div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-6">
                <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                    <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Hantar', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                </div>
                <br>
                <br>
                <br>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>