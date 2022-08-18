<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\popover\PopoverX;
use app\models\hronline\jenis_vaksin;
use kartik\datetime\DateTimePicker;


$js = '
$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
    
    var datePickers = $(this).find("[data-krajee-kvdatepicker]");
        datePickers.each(function(index, el) {
//            $(this).parent().removeData().kvDatepicker("initDPRemove");
            $(this).parent().kvDatepicker(eval($(this).attr("data-krajee-kvdatepicker")));
        });
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});

$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Adakah anda ingin menghapus rekod ini?")) {
        return false;
    }
    return true;
});

' .


    <<<js
    $(document).ready(function(){

        
        ////////sebab belum vaksin/////////////////
        var val1 = $("#status_vaksin").val();
        switch(parseInt(val1)) {
            case 0:
                $(".sebab_belum_terima").show();
                $(".sudah_terima").hide();
                break;
            default:
                $(".sebab_belum_terima").hide();
                $(".sudah_terima").show();
                $("#sbt").val(0);
                $(".lsbt").hide();
                break;
        }
        $('#status_vaksin').on('select2:close', function(e) {
            var val1 = $('#status_vaksin').val();
            switch(parseInt(val1)) {
                case 0:
                    $(".sebab_belum_terima").show();
                    $(".sudah_terima").hide();
                    break;
                default:
                    $(".sebab_belum_terima").hide();
                    $(".sudah_terima").show();
                    $("#sbt").val(0);
                    $(".lsbt").hide();
                    break;
            }
            $('#status_vaksin').val(val1);
        }); 

        ////////lampiran sebab belum vaksin/////////////////
        var val1 = $("#sbt").val();
        switch(parseInt(val1)) {
            case 1:
            case 2:
                $(".lsbt").show();
                break;
            default:
                $(".lsbt").hide();
                break;
        }

        $('#sbt').on('select2:close', function(e) {
            var val1 = $('#sbt').val();
            switch(parseInt(val1)) {
                case 1:
                case 2:
                    $(".lsbt").show();
                    break;
                default:
                    $(".lsbt").hide();
                    break;
            }
            $('#sbt').val(val1);
        }); 



    });
js;

$this->registerJs($js);
error_reporting(0);
?>
<?php
$dos = [
    '0' => 'PERTAMA',
    '1' => 'KEDUA'
];
?>
<?php
$content =  Html::img('@web/uploads/hronline/vaksinasi/SijilDigitalVaksinasi.jpeg', ['class' => 'pull-left img-responsive']);

?>
<?php $this->title = 'Borang Online'; ?>

