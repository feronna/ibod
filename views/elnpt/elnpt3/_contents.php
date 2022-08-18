<?php

$js = <<< JS
// $(document).on('beforeSubmit', '#content-form', function (e) {
$("#content-form").on("beforeSubmit",function(e){
    e.preventDefault();

    var form = $(this);
    var formData = new FormData($('#content-form')[0]);
    console.log(formData);

    $.ajax({
        url: form.attr("action"),
        type: 'post',
        data: formData,
        success: function (data) {
            if(data.success){
                $.pjax.reload({
                    container: '#timeline-cont',
                    url: 'pjax-ticket-timeline?lppid=$ticket->lpp_id&ticket_id=$ticket->id',
                });

                $('#reset_form').click();
            }
        },
        error: function () {
            alert("Something went wrong. Please contact the System Administrator.");
        },
        cache: false,
        contentType: false,
        processData: false,
    });

    return false;
}).on('submit', function(e){
    e.preventDefault();

});

JS;
$this->registerJs($js, \yii\web\View::POS_READY);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\elnpt\TblPenyelidikan;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\models\elnpt\elnpt2\RefAspekSkor;
use yiister\gentelella\widgets\Timeline;

foreach ($timeline as $ind => $t) {
    $timeline[$ind]['content'] = $t['content'] . (isset($t['filehash']) ? ('<br/>' . Html::a(
        "<sub>View Attachment</sub> <i class='fa fa-file' aria-hidden='true'></i>",
        Url::to(['elnpt3/view-file', 'hashfile' => $t['filehash'], 'lppid' => $ticket->lpp_id]),
        ['data-pjax' => 0, 'target' => '_blank']
    )) : '');
}

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
            <?= '<strong>Ticket #' . $ticket->id . ' - </strong>' . $ticket->ticketStatus() ?>
        </li>
    </ol>
</nav>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="panel-body">
                <?php yii\widgets\Pjax::begin(['id' => 'timeline-cont']) ?>
                <?=
                empty($timeline) ? '<strong>Submit the details below to start a conversation with our support representatives.</strong>' : Timeline::widget(['items' => $timeline]);
                ?>
                <?php yii\widgets\Pjax::end() ?>
            </div>
        </div>
        <?php if ($ticket->status != 100) { ?>
            <div class="x_panel">
                <div class="panel-body">
                    <?php yii\widgets\Pjax::begin(['id' => 'tmp-log-in']) ?>
                    <?php $form = ActiveForm::begin(['id' => 'content-form', 'action' => ['add-content?lppid=' . $ticket->lpp_id . '&ticket_id=' . $ticket->id], 'options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); ?>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Subject</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <?=
                            $form->field($model, 'title')->textInput(['placeholder' => 'Enter few words describing your request'])->label(false);
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Message</label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <?=
                            $form->field($model, 'content')->textArea(['style' => "resize: none;", 'rows' => '6', 'maxlength' => 300, 'placeholder' => 'Provide detailed explanation for logging this support ticket'])->label(false);
                            ?>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Upload Screenshot (Optional)</label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                                <?php
                                if (!($model->isNewRecord)) {
                                    // echo Html::a(Yii::$app->FileManager->NameFile($model->filehash));
                                    // echo '&nbsp&nbsp&nbsp&nbsp';
                                    // if ($pnp->id) {
                                    //     echo Html::a('Padam', ['deletegambar', 'id' => $model->id], ['class' => 'btn btn-danger']) . '<p>';
                                    echo $form->field($model, 'file')->widget(kartik\widgets\FileInput::classname(), [
                                        'options' => [
                                            'accept' => 'image/jpg, image/png',
                                            'multiple' => false,
                                            'id' => 'file_' . $kategori,
                                        ],
                                        'pluginOptions' => [
                                            'allowedFileExtensions' => ['jpg', 'png'],
                                            // 'showCaption' => true,
                                            'showRemove' => false,
                                            'showUpload' => false,
                                            'overwriteInitial' => true,
                                            'initialPreviewAsData' => true,
                                            // 'initialPreviewFileType' => 'pdf',
                                            // 'browseLabel' => '',
                                            // 'removeLabel' => '',
                                            'initialPreview' => [
                                                Yii::$app->FileManager->DisplayFile($model->filehash)
                                            ],
                                            'fileActionSettings' => [
                                                'showRemove' => false,
                                                // 'showZoom' => false
                                            ]
                                        ]
                                    ])->label(false);
                                    // }
                                } else {
                                    // echo $form->field($model, 'file')->fileInput()->label(false);
                                    echo $form->field($model, 'file')->widget(kartik\widgets\FileInput::classname(), [
                                        'options' => [
                                            'accept' => ' image/jpg, image/png',
                                            'multiple' => false,
                                            'id' => 'file_' . $kategori,
                                        ],
                                        'pluginOptions' => [
                                            'allowedFileExtensions' => ['jpg', 'png'],
                                            // 'showCaption' => true,
                                            // 'showRemove' => true,
                                            'showUpload' => false,
                                            'overwriteInitial' => true,
                                        ]
                                    ])->label(false);
                                }
                                // echo $model->filehash;
                                ?>
                            </div>
                            <!--<span data-toggle="tooltip" ><i class="fa fa-info-circle fa-lg"></i></span>-->
                        </div>

                        <div class="form-group">
                            <div class="col-md-push-3 col-sm-6 col-xs-12">
                                <?= Html::resetButton('Reset', ['class' => 'btn btn-primary', 'id' => 'reset_form']) ?>
                                <?= Html::submitButton('Send', ['class' => 'btn btn-success', 'id' => 'submit']) ?>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>
                        <?php yii\widgets\Pjax::end() ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>