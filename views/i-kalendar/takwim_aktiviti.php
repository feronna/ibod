<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\JsExpression;

?>

<?php
Modal::begin([
    'header' => '<h4>Kemaskini Aktiviti</h4>',
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    'footer' => '<a data-confirm="Adakah anda pasti untuk memadamnya?" data-method="post" id="modalDelete" class="btn btn-danger">Padam</a>',
    // 'toggleButton' => ['label' => 'click me'],
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    // 'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?= $this->render('_menuAdmin'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Takwim Aktiviti</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <?= \yii2fullcalendar\yii2fullcalendar::widget([
                    'events' => $events,
                    'eventRender' => new JsExpression(
                        "function(eventObj, el){
                            el.popover({
                                title: eventObj.title,
                                content: eventObj.nonstandard.dept,
                                trigger: 'hover',
                                placement: 'top',
                                container: 'body'
                            });
                        }"
                    ),
                    'clientOptions' => [
                        'selectable' => true,
                        'selectHelper' => true,
                        'droppable' => true,
                        'editable' => true,
                        'eventClick' => new JsExpression("function(calEvent, jsEvent, view) {
                            $.get(calEvent.nonstandard.url,{'id':calEvent.nonstandard.id},function(data){
                                $('#modal').modal('show')
                                    .find('#modalContent')
                                    .html(data);
                        
                                    $('#modal').on('shown.bs.modal', function () {
                                        $('#modalDelete').attr(\"href\", calEvent.nonstandard.urlDel);
                                      })
                            });
                        }"),
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>