<?php $form = ActiveForm::begin(['options' => ['enableAjaxValidation' => true, 'class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>


<div class="col-md-12 col-xs-12">



    <div class="row">

        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-user"></i>MAKLUMAT VAKSINASI</strong></h2>
                <ul class="nav navbar-right panel_toolbox">

                    <div class="clearfix"></div>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="form-group sudah_terima">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">MUATNAIK SIJIL VAKSINASI: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-10">
                        <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                        <?php
                        if ($modelsvaksin->isNewRecord ? $msg = 'Sila Muatnaik Sijil Digital Vaksinasi Anda.' : ($modelsvaksin->sijil_digital ? $msg =  Yii::$app->FileManager->NameFile($modelsvaksin->sijil_digital) : $msg = 'Sila Muatnaik Sijil Digital Vaksinasi Anda.'));
                        echo $form->field($modelsvaksin, 'file')->fileInput()->label($msg); ?>
                    </div>
                    <div class="jtooltip"><i class="fa fa-info-circle fa-md"></i>
                        <text>Open apps MySejahtera -> Profile -> scroll to very bottom</text>
                    </div>
                    <?=
                    PopoverX::widget([
                        'header' => 'ID dalam applikasi MySejahtera',
                        'size' => PopoverX::SIZE_X_SMALL,
                        'placement' => PopoverX::ALIGN_BOTTOM_LEFT,
                        'content' => $content,
                        'toggleButton' => ['label' => 'Rujukan', 'class' => 'btn btn-default'],
                    ]);
                    ?></br>
                </div>
                <div class="form-group ">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">CATATAN: <span class="required" style="color:red;"></span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">

                        <?= $form->field($modelsvaksin, 'catatan')->textArea(['maxlength' => true, 'rows' => '6'], ['class' => 'form-control col-md-7 col-xs-12',])->label(false) ?>

                    </div>
                </div>

                <div class="customer-form">
                    <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items', // required: css class selector
                        'widgetItem' => '.item', // required: css class
                        'limit' => 2, // the maximum times, an element can be added (default 999)
                        'min' => 1, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $modelsdos[0],
                        'formId' => 'dynamic-form',
                        'formFields' => [
                            'full_name',
                            'address_line1',
                            'address_line2',
                            'city',
                            'state',
                            'postal_code',
                        ],
                    ]); ?>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>
                                <i class="fa ">TAMBAH MAKLUMAT VAKSIN</i> 
                                <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i>Tambah </button>
                                <?php // Html::a('<i class="glyphicon glyphicon-plus"></i> <span class="btn-label">Tambah</span>', ['borangehsan/form-family',  'id' => $model->id ], ['class' => 'btn btn-success btn-sm pull-right']) 
                                ?>
                            </h4>
                        </div>
                        <div class="panel-body">
                            <div class="container-items">
                                <!-- widgetBody -->
                                <?php foreach ($modelsdos as $i => $modelsdos) : ?>
                                    <div class="item panel panel-default">
                                        <!-- widgetItem -->
                                        <div class="panel-heading">
                                            <div class="pull-right">
                                                <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="panel-body">
                                            <?php
                                            // necessary for update action.
                                            if (!$modelsdos->isNewRecord) {
                                                echo Html::activeHiddenInput($modelsdos, "[{$i}]id");
                                            }
                                            ?>

                                            <table class="table table-sm table-bordered">
                                                <thead>
                                                    <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;">
                                                        <center>MAKLUMAT DOS</center>
                                                    </th>
                                                    <tr>
                                                        <td valign="2">BIL. DOS: <span class="required" style="color:red;">*</span></td>
                                                        <td colspan="2">
                                                            <?= $dos[$i] ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="2">JENIS VAKSIN:<span class="required" style="color:red;">*</span></td>
                                                        <td colspan="2">
                                                            <?= $form->field($modelsdos,  "[{$i}]jenis_vaksin")->label(false)->widget(Select2::classname(), [
                                                                'data' => ArrayHelper::map(jenis_vaksin::find()->all(), 'id', 'nama_vaksin'),
                                                                'options' => ['placeholder' => 'Pilih jenis vaksin'],
                                                                'pluginOptions' => [
                                                                    'allowClear' => true
                                                                ],
                                                            ]); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="2">TARIKH VAKSIN:<span class="required" style="color:red;">*</span></td>
                                                        <td colspan="2">
                                                            <?=
                                                            DateTimePicker::widget([
                                                                'model' => $modelsdos,
                                                                'attribute' => "[{$i}]tarikh_vaksin",
                                                                'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                                                                'options' => ['required' => true],
                                                                'pluginOptions' => [
                                                                    'autoclose' => true,
                                                                    'format' => 'yyyy-mm-dd hh:ii',
                                                                ]
                                                            ]);
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="2">TEMPAT VAKSIN:<span class="required" style="color:red;">*</span></td>
                                                        <td colspan="2">
                                                            <?= $form->field($modelsdos, "[{$i}]tempat_vaksin")->textArea(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="2">BATCH VAKSIN:<span class="required" style="color:red;">*</span></td>
                                                        <td colspan="2">
                                                            <?= $form->field($modelsdos, "[{$i}]batch_vaksin")->textArea(['maxlength' => true], ['class' => 'form-control col-md-7 col-xs-12'])->label(false) ?>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div><!-- .panel -->
                    <?php DynamicFormWidget::end(); ?>
                    <!--           view dyanamic end here-->
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="customer-form">
            <div class="form-group" align="center">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
                    <?= Html::a('Kembali', ['view-status-vaksinasi'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::submitButton($modelsdos->isNewRecord ? 'Simpan' : 'Kemaskini', ['class' => 'btn btn-success']) ?>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>